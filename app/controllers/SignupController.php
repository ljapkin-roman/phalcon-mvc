<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {
	    print_r("index action");
    }

    public function registerAction()
    {
        $user = new Users();
        $data = $this->request->getPost();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->assign(
            [
                "firstname" => $data['firstname'],
                "lastname" => $data['lastname'],
                "email" => $data['email'],
                "password" => $data['password'],
                'user_type' => $data['status'],
            ]
        );
        $success = $user->save();

        if ($success) {
            echo "Thank you for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

           $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    }
}
