<?php

namespace Drupal\assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\assignment\Services\articleservice;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "Deo block",
 *   admin_label = @Translation("Dio block"),
 *   category = @Translation("Custom blocks"),
 * )
 */

class demoblock extends BlockBase{

    public function build(){

        $ser=\Drupal::service('assignment.demoservice');

        $artserv=\Drupal::service('assignment.articleservice');

        $artserv->createArticle();

        return[
            '#theme'=>'demoblock',
            '#name'=>$ser->msg('Dinesh Bhumi'),
            '#age'=>'20',
            '#cache'=>[
                'contexts'=>[
                    'user'
                ]
            ]


        ];
    }
}