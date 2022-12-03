<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepositRequest;
use Carbon\Carbon;

class DepositRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $header = $request->header("Authorization");
        if($header==''){
            $message = "Authorization is required";
            return response()->json(['Message'=>$message], 422);
        }else{
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
                $DepositRequest = DepositRequest::all();
                return response()->json($DepositRequest);
            }else{
                $message = "Authorization Token is miss-matched";
                return response()->json(['Message'=>$message], 422);
            }
        }
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

        //depositAttachment generate system...............
        $attachment = $request->file('attachment');
        $attachment_name_gen = hexdec(uniqid());
        $attachment_ext = strtolower($attachment->getClientOriginalExtension());
        $attachment_name = $attachment_name_gen.'.'.$attachment_ext;
        $up_location_attachment = 'images/deposit_attachment/';
        $attachment->move($up_location_attachment,$attachment_name);
        $last_attachment = $up_location_attachment.$attachment_name;

     $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $DepositRequest = DepositRequest::insert([
                 'agentId'        => $request->agentId,
                 'staffId'           => $request->staffId,
                 'depositId'          => $request->depositId,
                 'sender'       =>$request->sender,
                 'reciever'          => $request->reciever,
                 'paymentway'        => $request->paymentway,
                 'paymentmethod'           => $request->paymentmethod,
                 'transactionId'          => $request->transactionId,
                 'chequeIssueDate'       =>$request->chequeIssueDate,
                 'ref'          => $request->ref,
                 'amount'        => $request->amount,
                 'attachment'           => $last_attachment,
                 'createdAt'          => Carbon::now(),
                 'depositBy'       =>$request->depositBy,
                 'status'          => $request->status,
                 'remarks'        => $request->remarks,
                 'approvedBy'           => $request->approvedBy,
                 'rejectBy'          => $request->rejectBy,
                 'actionAt'       =>Carbon::now()

             ]);
             return response()->json([
                 'success' => 'DepositRequest added Successful',
                 'DepositRequest' => $DepositRequest,
             ]);
         }else{
             $message="Authorization Token is miss-matched";
             return response()->json(['Message'=>$message], 422);
         }
     }
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
    public function edit(Request $request, $id)
    {

        $header=$request->header('Authorization');
        if($header==''){
            $message = "Authorization is required";
            return response()->json(['message'=>$message], 422);
        }else{
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
                $DepositRequest = DepositRequest::findOrFail($id);
                return response()->json($DepositRequest);
            }else{
                $message = "Authorization Token is miss-matched";
                return response()->json(['message'=>$message], 422);
            }
        }
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

        //depositAttachment generate system...............
        $attachment = $request->file('attachment');
        $attachment_name_gen = hexdec(uniqid());
        $attachment_ext = strtolower($attachment->getClientOriginalExtension());
        $attachment_name = $attachment_name_gen.'.'.$attachment_ext;
        $up_location_attachment = 'images/deposit_attachment/';
        $attachment->move($up_location_attachment,$attachment_name);
        $last_attachment = $up_location_attachment.$attachment_name;

    $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $DepositRequest = DepositRequest::findOrFail($id)->update([
                 'agentId'        => $request->agentId,
                 'staffId'           => $request->staffId,
                 'depositId'          => $request->depositId,
                 'sender'       =>$request->sender,
                 'reciever'          => $request->reciever,
                 'paymentway'        => $request->paymentway,
                 'paymentmethod'           => $request->paymentmethod,
                 'transactionId'          => $request->transactionId,
                 'chequeIssueDate'       =>$request->chequeIssueDate,
                 'ref'          => $request->ref,
                 'amount'        => $request->amount,
                 'attachment'           => $last_attachment,
                 'depositBy'       =>$request->depositBy,
                 'status'          => $request->status,
                 'remarks'        => $request->remarks,
                 'approvedBy'           => $request->approvedBy,
                 'rejectBy'          => $request->rejectBy,
                 'updated_at'     => Carbon::now()


            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'AuthAgent' => $DepositRequest
            ]);
            } else {
                $message="Authorization Token is miss-matched";
                return response()->json(['msessage'=>$message], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $header = $request->header('Authorization');
        if($header==''){
            $message = "Authorization is required";
            return response()->json(['message' => $message], 422);
        }else{
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
                DepositRequest::findOrFail($id)->delete();
                return response()->json([
                'Delete' => "$id No. Id is Deleted successfully",
                ]);
            }else{
                $message = "Authorization Token is miss-mathced";
                return response()->json(['message' => $message], 422);
            }
        }
    }
}
