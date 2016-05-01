<?php

/**
 * @file
 * Contains \Drupal\restful\RequestHandler.
 */

namespace Drupal\restful;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandler.
 *
 * @package Drupal\restful
 */
class RequestHandler extends \Drupal\rest\RequestHandler {

  /**
   * {@inheritdoc}
   */
  public function handle(RouteMatchInterface $route_match, Request $request) {
    $response = parent::handle($route_match, $request);
    $response->addCacheableDependency(new RequestCacheabilityDependency());
    return $response;
  }


}
