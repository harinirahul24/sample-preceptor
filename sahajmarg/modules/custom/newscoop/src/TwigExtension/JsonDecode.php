<?php
namespace Drupal\newscoop\TwigExtension;
use Drupal\Component\Serialization\Json;
 
class JsonDecode extends \Twig_Extension {    
 
  /**
   * Generates a list of all Twig filters that this extension defines.
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('json_decode', array($this, 'jsondecode')),
    ];
  }
 
  /**
   * Gets a unique identifier for this Twig extension.
   */
  public function getName() {
    return 'twig.json_decode';
  }
 
  /**
   * Replaces all numbers from the string.
   */
  public static function jsondecode($string) {
    //&quot;
    //
    return Json::decode(htmlspecialchars_decode($string));
  }
 
}

