<?php
namespace Drupal\ask_daaji\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "ask_daaji_question_block",
 *   admin_label = @Translation("Ask Daaji Question"),
 *   category = @Translation("Ask Daaji Custom Quesiton")
 * )
 */
class QuestionFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\ask_daaji\Form\QuestionForm');

    return $form;
   }
}