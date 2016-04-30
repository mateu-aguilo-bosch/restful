<?php

/**
 * @file
 * Contains \Drupal\restful\Utility\VersionInterface.
 */

namespace Drupal\restful\Utility;

/**
 * Class VersionInterface.
 *
 * @package Drupal\restful\Utility
 */
interface VersionInterface {

  /**
   * Compares this version to the provided.
   *
   * @param VersionInterface $version
   *   The version object to compare with.
   *
   * @return int
   *   A negative value if the current version is lower. A positive if it's
   *   higher and a 0 if they are equal.
   */
  public function compare(VersionInterface $version);

  /**
   * Creates a version object.
   *
   * @param array $version_string
   *   The version string.
   */
  public static function create($version_string);

  /**
   * Gets the major version.
   *
   * @return mixed
   *   The major.
   */
  public function getMajor();

  /**
   * Gets the minor version.
   *
   * @return int
   *   The minor.
   */
  public function getMinor();

}
