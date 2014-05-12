<?php

/**
 * @file
 * Contains RestfulTestEntityTestsResource__1_5.
 */

class RestfulTestEntityTestsResource__1_5 extends RestfulEntityBaseMultipleBundles {

  /**
   * Overrides RestfulEntityBase::getPublicFields().
   */
  public function getPublicFields() {
    $public_fields = parent::getPublicFields();
    $public_fields['id']['property'] = 'pid';
    return $public_fields;
  }
}
