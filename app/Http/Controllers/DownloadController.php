<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cooker;
use App\Models\Member;
use App\Models\PayCookerBill;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;
use PHPUnit\TextUI\Help;

class DownloadController extends Controller
{
    public function index()
    {
        return view('download');
    }

    public function download(Request $request)
    {
        $type = $request->type;
        $month = $request->month;
        $data = [];

        if($type == 'utility'){
            $utility = Utility::whereMonth('date',$month)->get();
            if(!isset($utility)){
                $data = null;
            }else{
                $collected_fund = $utility->sum('amount');
                $paid_member = $utility;
                $due_member = Helper::dueBill('utility');
                $extra['adjustMember'] = Member::where('isAdjust',1)->orderBy('room_no','asc')->get();            
                $data = [
                    'member' => Member::where('isUtility',1)->count(),
                    'total_collection' => Helper::totalCollectableMoney('utility'),
                    'type' => ucfirst($type),
                    'month' => Carbon::parse($utility[0]->date)->format('F,Y'),
                    'collected_fund' => $collected_fund,
                    'due_fund' => Helper::totalCollectableMoney('utility') - $collected_fund,
                ];
            }
            
            
        }else if($type == 'cooker'){
            $cooker = Cooker::whereMonth('date',$month)->get();
            if(!isset($cooker)){
                $data = null;
            }else{
                $collected_fund = $cooker->sum('amount');
                $paid_member = $cooker;
                $due_member = Helper::dueBill('cooker');
                $extra['givenCooker'] = PayCookerBill::Date()->get();
                $data = [
                    'member' => Member::where('status',1)->count(),
                    'total_collection' => Helper::totalCollectableMoney('cooker'),
                    'type' => ucfirst($type),
                    'month' => Carbon::parse($cooker[0]->date)->format('F,Y'),
                    'collected_fund' => $collected_fund,
                    'due_fund' => Helper::totalCollectableMoney('cooker') - $collected_fund,
                ];        
            }
                
        }

        if($data != null){
            view()->share(ucfirst($type),$data);
            $pdf = PDF::loadView('pdf_view',compact('data','paid_member','due_member','extra'));
            return $pdf->stream($month.'-'.$type.'.pdf', array("Attachment" => false));
            // return $pdf->download($month.'-'.$type.'.pdf');
            // return view('pdf_view',compact('data','paid_member','due_member','extra'));
        }else{
            return redirect()->back()->with('error','This Month Data Not available.');
        }
    }
}
