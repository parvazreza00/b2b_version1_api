<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingOther;
use Carbon\Carbon;

class BookingOtherController extends Controller
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
                $allBooking = BookingOther::all();
                return response()->json($allBooking);
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
        //attachment generate system...............
        $attachment = $request->file('attachment');
        $attachment_name_gen = hexdec(uniqid());
        $attachment_ext = strtolower($attachment->getClientOriginalExtension());
        $attachment_name = $attachment_name_gen.'.'.$attachment_ext;
        $up_location_attachment = 'images/attachment/';
        $attachment->move($up_location_attachment,$attachment_name);
        $last_attachment = $up_location_attachment.$attachment_name;

        $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $OtherBookingData = BookingOther::insert([
                "othersId" =>$request->othersId,
                "agentId"=>$request->agentId,
                "reference"=>$request->reference,
                "amount"=>$request->amount,
                "description"=>$request->description,
                "serviceType"=>$request->serviceType,
                "attachment"=>$last_attachment,
                "companyname"=>$request->companyname,
                "companyphone"=>$request->companyphone,
                "createdBy"=>$request->createdBy,
                "createdAt"=>Carbon::now(),

             ]);
             return response()->json([
                 'success' => 'Staff added Successful',
                 'Ticketing' => $OtherBookingData,
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
                $editBooking = BookingOther::findOrFail($id);
                return response()->json($editBooking);
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
        //attachment generate system...............
        $attachment = $request->file('attachment');
        $attachment_name_gen = hexdec(uniqid());
        $attachment_ext = strtolower($attachment->getClientOriginalName());
        $attachment_name = $attachment_name_gen.'.'.$attachment_ext;
        $up_location_attachment = 'images/attachment/';
        $attachment->move($up_location_attachment,$attachment_name);
        $last_attachment = $up_location_attachment.$attachment_name;


        $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $OtherBookingData = BookingOther::findOrFail($id)->update([
                "othersId" =>$request->othersId,
                "agentId"=>$request->agentId,
                "reference"=>$request->reference,
                "amount"=>$request->amount,
                "description"=>$request->description,
                "serviceType"=>$request->serviceType,
                
                "companyname"=>$request->companyname,
                "companyphone"=>$request->companyphone,
                "createdBy"=>$request->createdBy,
                'updated_at' => Carbon::now()

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'staffData' => $OtherBookingData

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
                BookingOther::findOrFail($id)->delete();
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

