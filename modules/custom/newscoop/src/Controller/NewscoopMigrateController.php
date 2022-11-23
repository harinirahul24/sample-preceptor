<?php

namespace Drupal\newscoop\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\srcm_custom\Http\CustomGuzzleHttp;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\file\Entity\File;
use Drupal\Component\Serialization\Json;

/**
 * Class NewscoopMigrateController.
 */
class NewscoopMigrateController extends ControllerBase {


  public function addAllFields_from_newscoop($node,$item,$parent_node = FALSE) {
    $entityManager = \Drupal::service('entity_field.manager');
    $fields = $entityManager->getFieldStorageDefinitions('node', 'news_and_articles');
    $article_type_options = options_allowed_values($fields['field_article_type']);
    $node->set('title', $item['title']);
    $body = [
    'value' => $item['fields']['Description'], 
    'format' => 'full_html',
    ];
    $node->set('body', $body);
    // $node->set('field_article_section', $section_id);
    $node->set('field_article_type', strtolower($item['type']));
    $node->set('field_newscoop_id', strtolower($item['number']));
    $node->set('field_date_of_event', ['value' => $item['fields']['Date']]);
    // Handling Countries start.
    if ($item['fields']['Country']) {
      $query = \Drupal::database()->select('Countries', 'c');
      $query->fields('c',array('Code'));
      $query->condition('Id', $item['fields']['Country']);
      $country_code = $query->execute()->fetchField();
      if (empty($country_code)) {
        $query = \Drupal::database()->select('Countries', 'c');
        $query->fields('c',array('Name'));
        $query->condition('Id', $item['fields']['Country']);
        $country_name = $query->execute()->fetchField();
        $node->set('field_country_name_code_na', $country_name);
      } else {
        $country_local_check = new CustomGuzzleHttp();
        $country_json = $country_local_check->performRequest('https://profile.sahajmarg.org/api/v2/countries/?code='.$country_code);
        $node->set('field_country', $country_json['results'][0]['id']);
      }
    }
    // Handling Countries end.
    // Handling States & Cities start.
    
    if ($item['fields']['State'] || $item['fields']['State']) {
      $state_city_field_value = '{';
      if ($item['fields']['State']) {
        $query = \Drupal::database()->select('States', 's');
        $query->fields('s',array('Name'));
        $query->condition('Id', $item['fields']['State']);
        $state_name = $query->execute()->fetchField();
        $state_city_field_value .= 'state name:'.$state_name.'';
      }
      if ($item['fields']['State'] && $item['fields']['Centre']) {
        $state_city_field_value .= ",";
      }
      if ($item['fields']['Centre']) {
        $query = \Drupal::database()->select('Cities', 'c');
        $query->fields('c',array('Name'));
        $query->condition('Id', $item['fields']['Centre']);
        $city_name = $query->execute()->fetchField();
        $state_city_field_value  .= 'city name:'.$city_name.'';
      }
      $state_city_field_value .= '}';
      if ($state_city_field_value == '{state name:,city name:}') {

      }
      $node->set('field_newscoop_state_and_city', Json::encode($state_city_field_value));
    }
    // Handling States & Cities End.
    // Handling images start.
    $j = 0;
    foreach ($item['renditions'] as $image) {
      $image_uri = str_replace("http://news.sahajmarg.org/images/","public://newscoop-images/",$image['link']);
      $file = File::create([
        'uid' => 1,
        'filename' => str_replace("http://news.sahajmarg.org/images/","",$image['link']),
        'uri' => $image_uri,
        "langcode" => $item['language'],
        'status' => 1,
      ]);
      $file->save();
      if ($j == 0 && $file->id()) {
        $node->set('field_images', $file->id()); 
      } 
      if ($j > 0 && $file->id()) {
        $current = $node->get('field_images')->getValue();
        $current[] = array(
          'target_id' => $file->id(),
        );
        $node->set('field_images', $current); 
      }
      $j++;
    }
    // Handling images end.
    // Handling Paragraphs start.
    if (strtolower($item['type']) == 'hfn_others') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_Preceptor'])) {
            $translated_field['field_name_of_preceptor'] = $item['fields']['Name_Of_Preceptor']; 
          }
          if (!is_null($item['fields']['TypeOfEvent'])) {
            $translated_field['field_type_of_event'] = $item['fields']['TypeOfEvent']; 
          }
          if (!is_null($item['fields']['PlaceOfEvent'])) {
            $translated_field['field_place_of_event'] = $item['fields']['PlaceOfEvent']; 
          }
          if (!is_null($item['fields']['Number_Of_Participants'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Participants']; 
          }
          if (!is_null($item['fields']['Welcome_Card_Signed_By'])) {
            $translated_field['field_welcome_card_signed_by'] = $item['fields']['Welcome_Card_Signed_By']; 
          }
          if (!is_null($item['fields']['Name_Of_Event_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Event_Coordinator']; 
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_others',]);
        if (!is_null($item['fields']['Name_Of_Preceptor'])) {
          $paragraph->set('field_name_of_preceptor', $item['fields']['Name_Of_Preceptor']); 
        }
        if (!is_null($item['fields']['TypeOfEvent'])) {
          $paragraph->set('field_type_of_event', $item['fields']['TypeOfEvent']); 
        }
        if (!is_null($item['fields']['PlaceOfEvent'])) {
          $paragraph->set('field_place_of_event', $item['fields']['PlaceOfEvent']); 
        }
        if (!is_null($item['fields']['Number_Of_Participants'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Participants']); 
        }
        if (!is_null($item['fields']['Welcome_Card_Signed_By'])) {
          $paragraph->set('field_welcome_card_signed_by', $item['fields']['Welcome_Card_Signed_By']); 
        }
        if (!is_null($item['fields']['Name_Of_Event_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Event_Coordinator']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'master') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Region'])) {
            $translated_field['field_region'] = $item['fields']['Region']; 
          }
          if (!is_null($item['fields']['Location'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Location']; 
          }
          if (!is_null($item['fields']['Number_Of_Seekers'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Seekers'];  
          }
          if (!is_null($item['fields']['Visits'])) {
            $translated_field['field_total_number_of_students'] = $item['fields']['Visits']; 
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'master',]);
        if (!is_null($item['fields']['Region'])) {
          $paragraph->set('field_region', $item['fields']['Region']); 
        }
        if (!is_null($item['fields']['Location'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Location']); 
        }
        if (!is_null($item['fields']['Number_Of_Seekers'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Seekers']); 
        }
        if (!is_null($item['fields']['Visits'])) {
          $paragraph->set('field_total_number_of_students', $item['fields']['Visits']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'news_and_events') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          /*$translated_fields = [];
            $translated_fields['field_body'] = array(
              'value' => 'translated value',
              'format' => 'full'
            );
            $translated_fields['field_section_title'] = 'translated section title';

            $translated_entity_array = array_merge($entity_array, $translated_fields);*/
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'news_and_events',]);
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'ashram_activity') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Gathering'])) {
            $translated_field['field_gathering'] = $item['fields']['Gathering']; 
          }
          if (!is_null($item['fields']['Satsangh'])) {
            $translated_field['field_satshangh'] = $item['fields']['Satsangh']; 
          }
          if (!is_null($item['fields']['Open_House'])) {
            $translated_field['field_open_house'] = $item['fields']['Open_House'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'ashram_activity',]);
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        if (!is_null($item['fields']['Gathering'])) {
          $paragraph->set('field_gathering', $item['fields']['Gathering']); 
        }
        if (!is_null($item['fields']['Satsangh'])) {
          $paragraph->set('field_satshangh', $item['fields']['Satsangh']); 
        }
        if (!is_null($item['fields']['Open_House'])) {
          $paragraph->set('field_open_house', $item['fields']['Open_House']); 
        }
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'centre_activity') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          /*$translated_fields = [];
            $translated_fields['field_body'] = array(
              'value' => 'translated value',
              'format' => 'full'
            );
            $translated_fields['field_section_title'] = 'translated section title';

            $translated_entity_array = array_merge($entity_array, $translated_fields);*/
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'centre_activity',]);
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'hfn_c_connect') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_Company'])) {
            $translated_field['field_name_of_university'] = $item['fields']['Name_Of_Company']; 
          }
          if (!is_null($item['fields']['Address_Of_Company'])) {
            $translated_field['field_address_of_university'] = $item['fields']['Address_Of_Company']; 
          }
          if (!is_null($item['fields']['Place'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Place']; 
          }
          if (!is_null($item['fields']['Duration_Of_Program'])) {
            $translated_field['field_duration_of_program'] = $item['fields']['Duration_Of_Program']; 
          }
          if (!is_null($item['fields']['Number_Of_Seekers'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Seekers']; 
          }
          if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
            $translated_field['field_total_number_of_students'] = $item['fields']['Total_Number_Of_Employees'];
          }
          if (!is_null($item['fields']['Company_Contact_Information'])) {
            $translated_field['field_university_contact_informa'] = $item['fields']['Company_Contact_Information']; 
          }
          if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Lead_Coordinator']; 
          }
          if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
            $translated_field['field_name_of_poc_coordinator'] = $item['fields']['Name_Of_POC_Coordinator'];
          }
          if (!is_null($item['fields']['Feedback'])) {
            $translated_field['field_feedback'] = $item['fields']['Feedback'];
          }
          if (!is_null($item['fields']['Remarks'])) {
            $translated_field['field_remarks'] = $item['fields']['Remarks'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_c_connect',]);
        //  field_related_fields
        if (!is_null($item['fields']['Name_Of_Company'])) {
          $paragraph->set('field_name_of_university', $item['fields']['Name_Of_Company']); 
        }
        if (!is_null($item['fields']['Address_Of_Company'])) {
          $paragraph->set('field_address_of_university', $item['fields']['Address_Of_Company']); 
        }
        if (!is_null($item['fields']['Place'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Place']); 
        }
        if (!is_null($item['fields']['Duration_Of_Program'])) {
          $paragraph->set('field_duration_of_program', $item['fields']['Duration_Of_Program']); 
        }
        if (!is_null($item['fields']['Number_Of_Seekers'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Seekers']); 
        }
        if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
          $paragraph->set('field_total_number_of_students', $item['fields']['Total_Number_Of_Employees']); 
        }
        if (!is_null($item['fields']['Company_Contact_Information'])) {
          $paragraph->set('field_university_contact_informa', $item['fields']['Company_Contact_Information']); 
        }
        if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Lead_Coordinator']); 
        }
        if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
          $paragraph->set('field_name_of_poc_coordinator', $item['fields']['Name_Of_POC_Coordinator']); 
        }
        if (!is_null($item['fields']['Feedback'])) {
          $paragraph->set('field_feedback', $item['fields']['Feedback']); 
        }
        if (!is_null($item['fields']['Remarks'])) {
          $paragraph->set('field_remarks', $item['fields']['Remarks']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'hfn_g_connect') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_Department'])) {
            $translated_field['field_name_of_university'] = $item['fields']['Name_Of_Department']; 
          }
          if (!is_null($item['fields']['Address_Of_Department'])) {
            $translated_field['field_address_of_university'] = $item['fields']['Address_Of_Department']; 
          }
          if (!is_null($item['fields']['Place'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Place']; 
          }
          if (!is_null($item['fields']['Duration_Of_Program'])) {
            $translated_field['field_duration_of_program'] = $item['fields']['Duration_Of_Program']; 
          }
          if (!is_null($item['fields']['Number_Of_Seekers'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Seekers']; 
          }
          if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
            $translated_field['field_total_number_of_students'] = $item['fields']['Total_Number_Of_Employees'];
          }
          if (!is_null($item['fields']['Department_Contact_Information'])) {
            $translated_field['field_university_contact_informa'] = $item['fields']['Department_Contact_Information']; 
          }
          if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Lead_Coordinator']; 
          }
          if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
            $translated_field['field_name_of_poc_coordinator'] = $item['fields']['Name_Of_POC_Coordinator'];
          }
          if (!is_null($item['fields']['Feedback'])) {
            $translated_field['field_feedback'] = $item['fields']['Feedback'];
          }
          if (!is_null($item['fields']['Remarks'])) {
            $translated_field['field_remarks'] = $item['fields']['Remarks'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_g_connect',]);
        //  field_related_fields
        if (!is_null($item['fields']['Name_Of_Department'])) {
          $paragraph->set('field_name_of_university', $item['fields']['Name_Of_Department']); 
        }
        if (!is_null($item['fields']['Address_Of_Department'])) {
          $paragraph->set('field_address_of_university', $item['fields']['Address_Of_Department']); 
        }
        if (!is_null($item['fields']['Place'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Place']); 
        }
        if (!is_null($item['fields']['Duration_Of_Program'])) {
          $paragraph->set('field_duration_of_program', $item['fields']['Duration_Of_Program']); 
        }
        if (!is_null($item['fields']['Number_Of_Seekers'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Seekers']); 
        }
        if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
          $paragraph->set('field_total_number_of_students', $item['fields']['Total_Number_Of_Employees']); 
        }
        if (!is_null($item['fields']['Department_Contact_Information'])) {
          $paragraph->set('field_university_contact_informa', $item['fields']['Department_Contact_Information']); 
        }
        if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Lead_Coordinator']); 
        }
        if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
          $paragraph->set('field_name_of_poc_coordinator', $item['fields']['Name_Of_POC_Coordinator']); 
        }
        if (!is_null($item['fields']['Feedback'])) {
          $paragraph->set('field_feedback', $item['fields']['Feedback']); 
        }
        if (!is_null($item['fields']['Remarks'])) {
          $paragraph->set('field_remarks', $item['fields']['Remarks']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'hfn_open_house') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['No_of_Participants'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['No_of_Participants']; 
          }
          if (!is_null($item['fields']['Heartfulness_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Heartfulness_Coordinator']; 
          }
          if (!is_null($item['fields']['Place'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Place']; 
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_open_house',]);
        if (!is_null($item['fields']['No_of_Participants'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['No_of_Participants']); 
        }
        if (!is_null($item['fields']['Heartfulness_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Heartfulness_Coordinator']); 
        }
        if (!is_null($item['fields']['Place'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Place']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        //  field_related_fields
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'hfn_u_connect') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_University'])) {
            $translated_field['field_name_of_university'] = $item['fields']['Name_Of_University']; 
          }
          if (!is_null($item['fields']['Address_Of_University'])) {
            $translated_field['field_address_of_university'] = $item['fields']['Address_Of_University']; 
          }
          if (!is_null($item['fields']['Place'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Place']; 
          }
          if (!is_null($item['fields']['Duration_Of_Program'])) {
            $translated_field['field_duration_of_program'] = $item['fields']['Duration_Of_Program']; 
          }
          if (!is_null($item['fields']['Number_Of_Seekers'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Seekers']; 
          }
          if (!is_null($item['fields']['Nature_Of_Seekers'])) {
            $translated_field['field_nature_of_speakers'] = $item['fields']['Nature_Of_Seekers']; 
          }
          if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
            $translated_field['field_total_number_of_students'] = $item['fields']['Total_Number_Of_Employees'];
          }
          if (!is_null($item['fields']['University_Contact_Information'])) {
            $translated_field['field_university_contact_informa'] = $item['fields']['University_Contact_Information']; 
          }
          if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Lead_Coordinator']; 
          }
          if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
            $translated_field['field_name_of_poc_coordinator'] = $item['fields']['Name_Of_POC_Coordinator'];
          }
          if (!is_null($item['fields']['Feedback'])) {
            $translated_field['field_feedback'] = $item['fields']['Feedback'];
          }
          if (!is_null($item['fields']['Remarks'])) {
            $translated_field['field_remarks'] = $item['fields']['Remarks'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_u_connect',]);
        //  field_related_fields
        if (!is_null($item['fields']['Name_Of_University'])) {
          $paragraph->set('field_name_of_university', $item['fields']['Name_Of_University']); 
        }
        if (!is_null($item['fields']['Address_Of_University'])) {
          $paragraph->set('field_address_of_university', $item['fields']['Address_Of_University']); 
        }
        if (!is_null($item['fields']['Place'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Place']); 
        }
        if (!is_null($item['fields']['Duration_Of_Program'])) {
          $paragraph->set('field_duration_of_program', $item['fields']['Duration_Of_Program']); 
        }
        if (!is_null($item['fields']['Number_Of_Seekers'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Seekers']); 
        }
        if (!is_null($item['fields']['Total_Number_Of_Students'])) {
          $paragraph->set('field_total_number_of_students', $item['fields']['Total_Number_Of_Students']); 
        }
        if (!is_null($item['fields']['University_Contact_Information'])) {
          $paragraph->set('field_university_contact_informa', $item['fields']['University_Contact_Information']); 
        }
        if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Lead_Coordinator']); 
        }
        if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
          $paragraph->set('field_name_of_poc_coordinator', $item['fields']['Name_Of_POC_Coordinator']); 
        }
        if (!is_null($item['fields']['Feedback'])) {
          $paragraph->set('field_feedback', $item['fields']['Feedback']); 
        }
        if (!is_null($item['fields']['Remarks'])) {
          $paragraph->set('field_remarks', $item['fields']['Remarks']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'hfn_v_connect') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_Village'])) {
            $translated_field['field_name_of_university'] = $item['fields']['Name_Of_Village']; 
          }
          if (!is_null($item['fields']['Address_Of_Village'])) {
            $translated_field['field_address_of_university'] = $item['fields']['Address_Of_Village']; 
          }
          if (!is_null($item['fields']['Place'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Place']; 
          }
          if (!is_null($item['fields']['Duration_Of_Program'])) {
            $translated_field['field_duration_of_program'] = $item['fields']['Duration_Of_Program']; 
          }
          if (!is_null($item['fields']['Number_Of_Seekers'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['Number_Of_Seekers']; 
          }
          if (!is_null($item['fields']['Total_Number_Of_Employees'])) {
            $translated_field['field_total_number_of_students'] = $item['fields']['Total_Number_Of_Employees'];
          }
          if (!is_null($item['fields']['Village_Contact_Information'])) {
            $translated_field['field_university_contact_informa'] = $item['fields']['Village_Contact_Information']; 
          }
          if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Lead_Coordinator']; 
          }
          if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
            $translated_field['field_name_of_poc_coordinator'] = $item['fields']['Name_Of_POC_Coordinator'];
          }
          if (!is_null($item['fields']['Feedback'])) {
            $translated_field['field_feedback'] = $item['fields']['Feedback'];
          }
          if (!is_null($item['fields']['Remarks'])) {
            $translated_field['field_remarks'] = $item['fields']['Remarks'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'hfn_v_connect',]);
        //  field_related_fields
        if (!is_null($item['fields']['Name_Of_Village'])) {
          $paragraph->set('field_name_of_university', $item['fields']['Name_Of_Village']); 
        }
        if (!is_null($item['fields']['Address_Of_Village'])) {
          $paragraph->set('field_address_of_university', $item['fields']['Address_Of_Village']); 
        }
        if (!is_null($item['fields']['Place'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Place']); 
        }
        if (!is_null($item['fields']['Duration_Of_Program'])) {
          $paragraph->set('field_duration_of_program', $item['fields']['Duration_Of_Program']); 
        }
        if (!is_null($item['fields']['Number_Of_Seekers'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['Number_Of_Seekers']); 
        }
        if (!is_null($item['fields']['Total_Number_Of_People'])) {
          $paragraph->set('field_total_number_of_students', $item['fields']['Total_Number_Of_People']); 
        }
        if (!is_null($item['fields']['Village_Contact_Information'])) {
          $paragraph->set('field_university_contact_informa', $item['fields']['Village_Contact_Information']); 
        }
        if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Lead_Coordinator']); 
        }
        if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
          $paragraph->set('field_name_of_poc_coordinator', $item['fields']['Name_Of_POC_Coordinator']); 
        }
        if (!is_null($item['fields']['Feedback'])) {
          $paragraph->set('field_feedback', $item['fields']['Feedback']); 
        }
        if (!is_null($item['fields']['Remarks'])) {
          $paragraph->set('field_remarks', $item['fields']['Remarks']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    if (strtolower($item['type']) == 'essay_writing_events') {
      if ($item['language'] != 'en' && $node->hasTranslation($item['language'])) {
        if ($parent_node) {
          $add_related = $parent_node->get('field_related_fields')->getValue();
          $paragraph = Paragraph::load($add_related[0]['target_id']);
          $entity_array = $paragraph->toArray();
          $translated_fields = [];
          if (!is_null($item['fields']['Name_Of_Institution'])) {
            $translated_field['field_name_of_university'] = $item['fields']['Name_Of_Institution']; 
          }
          if (!is_null($item['fields']['Location'])) {
            $translated_field['field_place_of_event'] = $item['fields']['Location']; 
          }
          if (!is_null($item['fields']['No_of_Participants'])) {
            $translated_field['field_number_of_participants'] = $item['fields']['No_of_Participants']; 
          }
          if (!is_null($item['fields']['Institution_Contact_Information'])) {
            $translated_field['field_university_contact_informa'] = $item['fields']['Institution_Contact_Information']; 
          }
          if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
            $translated_field['field_name_of_event_coordinator'] = $item['fields']['Name_Of_Lead_Coordinator']; 
          }
          if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
            $translated_field['field_name_of_poc_coordinator'] = $item['fields']['Name_Of_POC_Coordinator'];
          }
          if (!is_null($item['fields']['Remarks'])) {
            $translated_field['field_remarks'] = $item['fields']['Remarks'];
          }
          $translated_entity_array = array_merge($entity_array, $translated_fields);
          $paragraph->addTranslation($item['language'],$entity_array);
          $paragraph->save();
        }
      } 
      if ($item['language'] == 'en') {
        $paragraph = Paragraph::create(['type' => 'essay_writing_events',]);
        //  field_related_fields
        if (!is_null($item['fields']['Name_Of_Institution'])) {
          $paragraph->set('field_name_of_university', $item['fields']['Name_Of_Institution']); 
        }
        if (!is_null($item['fields']['Location'])) {
          $paragraph->set('field_place_of_event', $item['fields']['Location']); 
        }
        if (!is_null($item['fields']['No_of_Participants'])) {
          $paragraph->set('field_number_of_participants', $item['fields']['No_of_Participants']); 
        }
        if (!is_null($item['fields']['Institution_Contact_Information'])) {
          $paragraph->set('field_university_contact_informa', $item['fields']['Institution_Contact_Information']); 
        }
        if (!is_null($item['fields']['Name_Of_Lead_Coordinator'])) {
          $paragraph->set('field_name_of_event_coordinator', $item['fields']['Name_Of_Lead_Coordinator']); 
        }
        if (!is_null($item['fields']['Name_Of_POC_Coordinator'])) {
          $paragraph->set('field_name_of_poc_coordinator', $item['fields']['Name_Of_POC_Coordinator']); 
        }
        if (!is_null($item['fields']['Remarks'])) {
          $paragraph->set('field_remarks', $item['fields']['Remarks']); 
        }
        $paragraph->isNew();
        $paragraph->save();
        $current = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );
        $node->set('field_related_fields', $current);
      }
    }
    // Handling Paragraphs end.
    
    return $node;
  }
  /**
   * Newscoopmigrate.
   *
   * @return string
   *   Return Hello string.
   */
  public function NewscoopMigrate() {

  /*$check = new CustomGuzzleHttp();
    $response = $check->performRequest('http://news.sahajmarg.org/api/sections/7/en/articles?&page=10&items_per_page=50&language=en');
    $section_id = $response['id'];
    foreach ($response['items'] as $item) {
      if ($item['language'] == 'en') {
        $node = Node::create(['type' => 'news_and_articles']);
        $node->language = $item['language'];
        if ($section_id == 14) {
          $section_id = 7;
        }
        $node->set('field_article_section', $section_id);
        $node = $this->addAllFields_from_newscoop($node,$item);
        if (isset($item['translations'])) {
          foreach ($item['translations'] as $lang_key => $translate_url) {
            $node_translated = $node->addTranslation($lang_key);
            $node_translated->language = $lang_key;
            $translatable_check = new CustomGuzzleHttp();
            $item = $translatable_check->performRequest($translate_url);
            $node_translated = $this->addAllFields_from_newscoop($node_translated,$item,$node);
          }
        }
        $node->enforceIsNew();
        $node->setPublished(TRUE);
        $node->save(); 
      }
    }*/
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: NewscoopMigrate')
    ];
  }

}
