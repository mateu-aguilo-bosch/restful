<?php

/**
 * @file
 * Contains \Drupal\restful\Utility\FactoryInterface.
 */

namespace Drupal\restful\Utility;

/**
 * Class FactoryInterface.
 *
 * @package Drupal\restful\Utility
 */
interface FactoryInterface {

  /**
   * Creates an instance of the pre-coonfigured object.
   *
   * @param array $arguments
   *   An array containing all the arguments to pass to the constructor.
   *
   * @return mixed
   *   An instance of whatever object this factory is for.
   */
  public function createInstance(array $arguments);

}
