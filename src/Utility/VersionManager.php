<?php

/**
 * @file
 * Contains \Drupal\restful\Utility\VersionManager.
 */

namespace Drupal\restful\Utility;

/**
 * Class VersionManager.
 *
 * @package Drupal\restful\Utility
 */
class VersionManager implements VersionManagerInterface {

  /**
   * The class to instantiate.
   *
   * @var string
   */
  protected static $productionClass = '\Drupal\restful\Utility\Version';

  /**
   * {@inheritdoc}
   */
  public function createInstance(array $arguments) {
    return call_user_func_array($this::$productionClass . '::create', $arguments);
  }

}
