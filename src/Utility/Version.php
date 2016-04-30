<?php

/**
 * @file
 * Contains \Drupal\restful\Utility\Version.
 */

namespace Drupal\restful\Utility;

use Drupal\restful\Exception\ServerConfigurationException;

/**
 * Class Version.
 *
 * @package Drupal\restful\Utility
 */
class Version implements VersionInterface {

  /**
   * Major version.
   *
   * @var int
   */
  protected $major;

  /**
   * Minor version.
   *
   * @var int
   */
  protected $minor;

  /**
   * Instantiates a new version object.
   *
   * @param string $version_string
   *   The version string as found in the URL.
   *
   * @throws ServerConfigurationException
   *   If the version cannot be parsed.
   */
  public function __construct($version_string) {
    if (strpos($version_string, 'v') !== 0) {
      throw new ServerConfigurationException(sprintf('Unable to parse version %s.', $version_string));
    }
    $version_string = substr($version_string, 1);
    list($this->major, $this->minor) = explode('.', $version_string);
    if ($this->major != (int) $this->major || $this->minor != (int) $this->minor) {
      throw new ServerConfigurationException(sprintf('The major and minor version numbers need to be integers. Provided: %s.', $version_string));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function compare(VersionInterface $version) {
    return $this->getMajor() == $version->getMajor() ? $this->getMinor() - $version->getMinor() : $this->getMajor() - $version->getMajor();
  }

  /**
   * {@inheritdoc}
   */
  public static function create($version_string) {
    return new static($version_string);
  }

  /**
   * {@inheritdoc}
   */
  public function getMajor() {
    return $this->major;
  }

  /**
   * {@inheritdoc}
   */
  public function getMinor() {
    return $this->minor;
  }

  /**
   * Make it a string.
   *
   * @return string
   *   The string representation.
   */
  public function __toString() {
    return sprintf('v%d.%d', $this->getMajor(), $this->getMinor());
  }

}
