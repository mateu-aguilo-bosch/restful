<?php

/**
 * @file
 * Contains RestfulExampleUsersResource.
 */

class RestfulExampleUsersResource extends RestfulEntityBaseNode {


  /**
   * Overrides RestfulExampleArticlesResource::getPublicFields().
   */
  public function getPublicFields() {
    $public_fields = parent::getPublicFields();

    if (module_exists('og')) {
      // Expose the groups a user is member of, given Organic groups module is
      // enabled, the group content type is called "group".
    }

    return $public_fields;
  }
}
