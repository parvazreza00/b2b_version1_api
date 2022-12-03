<?php

namespace App\Http\Controllers\Admin\DepositRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartialPayment;
use Carbon\Carbon;

class PartialPaymentController extends Controller
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
                $PartialPayment = PartialPayment::all();
                return response()->json($PartialPayment);
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


        $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $PartialPayment = PartialPayment::insert([
                "agentId" => $request->agentId,
                "bookingId"=> $request->bookingId,
                "stuffId"=> $request->stuffId,
                "ticketId"=> $request->ticketId,
                "status"=> $request->status,
                "action"=> $request->action,
                "travelDate"=> $request->travelDate,
                "totalAmount"=> $request->totalAmount,
                "paidAmount"=> $request->paidAmount,
                "dueAmount"=> $request->dueAmount,
                "dueDate"=> $request->dueDate,
                "settleOn"=> $request->settleOn,
                'created_at' => Carbon::now()


             ]);
             return response()->json([
                 'success' => 'PartialPayment added Successful',
                 'PartialPayment' => $PartialPayment,
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
                $PartialPayment = PartialPayment::findOrFail($id);
                return response()->json($PartialPayment);
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


       $header = $request->header("Authorization");
    if($header==''){
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    }else{
        if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
            $PartialPayment = PartialPayment::findOrFail($id)->update([
                "agentId" => $request->agentId,
                "bookingId"=> $request->bookingId,
                "stuffId"=> $request->stuffId,
                "ticketId"=> $request->ticketId,
                "status"=> $request->status,
                "action"=> $request->action,
                "travelDate"=> $request->travelDate,
                "totalAmount"=> $request->totalAmount,
                "paidAmount"=> $request->paidAmount,
                "dueAmount"=> $request->dueAmount,
                "dueDate"=> $request->dueDate,
                "settleOn"=> $request->settleOn,
                'updated_at'         => Carbon::now()

            ]);
            return response()->json([
                'success' => 'PartialPayment  updated Successful',
                'PartialPayment' => $PartialPayment,
            ]);
        }else{
            $message="Authorization Token is miss-matched";
            return response()->json(['Message'=>$message], 422);
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
                PartialPayment::findOrFail($id)->delete();
                return response()->json([
                'Delete' => "Id $id is Deleted successfully",
                ]);
            }else{
                $message = "Authorization Token is miss-mathced";
                return response()->json(['message' => $message], 422);
            }
        }
    }
}
