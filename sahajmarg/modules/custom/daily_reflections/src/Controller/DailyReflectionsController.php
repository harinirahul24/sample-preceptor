<?php

namespace Drupal\daily_reflections\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\daily_reflections\Http\CustomGuzzleHttp;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DailyReflectionsController.
 */
class DailyReflectionsController extends ControllerBase {

   /**
   * Returns a page title.
   */
  public function getTitle($year, $month) {
    $monthNum  = $month;
    $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F');
    return  'Beautiful Thoughts for '.$monthName.' '.$year;
  }

  /**
   * Obt_archive.
   *
   * @return string
   *   Return Hello string.
   */
  public function obt_archive($year, $month) {
    $year_int = (int)$year;
    $month_int = (int)$month;
    if ($year_int < 2005 || $month_int <= 0) {
      throw new NotFoundHttpException();
    }
    if ($year_int == 2005 && $month_int < 4) {
      throw new NotFoundHttpException();
    }
    if ($year_int == date('Y') && $month_int > date('m')) {
      throw new NotFoundHttpException();
    }
    if ($year_int > date('Y')) {
      throw new NotFoundHttpException();
    }
    $map_url = "http://dr.sahajmarg.org/sm_view_dr/list_xml?lang=EN&ct=5&filter=".$year.$month;
    if (($response_xml_data = file_get_contents($map_url))===false){
        $output .= "Error fetching XML\n";
    } else {
       libxml_use_internal_errors(true);
       $data = simplexml_load_string($response_xml_data);
       if (!$data) {
           $output .= "Error loading XML\n";
           foreach(libxml_get_errors() as $error) {
               $output = "There are no Beautiful Thoughts for this month.";
               $renderable = [
                '#theme' => 'daily_reflections_archive',
                '#monthly_items' => $output,
                '#current_year' => $year,
                '#current_month' => $month,
                '#end_year' => date('Y'),
                '#start_year' => '2005',
                '#start_month' => '04',
                '#end_month' => date('m'),
                '#title' => getTitle($year, $month),
                '#attached' => array('library' => 'daily_reflections/daily_reflections'),
              ];
              $output = \Drupal::service('renderer')->render($renderable);
           }
       } else {
        $json_resp = Json::encode($data);
        $responseArray = Json::decode($json_resp,true);
        $dr_items = array(); 
        foreach ($responseArray['sm-view-dr'] as $item) {
          $display_date = \DateTime::createFromFormat('Y-m-d', $item['display-dt']);
          $formatted_display_date = $display_date->format('l, F d,Y');
          $dr_items[] = array(
            'display_day' => strtolower($display_date->format('l')),
            'content' => array('#type' => 'markup', '#markup' => $item['content']),
            'display_date' => $formatted_display_date,
            'footer_note' => $item['footnote'],
          );
        }
        $dateObj   = \DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $renderable = [
          '#theme' => 'daily_reflections_archive',
          '#monthly_items' => $dr_items,
          '#current_year' => $year,
          '#current_month' => $month,
          '#end_year' => date('Y'),
          '#start_year' => '2018',
          '#start_month' => '11',
          '#end_month' => date('m'),
          '#obt_title' => 'Beautiful Thoughts for '.$monthName.' '.$year,
          '#attached' => array('library' => 'daily_reflections/daily_reflections'),
        ];
        $output = \Drupal::service('renderer')->render($renderable);
      }
    }
    return [
      '#type' => 'markup',
      '#markup' => $output
    ];
  }

}
