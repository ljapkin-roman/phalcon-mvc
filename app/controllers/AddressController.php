<?php

use Phalcon\Mvc\Controller;

class AddressController extends Controller
{
    public function indexAction()
    {
    }
    
    public function getAction($email=null)
    {
        if (!$email) {
            $addresses = Addresses::find();
        }
        else {
            $addresses = Addresses::query()
            ->leftJoin("Users", "users.user_id = Addresses.user_id", "users")
            ->where("users.email = '{$email}'")
            ->execute();
        }

       $data = [];
       foreach ($addresses as $address) {
            $data[$address->address_id]['street'] = $address->street ;
            $data[$address->address_id]['city'] = $address->city ;
            $data[$address->address_id]['region'] = $address->region ;
            $data[$address->address_id]['postcode'] = $address->postcode ;
            $data[$address->address_id]['owner'] = $address->users->email ;
       } 
       $this->view->disable();
       print_r(json_encode($data, JSON_UNESCAPED_UNICODE));
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
    
    public function showAction($email)
    {


        $user = Users::findFirst(
            "email='{$email}'"
        );

        $this->view->user = $user; 

        $user_id = $user->user_id;

        $this->view->addresses = Addresses::find(
            "user_id='{$user_id}'"
        );
    }

    public function allAction()
    {
        $this->view->allAddress = Addresses::find();
        $this->view->users = Users::find();
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
