<?php

/**
 * @file
 * Contains \Drupal\snippets\Plugin\field\formatter\SnippetsDefaultFormatter.
 */

namespace Drupal\my_contact_form\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'snippets_default' formatter.
 *
 * @FieldFormatter(
 *   id = "snippets_default",
 *   label = @Translation("Snippets default"),
 *   field_types = {
 *     "snippets_code"
 *   }
 * )
 */
class SnippetsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    foreach ($items as $delta => $item) {
      // Render output using snippets_default theme.
      $source = array(
        '#theme' => 'snippets_default',
        '#source_description' => $item->source_description,
        '#source_code' => $item->source_code,
      );

      $elements[$delta] = array('#markup' => drupal_render($source));
    }

    return $elements;
  }
}
