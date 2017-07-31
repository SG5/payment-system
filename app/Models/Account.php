<?php

namespace App\Models;

use App\Events\AccountSaved;
use Illuminate\Database\Eloquent\Model;

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

    public static function boot()
    {
        parent::boot();

        self::saving(function($account){
            $change = $account->getAttribute('amount') - $account->getOriginal('amount');

            if ($change) {
                $rateUsd = CurrencyRate::where('currency_id', $account->currency_id)
                    ->currentRate()
                    ->firstOrFail()->rate;

                AccountHistory::create([
                    'account_id' => $account->id,
                    'change' => $change,
                    'change_usd' => $change * $rateUsd,
                ]);
            }
        });
    }

    public function currency()
    {
        return $this->hasOne(Currency::class);
    }
}