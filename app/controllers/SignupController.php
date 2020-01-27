<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

    public function indexAction()
    {
        $user = new Users();
        if ($this->request->getPost()) {
            $dataPOST = $this->request->getPost();
            $dataPOST['password'] = password_hash($dataPOST['password'], PASSWORD_DEFAULT);
            $user->assign(
                $dataPOST
            );
            $success = $user->save();

            if ($success) {
                $this->session->set(
                    'auth',
                    [
                        'id' =>$user->user_id,
                        'email' =>$user->email,
                        'status' => $user->user_type,
                    ]
                );
                $this->flashSession->success(
                    'Welcome ' . $user->firstname .'</br>'.
                    "Thank you for registering!"
                );
                $this->response->redirect('/');
            } else {
                $this->flashSession->error(
                    "Sorry, the following problems were generated: "
                );
                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    $this->flashSession->success(
                        $message->getMessage()
                    );
                }
                $dataPOST['password'] = '';
                $this->view->data = $dataPOST;
            }
        }
    }


}
