<?php

namespace App\Http\Controllers\SearchHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SearchHistory;
use Carbon\Carbon;

class SearchHistoryController extends Controller
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
                $SearchHistory = SearchHistory::all();
                return response()->json($SearchHistory);
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
             $SearchHistory = SearchHistory::insert([
                 'searchId'       => $request->searchId,
                 'agentId'       => $request->agentId,
                 'company'          => $request->company,
                 'phone'         => $request->phone,
                 'searchBy'      => $request->searchBy,
                 'searchtype'         => $request->searchtype,
                 'DepFrom'   => $request->DepFrom,
                 'DepAirport'          => $request->DepAirport,
                 'ArrTo'        => $request->ArrTo,
                 'ArrAirport'       => $request->ArrAirport,
                 'class'       => $request->class,
                 'searchTime'          => $request->searchTime,
                 'depTime'         => $request->depTime,
                 'adult'      => $request->adult,
                 'child'         => $request->child,
                 'infant'   => $request->infant,
                 'returnTime'          => $request->returnTime,
                 'created_at'       => Carbon::now()

             ]);
             return response()->json([
                 'success' => 'Staff added Successful',
                 'Ticketing' => $SearchHistory,
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
                $SearchHistory = SearchHistory::findOrFail($id);
                return response()->json($SearchHistory);
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
            $SearchHistory = SearchHistory::findOrFail($id)->update([
                'searchId'       => $request->searchId,
                 'agentId'       => $request->agentId,
                 'company'          => $request->company,
                 'phone'         => $request->phone,
                 'searchBy'      => $request->searchBy,
                 'searchtype'         => $request->searchtype,
                 'DepFrom'   => $request->DepFrom,
                 'DepAirport'          => $request->DepAirport,
                 'ArrTo'        => $request->ArrTo,
                 'ArrAirport'       => $request->ArrAirport,
                 'class'       => $request->class,
                 'searchTime'          => $request->searchTime,
                 'depTime'         => $request->depTime,
                 'adult'      => $request->adult,
                 'child'         => $request->child,
                 'infant'   => $request->infant,
                 'returnTime'          => $request->returnTime,
                 'updated_at'    => Carbon::now(),

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'staffData' => $SearchHistory

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
                SearchHistory::findOrFail($id)->delete();
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

