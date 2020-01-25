<?php

use Phalcon\Mvc\Controller;

class UserlistController extends Controller
{
    public function indexAction()
    {
        $this->view->users = Users::find();
    }

}
