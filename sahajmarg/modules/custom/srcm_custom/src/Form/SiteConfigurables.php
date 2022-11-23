<?php

namespace Drupal\srcm_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SiteConfigurables.
 */
class SiteConfigurables extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'srcm_custom.siteconfigurables',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_configurables';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = $this->config('srcm_custom.siteconfigurables');
    $form['countries'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Countries'),
      '#description' => $this->t('Countries in JSON format'),
      '#size' => 64,
      '#default_value' => $config->get('countries'),
    ];
    $form['old_design_trigger'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Switch to Old Design'),
      '#default_value' => $config->get('old_design_trigger'),
    );
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
    $this->config('srcm_custom.siteconfigurables')
      ->set('countries', $form_state->getValue('countries'))
      ->set('old_design_trigger', $form_state->getValue('old_design_trigger'))
      ->save();
  }

}
