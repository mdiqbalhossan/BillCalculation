<?php

namespace App\Http\Controllers;

use App\Models\Cooker;
use App\Models\Member;
use App\Models\PayCookerBill;
use App\Models\Setting;
use App\Models\Utility;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $cookerTotal = Cooker::Date()->get();
        $cookerTotal = isset($cookerTotal) ? $cookerTotal->sum('amount') : 0;
        $givenCooker = PayCookerBill::Date()->get();
        $givenCooker = isset($givenCooker) ? $givenCooker->sum('amount') : 0;

        $utilityTotal = Utility::Date()->get();
        $utilityTotal = isset($utilityTotal) ? $utilityTotal->sum('amount') : 0;

        $total = [
            'cooker' => [
                'collected' => number_format($cookerTotal,2, '.', ','),
                'given' => number_format($givenCooker,2, '.', ','),
                'available' => number_format($cookerTotal - $givenCooker,2, '.', ','),
                'due' => number_format($this->totalCollectableMoney('cooker') - $cookerTotal,2, '.', ','),
            ],
            'utility' => [
                'collected' => number_format($utilityTotal,2, '.', ','),
                'total' => number_format($this->totalCollectableMoney('utility'),2, '.', ','),
                'due' => number_format($this->totalCollectableMoney('utility') - $utilityTotal,2, '.', ','),
                'adjust' => number_format($this->adjustBill(),2, '.', ',')
            ]
        ];

        $cookerDue = $this->dueBill("cooker");
        $utilityDue = $this->dueBill("utility");

        $setting = Setting::first();
        $payBills = PayCookerBill::Date()->get();
        $singleBill = [
            'cook' => $this->singleAmount("cooker"),
            'utility' => $this->singleAmount("utility"),
        ];
        $adjustMember = Member::where('isAdjust',1)->orderBy('room_no','asc')->get();
        return view('dashboard',compact('total', 'cookerDue','utilityDue','setting','payBills','singleBill','adjustMember'));
        // dd($cookerDue);
    }

    public function dueBill($type){
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

    public function adjustBill(){
        $total_member = Member::where('isUtility',1)->where('isAdjust',1)->count();
        $singleBill = $this->singleAmount("utility");
        $totalAdjustBill = $total_member * $singleBill;
        return $totalAdjustBill;
    }
    



    public function totalCollectableMoney($type){        
        if($type == "cooker"){
            $total_member = Member::where('status',1)->count();
            return $total_member * $this->singleAmount("cooker");
        }else if($type == "utility"){
            $total_member = Member::where('isUtility',1)->count();
            return $total_member * $this->singleAmount("utility");
        }
    }

    public function singleAmount($type){
        if($type == "cooker"){
            $cooker = Cooker::Date()->first();
            return isset($cooker->amount) ? $cooker->amount : 0;
        }else if($type == "utility"){
            $utility = Utility::Date()->first();
            return isset($utility->amount) ? $utility->amount : 0;
        }
    }

    
}
