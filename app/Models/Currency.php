<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const USD_ID = 149;

    protected $table = 'currency';
    protected $fillable = ['code'];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function rates()
    {
        return $this->hasMany(CurrencyRate::class);
    }
}