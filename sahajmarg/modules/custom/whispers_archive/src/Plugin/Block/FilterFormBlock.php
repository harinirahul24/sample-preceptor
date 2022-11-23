<?php
namespace Drupal\whispers_archive\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "whispers_archive_form",
 *   admin_label = @Translation("Whispers Archive Form"),
 *   category = @Translation("Whispers Archive Custom Form")
 * )
 */
class FilterFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\whispers_archive\Form\FilterForm');

    return $form;
   }
}