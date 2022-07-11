<?php

namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class details extends FormBase{

    public function getFormId(){
        return 'detailsform';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

        $form['first_name']=array(
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#required' => TRUE
        );

        $form['last_name']=array(
            '#type' => 'textfield',
            '#title' => 'Last Name',
            '#required' =>TRUE
        );

        $form['email']=array(
            '#type'=> 'email',
            '#title' => 'Enter your email',
            '#required' => TRUE
        );

        $form['hobbies']=array(
            '#type'=>'checkboxes',
            '#title'=>'Select your hobbies',
            '#options'=>array(
                'cricket'=>'Cricket',
                'reading'=>'Reading',
                'singing'=>'Singing'
            ),
            '#required' => TRUE
        );

        $form['location']=array(
            '#type'=>'select',
            '#title'=>'Select your locations',
            '#options'=>array(
                'bangalore'=>'Bangalore',
                'hyderabad'=>'Hyderabad',
                'indore'=>'Indore'
            ),
            '#required' => TRUE
        );

        $form['married']=array(
            '#type'=>'radios',
            '#title'=>'Are you Married?',
            '#options'=>array(
                'yes'=>'YES',
                'no'=>'No'
            ),
            '#required' => TRUE
        );

        $form['my_file'] = [
            '#type' => 'managed_file',
            '#title' => 'my file',
            '#name' => 'my_custom_file',
            '#description' => $this->t('my file description'),
            '#upload_location' => 'public://'
          ];

        $form['submit']=array(
            '#type' => 'submit',
            '#value' => 'save'
        );

        return $form;
    }

    public function validateForm(array &$form,FormStateInterface $form_state){

        if(!preg_match ("/^[a-zA-z]*$/", $form_state->getValue('first_name'))){
            $form_state->setErrorByName('first_name', $this->t('Please enter valid first name'));
        }

        if(!preg_match ("/^[a-zA-z]*$/", $form_state->getValue('last_name'))){
            $form_state->setErrorByName('last_name', $this->t('Please enter valid last name'));
        }

        // dump(!\Drupal::service('email.validator')->isValid($form_state->getValue('email')));
        // exit;
        if(!\Drupal::service('email.validator')->isValid($form_state->getValue('email'))){
            $form_state->setErrorByName('email', $this->t('Please enter valid email'));
        }

    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        \Drupal::messenger()->addMessage('Form submitted successfully');

        // dump($form_state->getValues());
        // exit;

        // dump($form_state->getValue('hobbies'));
        // exit;

        $db=\Drupal::database();

        $ut=\Drupal::time()->getRequestTime();
        // $ut=date('H:i:s',$ut);


        $query=$db->insert('user_details')
        ->fields([
            'first_name'=> $form_state->getValue('first_name'),
            'last_name'=> $form_state->getValue('last_name'),
            'email'=> $form_state->getValue('email'),
            'hobbies'=>implode(",",$form_state->getValue('hobbies')),
            'locations'=> $form_state->getValue('location'),
            'married'=> $form_state->getValue('married'),
            'created'=> $ut,

        ])->execute();

        if($query){
            \Drupal::messenger()->addMessage('Details saved successfully');
        }


}

}

?>