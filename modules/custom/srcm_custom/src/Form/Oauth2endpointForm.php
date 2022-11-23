<?php

namespace Drupal\srcm_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Oauth2endpointForm.
 *
 * @package Drupal\srcm_custom\Form
 */
class Oauth2endpointForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'srcm_custom.oauth2endpoint',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'oauth2endpoint_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $config = $this->config('srcm_custom.oauth2endpoint');
    $form['oauth2_end_point_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Oauth2 End point url'),
      '#description' => $this->t('Endpoint url. E.G. http://profile.sahajmarg.net'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('oauth2_end_point_url'),
    ];
    $form['static_url_part1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Static URL authorize'),
      '#description' => '',
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('static_url_part1'),
    ];
    $form['oauth2_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Oauth2 Client ID'),
      '#description' => $this->t('Client ID'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('oauth2_client_id'),
    ];
    $form['static_url_part2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Static URL redirect'),
      '#description' => '',
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('static_url_part2'),
    ];
    $form['static_url_part3'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Static fallback URL'),
      '#description' => '',
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('static_url_part3'),
    ];
    $form['oauth2_pass_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Oauth2 Pass Token'),
      '#description' => $this->t('Pass Token'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('oauth2_pass_token'),
    ];
    $form['oauth2_service_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Oauth2 Service path'),
      '#description' => $this->t('Service path'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('oauth2_service_path'),
    ];
   /*  $form['preceptor_node_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Preceptor Homepage node ID'),
      '#description' => $this->t('Node ID'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('preceptor_node_id'),
    ]; */
	$form['preceptor_homepage_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Preceptor Home Page URL'),
      '#description' => $this->t('Preceptor Home Page'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('preceptor_homepage_url'),
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

    $this->config('srcm_custom.oauth2endpoint')
      ->set('oauth2_end_point_url', $form_state->getValue('oauth2_end_point_url'))
      ->set('oauth2_client_id', $form_state->getValue('oauth2_client_id'))
      ->set('static_url_part1', $form_state->getValue('static_url_part1'))
      ->set('static_url_part2', $form_state->getValue('static_url_part2'))
      ->set('static_url_part3', $form_state->getValue('static_url_part3'))
      ->set('oauth2_pass_token', $form_state->getValue('oauth2_pass_token'))
      ->set('oauth2_service_path', $form_state->getValue('oauth2_service_path'))
     // ->set('preceptor_node_id', $form_state->getValue('preceptor_node_id'))
	  ->set('preceptor_homepage_url', $form_state->getValue('preceptor_homepage_url'))
      ->save();
  }

}
