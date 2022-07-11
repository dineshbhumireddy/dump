<?php

namespace Drupal\assignment\Services;

use Drupal\Core\Session\AccountProxy;

class demoservice{

    private $user;

    public function __construct(AccountProxy $cuser){
        global $user;
        $user=$cuser;
    }
    public function msg($msg){
        global $user;
        $mail=$user->getEmail();
        $name=$user->getAccountName();
        return 'Hi this is '.$msg.' . My email is'.$mail.'. My account name is '.$name.'.';

    }
}