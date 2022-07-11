<?php

namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class demoform extends FormBase{

    public function getFormId(){
        return 'ajaxForm';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

        $form['#prefix']='<div id="ajaxForm">';
        $form['#suffix']='</div>';

        $values=$form_state->getValues();


        $cont=[
            'IND'=>'INDIA',
            'USA'=>'USA',
            'PAK'=>'pakistan'
        ];

        $form['title']=array(
            '#title'=>'Enter title',
            '#type'=>'textfield',
            '#required'=>TRUE
        );

        $form['country']=array(
            '#type'=>'select',
            '#title'=>'Country',
            '#options'=>$cont,
            '#required'=>TRUE,
            '#ajax'=>[
                'callback'=>'::getCallback',
                'event'=>'change',
                'wrapper'=>'ajaxForm'
            ]
        );
        if(!empty($values['country'])){
        $states=$this->getStates($values['country']);}
        else{
            $states=[];
        }

        $form['state']=array(
            '#type'=>'select',
            '#title'=>'State',
            '#options'=>$states,
            '#required'=>TRUE,
            '#ajax'=>[
                'callback'=>'::getCallback',
                'event'=>'change',
                'wrapper'=>'ajaxForm'
            ]

            );

        if(!empty($values['state'])){
        $cities=$this->getCities($values['state']);}
        else{
            $cities=[];
        }

        $form['city']=array(
        '#type'=>'select',
        '#title'=>'City',
        '#options'=>$cities,
        '#required'=>TRUE,
        // '#ajax'=>[
        //     'callback'=>'::getCallback',
        //     'event'=>'change',
        //     'wrapper'=>'ajaxForm'
        // ]

        );

        $form['submit']=array(
            '#type'=>'submit',
            '#value'=>'save'
        );

        return $form;


}

    public function getCallback(array &$form,FormStateInterface $form_state){
        return $form;
    }

    public function getStates($country){
        // dump($country);
        // exit;
        switch($country){
            case 'IND':
                return[
                    'AP'=>'Andhra',
                    'TS'=>'Telangana'
                ];
            break;
            case 'USA':
                return[
                    'TXS'=>'Texas',
                    'NYK'=>'new york'
                ];
            break;
            case 'PAK':
                return[
                    'KRC'=>'Karachi',
                    'IMD'=>'Islamabad'
                ];
            default:
                return[];
        }
    }

    public function getCities($state){
        switch($state){
            case 'AP':
                return[
                    'KDP'=>'kadapa',
                    'ATP'=>'Anantapur'
                ];
                break;
            case 'TS':
                return
                    array('HYD','SBD')
                ;
                break;
            case 'NYK':
                return
                    array('MLB','OHO')
                ;
                break;
            case 'TXS':
                return
                    array('MXC','JRS')
                ;
            case 'KRC':
                return[
                    'HZR'=>'Huzur',
                    'KPR'=>'Karpa'
                ];
                break;
            case 'IMB':
                return[
                    'POL'=>'Polgad',
                    'HRP'=>'Harpa'
                ];
        }
    }

    public function submitForm(array &$form,FormStateInterface $form_state){
        // dump($form_state->getValues());
        // exit;
        $values['state'];
        \Drupal::service('assignment.articleservice')->createAjax($form_state->getValues());
        \Drupal::messenger()->addMessage('Details saved successfully');
    }

}
