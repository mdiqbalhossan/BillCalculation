<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Utility;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::where('status',1)->get();
        $total = Utility::Date()->get();
        $total = isset($total) ? $total->sum('amount') : 0;
        return view('utility',compact('members','total'));
    }

    public function fetch(){
        $bills = Utility::all();
        $output = '';
        if($bills->count() > 0){
            $output .= '<table id="example" class="table table-striped table-bordered table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10">Room No</th>
                            <th width="30">Name</th>
                            <th width="20">Amount</th>
                            <th width="20">Payment Date</th>
                            <th width="20">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="10">Room No</th>
                            <th width="30">Name</th>
                            <th width="20">Amount</th>
                            <th width="20">Payment Date</th>
                            <th width="20">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';

            foreach($bills as $item){
                $output .= '<tr>
                            <td>'.$item->member->room_no.'</td>
                            <td>'.$item->member->name.'</td>
                            <td>'.$item->amount.' TK</td>
                            <td>'.$item->date.'</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm edit" id="'.$item->id.'"><i class="fa fa-edit"
                                        aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-danger btn-sm dlt" id="'.$item->id.'"><i class="fa fa-trash"
                                        aria-hidden="true"></i></a>
                            </td>
                        </tr>';
            }

            $output .= '</tbody>
                </table>';
        }else{
            $output .= '<h3 class="text-center text-danger">No Data Found</h3>';
        }
        echo $output;
    }

    public function fetchMember(){
        $members = Member::where('isUtility',1)->get();
        $output = '';
        if($members->count() > 0){
            $output .= '<table id="example1" class="table table-striped table-bordered table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10">Room No</th>
                            <th width="30">Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="10">Room No</th>
                            <th width="30">Name</th>
                        </tr>
                    </tfoot>
                    <tbody>';

            foreach($members as $item){
                $output .= '<tr>
                            <td>'.$item->member->room_no.'</td>
                            <td>'.$item->member->name.'</td>
                        </tr>';
            }

            $output .= '</tbody>
                </table>';
        }else{
            $output .= '<h3 class="text-center text-danger">No Data Found</h3>';
        }
        echo $output;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = count($request->member_id);
        if ($count != null){
            for($i=0; $i<$count; $i++){
                Utility::updateOrCreate(['id' => $request->id], [
                    'member_id' => $request->member_id[$i],
                    'amount' => $request->amount,
                    'date' => $request->date
                ]);                
            }
        } 
    
        return response()->json(['status' => 200]); 
        
    }

    public function MemberUpdate(Request $request)
    {
        $count = count($request->member_id);
        if ($count != null){
            for($i=0; $i<$count; $i++){
                Member::updateOrCreate(['id' => $request->member_id], [
                    'is_utility' => 1
                ]);                
            }
        } 
    
        return response()->json(['status' => 200]); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bills = Utility::find($id);
        return response()->json($bills);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Utility::destroy($id);
        return response()->json(['status' => 200]);
    }
}
