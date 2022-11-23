<?php
namespace Drupal\srcm_custom\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Url;

/**
 * Event subscriber subscribing to KernelEvents::REQUEST.
 */
class RedirectAnonymousSubscriber implements EventSubscriberInterface {

  public function __construct() {
    $this->account = \Drupal::currentUser();
  }

  public function checkAuthStatus(GetResponseEvent $event) {
    if ($this->account->isAnonymous() && preg_match('/preceptor/', \Drupal::request()->getRequestUri())) {
	  $request = \Drupal::request();
	  $referer = $request->headers->get('referer');
      $config = \Drupal::config('srcm_custom.oauth2endpoint');
      $endpoint = $config->get('oauth2_end_point_url');
      $client_id = $config->get('oauth2_client_id');
      $static_url_part1 = $config->get('static_url_part1');
      $static_url_part2 = $config->get('static_url_part2');
      $static_url_part3 = $config->get('static_url_part3');
	  $request_url =  \Drupal::request()->getRequestUri();
	  unset($_SESSION['request_url']);
	  $_SESSION['request_url'] = $request_url;	  
	  \Drupal::logger('my_module')->notice($_SESSION['request_url']);
      $url = $endpoint.$static_url_part1.$client_id.$static_url_part2.$static_url_part3;
      $response = new TrustedRedirectResponse($url, 301);
      $event->setResponse($response);
      $event->stopPropagation();
    }
    return;
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('checkAuthStatus',100);
    return $events;
  }

}