<?php
namespace App\Model;

use Resource\Model;


class User extends Model
{

    public function __construct()
    {
        parent::__construct("users", ['name','email','password','permition','image']);
    }


}

