<?php

namespace Drupal\srcm_oauth2_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\externalauth\ExternalAuth;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Url;

/**
 * Class Oauth2CatchController.
 *
 * @package Drupal\srcm_oauth2_login\Controller
 */
class Oauth2CatchController extends ControllerBase {
	
	function __construct(ExternalAuth $externalAuth) {
		$this->externalAuth = $externalAuth;
	}

    /**
	* Oauth2_redirect_call.
	*
	* @return string
	*   Return Hello string.
	*/
	public function oauth2_redirect_call() {
	 
		$token = $this->getToken();
		$json = $this->getProfile($token);
		$username = $json["results"][0]['user_email'];
	 
		$is_prefect = $json["results"][0]['is_prefect'];
		$first_name = $json["results"][0]['first_name'];
		$last_name = $json["results"][0]['last_name'];
		$user_roles = $json["results"][0]['user_roles'];
		//$user_id = $json["results"][0]['user_id'];
		//echo '<pre>'; print_r($json);
		if($username){
			$request_url = $_SESSION['request_url'];
			if($is_prefect==""){
				$roles = array('abhyasi');
				$config = \Drupal::config('srcm_custom.oauth2endpoint');
				$homepageurl = $config->get('preceptor_homepage_url');

				$acc_data = array('roles' => $roles, 'mail' => $username);
				$this->externalAuth->loginRegister($username, 'srcm', $acc_data);
				$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
				$roles = $user->getRoles();
				
				if(!in_array('abhyasi', $roles)){
					$user->set('roles', 'abhyasi');
					$user->save();
				} 
				
				if (!$user->get('field_first_name')->value) {
					$user->set('field_last_name', $last_name);
					$user->set('field_first_name', $first_name);
					$user->save();
				}	
				if($request_url==""){
					//return new RedirectResponse($homepageurl);
					return new RedirectResponse("/abhyasi");
					
				}else{					 
					$abhyasiurl = ($request_url=="/en/preceptor/?pre=".$roles[0]."-".$roles[1]."-".$roles[2]."") ? ("/abhyasi") : ($request_url);
					return new RedirectResponse($abhyasiurl);		
				}
				
			} else {
				
				$roles = array('preceptor');
				$config = \Drupal::config('srcm_custom.oauth2endpoint');
				$homepageurl = $config->get('preceptor_homepage_url');

				$acc_data = array('roles' => $roles, 'mail' => $username);
				$this->externalAuth->loginRegister($username, 'srcm', $acc_data);
				$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
				  
				$roles = $user->getRoles();			  
				if(!in_array('preceptor', $roles)){
					$user->set('roles', 'preceptor');
					$user->save();
				}
				
				if (!$user->get('field_first_name')->value) {
					$user->set('field_last_name', $last_name);
					$user->set('field_first_name', $first_name);
					$user->save();
				}
				
				if($request_url==''){
					//return new RedirectResponse("/abhyasi");
					return new RedirectResponse($homepageurl);
				}else{
					return new RedirectResponse($request_url);		
				}
				
			}
			
		} else {
			return "You have landed on wrong location!";
		}		
	}

	private function getToken() {    
		$config = \Drupal::config('srcm_custom.oauth2endpoint');
		$endpoint = $config->get('oauth2_end_point_url');
		$client_id = $config->get('oauth2_client_id');
		$fallback_url = $config->get('static_url_part3');
		$pass_token = $config->get('oauth2_pass_token');
		$curl_request = curl_init() or die(curl_error($curl_request));
		curl_setopt($curl_request, CURLOPT_POST, 1);
		curl_setopt($curl_request, CURLOPT_POSTFIELDS, "code=" . $_GET['code'] . "&grant_type=authorization_code&redirect_uri=".$fallback_url);
		curl_setopt($curl_request, CURLOPT_URL, $endpoint . "/o/token/");
		//curl_setopt($curl_request, CURLOPT_URL, "http://profile.sahajmarg.org/o/token/");
		curl_setopt($curl_request, CURLOPT_USERPWD, $client_id.":".$pass_token);
		curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
		$dataret = curl_exec($curl_request) or die(curl_error($curl_request));
		$json = json_decode($dataret, TRUE);
		curl_close($curl_request);
		return $json['access_token'];
	}

	private function getProfile($token) {
		$config = \Drupal::config('srcm_custom.oauth2endpoint');
		$endpoint = $config->get('oauth2_end_point_url');
		$service_path = $config->get('oauth2_service_path');
		$curl_request = curl_init() or die(curl_error($curl_request));

		curl_setopt($curl_request, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $token));
		//curl_setopt($dvreq, CURLOPT_HTTPAUTH,"Bearer ".$json['access_token']);
		curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curl_request, CURLOPT_URL, "http://profile.sahajmarg.org/api/me/");
		curl_setopt($curl_request, CURLOPT_URL, $endpoint . $service_path);
		$dataret = curl_exec($curl_request) or die(curl_error($curl_request));
		curl_close($curl_request);
		$json = json_decode($dataret, TRUE);
		return $json;
	}

	public static function create(ContainerInterface $container) {
		return new static(
		  $container->get('externalauth.externalauth')
		);
		//return parent::create($container); // TODO: Change the autogenerated stub
	}
}