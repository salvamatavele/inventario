<?php

namespace App\Model;

use Resource\Model;

class Category extends Model
{

    public function __construct()
    {
        parent::__construct("categories",['name']);
    }
}
