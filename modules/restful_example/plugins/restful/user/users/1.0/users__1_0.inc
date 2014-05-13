<?php

$plugin = array(
  'label' => t('Users'),
  'resource' => 'users',
  'name' => 'users__1_0',
  'entity_type' => 'user',
  'bundle' => 'user',
  'description' => t('Export the users entity (and single bundle).'),
  'class' => 'RestfulExampleUsersResource',
);
