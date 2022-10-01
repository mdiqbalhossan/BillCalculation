<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PayCookerBill extends Model
{
    use HasFactory;
    protected $fillable = ['name','amount','date'];

    public function scopeDate($query)
    {
        return $query->whereRaw('extract(month from date) = ?', [Carbon::today()->month]);
    }

    public function getDateAttribute($date)
    {
        return $this->attributes['date'] = Carbon::parse($date)->format('d F, Y');
    }
}
