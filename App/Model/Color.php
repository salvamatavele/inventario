<?php

namespace App\Model;

use Resource\Model;

class Color extends Model
{
    public function __construct()
    {
        parent::__construct('colories',['name']);
    }
}
