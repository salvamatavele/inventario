<?php

namespace App\Model;

use Resource\Model;

class Product extends Model
{
   

    public function __construct()
    {
        parent::__construct("products",['name','category_id','location_id','status','stock','description','image']);
    }


}
