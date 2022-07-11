<?php

namespace Drupal\assignment\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Url;
use \Drupal\node\Entity\Node;

class assignmentController extends ControllerBase{
    public function show(){

        $db=\Drupal::database();

        // dump(gettype($db));
        // exit;
        \Drupal::service('page_cache_kill_switch')->trigger();

        $entity = \Drupal::entityTypeManager()->getStorage('node')->load(56);

        dump(gettype($entity));
        dump($entity);
        dump($entity->get('field_cuntry')->target_id);

        exit;


        $query=$db->select('user_details','ud')
        ->fields('ud');

        $res=$query->execute()->fetchAll();

        $rows=[];
        // dump($res);
        // exit;

        foreach($res as  $value){
            $edit=$this->edit($value->id);
            $delete=$this->delete($value->id);
            // dump($value->id);
            // exit;
            $rows[]=[
                'id'=>$value->id,
                'first_name' => $value->first_name,
                'last_name' => $value->last_name,
                'email' => $value->email,
                'hobbies'=>$value->hobbies,
                'location'=>$value->locations,
                'married'=>$value->married,
                'created'=>$value->created,
                'edit'=> $edit,
                'delete' => $delete
            ];
        }

        $config = \Drupal::config('assignment.settings');

        // dump($config);
        // exit;
        $request = \Drupal::request();
        $route_match = \Drupal::routeMatch();
        $title = \Drupal::service('title_resolver')->getTitle($request, $route_match->getRouteObject());
        $current_user = \Drupal::currentUser();

        // dump(\Drupal::request()->getBaseUrl());
        // exit;


        return[
        '#theme' => 'table',
        '#header'=>['Id','First Name','Last Name','Email','Hobbies','Location','Married','Created','Edit','Delete'],
        '#rows'=>$rows,
        '#attached'=>[
            'library'=>['assignment/assignment.library'],
            'drupalSettings'=>[
                'name'=>$config->get('first_name'),
                'title'=>$title,
                'time'=>date('H:i:s',$current_user->getLastAccessedTime()),
            ],
        ],
    ];
}

    protected function edit($id){
        $this->id=$id;
        $url=Url::fromRoute('assignment.update', ['id' => $this->id]);
        $url=$url->toString();
        $url=$this->t('<a href="@link" target="_blank">Edit</a>',['@link' => $url]) ;

        return $url;
    }

    protected function delete($id){
        $this->id=$id;
        $url=Url::fromRoute('assignment.delete', ['id' => $this->id]);
        $url=$url->toString();
        $url=$this->t('<a href="@link" target="_blank">Delete</a>',['@link' => $url]) ;

        return $url;
    }


}