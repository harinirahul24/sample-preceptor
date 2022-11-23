<?php  
  
namespace Drupal\srcm_custom\Form;
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class LogoutUrlForm extends ConfigFormBase {  
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
        'srcm_custom.logouturl',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'logourl_form';  
    }  

   
  public function buildForm(array $form, FormStateInterface $form_state) {
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $config = $this->config('srcm_custom.logouturl');
    
    $form['logout_url_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the Preceptor Logout URL'),
      '#description' => $this->t('url should be like this "http://profile.srcm.net/accounts/logout/"'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('logout_url_value'),
    ];


    $form['my_account_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter My Account Url'),
      '#description' => $this->t('url should be like this "https://profile.sahajmarg.org/members/update"'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('my_account_url'),
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

    $this->config('srcm_custom.logouturl')
      ->set('logout_url_value', $form_state->getValue('logout_url_value'))
      ->set('my_account_url', $form_state->getValue('my_account_url'))
      ->save();
  }

}  