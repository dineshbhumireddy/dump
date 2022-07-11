<?php

namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\assignment\Services;

class articleForm extends FormBase{

    public function getFormId(){
        return 'articleForm';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        $form['title']=array(
            '#title'=>'Enter title',
            '#type'=>'textfield',
            '#required'=>TRUE
        );

        $form['image']=array(
            '#title'=>'Upload your image',
            '#type'=>'managed_file',
            '#upload_location'=>'public://'
        );

        $form['my_file'] =array (
            '#type' => 'managed_file',
            '#title' => 'My file',
            '#name' => 'my_custom_file',
            '#description' => $this->t('my file description'),
            '#upload_location' => 'public://'
        );

        $form['submit']=array(
            '#type' => 'submit',
            '#value' => 'save'
        );

        return $form;

    }

    public function submitForm(array &$form, FormStateInterface $form_state){

            $arr=$form_state->getValues();

            $serv=\Drupal::service('assignment.articleservice')->createArticle($arr);
    }

    }


