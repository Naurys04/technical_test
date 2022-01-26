<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    public $timestamps = false;
    protected $table = "products";

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
