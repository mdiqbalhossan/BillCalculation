<?php

namespace App\Http\Controllers;

use App\Models\Cooker;
use App\Models\Member;
use App\Models\PayCookerBill;
use App\Models\Setting;
use App\Models\Utility;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        $cookerTotal = Cooker::Date()->sum('amount');
        $givenCooker = PayCookerBill::Date()->sum('amount');

        $utilityTotal = Utility::Date()->sum('amount');

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
                'due' => number_format($this->totalCollectableMoney('utility') - $utilityTotal,2, '.', ',')
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
        return view('status',compact('total', 'cookerDue','utilityDue','setting','payBills','singleBill'));
        // dd($cookerDue);
    }

    public function dueBill($type){
        if($type == "cooker"){
            $cooker = Cooker::all('member_id');
            $item = [];
            foreach($cooker as $v){
                $item[] = array_push($item,$v->member_id);
            }
            return Member::whereNotIn('id',$item)->get();
        }else if($type == "utility"){
            $utility = Utility::all('member_id');
            $item = [];
            foreach($utility as $v){
                $item[] = array_push($item,$v->member_id);
            }
            return Member::whereNotIn('id',$item)->get();
        }
    }
    



    public function totalCollectableMoney($type){
        $total_member = Member::where('status',1)->count();
        if($type == "cooker"){
            return $total_member * $this->singleAmount("cooker");
        }else if($type == "utility"){
            return $total_member * $this->singleAmount("utility");
        }
    }

    public function singleAmount($type){
        if($type == "cooker"){
            $cooker = Cooker::Date()->first();
            return $cooker->amount;
        }else if($type == "utility"){
            $utility = Utility::Date()->first();
            return $utility->amount;
        }
    }
}
