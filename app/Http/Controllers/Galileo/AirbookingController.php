<?php

namespace App\Http\Controllers\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class AirbookingController extends Controller
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
                $allBooking = Booking::all();
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
        $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $BookingData = Booking::insert([
                "bookingId" =>$request->bookingId,
                "ticketId"=>$request->ticketId,
                "voidId"=>$request->voidId,
                "refundId"=>$request->refundId,
                "reissueId"=>$request->reissueId,
                "agentId"=>$request->agentId,
                "staffId"=>$request->staffId,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "name"=>$request->name,
                "refundable"=>$request->refundable,
                "pnr"=>$request->pnr,
                "airlinesPNR"=>$request->airlinesPNR,
                "tripType"=>$request->tripType,
                "journeyType"=>$request->journeyType,
                "pax"=>$request->pax,
                "adultBag"=>$request->adultBag,
                "childBag"=>$request->childBag,
                "infantBag"=>$request->infantBag,
                "adultCount"=>$request->adultCount,
                "childCount"=>$request->childCount,
                "infantCount"=>$request->infantCount,
                "netCost"=>$request->netCost,
                "adultCostBase"=>$request->adultCostBase,
                "childCostBase"=>$request->childCostBase,
                "infantCostBase"=>$request->infantCostBase,
                "adultCostTax"=>$request->adultCostTax,
                "childCostTax"=>$request->childCostTax,
                "infantCostTax"=>$request->infantCostTax,
                "grossCost"=>$request->grossCost,
                "baseFare"=>$request->baseFare,
                "Tax"=>$request->Tax,
                "deptFrom"=>$request->deptFrom,
                "airlines"=>$request->airlines,
                "arriveTo"=>$request->arriveTo,
                "gds"=>$request->gds,
                "status"=>$request->status,
                "coupon"=>$request->coupon,
                "bonus"=>$request->bonus,
                "travelDate"=>$request->travelDate,
                "bookedAt"=> Carbon::now(),
                "timeLimit"=>$request->timeLimit,
                "searchId"=>$request->searchId,
                "resultId"=>$request->resultId,
                "bookedBy"=>$request->bookedBy,
                "lastUpdated"=> Carbon::now()
             ]);
             return response()->json([
                 'success' => 'booking added Successful',
                 'BookingData' => $BookingData,
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
                $editBooking = Booking::findOrFail($id);
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
        $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $BookingData = Booking::findOrFail($id)->update([
                "bookingId" =>$request->bookingId,
                "ticketId"=>$request->ticketId,
                "voidId"=>$request->voidId,
                "refundId"=>$request->refundId,
                "reissueId"=>$request->reissueId,
                "agentId"=>$request->agentId,
                "staffId"=>$request->staffId,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "name"=>$request->name,
                "refundable"=>$request->refundable,
                "pnr"=>$request->pnr,
                "airlinesPNR"=>$request->airlinesPNR,
                "tripType"=>$request->tripType,
                "journeyType"=>$request->journeyType,
                "pax"=>$request->pax,
                "adultBag"=>$request->adultBag,
                "childBag"=>$request->childBag,
                "infantBag"=>$request->infantBag,
                "adultCount"=>$request->adultCount,
                "childCount"=>$request->childCount,
                "infantCount"=>$request->infantCount,
                "netCost"=>$request->netCost,
                "adultCostBase"=>$request->adultCostBase,
                "childCostBase"=>$request->childCostBase,
                "infantCostBase"=>$request->infantCostBase,
                "adultCostTax"=>$request->adultCostTax,
                "childCostTax"=>$request->childCostTax,
                "infantCostTax"=>$request->infantCostTax,
                "grossCost"=>$request->grossCost,
                "baseFare"=>$request->baseFare,
                "Tax"=>$request->Tax,
                "deptFrom"=>$request->deptFrom,
                "airlines"=>$request->airlines,
                "arriveTo"=>$request->arriveTo,
                "gds"=>$request->gds,
                "status"=>$request->status,
                "coupon"=>$request->coupon,
                "bonus"=>$request->bonus,
                "travelDate"=>$request->travelDate,
                "bookedAt"=> Carbon::now(),
                "timeLimit"=>$request->timeLimit,
                "searchId"=>$request->searchId,
                "resultId"=>$request->resultId,
                "bookedBy"=>$request->bookedBy,
                'updated_at' => Carbon::now()->toDateTimeString()

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'staffData' => $BookingData

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
                Booking::findOrFail($id)->delete();
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
