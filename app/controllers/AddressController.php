<?php

use Phalcon\Mvc\Controller;

class AddressController extends Controller
{
    public function indexAction()
    {
    }
    
    public function deleteAction($address_id)
    {
        $this->view->disable();
        $address =  Addresses::findFirst($address_id);
        if ($address !== false) {
            if ($address->delete() === false) {
                echo "К сожалению, мы не можем удалить робота прямо сейчас: \n";

                $messages = $address->getMessages();

                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } else {
                echo 'Робот был успешно удален!';
            }
        }
    }
    
    public function showAction($user_id)
    {
        $this->view->user = Users::findFirst(
            "user_id='{$user_id}'"
        );


        $this->view->addresses = Addresses::find(
            "user_id='{$user_id}'"
        );
    }


    public function registerAction()
    {
        
        $address = new Addresses();
        $data = $this->request->getPost();
        $address->assign(
            [
                "city" => $data['city'],
                "postcode" => $data['postcode'],
                "region" => $data['region'],
                "street" => $data['street'],
                'user_id' => $data['user_id'],
            ]
        );
        $success = $address->save();

        if ($success) {
            echo "Thank you for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

           $messages = $address->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    }
}
