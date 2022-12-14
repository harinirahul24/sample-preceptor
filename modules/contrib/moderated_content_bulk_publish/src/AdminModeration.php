<?php
namespace Drupal\moderated_content_bulk_publish;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\moderated_content_bulk_publish\AdminHelper;

/**
 * A Helper Class to assist with the publishing and unpublishing bulk action.
 *   - Called by Publish Latest Revision and Unpublish Current Revision Bulk Operations
 *   - Easy one-stop shop to make modifications to these bulk actions.
 */
class AdminModeration
{
    //set this to true to send to $testEmailList
    private $testMode = false;
    private $entity = null;
    private $id = 0;
    private $status = 0; // Default is 0, unpublish.

    public function __construct($entity, $status)
    {
      $this->entity = $entity;
      if (!is_null($status)) {
        $this->status = $status;
      }
      $this->id = $this->entity->id();
    }

    /**
     * Unpublish current revision.
     */
    public function unpublish() {
      $user = \Drupal::currentUser();
      $allLanguages = AdminHelper::getAllEnabledLanguages();
      foreach ($allLanguages as $langcode => $languageName) {
        if ($this->entity->hasTranslation($langcode)) {
          \Drupal::logger('moderated_content_bulk_publish')->notice(
            utf8_encode("Unpublish $langcode for " . $this->id . " in moderated_content_bulk_publish")
          );
          $this->entity = $this->entity->getTranslation($langcode);
          $this->entity->set('moderation_state', 'archived');
          if ($this->entity instanceof RevisionLogInterface) {
            // $now = time();
            $this->entity->setRevisionCreationTime(\Drupal::time()->getRequestTime());
            $msg = 'Bulk operation create archived revision';
            $this->entity->setRevisionLogMessage($msg);
            $current_uid = \Drupal::currentUser()->id();
            $this->entity->setRevisionUserId($current_uid);
          }
          $this->entity->setSyncing(TRUE);
          $this->entity->setRevisionTranslationAffected(TRUE);
          if ($user->hasPermission('moderated content bulk unpublish')) {
            $this->entity->save();
          }
          else {
            \Drupal::logger('moderated_content_bulk_publish')->notice(
              utf8_encode("Bulk unpublish not permitted, check permissions")
            );
          }
        }
      }
      foreach ($allLanguages as $langcode => $languageName) {
        if ($this->entity->hasTranslation($langcode)) {
          $this->entity = $this->entity->getTranslation($langcode);
          $this->entity->set('moderation_state', 'draft');
          if ($this->entity instanceof RevisionLogInterface) {
            // $now = time();
            $this->entity->setRevisionCreationTime(\Drupal::time()->getRequestTime());
            $msg = 'Bulk operation create draft revision';
            $this->entity->setRevisionLogMessage($msg);
            $current_uid = \Drupal::currentUser()->id();
            $this->entity->setRevisionUserId($current_uid);
          }
          $this->entity->setRevisionTranslationAffected(TRUE);
          if ($user->hasPermission('moderated content bulk unpublish')) {
            $this->entity->save();
          }
          else {
            \Drupal::logger('moderated_content_bulk_publish')->notice(
              utf8_encode("Bulk unpublish not permitted, check permissions.")
            );
          }
        }
      }
      return $this->entity;
    }


    /**
     * Publish Latest Revision.
     */
    public function publish() {
      $user = \Drupal::currentUser();
      $allLanguages = AdminHelper::getAllEnabledLanguages();
      foreach ($allLanguages as $langcode => $languageName) {
        if ($this->entity->hasTranslation($langcode)) {
          \Drupal::logger('moderated_content_bulk_publish')->notice(
            utf8_encode("Publish latest revision $langcode for " . $this->id . " in moderated_content_bulk_publish")
          );
          $latest_revision = self::_latest_revision($this->entity->id(), $vid, $langcode);
          if (!$latest_revision === FALSE) {
            $this->entity = $latest_revision;
          }
          $this->entity = $this->entity->getTranslation($langcode);
          $this->entity->set('moderation_state', 'published');
          if ($this->entity instanceof RevisionLogInterface) {
            // $now = time();
            $this->entity->setRevisionCreationTime(\Drupal::time()->getRequestTime());
            $msg = 'Bulk operation publish revision ';
            $this->entity->setRevisionLogMessage($msg);
            $current_uid = \Drupal::currentUser()->id();
            $this->entity->setRevisionUserId($current_uid);
          }
          $this->entity->setSyncing(TRUE);
          $this->entity->setRevisionTranslationAffected(TRUE);
          if ($user->hasPermission('moderated content bulk publish')) {
            $this->entity->save();
          }
          else {
            \Drupal::logger('moderated_content_bulk_publish')->notice(
              utf8_encode("Bulk publish not permitted, check permissions.")
            );
          }
        }
      }
      return $this->entity;
    }

    /**
     * Get the latest revision.
     */
    public static function _latest_revision($nid, &$vid, $langcode = NULL) {
      // Can be removed once we move to Drupal >= 8.6.0 , currently on 8.5.0.
      // See change record here: https://www.drupal.org/node/2942013 .
      $lang = $langcode;
      if (!isset($lang)) {
        $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
      }
      $latestRevisionResult = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
        ->latestRevision()
        ->condition('nid', $nid, '=')
        ->execute();
      if (count($latestRevisionResult)) {
        $node_revision_id = key($latestRevisionResult);
        if ($node_revision_id == $vid) {
          // There is no pending revision, the current revision is the latest.
          return FALSE;
        }
        $vid = $node_revision_id;
        $latestRevision = \Drupal::entityTypeManager()->getStorage('node')->loadRevision($node_revision_id);
        if ($latestRevision->language()->getId() != $lang && $latestRevision->hasTranslation($lang)) {
          $latestRevision = $latestRevision->getTranslation($lang);
        }
        return $latestRevision;
      }
      return FALSE;
    }
}
