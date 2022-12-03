<?php

namespace App\Http\Controllers\AirBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FailedBooking;
use Carbon\Carbon;

class FailedBookingController extends Controller
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
                $allAgentFail = FailedBooking::all();
                return response()->json($allAgentFail);
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
             $AgentFail = FailedBooking::insert([
                 'agentId'           => $request->agentId,
                 'staffId'           => $request->staffId,
                 'system'            => $request->system,
                 'depfrom'           => $request->depfrom,
                 'arrto'             => $request->arrto,
                 'route'             => $request->route,
                 'airlines'          => $request->airlines,
                 'tripType'          => $request->tripType,
                 'depTime'           => $request->depTime,
                 'arrTime'           => $request->arrTime,
                 'pax'               => $request->pax,
                 'adultcount'        => $request->adultcount,
                 'childcount'        => $request->childcount,
                 'infantcount'       => $request->infantcount,
                 'netcost'           => $request->netcost,
                 'flightnumber'      => $request->flightnumber,
                 'cabinclass'        => $request->cabinclass,
                 'SearchID'          => $request->SearchID,
                 'ResultID'          => $request->ResultID,
                 'createdAt'         => Carbon::now(),
                 'createdBy'         => $request->createdBy,
                 'companyname'       => $request->companyname,


             ]);
             return response()->json([
                 'success' => 'Ledger added Successful',
                 'Ticketing' => $AgentFail,
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
                $editActivityLog = FailedBooking::findOrFail($id);
                return response()->json($editActivityLog);
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
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $failedBooking = FailedBooking::findOrFail($id)->update([
                'agentId'           => $request->agentId,
                 'staffId'           => $request->staffId,
                 'system'            => $request->system,
                 'depfrom'           => $request->depfrom,
                 'arrto'             => $request->arrto,
                 'route'             => $request->route,
                 'airlines'          => $request->airlines,
                 'tripType'          => $request->tripType,
                 'depTime'           => $request->depTime,
                 'arrTime'           => $request->arrTime,
                 'pax'               => $request->pax,
                 'adultcount'        => $request->adultcount,
                 'childcount'        => $request->childcount,
                 'infantcount'       => $request->infantcount,
                 'netcost'           => $request->netcost,
                 'flightnumber'      => $request->flightnumber,
                 'cabinclass'        => $request->cabinclass,
                 'SearchID'          => $request->SearchID,
                 'ResultID'          => $request->ResultID,
                 'createdBy'         => $request->createdBy,
                 'companyname'       => $request->companyname,
                 'updated_at'        => Carbon::now()

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
                "FailedBooking" => $failedBooking
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
                FailedBooking::findOrFail($id)->delete();
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
