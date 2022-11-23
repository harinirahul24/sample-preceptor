<?php

namespace Drupal\moderated_content_bulk_publish;

class AdminHelper {

  static public function addMessage($message) {
    \Drupal::messenger()->addMessage($message);
  }

  static public function addToLog($message, $DEBUG = FALSE) {
    //$DEBUG = TRUE;
    if ($DEBUG) {
      \Drupal::logger('moderated_content_bulk_publish')->notice($message);
    }
  }

  /**
   * Helper function to get all enabled languages, excluding current language.
   */
  static public function getOtherEnabledLanguages() {
    // Get the list of all languages
    $language = \Drupal::languageManager()->getCurrentLanguage();
    $languages = \Drupal::languageManager()->getLanguages();
    $other_languages = array();

    // Add each enabled language, aside from the current language to an array.
    foreach ($languages as $field_language_code => $field_language) {
      if ($field_language_code != $language->getId()) {
        $other_languages[$field_language_code] = $field_language->getName();
      }
    }
    return $other_languages;
  }

  /**
   * Helper function get current language.
   */
  static public function getDefaultLangcode() {
    $language = \Drupal::languageManager()->getDefaultLanguage();
    return $language->getId();
  }

  /**
   * Helper function to get all enabled languages, including the current language.
   */
  static public function getAllEnabledLanguages() {
    // Get the list of all languages
    $language = \Drupal::languageManager()->getCurrentLanguage();
    $languages = \Drupal::languageManager()->getLanguages();
    $other_languages = array();

    // Add each enabled language, aside from the current language to an array.
    foreach ($languages as $field_language_code => $field_language) {
      $other_languages[$field_language_code] = $field_language->getName();
    }
    return $other_languages;
  }

}

