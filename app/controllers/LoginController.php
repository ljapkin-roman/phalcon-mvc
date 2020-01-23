<?php

use Phalcon\Mvc\Controller;
use Phalcon\Assets\Asset\Css;


class LoginController extends Controller
{
    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            [
                'id'   => $user->user_id,
                'name' => $user->firstname,
                'status' => $user->user_type,
            ]
        );
    }

    public function indexAction()
    {
    }


    public function startAction()
    {
        if (true === $this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = Users::findFirst(
                [
                    "(email = :email:) " ,
                    'bind' => [
                        'email'    => $email,
                    ]
                ]
            );

            if (false !== $user and password_verify($password, $user->password)) {

                $this->_registerSession($user);

                $this->flashSession->success(
                    'Welcome ' . $user->firstname
                );
                $this->response->redirect('/');


                return $this->dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action'     => 'index',
                    ]
                );
            }
                
            $this->flashSession->error(
                'Wrong email/password'
            );
            $this->response->redirect('/login');
        }

    }
}
