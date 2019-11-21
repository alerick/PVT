<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanInterest extends Model
{
    public $timestamps = false;
    protected $fillable = ['procedure_modality_id', 'annual_interest','penal_interest'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function getDailyCurrentInterestAttribute()
    {
        return $this->annual_interest / (100 * 365);
    }

    public function getDailyPenalInterestAttribute()
    {
        return $this->penal_interest / (100 * 365);
    }

    public function getMonthlyCurrentInterestAttribute()
    {
        return $this->annual_interest / (100 * 12);
    }

    public function getMonthlyPenalInterestAttribute()
    {
        return $this->penal_interest / (100 * 12);
    }
}
