<?php

namespace App\Model;

use Resource\Model;

class Location extends Model
{
    public function __construct()
    {
        parent::__construct("locations",['name']);
    }
}
