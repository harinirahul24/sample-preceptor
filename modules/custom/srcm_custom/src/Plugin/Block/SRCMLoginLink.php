<?php

namespace Drupal\srcm_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SRCMLginLink' block.
 *
 * @Block(
 *  id = "srcm_login_link",
 *  admin_label = @Translation("SRCM Login Link"),
 * )
 */
class SRCMLoginLink extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $output = '';
    $config = \Drupal::config('srcm_custom.oauth2endpoint');
    $endpoint = $config->get('oauth2_end_point_url');
    $client_id = $config->get('oauth2_client_id');
    $static_url_part1 = $config->get('static_url_part1');
    $static_url_part2 = $config->get('static_url_part2');
    $static_url_part3 = $config->get('static_url_part3');
    $lan_id = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $tempstore = \Drupal::service('tempstore.private')->get('srcm_custom');
    $tempstore->set('lang_id', $lan_id);
    $output = '<a style="float:right;" href="'.$endpoint.$static_url_part1.$client_id.$static_url_part2.$static_url_part3.'">Login</a>';
    return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }

}
