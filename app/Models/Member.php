<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','room_no','status','isUtility'];

    public function getStatusAttribute(){
        if($this->status == 1){
            $r = "<span class='badge badge-success'>Stay</span>";
            return $r;
        }else{
            $r = "<span class='badge badge-danger'>Leave</span>";
            return $r;
        }
    }
}
