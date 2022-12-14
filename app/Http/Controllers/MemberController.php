<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member');
    }

    public function fetch(){
        $members = Member::orderBy('room_no','asc')->get();
        $output = '';
        if($members->count() > 0){
            $output .= '<table id="example" class="table table-sm table-striped table-bordered table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:15%;text-align:center;">Room No</th>
                            <th style="width:25%;text-align:center;">Name</th>
                            <th style="width:25%;text-align:center;">Phone</th>
                            <th style="width:10%;text-align:center;">Status</th>
                            <th style="width:25%;text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="width:15%;text-align:center;">Room No</th>
                            <th style="width:25%;text-align:center;">Name</th>
                            <th style="width:25%;text-align:center;">Phone</th>
                            <th style="width:10%;text-align:center;">Status</th>
                            <th style="width:25%;text-align:center;">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';

            foreach($members as $key =>  $item){
                $output .= '<tr>
                            <td>'.$item->room_no.'</td>
                            <td>'.$item->name.'</td>
                            <td>'.$item->phone.'</td>
                            <td>'.(($item->status) == 1 ? '<span class="badge bg-success">Stay</span>' : '<span class="badge bg-danger">Leave</span>').'</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm edit" id="'.$item->id.'"><i class="fa fa-edit"
                                        aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-danger btn-sm dlt" id="'.$item->id.'"><i class="fa fa-trash"
                                        aria-hidden="true"></i></a>';
                            if($item->status == 1){
                                $output .= '<a href="#" class="ms-1 btn btn-dark btn-sm deactivateStatus" id="'.$item->id.'"><i class="fa fa-times-circle"
                                aria-hidden="true"></i></a>';
                            }else{
                                $output .= '<a href="#" class="ms-1 btn btn-dark btn-sm activeStatus" id="'.$item->id.'"><i class="fa fa-check-circle"
                                aria-hidden="true"></i></a>';
                            }
                            $output .= '<form action="" method="GET" style="display:inline;">
                            <div class="material-switch pull-right">
                            <input class="utility_status" id="us_'.$item->id.'" name="utility_status" value="1" '.($item->isUtility == 1 ? 'checked' : '').' type="checkbox"/>
                            <label for="us_'.$item->id.'" class="text-danger"></label>
                        </div>
                        <div class="material-switch">
                            <input class="adjust_status" id="as_'.$item->id.'" name="adjust_status" value="1" '.($item->isAdjust == 1 ? 'checked' : '').' type="checkbox"/>
                            <label for="as_'.$item->id.'" class="text-danger"></label>
                        </div></form>';
                                
                            $output .= '</td>
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
        Member::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'phone' => $request->phone,
            'room_no' => $request->room_no
        ]);
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
        $member = Member::find($id);
        return response()->json($member);
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
        Member::destroy($id);
        return response()->json(['status' => 200]);
    }

    public function activate($id)
    {
        $member = Member::find($id);
        $member->update([
            'status' => 1
        ]);
        return response()->json(['status' => 200]);
    }

    public function deactivate($id)
    {
        $member = Member::find($id);
        $member->update([
            'status' => 0
        ]);
        return response()->json(['status' => 200]);
    }

    public function utilityUpdate($id,$type)
    {
        $member = Member::find($id);
        if($type == "able"){            
            $member->update([
                'isUtility' => 1
            ]);
        }elseif($type == "notable"){
            $member->update([
                'isUtility' => 0
            ]);
        }
        return response()->json(['status' => 200]);
    }

    public function adjustUpdate($id,$type)
    {
        $member = Member::find($id);
        if($type == "able"){            
            $member->update([
                'isAdjust' => 1
            ]);
        }elseif($type == "notable"){
            $member->update([
                'isAdjust' => 0
            ]);
        }
        return response()->json(['status' => 200]);
    }
}
