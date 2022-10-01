<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    protected $fillable = ['amount','member_id','date'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeDate($query)
    {
        return $query->whereRaw('extract(month from date) = ?', [Carbon::today()->month]);
    }

    public function getDateAttribute($date)
    {
        return $this->attributes['date'] = Carbon::parse($date)->format('d F, Y');
    }
}
