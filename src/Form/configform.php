<?php
namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class configform extends ConfigFormBase{
    public function getEditableConfigNames(){
        return[
            'assignment.settings'
        ];
    }

    public function getFormId(){
        return 'configform';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        $config=$this->config('assignment.settings');
        $form['full_name']=array(
            '#type' => 'textfield',
            '#title' => 'Full Name',
            '#default_value' => $config->get('first_name'),
        );



        return parent::buildForm($form,$form_state);


    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        parent::submitForm($form,$form_state);
        $this->config('assignment.settings')
        ->set('first_name',$form_state->getValue('full_name'))
        ->save();
    }
}