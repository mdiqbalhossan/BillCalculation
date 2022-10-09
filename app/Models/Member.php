<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','room_no','status','isUtility'];

    public function getStatusAttribute($value){
        if($value == 1){
            $return = "<span class='badge badge-success'>Stay</span>";
            return $return;
        }else{
            $return = "<span class='badge badge-danger'>Leave</span>";
        }
    }
}
