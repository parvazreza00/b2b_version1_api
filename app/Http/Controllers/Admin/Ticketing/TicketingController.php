<?php

namespace App\Http\Controllers\Admin\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticketing;
use Carbon\Carbon;

class TicketingController extends Controller
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
                $Ticketing = Ticketing::all();
                return response()->json($Ticketing);
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
         //image generate system...............
         $passportCopy = $request->file('passportCopy');
         $passportCopy_name_gen = hexdec(uniqid());
         $passportCopy_ext = strtolower($passportCopy->getClientOriginalExtension());
         $passportCopy_name = $passportCopy_name_gen.'.'.$passportCopy_ext;
         $up_location_passportCopy = 'images/passportCopy/';
         $passportCopy->move($up_location_passportCopy,$passportCopy_name);
         $last_passportCopy = $up_location_passportCopy.$passportCopy_name;

          //image generate system...............
        $visaCopy = $request->file('visaCopy');
        $visaCopy_name_gen = hexdec(uniqid());
        $visaCopy_ext = strtolower($visaCopy->getClientOriginalExtension());
        $visaCopy_name = $visaCopy_name_gen.'.'.$visaCopy_ext;
        $up_location_visaCopy = 'images/visaCopy/';
        $visaCopy->move($up_location_visaCopy,$visaCopy_name);
        $last_visaCopy = $up_location_visaCopy.$visaCopy_name;

     $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $Ticketing = Ticketing::insert([
                'ticketId'          => $request->ticketId,
                'agentId'        => $request->agentId,
                'bookingId'       =>$request->bookingId,
                'staffId'           => $request->staffId,
                'route'          => $request->route,
                'cost'        => $request->cost,
                'tripType'          => $request->tripType,
                'airlines'          => $request->airlines,
                'status'        => $request->status,
                'remarks'          => $request->remarks,
                'bonus'          => $request->bonus,
                'created'       =>Carbon::now(),
                'actionBy'           => $request->actionBy,
                'actionAt'          => Carbon::now(),
                'issueRequestBy'        => $request->issueRequestBy,
                'passportCopy'          => $last_passportCopy,
                'visaCopy'          => $last_visaCopy,

             ]);
             return response()->json([
                 'success' => 'Ticketing added Successful',
                 'Ticketing' => $Ticketing,
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
                $Ticketing = Ticketing::findOrFail($id);
                return response()->json($Ticketing);
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
         //passportCopy generate system...............
         $passportCopy = $request->file('passportCopy');
         $passportCopy_name_gen = hexdec(uniqid());
         $passportCopy_ext = strtolower($passportCopy->getClientOriginalExtension());
         $passportCopy_name = $passportCopy_name_gen.'.'.$passportCopy_ext;
         $up_location_passportCopy = 'images/passportCopy/';
         $passportCopy->move($up_location_passportCopy,$passportCopy_name);
         $last_passportCopy = $up_location_passportCopy.$passportCopy_name;

          //visaCopy generate system...............
        $visaCopy = $request->file('visaCopy');
        $visaCopy_name_gen = hexdec(uniqid());
        $visaCopy_ext = strtolower($visaCopy->getClientOriginalExtension());
        $visaCopy_name = $visaCopy_name_gen.'.'.$visaCopy_ext;
        $up_location_visaCopy = 'images/visaCopy/';
        $visaCopy->move($up_location_visaCopy,$visaCopy_name);
        $last_visaCopy = $up_location_visaCopy.$visaCopy_name;

    $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $Ticketing = Ticketing::findOrFail($id)->update([
                'ticketId'          => $request->ticketId,
                'agentId'        => $request->agentId,
                'bookingId'       =>$request->bookingId,
                'staffId'           => $request->staffId,
                'route'          => $request->route,
                'cost'        => $request->cost,
                'tripType'          => $request->tripType,
                'airlines'          => $request->airlines,
                'status'        => $request->status,
                'remarks'          => $request->remarks,
                'bonus'        => $request->bonus,
                
                'actionBy'           => $request->actionBy,
                'actionAt'          => Carbon::now(),
                'issueRequestBy'        => $request->issueRequestBy,
                'passportCopy'          => $last_passportCopy,
                'visaCopy'          => $last_visaCopy,
                'updated_at'     => Carbon::now()


            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'Voided' => $Ticketing
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
                Ticketing::findOrFail($id)->delete();
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
