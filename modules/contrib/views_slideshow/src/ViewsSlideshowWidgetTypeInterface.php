<?php

namespace Drupal\views_slideshow;

use Drupal\Component\Plugin\ConfigurableInterface;
use Drupal\Component\Plugin\DependentPluginInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Provides an interface for a Views slideshow widget type.
 */
interface ViewsSlideshowWidgetTypeInterface extends PluginInspectionInterface,  ConfigurableInterface, PluginFormInterface, DependentPluginInterface {

  /**
   * Check if the widget type is compatible with the selected slideshow.
   *
   * @return bool
   *   TRUE if the widget type is compatible with the slideshow.
   */
  public function checkCompatiblity($slideshow);

}
