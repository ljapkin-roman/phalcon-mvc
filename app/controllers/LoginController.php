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

    public function otherAction()
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

                $this->flash->success(
                    'Welcome ' . $user->name
                );


                return $this->dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action'     => 'index',
                    ]
                );
            }
                
            $this->flash->error(
                'Wrong email/password'
            );
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
