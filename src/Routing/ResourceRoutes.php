<?php

/**
 * @file
 * Contains \Drupal\restful\Routing\ResourceRoutes.
 */

namespace Drupal\restful\Routing;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\rest\Plugin\ResourceInterface;
use Drupal\rest\Plugin\Type\ResourcePluginManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Subscriber for REST-style routes.
 */
class ResourceRoutes extends RouteSubscriberBase {

  /**
   * The plugin manager for REST plugins.
   *
   * @var \Drupal\rest\Plugin\Type\ResourcePluginManager
   */
  protected $manager;

  /**
   * The Drupal configuration factory.
   *
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * A logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a RouteSubscriber object.
   *
   * @param \Drupal\rest\Plugin\Type\ResourcePluginManager $manager
   *   The resource plugin manager.
   * @param EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   */
  public function __construct(ResourcePluginManager $manager, EntityTypeManagerInterface $entity_type_manager, LoggerInterface $logger) {
    $this->manager = $manager;
    $this->entityTypeManager = $entity_type_manager;
    $this->logger = $logger;
  }

  /**
   * Alters existing routes for a specific collection.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection for adding routes.
   *
   * @return array
   */
  protected function alterRoutes(RouteCollection $collection) {
    $storage = $this->entityTypeManager->getStorage('resource_config');
    $enabled_resources = $storage->loadMultiple();
    // Iterate over all enabled resource plugins.
    foreach ($enabled_resources as $id => $resource_config) {
      /* @var \Drupal\restful\Plugin\rest\resource\RestfulResource $plugin */
      $plugin = $this->manager->getInstance(['id' => 'restful_entity:' . $id]);
      $this->addRouteVariants($collection, $plugin, $plugin->isLatest($storage));
    }
  }

  /**
   * Add the different routes per method and format.
   *
   * @param RouteCollection $collection
   *   The collection of routes.
   * @param ResourceInterface $plugin
   *   The REST plugin.
   * @param bool $is_latest
   *   Boolean indicating if this is the latest version of the resource.
   */
  protected function addRouteVariants(RouteCollection $collection, ResourceInterface $plugin, $is_latest = FALSE) {
    foreach ($plugin->routes() as $name => $route) {
      /* @var \Symfony\Component\Routing\Route $route */
      // @todo: Are multiple methods possible here?
      $methods = $route->getMethods();
      // Only expose routes where the method is enabled in the configuration.
      if ($methods && ($method = $methods[0]) && $method) {
        $route->setRequirement('_access_rest_csrf', 'TRUE');
        $definition = $plugin->getPluginDefinition();
        if ($method != 'POST') {
          // Make sure that the matched route is for the correct bundle.
          $route->setRequirement('_entity_type', $definition['entity_type']);
          $route->setRequirement('_bundle', $definition['bundle']);
        }
        $collection->add("rest.$name", $route);

        if ($is_latest) {
          $new_route = clone $route;
          // If this is the latest version of the resource we need to re-add the
          // route without the version prefix.
          $version = $definition['version'];
          $new_path = str_replace('/' . $version, '', $new_route->getPath());
          $new_name = str_replace('.' . $version, '', $name);
          $new_route->setPath($new_path);
          $collection->add("rest.$new_name", $new_route);
        }
      }
    }
  }

}
