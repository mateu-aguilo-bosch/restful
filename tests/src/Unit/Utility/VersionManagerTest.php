<?php

/**
 * @file
 * Contains \Drupal\Tests\restful\Unit\Utility\VersionManagerTest.
 */

namespace Drupal\Tests\restful\Unit\Utility;
use Drupal\restful\Utility\VersionManager;
use Drupal\Tests\UnitTestCase;

/**
 * Class VersionManager.
 *
 * @package Drupal\Tests\restful\Unit\Utility
 *
 * @coversDefaultClass \Drupal\restful\Utility\VersionManager
 *
 * @group RESTful
 */
class VersionManagerTest extends UnitTestCase {

  /**
   * Test the factory.
   *
   * @covers ::createInstance
   */
  public function testCreateInstance() {
    $manager = new VersionManager();
    $version = 'v' . (int) mt_rand(1, 10) . '.' . (int) mt_rand(1, 10);
    $output = $manager->createInstance([$version]);
    $this->assertInstanceOf('\Drupal\restful\Utility\Version', $output);
  }

}
