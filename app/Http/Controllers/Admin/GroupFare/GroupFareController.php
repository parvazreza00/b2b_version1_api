<?php

namespace App\Http\Controllers\Admin\GroupFare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupFare;
use Carbon\Carbon;

class GroupFareController extends Controller
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
                $GroupFare = GroupFare::all();
                return response()->json($GroupFare);
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
             $GroupFare = GroupFare::insert([
                "groupId" => $request->groupId,
                "segment"=> $request->segment,
                "career"=> $request->career,
                "total"=> $request->total,
                "BasePrice"=> $request->BasePrice,
                "Taxes"=> $request->Taxes,
                "price"=> $request->price,
                "departure1"=> $request->departure1,
                "departure2"=> $request->departure2,
                "departure3"=> $request->departure3,
                "depTime1"=> $request->depTime1,
                "depTime2"=> $request->depTime2,
                "depTime3"=> $request->depTime3,
                "arrival1"=> $request->arrival1,
                "arrival2"=> $request->arrival2,
                "arrival3"=> $request->arrival3,
                "arrTime1"=> $request->arrTime1,
                "arrTime2"=> $request->arrTime2,
                "arrTime3"=> $request->arrTime3,
                "seat"=> $request->seat,
                "bags"=> $request->bags,
                "flightNum1"=> $request->flightNum1,
                "flightNum2"=> $request->flightNum2,
                "flightNum3"=> $request->flightNum3,
                "journeyTime"=> $request->journeyTime,
                "transit1"=> $request->transit1,
                "transit2"=> $request->transit2,
                'created_at' => Carbon::now()


             ]);
             return response()->json([
                 'success' => 'Groupfare added Successful',
                 'Groupfare' => $GroupFare,
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
                $GroupFare = GroupFare::findOrFail($id);
                return response()->json($GroupFare);
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
            $GroupFare = GroupFare::findOrFail($id)->update([
                "groupId" => $request->groupId,
                "segment"=> $request->segment,
                "career"=> $request->career,
                "total"=> $request->total,
                "BasePrice"=> $request->BasePrice,
                "Taxes"=> $request->Taxes,
                "price"=> $request->price,
                "departure1"=> $request->departure1,
                "departure2"=> $request->departure2,
                "departure3"=> $request->departure3,
                "depTime1"=> $request->depTime1,
                "depTime2"=> $request->depTime2,
                "depTime3"=> $request->depTime3,
                "arrival1"=> $request->arrival1,
                "arrival2"=> $request->arrival2,
                "arrival3"=> $request->arrival3,
                "arrTime1"=> $request->arrTime1,
                "arrTime2"=> $request->arrTime2,
                "arrTime3"=> $request->arrTime3,
                "seat"=> $request->seat,
                "bags"=> $request->bags,
                "flightNum1"=> $request->flightNum1,
                "flightNum2"=> $request->flightNum2,
                "flightNum3"=> $request->flightNum3,
                "journeyTime"=> $request->journeyTime,
                "transit1"=> $request->transit1,
                "transit2"=> $request->transit2,
                'updated_at'         => Carbon::now()

            ]);
            return response()->json([
                'success' => 'groupFare  updated Successful',
                'Ticketing' => $GroupFare,
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
                GroupFare::findOrFail($id)->delete();
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
