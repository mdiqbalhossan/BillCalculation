<?php


namespace App\Helpers;

use App\Models\Cooker;
use App\Models\Member;
use App\Models\Utility;

class Helper
{
    public static function dueBill($type){
        if($type == "cooker"){
            $cooker = Cooker::Date()->get('member_id');
            $item = [];
            foreach($cooker as $v){
                array_push($item,$v->member_id);
            }
            return Member::whereNotIn('id',$item)->where('status',1)->get();
            // dd($item);
        }else if($type == "utility"){
            $utility = Utility::Date()->get('member_id');
            $item = [];
            foreach($utility as $v){
                array_push($item,$v->member_id);
            }
            return Member::whereNotIn('id',$item)->where('isUtility',1)->get();
        }
    }

    public static function totalCollectableMoney($type){        
        if($type == "cooker"){
            $total_member = Member::where('status',1)->count();
            return $total_member * self::singleAmount("cooker");
        }else if($type == "utility"){
            $total_member = Member::where('isUtility',1)->count();
            return $total_member * self::singleAmount("utility");
        }
    }

    public static function singleAmount($type){
        if($type == "cooker"){
            $cooker = Cooker::Date()->first();
            return isset($cooker->amount) ? $cooker->amount : 0;
        }else if($type == "utility"){
            $utility = Utility::Date()->first();
            return isset($utility->amount) ? $utility->amount : 0;
        }
    }
}