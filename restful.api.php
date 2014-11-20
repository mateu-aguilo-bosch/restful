<?php

/**
 * @file
 * Hooks provided by the RESTful module.
 */

/**
 * @addtogroup hooks
 * @{
 */


/**
 * Allow altering the request before it is processed.
 *
 * @param $request
 *   The request array.
 */
function hook_restful_parse_request_alter(&$request) {
  $request['__application'] += array(
    'some_header' => \RestfulManager::getHttpHeader('X_HTTP_SOME_HEADER'),
  );
}

/**
 * @} End of "addtogroup hooks".
 */
