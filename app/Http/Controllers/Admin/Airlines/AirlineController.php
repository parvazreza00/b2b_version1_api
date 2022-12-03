<?php

namespace App\Http\Controllers\Admin\Airlines;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;
use Carbon\Carbon;

class AirlineController extends Controller
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
                $allAirline = Airline::all();
                return response()->json($allAirline);
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
             $AirlineData = Airline::insert([
                 'name'       => $request->name,
                 'nameBangla'       => $request->nameBangla	,
                 'code'          => $request->code,
                 'commission'         => $request->commission,
                 'created_at'    => Carbon::now(),

             ]);
             return response()->json([
                 'success' => 'Staff added Successful',
                 'Ticketing' => $AirlineData,
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
                $editAirline = Airline::findOrFail($id);
                return response()->json($editAirline);
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
            $AirlineData = Airline::findOrFail($id)->update([
                'name'          => $request->name,
                'nameBangla'    => $request->nameBangla	,
                'code'          => $request->code,
                'commission'    => $request->commission,
                'updated_at'    => Carbon::now(),

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'staffData' => $AirlineData

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
                Airline::findOrFail($id)->delete();
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
