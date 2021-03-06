<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AccountHistory extends Model
{
    protected $table = 'account_history';
    protected $fillable = ['account_id', 'change', 'change_usd'];

    public function account()
    {
        return $this->hasOne(Account::class);
    }
}