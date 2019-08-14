<?php

namespace Drupal\my_custom_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'My Custom Form' block.
 * Place this form to anywhere.
 * @Block(
 *  id = "my_custom_form_block",
 *  admin_label = @Translation("My Custom Form Block"),
 * )
 */
class MyCustomForm extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\my_custom_form\Form\myCustomForm');
    return $form;

  }
}
