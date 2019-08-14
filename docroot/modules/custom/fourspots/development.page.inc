<?php

/**
 * @file
 * Contains development.page.inc.
 *
 * Page callback for Development entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Development templates.
 *
 * Default template: development.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_development(array &$variables) {
  // Fetch development Entity Object.
  $development = $variables['elements']['#development'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
