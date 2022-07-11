<?php

namespace Drupal\assignment\Services;

use Drupal\Core\Entity\EntityTypeManager;

class articleservice{

    private $entity;

    public function __construct(EntityTypeManager $entity){

        $this->entity=$entity;
    }

    public function createArticle($arr){
        $art_array=[
            'type'=>'article',
            'title'=>$arr['title'],
            'body'=>'Hi This article is custom created',
            // 'field_tags'=>[
            //     'target_id'=>'3'
            // ],
            'field_image'=>[
                'target_id'=>$arr['image'][0]
            ],
            'field_myfile'=>[
                'target_id'=>$arr['my_file'][0]
            ],
        ];

        $node = $this->entity->getStorage('node')->create($art_array);

        $node->save();
    }

    public function createAjax($arr){
        // dump($arr['title']);
        // exit;
        $ajax=[
            'type'=>'ajax_content',
            'title'=>$arr['title'],
            'field_country'=>[
                'target_id'=>'7'
            ],
            'field_state'=>[
                'target_id'=>'9'
            ],
            'field_city'=>[
                'target_id'=>'12'
            ],

        ];

        $node = $this->entity->getStorage('node')->create($ajax);
        $node->save();
    }

}
