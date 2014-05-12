<?php

$plugin = array(
  'label' => t('Entity tests'),
  'description' => t('Export a multiple bundles.'),
  'resource' => 'entity_tests',
  'name' => 'entity_tests__1_5',
  'entity_type' => 'entity_test',
  'bundles' => array(
    'main' => 'entity_tests',
    'test' => 'test_resource',
  ),
  'class' => 'RestfulTestEntityTestsResource__1_5',
  'minor_version' => 5,
);
