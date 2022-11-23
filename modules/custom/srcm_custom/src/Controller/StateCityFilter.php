<?php
namespace Drupal\srcm_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\srcm_custom\Http\CustomGuzzleHttp;
use Drupal\Core\Cache\CacheBackendInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class NewsDetailController.
 */
class StateCityFilter extends ControllerBase {

  public function cities_looping_in($url) {
    $rec_response = array();
    $check = new CustomGuzzleHttp();
    $response = $check->performRequest($url);
    foreach ($response['results'] as $result) {
      $rec_response[$result['id']] = $result['name'];
    }
    return $rec_response;
  }
  /**
   * [].
   *
   * @return string
   *   Return Hello string.
   */
  public function state_city_filter($country_state, $id) { 
    $just_options = array();
    $just_options['_none'] = '- None -';
    $config = \Drupal::config('srcm_custom.oauth2endpoint');
    $endpoint = $config->get('oauth2_end_point_url');
    $check = new CustomGuzzleHttp();
    if ($country_state == 'states') {
      $response = $check->performRequest($endpoint.'/api/v2/'.$country_state.'/?country='.$id.'&page_size=200');
      foreach ($response['results'] as $result) {
        $just_options[$result['id']] = $result['name'];
      }
    } else {
      $response = $check->performRequest($endpoint.'/api/v2/'.$country_state.'/?state='.$id.'&page_size=200');
      $total_count = $response['count'];
      $no_of_pages = ceil($total_count/200);
      foreach ($response['results'] as $result) {
        $just_options[$result['id']] = $result['name'];
      }
      for ($i=2;$i<=$no_of_pages;$i++) {
        $just_options = $just_options+$this->cities_looping_in($endpoint.'/api/v2/'.$country_state.'/?page='.$i.'&page_size=200&state='.$id.'');
      }
    }
    $response = new Response();
    $response->setContent(json_encode($just_options));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }
}
