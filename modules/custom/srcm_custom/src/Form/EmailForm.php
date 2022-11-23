<?php  
  
namespace Drupal\srcm_custom\Form;
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class EmailForm extends ConfigFormBase {  
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
        'srcm_custom.email',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'email_form';  
    }  

   
  public function buildForm(array $form, FormStateInterface $form_state) {
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $config = $this->config('srcm_custom.email');
    
    $form['email_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the Email ID'),
      '#description' => $this->t('Please enter the Feature Topic admin user nodification email id'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('email_value'),
    ];
	
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('srcm_custom.email')
      ->set('email_value', $form_state->getValue('email_value'))
      ->save();
  }

}  