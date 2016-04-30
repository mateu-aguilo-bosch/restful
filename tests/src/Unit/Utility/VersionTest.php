<?php

/**
 * @file
 * Contains \Drupal\Tests\restful\Unit\Utility\VersionTest.
 */
namespace Drupal\Tests\restful\Unit\Utility;
use Drupal\restful\Utility\Version;
use Drupal\restful\Utility\VersionInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Class VersionTest.
 *
 * @package Drupal\Tests\restful\Unit\Utility
 *
 * @coversDefaultClass Drupal\restful\Utility\Version
 *
 * @group RESTful
 */
class VersionTest extends UnitTestCase {

  /**
   * Test factory method.
   *
   * @covers ::create
   */
  public function testCreate() {
    $version = 'v' . (int) mt_rand(1, 10) . '.' . (int) mt_rand(1, 10);
    $this->assertInstanceOf('\Drupal\restful\Utility\Version', Version::create($version));
  }

  /**
   * Tests getters.
   *
   * @covers ::getMajor
   * @covers ::getMinor
   */
  public function testGetters() {
    $major = (int) mt_rand(1, 10);
    $minor = (int) mt_rand(1, 10);
    $version_string = "v$major.$minor";
    $version = new Version($version_string);
    $this->assertEquals($major, $version->getMajor());
    $this->assertEquals($minor, $version->getMinor());
  }

  /**
   * Tests getters.
   *
   * @covers ::__toString
   */
  public function testString() {
    $version_string = 'v' . (int) mt_rand(1, 10) . '.' . (int) mt_rand(1, 10);
    $version = new Version($version_string);
    $this->assertEquals($version_string, (string) $version);
  }

  /**
   * Test the comparation method.
   *
   * @covers ::compare
   *
   * @dataProvider compareDataProvider
   */
  public function testCompare(VersionInterface $version, VersionInterface $version2, $exppected) {
    $this->assertEquals($exppected, $version->compare($version2));
  }

  /**
   * Compare data provider.
   */
  public function compareDataProvider() {
    $ver1 = new Version('v1.0');
    $ver2 = new Version('v1.1');
    $ver3 = new Version('v2.1');
    $ver4 = new Version('v2.3');
    return [
      [$ver1, $ver2, -1],
      [$ver1, $ver3, -1],
      [$ver1, $ver4, -1],
      [$ver2, $ver3, -1],
      [$ver2, $ver4, -1],
      [$ver3, $ver4, -2],
    ];
  }

}
