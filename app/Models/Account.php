<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Account extends Model
{

    public static $rules = [
        'name' => 'required',
        'country' => 'required',
        'city' => 'required',
        'currency_id' => 'required',
    ];

    protected $table = 'account';
    protected $fillable = ['name', 'country', 'city', 'currency_id', 'amount'];

    public function currency()
    {
        return $this->hasOne(Currency::class);
    }
}