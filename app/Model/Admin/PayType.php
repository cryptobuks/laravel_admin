<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class PayType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'pay_type', 'rate', 'min', 'max', 'limit', 'settle_type', 'status'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = ['name', 'pay_type', 'rate', 'min', 'max', 'limit', 'settle_type', 'status'];

}
