<?php

namespace App\Model;

use Resource\Model;

class PasswordReset extends Model
{

    public function __construct()
    {
        parent::__construct("password_resets",["email","token"],"id",false);
    }

    
}
