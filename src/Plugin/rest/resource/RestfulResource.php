<?php

namespace Drupal\restful\Plugin\rest\resource;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\restful\Utility\VersionManagerInterface;
use Psr\Log\LoggerInterface;
use Drupal\rest\Plugin\rest\resource\EntityResource;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "restful_entity",
 *   label = @Translation("RESTful Entity"),
 *   serialization_class = "Drupal\Core\Entity\Entity",
 *   deriver = "Drupal\restful\Plugin\Deriver\ResourceDeriver",
 *   uri_paths = {
 *     "canonical" = "/entity/{entity_type}/{entity}",
 *     "https://www.drupal.org/link-relations/create" = "/entity/{entity_type}"
 *   }
 * )
 *
 * @see \Drupal\restful\Plugin\Deriver\ResourceDeriver
 */
class RestfulResource extends EntityResource {

  /**
   * The version manager.
   *
   * @var VersionManagerInterface
   */
  protected $versionManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, array $serializer_formats, LoggerInterface $logger, VersionManagerInterface $version_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->versionManager = $version_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('restful.version_manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  protected function getBaseRoute($canonical_path, $method) {
    $route = parent::getBaseRoute($canonical_path, $method);

    $route->setRequirement('_permission', 'access RESTful resources');

    return $route;
  }

  /**
   * Check if the resource is the latest version for the configured path.
   *
   * @param EntityStorageInterface $storage
   *   The entity storage object.
   *
   * @return bool
   *   TRUE if it's the latest version. FALSE otherwise.
   */
  public function isLatest(EntityStorageInterface $storage) {
    $resource_id = str_replace('restful_entity:', '', $this->getPluginId());
    return $this->getLatest($resource_id, $storage)->id() == $resource_id;
  }

  /**
   * Gets the latest version for the current resource.
   *
   * @param string $resource_id
   *   The resource ID. Ex: "articles.v1.9".
   * @param EntityStorageInterface $storage
   *   The storage for resource entities.
   *
   * @return RestfulResource
   *   The latest resource.
   */
  protected function getLatest($resource_id, EntityStorageInterface $storage) {
    static $latest_entities = [];
    /* @var \Drupal\restful\ResourceConfigInterface $resource_config */
    $resource_config = $storage->load($resource_id);
    $path = $resource_config->getPath();
    if (isset($latest_entities[$path])) {
      return $latest_entities[$path];
    }
    $results = $storage
      ->getQuery()
      ->condition('path', $path)
      ->execute();
    /* @var \Drupal\restful\ResourceConfigInterface[] $entities */
    $entities = $storage->loadMultiple(array_keys($results));
    usort($entities, function ($resource1, $resource2) {
      // Remove the leading 'v' and explode to get the major and minor version.
      $version1 = $this->versionManager->createInstance([$resource1->getVersion()]);
      $version2 = $this->versionManager->createInstance([$resource2->getVersion()]);
      return $version1->compare($version2);
    });
    $latest_entities[$path] = array_pop($entities);
    return $latest_entities[$path];
  }

}
