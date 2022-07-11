<?php

namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class update extends FormBase{

    public function getFormId(){
        return 'updateform';
    }

    public function buildForm(array $form, FormStateInterface $form_state,$id=NULL){

        $this->id=$id;

        $db=\Drupal::database();

        $query=$db->select('user_details','ud')
        ->condition('ud.id',$this->id,'=')
        ->fields('ud');



        $res=$query->execute()->fetchAssoc();
       // dump($res['hobbies']);
        $a=[];
        if(strstr($res['hobbies'],'cricket')){
            array_push($a,'cricket');
        }
        if(strstr($res['hobbies'],'reading')){
            array_push($a,'reading');
        }
        if(strstr($res['hobbies'],'singing')){
            array_push($a,'singing');
        }
        // dump($a);
        // dump(explode(",",$res['hobbies']));
        // exit;

        $form['first_name']=array(
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#default_value'=>$res['first_name'],
            '#required' => TRUE
        );

        $form['last_name']=array(
            '#type' => 'textfield',
            '#title' => 'Last Name',
            '#default_value'=>$res['last_name'],
            '#required' =>TRUE
        );

        $form['email']=array(
            '#type'=> 'email',
            '#title' => 'Enter your email',
            '#default_value'=>$res['email'],
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
            '#required' => TRUE,
            '#default_value' => $a,
        );

        $form['location']=array(
            '#type'=>'select',
            '#title'=>'Select your locations',
            '#options'=>array(
                'bangalore'=>'Bangalore',
                'hyderabad'=>'Hyderabad',
                'indore'=>'Indore'
            ),
            '#default_value'=>$res['locations'],
            '#required' => TRUE
        );

        $form['married']=array(
            '#type'=>'radios',
            '#title'=>'Are you Married?',
            '#options'=>array(
                'yes'=>'YES',
                'no'=>'No'
            ),
            '#default_value'=>$res['married'],
            '#required' => TRUE
        );

        $form['submit']=array(
            '#type' => 'submit',
            '#value' => 'save'
        );

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state){

        $db=\Drupal::database();

        // $ans=$form_state->getValues();

        $ut=\Drupal::time()->getRequestTime();
        // $ut=date('H:i:s',$ut);

        $query=$db->update('user_details')
        ->fields([
            'first_name'=> $form_state->getValue('first_name'),
            'last_name'=> $form_state->getValue('last_name'),
            'email'=> $form_state->getValue('email'),
            'hobbies'=>implode(",",$form_state->getValue('hobbies')),
            'locations'=> $form_state->getValue('location'),
            'married'=> $form_state->getValue('married'),
            'created'=> $ut,
        ])
        ->condition('id',$this->id)
        ->execute();

        $form_state->setRedirect('assignment.show');
    }

}