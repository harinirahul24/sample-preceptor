<?php

namespace Drupal\daily_reflections\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'OneBeautifulThought' block.
 *
 * @Block(
 *  id = "one_beautiful_thought",
 *  admin_label = @Translation("One Beautiful Thought"),
 * )
 */
class OneBeautifulThought extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $output = '';
    $map_url = "http://dr.sahajmarg.org/sm_view_dr/show_xml?lang=EN&ct=5&display_dt=".date('Y/m/d');
    if (($response_xml_data = file_get_contents($map_url))===false){
        $output .= "Error fetching XML\n";
    } else {
       libxml_use_internal_errors(true);
       $data = simplexml_load_string($response_xml_data);
       if (!$data) {
           $output .= "Error loading XML\n";
           foreach(libxml_get_errors() as $error) {
               $output .= "\t".$error->message;
           }
       } else {
        $json_resp = json_encode($data);
      $responseArray = json_decode($json_resp,TRUE);
        $display_date = \DateTime::createFromFormat('Y-m-d', $data->{"display-dt"});
    $formatted_display_date = $display_date->format('l, F d,Y');
        $renderable = [
          '#theme' => 'one_beautiful_thought',
          '#content' => $data->{"content"},
          '#display_date' => $formatted_display_date,
          '#footer_note' => $data->{"footnote"},
        ];
        $output = \Drupal::service('renderer')->render($renderable);
       }
    }
    $build['one_beautiful_thought']['#markup'] = $output;
    return $build;
  }

}
