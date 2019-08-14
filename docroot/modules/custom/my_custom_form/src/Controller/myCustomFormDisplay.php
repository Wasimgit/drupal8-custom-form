<?php

namespace Drupal\my_custom_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
 * Class myCustomFormDisplay.
 */
class myCustomFormDisplay extends ControllerBase {

  /**
   * _formSubmissions.
   */
  public function _formSubmissions() {

    // Get Database ConnectionException
    $connection = Database::getConnection();


    //create table header
    $header_table = array(
     'id'=>    t('SrNo'),
      'name' => t('Name'),
        'mobilenumber' => t('MobileNumber'),
        'email'=>t('Email'),
        'age' => t('Age'),
        'gender' => t('Gender'),
        'website' => t('Web site'),
    );


    //select records from table
    $query = \Drupal::database()->select('my_custom_form', 'm');
    $query->fields('m', ['id','name','mobilenumber','email','age','gender','website']);
    $results = $query->execute()->fetchAll();
    $rows = array();
    foreach($results as $data){
      //print the data from table
          $rows[] = array(
            'id' =>$data->id,
            'name' => $data->name,
            'mobilenumber' => $data->mobilenumber,
            'email' => $data->email,
            'age' => $data->age,
            'gender' => $data->gender,
            'website' => $data->website,
            );
    }
    //display data in site
    $form['table'] = [
            '#type'   => 'table',
            '#header' => $header_table,
            '#rows'   => $rows,
            '#empty'  => t('No users found'),
        ];
    return $form;
  }

}
