<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_products extends Model
{
    public $timestamps = false;
    protected $table = "vw_products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'price'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
