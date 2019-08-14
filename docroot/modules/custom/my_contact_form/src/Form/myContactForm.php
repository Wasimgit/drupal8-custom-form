<?php

namespace Drupal\my_contact_form\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/*
      Implements My Contact Form Controller\
*/

class myContactForm extends FormBase{

  protected $callService;

  //GEt  form Id
  public function getFormId(){
        return 'myContactForm';
  }

  //Build form
  public function buildForm(array $form, FormStateInterface $form_state, $params = NULL){

      // Disable caching
      $form['#cache']['max-age'] = 0;

      // This will generate an anchor scroll to the form when submitting
      #$form['#action'] = '#my-contact-form';

      $form['personnal'] = array(
        '#type'  => 'fieldset',
        '#title' => $this->t('Your personnal data'),
      );
      $form['personnal']['firstname'] = array(
          '#title'       => $this->t('Your firstname *'),
          '#placeholder' => $this->t('Wasim'),
          '#type'        => 'textfield',
          '#attributes'  => ['size' => 25],
          '#required'    => false,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['lastname'] = array(
          '#title'       => $this->t('Your lastname *'),
          '#placeholder' => $this->t('Rochat'),
          '#type'        => 'textfield',
          '#attributes'  => ['size' => 24],
          '#required'    => false,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['email'] = array(
          '#title'       => $this->t('Your email *'),
          '#placeholder' => $this->t('wasim.khan@domain.com'),
          '#type'        => 'textfield',
          '#required'    => false,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['message'] = array(
        '#type'  => 'fieldset',
        '#title' => $this->t('Your message'),
      );
      $form['message']['subject'] = array(
          '#title'    => $this->t('Subject *'),
          '#type'     => 'textfield',
          '#required' => false,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['message']['message'] = array(
          '#title'       => $this->t('Message *'),
          '#type'        => 'textarea',
          '#required'    => false,
          '#attributes'  => ['cols' => 59],
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['actions']['submit'] = array(
          '#type'        => 'submit',
          '#value'       => $this->t('Send'),
          '#attributes'  => ['class' => array('btn-lg btn-primary pull-right')],
          '#button_type' => 'primary',
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      return $form;
  }
  // Validate form
  public function validateForm(array &$form, FormStateInterface $form_state) {
      // Assert the firstname is valid
      if (!$form_state->getValue('firstname') || empty($form_state->getValue('firstname'))) {
          $form_state->setErrorByName('[personnal][firstname]', $this->t('Please enter your first name.'));
      }
      // Assert the lastname is valid
      if (!$form_state->getValue('lastname') || empty($form_state->getValue('lastname'))) {
          $form_state->setErrorByName('[personnal][lastname]', $this->t('Please enter your last name.'));
      }
      // Assert the email is valid
      if (!$form_state->getValue('email') || !filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
          $form_state->setErrorByName('[personnal][email]', $this->t('Please enter your valid email.'));
      }
  }

//   // submit
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $field     = $form_state->getValues();
    $firstname = $field['firstname'];
    $lastname  = $field['lastname'];
    $email     = $field['email'];
    $subject   = $field['subject'];
    $message   = $field['message'];
    // Storing the form values as content type "My Contact Form"
    $node = Node::create([
          'type'            => 'my_contact_form',
          'title'           => 'My Contact Form Submissions',
          'field_firstname' => $firstname,
          'field_lastname'  => $lastname,
          'field_email'     => $email,
          'field_subject'   => $subject,
          'field_message'   => $message,
    ]);
    assert($node->isNew(), TRUE);
    $setMessage = $node->save();
    if ( isset($setMessage) ){
        \Drupal::messenger()->addMessage(t('Your Detials are stored successfully !'));
        // \Drupal::logger('my_message')->critical('hi there');
    }
  }
}
