<?php

namespace Drupal\ask_daaji\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;




class QuestionForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  
  public function getFormId() {
    return 'question_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
      $form['#prefix']='<div class="result_message"></div><div class="submit-question">
      <div class="container">
      <div class="col-md-12 py-3">
      <h3 class="PlayfairDisplay-Italic" id="faqform">Submit Your Questions Here</h3>
      </div>
      <div class="col-md-12 type-questions-here px-5 py-3">
      <h6>Daaji will select and record answers to a few questions every few weeks. You may submit your questions here.</h6>';
      
      $form['question']['#prefix']='<div class="col-md-9">';
      $form['question']['#suffix']= '</div>';
      $form['actions']['#prefix']='<div class="col-md-3">';
      $form['actions']['#suffix']= '</div><div class="col-md-12 m-0 py-0 px-3"><hr class="question-btm-border"  /></div>';	
          
      $form['#suffix'] = '</div>
          </div>
          </div>';
      
      $form['question'] = array(
      '#type' => 'textfield',
      '#attributes' => ['placeholder' => ['TYPE YOUR QUESTION HERE']],
	  '#maxlength' => '2000',
      '#required' => TRUE,
      );     

      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t(' Submit Question'),
      '#button_type' => 'primary',      
      '#attributes' => ['class' => ['learn-more text-uppercase gotham-medium btn btn-light']],
      '#ajax' => [
        'callback' => '::setMessage',
        'event' => 'click',
      ],
      );
      return $form;
  }

  public function setMessage(array $form, FormStateInterface $form_state) {

    $response = new AjaxResponse();
    $response->addCommand(
      new HtmlCommand(
        '.result_message',
        '<div class="my_top_message alert alert-success">' . t('Submitted Successfully') . '</div>'
      )
    );
    return $response;
  }



  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	$config = \Drupal::config('srcm_custom.email');
    $usermail = $config->get('email_value'); 	
	$user = \Drupal::currentUser();
	$user_email = $user->getEmail();
	$user_name = $user->getUsername();
	$temp = new \Drupal\Core\Datetime\DrupalDateTime();
	$temp->__toString();
	$date_time = $temp->format('Y-m-d h:i'); 
    $question  =  $form_state->getValue('question');
	$split = str_split($question, 50);
	$title = $split[0] . "...";
	
		
          $node = Node::create([
            'type' => 'common_questions',
            'title' =>  $title,
			'field_questions' => $question
          ]);  
          $node->save();
	$send_mail = new \Drupal\Core\Mail\Plugin\Mail\PhpMail(); // this is used to send HTML emails
	$from = $user_email;
	//$to = 'Daaji@heartfulness.org';
	$to = $usermail;
	$message['headers'] = array(
	'content-type' => 'text/html',
	'MIME-Version' => '1.0',
	'reply-to' => $from,
	'from' => 'Sahajmarg <'.$from.'>'
	);
	$message['to'] = $to;
	$message['subject'] = "Ask Daaji Featured Topic !!!!!";
	 
	$message['body'] = '<html>
    <body>
        <table style="border: 1px solid black;">
            <tr>
                <td width="350" style="border: 1px solid black ;">
                   Question
                </td>
                <td width="80" style="border: 1px solid black ;">
                    '.$question.'
                </td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">
                    Email ID
                </td>
                <td style="border: 1px solid black;">
                   '.$user_email.'
                </td>
                
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">
                    Updated Date & Time
                </td>
                <td style="border: 1px solid black;">
                    '.$date_time.'
                </td>
            </tr>
        </table>
    </body>
</html>';
	 
	$send_mail->mail($message);	
    drupal_set_message($this->t('@questiontxt ,Your application is being submitted!', array('@questiontxt' => $form_state->getValue('question'))));

  }
}