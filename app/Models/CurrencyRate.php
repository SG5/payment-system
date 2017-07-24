<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    public static $rules = [
        'rate' => 'required|numeric',
        'date' => 'required|date_format:Y-m-d',
    ];

    protected $table = 'currency_rate';
    protected $fillable = ['currency_id', 'rate', 'date'];

    public function accounts()
    {
        return $this->hasOne(Currency::class);
    }
}