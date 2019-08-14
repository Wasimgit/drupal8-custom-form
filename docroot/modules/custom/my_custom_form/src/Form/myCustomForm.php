<?php

namespace Drupal\my_custom_form\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/*
      Implements My Custom Form Controller
*/

class myCustomForm extends FormBase{

  //GEt  form Id
  public function getFormId(){
        return 'myCustomForm';
  }

  //Build form
  public function buildForm(array $form, FormStateInterface $form_state, $params = NULL){

      // Disable caching
      $form['#cache']['max-age'] = 0;

      // This will generate an anchor scroll to the form when submitting
      #$form['#action'] = '#my-Custom-form';

      $form['personnal'] = array(
        '#type'  => 'fieldset',
        '#title' => $this->t('Your personnal data'),
      );
      $form['personnal']['name'] = array(
          '#title'       => $this->t('Your name'),
          '#placeholder' => $this->t('Name'),
          '#type'        => 'textfield',
          '#attributes'  => ['size' => 25],
          '#required'    => true,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['mobilenumber'] = array(
          '#title'       => $this->t('Your mobile number'),
          '#placeholder' => $this->t('Number'),
          '#type'        => 'textfield',
          '#attributes'  => ['size' => 10],
          '#required'    => true,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['email'] = array(
          '#title'       => $this->t('Your email'),
          '#placeholder' => $this->t('example@domain.com'),
          '#type'        => 'textfield',
          '#required'    => true,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['age'] = array(
          '#title'       => $this->t('Your age'),
          '#placeholder' => $this->t('Age in years'),
          '#type'        => 'textfield',
          '#attributes'  => ['size' => 2],
          '#required'    => true,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['gender'] = array(
          '#title'       => $this->t('Your gender'),
          '#placeholder' => $this->t('Gender'),
          '#type'        => 'select',
          '#options' => array(
               'Female' => t('Female'),
               'male' => t('Male'),
          ),
          '#required'    => true,
          '#prefix'      => '<div class="form-group">',
          '#suffix'      => '</div>',
      );
      $form['personnal']['website'] = array(
          '#title'    => $this->t('Website'),
          '#type'     => 'textfield',
          '#required' => true,
          '#prefix'   => '<div class="form-group">',
          '#suffix'   => '</div>',
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
      // Assert the name is valid
      if (!$form_state->getValue('name') || empty($form_state->getValue('name'))) {
          $form_state->setErrorByName('[personnal][name]', $this->t('Please enter your name.'));
      }
      // Assert the mobilenumber is valid
      if (!$form_state->getValue('mobilenumber') || empty($form_state->getValue('mobilenumber'))) {
          $form_state->setErrorByName('[personnal][mobilenumber]', $this->t('Please enter your mobilenumber.'));
      }
      // if (strlen($form_state->getValue('mobile_number')) < 10 ) {
      //       $form_state->setErrorByName('mobile_number', $this->t('your mobile number must in 10 digits'));
      // }
      // Assert the email is valid
      if (!$form_state->getValue('email') || !filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
        $form_state->setErrorByName('[personnal][email]', $this->t('Please enter your valid email.'));
      }
      // Assert the age is valid
      if (!$form_state->getValue('age') || empty($form_state->getValue('age'))) {
          $form_state->setErrorByName('[personnal][age]', $this->t('Please enter your age.'));
      }
      // Assert the gender is valid
      if (!$form_state->getValue('gender') || empty($form_state->getValue('gender'))) {
          $form_state->setErrorByName('[personnal][gender]', $this->t('Please enter your gender.'));
      }
      // Assert the website is valid
      if (!$form_state->getValue('website') || empty($form_state->getValue('website'))) {
          $form_state->setErrorByName('[personnal][website]', $this->t('Please enter your website.'));
      }
  }

//   // submit
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $field     =    $form_state->getValues();
    $name      =    $field['name'];
    $number    =    $field['mobilenumber'];
    $email     =    $field['email'];
    $age       =    $field['age'];
    $gender    =    $field['gender'];
    $website   =    $field['website'];

    //dump($field); exit();

    // Storing the form values as content type "My Custom Form"

    if (isset($field)) {
       $field  = array(
          'name'   =>  $name,
          'mobilenumber' =>  $number,
          'email' =>  $email,
          'age' => $age,
          'gender' => $gender,
          'website' => $website,
      );
       $query = \Drupal::database();
       $query ->insert('my_custom_form')
           ->fields($field)
           ->execute();
       drupal_set_message("succesfully saved");
   }

  }
}
