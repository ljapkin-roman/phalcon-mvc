<?php
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\PresenceOf;

class Users extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $user_type;
    public $created_at;
    public $user_id;
     public function validation()
        {
            $validator = new Validation();

            $validator->add(
                'user_type',
                new PresenceOf(
                    [
                        'message' => 'You must be choose type user ',
                    ]
                )
            );
            
            $validator->add(
                'email',
                new EmailValidator(
                    [
                        'message' => 'Invalid email given',
                    ]
                )
            );

            $validator->add(
                'email',
                new UniquenessValidator(
                    [
                        'message' => 'Sorry, The email was registered by another user',
                    ]
                )
            );
            
            return $this->validate($validator);
        }
        
}
