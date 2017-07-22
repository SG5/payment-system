<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';
    protected $fillable = ['code'];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}