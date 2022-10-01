<?php

namespace App\Http\Controllers;

use App\Models\PayCookerBill;
use Illuminate\Http\Request;

class PayCookerBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = PayCookerBill::sum('amount');
        return view('pay_cooker',compact('total'));
    }

    public function fetch(){
        $bills = PayCookerBill::all();
        $output = '';
        if($bills->count() > 0){
            $output .= '<table id="example" class="table table-striped table-bordered table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10">SI</th>
                            <th width="30">Name</th>
                            <th width="20">Amount</th>
                            <th width="20">Payment Date</th>
                            <th width="20">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="10">SI</th>
                            <th width="30">Name</th>
                            <th width="20">Amount</th>
                            <th width="20">Payment Date</th>
                            <th width="20">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';

            foreach($bills as $key =>  $item){
                $output .= '<tr>
                            <td>'.($key+1).'</td>
                            <td>'.$item->name.'</td>
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
        PayCookerBill::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date
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
        $bills = PayCookerBill::find($id);
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
        PayCookerBill::destroy($id);
        return response()->json(['status' => 200]);
    }
}
