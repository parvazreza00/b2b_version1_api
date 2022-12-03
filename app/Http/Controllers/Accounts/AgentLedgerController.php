<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentLedger;
use Carbon\Carbon;

class AgentLedgerController extends Controller
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
                $allLedgerData = AgentLedger::all();
                return response()->json($allLedgerData);
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
            $request->validate([
               'agentId'        =>'required',
               'staffId'        =>'required',
               'deposit'        =>'required',
               'purchase'       =>'required',
               'loan'           =>'required',
               'returnMoney'    =>'required',
               'void'           =>'required',
               'refund'         =>'required',
               'reissue'        =>'required',
               'others'         =>'required',
               'servicefee'     =>'required',
               'lastAmount'     =>'required',
               'transactionId'  =>'required',
               'details'        =>'required',
               'reference'      =>'required',
               'actionBy'       =>'required',
        ]);

        $header = $request->header("Authorization");
        if($header==''){
            $message = "Authorization is required";
            return response()->json(['Message'=>$message], 422);
        }else{
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
                $ClientData = AgentLedger::insert([
                    'agentId'           => $request->agentId,
                    'staffId'           => $request->staffId,
                    'deposit'           => $request->deposit,
                    'purchase'          => $request->purchase,
                    'loan'              => $request->loan,
                    'returnMoney'       => $request->returnMoney,
                    'void'              => $request->void,
                    'refund'            => $request->refund,
                    'reissue'           => $request->reissue,
                    'others'            => $request->others,
                    'servicefee'        => $request->servicefee,
                    'lastAmount'        => $request->lastAmount,
                    'transactionId'     => $request->transactionId,
                    'details'           => $request->details,
                    'reference'         => $request->reference,
                    'actionBy'          => $request->actionBy,
                    'createdAt'         => Carbon::now()
                ]);
                return response()->json([
                    'success' => 'Ledger added Successful',
                    'Ticketing' => $ClientData,
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
                $editClientLedger = AgentLedger::findOrFail($id);
                return response()->json($editClientLedger);
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
        $header=$request->header("Authorization");
        if($header==''){
            $message="Authorization is required";
            return response()->json(['msessage'=>$message], 422);
        }else{
    if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
        AgentLedger::findOrFail($id)->update([
            'agentId'           => $request->agentId,
            'staffId'         => $request->staffId,
            'deposit'            => $request->deposit,
            'purchase'          => $request->purchase,
            'loan'        => $request->loan,
            'returnMoney'     => $request->returnMoney,
            'void'     => $request->void,
            'refund'               => $request->refund,
            'reissue'            => $request->reissue,
            'others'        => $request->others,
            'servicefee'          => $request->servicefee,
            'lastAmount'            => $request->lastAmount,
            'transactionId'           => $request->transactionId,
            'details'           => $request->details,
            'reference'           => $request->reference,
            'actionBy'           => $request->actionBy,
            'createdAt'           => $request->createdAt

        ]);
        return response()->json([
            'success' => 'Updated Successfully',
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
                AgentLedger::findOrFail($id)->delete();
                return response()->json([
                'Delete' => "Deleted successfully",
                ]);
            }else{
                $message = "Authorization Token is miss-mathced";
                return response()->json(['message' => $message], 422);
            }
        }
    }
}
