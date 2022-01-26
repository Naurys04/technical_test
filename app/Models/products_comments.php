<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products_comments extends Model
{
    public $timestamps = false;
    protected $table = "products_comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_products', 'description'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
