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
  const PRODUCTION_CLASS = '\Drupal\restful\Utility\Version';

  /**
   * Instantiates a VersionManager object.
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  public function createInstance(array $arguments) {
    return call_user_func_array($this::PRODUCTION_CLASS . '::create', $arguments);
  }

}
