<?php

namespace App\Http\Controllers\Admin\Ticketed;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reissue;
use Carbon\Carbon;

class ReissueController extends Controller
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
                $Reissue = Reissue::all();
                return response()->json($Reissue);
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
             $Reissue = Reissue::insert([

                'agentId'           => $request->agentId,
                'reissueId'        => $request->reissueId,
                'bookingId'          => $request->bookingId,
                'ticketId'       =>$request->ticketId,
                'passengerDetails'          => $request->passengerDetails,
                'charge'        => $request->charge,
                'servicefee'       =>$request->servicefee,
                'reissueDate'       =>$request->reissueDate,
                'servicefee'       =>$request->servicefee,
                'requestedBy'        => $request->requestedBy,
                'requestedAt'        => Carbon::now(),
                'status'          => $request->status,
                'remarks'       =>$request->remarks,
                'actionBy'           => $request->actionBy,
                'actionAt'          => Carbon::now(),


             ]);
             return response()->json([
                 'success' => 'Reissue added Successful',
                 'Reissue' => $Reissue,
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
                $Reissue = Reissue::findOrFail($id);
                return response()->json($Reissue);
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
            $Reissue = Reissue::findOrFail($id)->update([
                'agentId'           => $request->agentId,
                'reissueId'        => $request->reissueId,
                'bookingId'          => $request->bookingId,
                'ticketId'       =>$request->ticketId,
                'passengerDetails'          => $request->passengerDetails,
                'charge'        => $request->charge,
                'servicefee'       =>$request->servicefee,
                'reissueDate'       =>$request->reissueDate,
                'servicefee'       =>$request->servicefee,
                'requestedBy'        => $request->requestedBy,
                'status'          => $request->status,
                'remarks'       =>$request->remarks,
                'actionBy'           => $request->actionBy,
                'actionAt'          => Carbon::now(),
                'updated_at'     => Carbon::now()


            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'Reissue' => $Reissue
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
                Reissue::findOrFail($id)->delete();
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
