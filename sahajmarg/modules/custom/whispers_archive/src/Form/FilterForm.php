<?php

namespace Drupal\whispers_archive\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;




class FilterForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  
  public function getFormId() {
    return 'whispers_archive_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
	$currently_selected = date('Y');
    $earliest_year = 2005; 
    $latest_year = date('Y'); 
	foreach ( range( $latest_year, $earliest_year ) as $i ) {
		$options[$i] = $i;
	}
	$currently_selected_m = date('Y');
    $earliest_year_m = 1999; 
    $latest_year_m= date('Y'); 
	foreach ( range( $latest_year_m, $earliest_year_m ) as $m ) {
		$options_m[$m] = $m;
	}
	$form['#prefix']='<div class="col-lg-7 offset-lg-2 whisper-archive-form-select">';
    $form['category'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Type'),
      '#options' => [
        'broadcast' => $this
          ->t('Broadcast Date'),       
        'message' => $this
          ->t('Message Date'),
      ],
      '#wrapper_attributes' => ['class' => 'col'],
      '#default_value' => (isset($data['select'])) ? $data['select'] : '',
    ];
	$form['year_b'] = [
      '#type' => 'select',
      '#title' => $this->t('Year'),
	  '#options' => $options,
      '#wrapper_attributes' => ['class' => 'col'],
      '#default_value' => (isset($data['select'])) ? $data['select'] : '',
    ];
	$form['year_m'] = [
      '#type' => 'select',
      '#title' => $this->t('Year'),
	  '#options' => $options_m,
      '#wrapper_attributes' => ['class' => 'col'],
      '#default_value' => (isset($data['select'])) ? $data['select'] : '',
    ];
	$form['month'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Month'),
      '#options' => [
        '1' => $this
          ->t('January'),       
        '2' => $this
          ->t('February'),
		'3' => $this
          ->t('March'),       
        '4' => $this
          ->t('April'),
		'5' => $this
          ->t('May'),       
        '6' => $this
          ->t('June'),
		'7' => $this
          ->t('July'),       
        '8' => $this
          ->t('August'),
		'9' => $this
          ->t('September'),       
        '10' => $this
          ->t('October'),
		'11' => $this
          ->t('November'),       
        '12' => $this
          ->t('December'),
      ],
      '#wrapper_attributes' => ['class' => 'col'],
      '#default_value' => (isset($data['select'])) ? $data['select'] : '',
    ];
	
    $form['submit_button'] = [
      '#type' => 'submit',
      '#name' => 'submit-email',
	  '#wrapper_attributes' => ['class' => 'col'],
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::displayData',
        'wrapper' => 'display-result',
        'effect' => 'fade',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Processing ...'),
        ],
      ],
	];
	
	 $form['thanks'] = [
     '#type' => '#markup',
     '#markup'=> '',
     '#prefix' => '<div id="display-result">',
     '#suffix' => '</div>'
    ];
	$form['#suffix'] = '</div>';
    return $form;
  }

    public function validateForm(array &$form, FormStateInterface $form_state) {
	}

    public function submitForm(array &$form, FormStateInterface $form_state) {
	   
    }

  /**
   * {@inheritdoc}
   */
  public function displayData(array &$form, FormStateInterface $form_state) {
	  $ajax_response = new AjaxResponse();
	  $category  =  $form_state->getValue('category');
	  $year_b  =  $form_state->getValue('year_b');
	  $year_m  =  $form_state->getValue('year_m');	  
	  $month  =  $form_state->getValue('month');
	  $year =  ($category =='broadcast') ? $year_b : $year_m;
	
	$conn   = \Drupal\Core\Database\Database::setActiveConnection('external');	
	$db = \Drupal\Core\Database\Database::getConnection();
	//$db = \Drupal::database();
				
	if($category=="broadcast"){
		$result = $db
		  ->query("SELECT `display_dt`,`list_id`,`profile_name`,`author`,`content` FROM `sm_view_whispers` WHERE month(`display_dt`)='".$month."' && year(`display_dt`)='".$year."' && `language`='EN' order by display_dt,msg_num")
		  ->fetchAll();

	}else{	
		$result = $db
		  ->query("SELECT `display_dt`,`list_id`,`profile_name`,`author`,`message_dt`,`content` FROM `sm_view_whispers` WHERE date_format(message_dt,'%m%Y')='".$month."".$year."'&& `language`='EN' order by display_dt,msg_num")
		  ->fetchAll();
	}	
	
	$count = count($result);
	if($count > 0){
		
	foreach($result as $res){
				
				$content_text = $res->content;
				$string = str_replace( array('speaker', 'date','author'),array('div','b','div'),$content_text);
				$string_text =str_replace(array('divNI','divNormal'),array('div','div'),$string);
				
					$dom = new \DOMDocument();
					$dom->loadHTML($string_text);
					//\Drupal::logger('contents')->notice($string_text);
					$datetags = $dom->getElementsByTagName("b");
					$dateFormate = $datetags[0]->nodeValue;
					$datereplace = str_replace(array("a.m","p.m"), array("AM","PM"),$dateFormate);
					$url = "https://content.sahajmarg.org/smapp/viewMessage.do?PROPFILE_NAME=".$res->profile_name."&list=".$res->list_id."&DATE=".$res->display_dt."&msgNum=0";
					
				
					$table .='<tr><td>"'.$res->display_dt.'"</td><td>"'.$res->author.'"</td><td><a target="blank" href='.$url .'>"'.$datereplace.'"</a></td></tr>';
				//$dateValue .=$res->display_dt;
																
		} 
	
	$month_name = date("F", mktime(0, 0, 0, $month, 10));
	$responce = "<span>Whispers for ".$month_name." ".$year."</span><table class='wishpers-table'><tr><th class='wishper-title'>Broadcast Date</th><th class='wishper-title'>Message From</th> <th class='wishper-title'>Received on</th>".str_replace('"', '', $table)."</table>";
	}else{
		$responce = "<p class='wishper-empty'>Whispers not available for selected period. Please try for different Year or Month.</p>";
	}
	
	
	$ajax_response->addCommand(new HtmlCommand('#display-result', $responce));
    return $ajax_response;
 
  }

}