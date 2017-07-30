<?php

namespace App\Models;
use App\Exceptions\CurrencyRateNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Rate for current date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrentRate($query)
    {
        $actualRates = self::select(DB::raw('currency_id, MAX(date) as date'))
            ->where('date', '<=', date('Y-m-d'))
            ->groupBy('currency_id')
            ->get()
            ->pluck('date', 'currency_id')
            ->all()
        ;
        return $query->whereIn('date', $actualRates)
            ->whereIn('currency_id', array_keys($actualRates));
    }

    public static function getRate(int $currencyOne, int $currencyTwo): float
    {
        if ($currencyOne === $currencyTwo) {
            return 1;
        }

        $rates = CurrencyRate::whereIn('currency_id', [$currencyOne,$currencyTwo])
            ->currentRate()
            ->get()
            ->pluck('rate', 'currency_id')
            ->all();

        if (Currency::USD_ID === $currencyOne) {
            if (empty($rates[$currencyTwo])) {
                throw new CurrencyRateNotFoundException('', $currencyTwo);
            }
            return $rates[$currencyTwo];
        }

        if (Currency::USD_ID === $currencyTwo) {
            if (empty($rates[$currencyOne])) {
                throw new CurrencyRateNotFoundException('', $currencyOne);
            }
            return $rates[$currencyOne];
        }

        return $rates[$currencyTwo]/$rates[$currencyOne];
    }
}