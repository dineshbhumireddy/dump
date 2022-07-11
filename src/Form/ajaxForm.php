<?php


namespace Drupal\assignment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ajaxForm extends FormBase{
    public function getFormId(){
        return 'Ajaxformid';
    }
    public function buildForm(array $form, FormStateInterface $form_state){
        $form_values= $form_state->getValues();

        $state_code= !empty($form_values['Country'])?$form_values['Country']: "";
        $city_code= !empty($form_values['State'])?$form_values['State']: "";


        $form['#prefix']='<div id="Ajax_form">';
        $form['#suffix']='</div>';

        $country=[
            'IND'=>'India',
            "USA"=>'USA',
            'ENG'=>'England'
        ];
        $form['Title'] = array(
            '#type' => 'textfield',
            '#title' => t('Enter  Title:'),
            '#required' => TRUE,
        );

        $form['Country'] = array(
            '#type' => 'select',
            '#title' => t('select Country'),
            '#options'=>$country,
            '#required' => TRUE,
            '#ajax'=>[
                'callback' =>'::get_call_country',
                'event'=>'change',
                'wrapper'=>'Ajax_form'
            ]
        );
        $state_list=$this->get_states($state_code);

        $form['State'] = array(
            '#type' => 'select',
            '#title' => t('select state'),
            '#options'=>$state_list,
            '#required' => TRUE,
            '#ajax'=>[
                'callback' =>'::get_call_state',
                'event'=>'change',
                'wrapper'=>'Ajax_form'
            ]
        );

        $city_list=$this->get_city($city_code,$state_code);

        $form['City'] = array(
            '#type' => 'select',
            '#title' => t('select state'),
            '#options'=>$city_list,
            '#required' => TRUE,
            // '#ajax'=>[
            //     'callback' =>'::get_call_country',
            //     'event'=>'change',
            //     'wrapper'=>'Ajax_form'
            // ]
        );

        $form['submit']=array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary',
        );
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state){
        $form_values=$form_state->getValues();
        \Drupal::messenger()->addMessage(t("Ajax Done"));

    }

    public function get_call_country(array &$form, FormStateInterface $form_state){
        return $form;
    }

    public function get_call_state(array &$form, FormStateInterface $form_state){
        return $form;
    }
    public function get_states($state_code){
        switch($state_code){
            case 'IND':
                return[
                    'AP'=>'Andhra',
                    'MP'=>'Madhya pradesh',
                    'KA'=>'Karnataka'
                ];
                break;
            case 'USA':
                return[
                    'NY'=>'New York',
                    'TEX'=>'Texas',
                    'WASH'=>'Washinton'
                ];
                break;
            case 'ENG':
                return[
                    'MAN'=>'Manchester',
                    'LON'=>'London',
                    'SOU'=>'SouthAmthen'
                ];
                break;
            default:
                return [];
                break;
        }
    }

    public function get_city($city_code,$state_code ){
        // dump($city_code);
        // exit;
        // if($state_code=='IND' ){
            switch($city_code){
                case 'AP':
                    return[
                        'TU'=>'Tirupati',
                        'VJ'=>'Vijayawada',
                        'VI'=>'Vizag'
                    ];
                    break;
                case 'MP':
                    return[
                        'IN'=>'Indore',
                        'BP'=>'Bhopal',
                        'UJ'=>'Ujain'
                    ];
                    break;
                case 'KA':
                    return[
                        'BAN'=>'Bangalore',
                        'MY'=>'Mysore',
                        'Hu'=>'Hubli'
                    ];
                    break;
                case 'NY':
                    return[
                        'TU'=>'Tirupati',
                        'VJ'=>'Vijayawada',
                        'VI'=>'Vizag'
                    ];
                    break;
                case 'TEX':
                    return[
                        'IN'=>'Indore',
                        'BP'=>'Bhopal',
                        'UJ'=>'Ujain'
                    ];
                    break;
                case 'WASH':
                    return[
                        'BAN'=>'Bangalore',
                        'MY'=>'Mysore',
                        'Hu'=>'Hubli'
                    ];
                    break;
                default:
                    return [];
                    break;
            }
        // }
    }
}