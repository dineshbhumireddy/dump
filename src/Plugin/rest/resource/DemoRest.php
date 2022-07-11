<?php

namespace Drupal\assignment\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;


/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "demo_resource",
 *   label = @Translation("DemoRest Resource"),
 *   uri_paths = {
 *     "canonical" = "/demorest"
 *   }
 * )
 */
class DemoRest extends ResourceBase {

    public function get($data=NULL) {
      $nids = \Drupal::entityQuery('node')->condition('type','ajax_content')->execute();
      $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
        foreach($nodes as $res){
          print_r($res->get('title')->value);
          echo "<br>";

        }
        $response = ['message' => 'Hello, this is a rest service'.$data.'.'];
        return new ResourceResponse($response);
      }

}