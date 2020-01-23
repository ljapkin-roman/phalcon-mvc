
<?php
use Phalcon\Mvc\Model;

class Addresses extends Model
{
    public $city;
    public $postcode;
    public $email;
    public $region;
    public $street;
    public $user_id;
    public function initialize()
    {
        $this->belongsTo(
            'user_id',
            'Users',
            'user_id'
        );
    }
}
