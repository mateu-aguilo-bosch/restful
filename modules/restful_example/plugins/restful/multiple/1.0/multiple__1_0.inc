<?php

$plugin = array(
  'label' => t('Multiple'),
  'resource' => 'multiple',
  'name' => 'multiple__1_0',
  'entity_type' => 'node',
  'bundles' => array(
    'article' => 'articles',
    'company' => 'companies',
  ),
  'description' => t('Export multiple content types.'),
  'class' => 'RestfulExampleMultipleResource',
);
