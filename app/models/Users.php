<?php
use Phalcon\Mvc\Model;

class Users extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $user_type;
    public $created_at;
    public $user_id;
}
