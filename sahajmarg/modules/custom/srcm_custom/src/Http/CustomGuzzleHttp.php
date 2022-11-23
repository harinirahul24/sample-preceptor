<?php
namespace Drupal\srcm_custom\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Serialization\Json;
/** 
 * Get a response code from any URL using Guzzle in Drupal 8! 
 **/
class CustomGuzzleHttp {
  use StringTranslationTrait;
  
  public function performRequest($siteUrl) {
    $client = new \GuzzleHttp\Client();
    try {
      $res = $client->get($siteUrl, ['http_errors' => false]);
      return(Json::decode($res->getBody()));
    } catch (RequestException $e) {
      return($this->t('Error'));
    }
  }
}