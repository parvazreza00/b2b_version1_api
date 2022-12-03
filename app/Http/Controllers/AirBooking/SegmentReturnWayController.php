<?php

namespace App\Http\Controllers\AirBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SegmentReturnWay;
use Carbon\Carbon;

class SegmentReturnWayController extends Controller
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
                $SegmentReturnWay = SegmentReturnWay::all();
                return response()->json($SegmentReturnWay);
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
             $SegmentReturnWay = SegmentReturnWay::insert([
                "system" => $request->system,
                "segment"=> $request->segment,
                "pnr"=> $request->pnr,
                "goTransit1"=> $request->goTransit1,
                "goTransit2"=> $request->goTransit2,
                "backTransit1"=> $request->backTransit1,
                "backTransit2"=> $request->backTransit2,
                "goMarketingCareer1"=> $request->goMarketingCareer1,
                "goMarketingCareer2"=> $request->goMarketingCareer2,
                "goMarketingCareer3"=> $request->goMarketingCareer3,
                "goMarketingCareerName1"=> $request->goMarketingCareerName1,
                "goMarketingCareerName2"=> $request->goMarketingCareerName2,
                "goMarketingCareerName3" => $request->goMarketingCareerName3,
                "goMarketingFlight1"=> $request->goMarketingFlight1,
                "goMarketingFlight2"=> $request->goMarketingFlight2,
                "goMarketingFlight3"=> $request->goMarketingFlight3,
                "goOperatingCareer1"=> $request->goOperatingCareer1,
                "goOperatingCareer2"=> $request->goOperatingCareer2,
                "goOperatingCareer3"=> $request->goOperatingCareer3,
                "goOperatingFlight1"=> $request->goOperatingFlight1,
                "goOperatingFlight2"=> $request->goOperatingFlight2,
                "goOperatingFlight3"=> $request->goOperatingFlight3,
                "goDeparture1"=> $request->goDeparture1,
                "goDeparture2"=> $request->goDeparture2,
                "goDeparture3" => $request->goDeparture3,
                "goArrival1"=> $request->goArrival1,
                "goArrival2"=> $request->goArrival2,
                "goArrival3"=> $request->goArrival3,
                "goDepartureAirport1"=> $request->goDepartureAirport1,
                "goDepartureAirport2"=> $request->goDepartureAirport2,
                "goDepartureAirport3"=> $request->goDepartureAirport3,
                "goArrivalAirport1"=> $request->goArrivalAirport1,
                "goArrivalAirport2"=> $request->goArrivalAirport2	,
                "goArrivalAirport3"=> $request->goArrivalAirport3,
                "goDepartureLocation1"=> $request->goDepartureLocation1,
                "goDepartureLocation2"=> $request->goDepartureLocation2,
                "goDepartureLocation3" => $request->goDepartureLocation3,
                "goArrivalLocation1"=> $request->goArrivalLocation1,
                "goArrivalLocation2"=> $request->goArrivalLocation2,
                "goArrivalLocation3"=> $request->goArrivalLocation3,
                "goDepartureTime1"=> $request->goDepartureTime1,
                "goDepartureTime2"=> $request->goDepartureTime2,
                "goDepartureTime3"=> $request->goDepartureTime3,
                "goArrivalTime1"=> $request->goArrivalTime1,
                "goArrivalTime2"=> $request->goArrivalTime2,
                "goArrivalTime3"=> $request->goArrivalTime3,
                "goFlightDuration1"=> $request->goFlightDuration1,
                "goFlightDuration2"=> $request->goFlightDuration2,
                "goFlightDuration3"=> $request->goFlightDuration3,
                "goBookingCode1"=> $request->goBookingCode1,
                "goBookingCode2"=> $request->goBookingCode2,
                "goBookingCode3"=> $request->goBookingCode3,
                "goDepTerminal1"=> $request->goDepTerminal1,
                "goDepTerminal2"=> $request->goDepTerminal2,
                "goDepTerminal3"=> $request->goDepTerminal3,
                "goArrTerminal1"=> $request->goArrTerminal1,
                "goArrTerminal2"=> $request->goArrTerminal2,
                "goArrTerminal3"=> $request->goArrTerminal3,
                "backMarketingCareer1"=> $request->backMarketingCareer1,
                "backMarketingCareer2"=> $request->backMarketingCareer2,
                "backMarketingCareer3"=> $request->backMarketingCareer3,
                "backMarketingCareerName1"=> $request->backMarketingCareerName1,
                "backMarketingCareerName2"=> $request->backMarketingCareerName2,
                "backMarketingCareerName3"=> $request->backMarketingCareerName3,
                "backMarketingFlight1"=> $request->backMarketingFlight1,
                "backMarketingFlight2"=> $request->backMarketingFlight2,
                "backMarketingFlight3"=> $request->backMarketingFlight3,
                "backOperatingCareer1"=> $request->backOperatingCareer1,
                "backOperatingCareer2"=> $request->backOperatingCareer2,
                "backOperatingCareer3"=> $request->backOperatingCareer3,
                "backOperatingFlight1"=> $request->backOperatingFlight1,
                "backOperatingFlight2"=> $request->backOperatingFlight2,
                "backOperatingFlight3"=> $request->backOperatingFlight3,
                "backDeparture1"=> $request->backDeparture1,
                "backDeparture2"=> $request->backDeparture2,
                "backDeparture3"=> $request->backDeparture3,
                "backArrival1"=> $request->backArrival1,
                "backArrival2"=> $request->backArrival2,
                "backArrival3"=> $request->backArrival3,
                "backDepartureAirport1" => $request->backDepartureAirport1,
                "backDepartureAirport2"=> $request->backDepartureAirport2,
                "backDepartureAirport3"=> $request->backDepartureAirport3,
                "backArrivalAirport1"=> $request->backArrivalAirport1,
                "backArrivalAirport2"=> $request->backArrivalAirport2,
                "backArrivalAirport3"=> $request->backArrivalAirport3,
                "backDepartureLocation1"=> $request->backDepartureLocation1,
                "backDepartureLocation2"=> $request->backDepartureLocation2,
                "backDepartureLocation3"=> $request->backDepartureLocation3,
                "backArrivalLocation1"=> $request->backArrivalLocation1,
                "backArrivalLocation2"=> $request->backArrivalLocation2,
                "backArrivalLocation3"=> $request->backArrivalLocation3,
                "backDepartureTime1" => $request->backDepartureTime1,
                "backDepartureTime2"=> $request->backDepartureTime2,
                "backDepartureTime3"=> $request->backDepartureTime3,
                "backArrivalTime1"=>$request->backArrivalTime1,
                "backArrivalTime2"=> $request->backArrivalTime2,
                "backArrivalTime3"=> $request->backArrivalTime3,
                "backFlightDuration1"=> $request->backFlightDuration1,
                "backFlightDuration2"=> $request->backFlightDuration2,
                "backFlightDuration3"=> $request->backFlightDuration3,
                "backBookingCode1"=> $request->backBookingCode1,
                "backBookingCode2"=> $request->backBookingCode2,
                "backBookingCode3"=> $request->backBookingCode3,
                "backdepTerminal1" => $request->backdepTerminal1,
                "backdepTerminal2"=> $request->backdepTerminal2,
                "backdepTerminal3"=> $request->backdepTerminal3,
                "backArrTerminal1"=> $request->backArrTerminal1,
                "backArrTerminal2"=> $request->backArrTerminal2,
                "backArrTerminal3"=> $request->backArrTerminal3,
                "searchId"=> $request->searchId,
                "resultId"=> $request->resultId,
                'createdAt' => Carbon::now()

             ]);
             return response()->json([
                 'success' => 'Round way added Successful',
                 'Round way' => $SegmentReturnWay,
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
                $SegmentReturnWay = SegmentReturnWay::findOrFail($id);
                return response()->json($SegmentReturnWay);
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
            $SegmentReturnWay = SegmentReturnWay::findOrFail($id)->update([
                "system" => $request->system,
                "segment"=> $request->segment,
                "pnr"=> $request->pnr,
                "goTransit1"=> $request->goTransit1,
                "goTransit2"=> $request->goTransit2,
                "backTransit1"=> $request->backTransit1,
                "backTransit2"=> $request->backTransit2,
                "goMarketingCareer1"=> $request->goMarketingCareer1,
                "goMarketingCareer2"=> $request->goMarketingCareer2,
                "goMarketingCareer3"=> $request->goMarketingCareer3,
                "goMarketingCareerName1"=> $request->goMarketingCareerName1,
                "goMarketingCareerName2"=> $request->goMarketingCareerName2,
                "goMarketingCareerName3" => $request->goMarketingCareerName3,
                "goMarketingFlight1"=> $request->goMarketingFlight1,
                "goMarketingFlight2"=> $request->goMarketingFlight2,
                "goMarketingFlight3"=> $request->goMarketingFlight3,
                "goOperatingCareer1"=> $request->goOperatingCareer1,
                "goOperatingCareer2"=> $request->goOperatingCareer2,
                "goOperatingCareer3"=> $request->goOperatingCareer3,
                "goOperatingFlight1"=> $request->goOperatingFlight1,
                "goOperatingFlight2"=> $request->goOperatingFlight2,
                "goOperatingFlight3"=> $request->goOperatingFlight3,
                "goDeparture1"=> $request->goDeparture1,
                "goDeparture2"=> $request->goDeparture2,
                "goDeparture3" => $request->goDeparture3,
                "goArrival1"=> $request->goArrival1,
                "goArrival2"=> $request->goArrival2,
                "goArrival3"=> $request->goArrival3,
                "goDepartureAirport1"=> $request->goDepartureAirport1,
                "goDepartureAirport2"=> $request->goDepartureAirport2,
                "goDepartureAirport3"=> $request->goDepartureAirport3,
                "goArrivalAirport1"=> $request->goArrivalAirport1,
                "goArrivalAirport2"=> $request->goArrivalAirport2	,
                "goArrivalAirport3"=> $request->goArrivalAirport3,
                "goDepartureLocation1"=> $request->goDepartureLocation1,
                "goDepartureLocation2"=> $request->goDepartureLocation2,
                "goDepartureLocation3" => $request->goDepartureLocation3,
                "goArrivalLocation1"=> $request->goArrivalLocation1,
                "goArrivalLocation2"=> $request->goArrivalLocation2,
                "goArrivalLocation3"=> $request->goArrivalLocation3,
                "goDepartureTime1"=> $request->goDepartureTime1,
                "goDepartureTime2"=> $request->goDepartureTime2,
                "goDepartureTime3"=> $request->goDepartureTime3,
                "goArrivalTime1"=> $request->goArrivalTime1,
                "goArrivalTime2"=> $request->goArrivalTime2,
                "goArrivalTime3"=> $request->goArrivalTime3,
                "goFlightDuration1"=> $request->goFlightDuration1,
                "goFlightDuration2"=> $request->goFlightDuration2,
                "goFlightDuration3"=> $request->goFlightDuration3,
                "goBookingCode1"=> $request->goBookingCode1,
                "goBookingCode2"=> $request->goBookingCode2,
                "goBookingCode3"=> $request->goBookingCode3,
                "goDepTerminal1"=> $request->goDepTerminal1,
                "goDepTerminal2"=> $request->goDepTerminal2,
                "goDepTerminal3"=> $request->goDepTerminal3,
                "goArrTerminal1"=> $request->goArrTerminal1,
                "goArrTerminal2"=> $request->goArrTerminal2,
                "goArrTerminal3"=> $request->goArrTerminal3,
                "backMarketingCareer1"=> $request->backMarketingCareer1,
                "backMarketingCareer2"=> $request->backMarketingCareer2,
                "backMarketingCareer3"=> $request->backMarketingCareer3,
                "backMarketingCareerName1"=> $request->backMarketingCareerName1,
                "backMarketingCareerName2"=> $request->backMarketingCareerName2,
                "backMarketingCareerName3"=> $request->backMarketingCareerName3,
                "backMarketingFlight1"=> $request->backMarketingFlight1,
                "backMarketingFlight2"=> $request->backMarketingFlight2,
                "backMarketingFlight3"=> $request->backMarketingFlight3,
                "backOperatingCareer1"=> $request->backOperatingCareer1,
                "backOperatingCareer2"=> $request->backOperatingCareer2,
                "backOperatingCareer3"=> $request->backOperatingCareer3,
                "backOperatingFlight1"=> $request->backOperatingFlight1,
                "backOperatingFlight2"=> $request->backOperatingFlight2,
                "backOperatingFlight3"=> $request->backOperatingFlight3,
                "backDeparture1"=> $request->backDeparture1,
                "backDeparture2"=> $request->backDeparture2,
                "backDeparture3"=> $request->backDeparture3,
                "backArrival1"=> $request->backArrival1,
                "backArrival2"=> $request->backArrival2,
                "backArrival3"=> $request->backArrival3,
                "backDepartureAirport1" => $request->backDepartureAirport1,
                "backDepartureAirport2"=> $request->backDepartureAirport2,
                "backDepartureAirport3"=> $request->backDepartureAirport3,
                "backArrivalAirport1"=> $request->backArrivalAirport1,
                "backArrivalAirport2"=> $request->backArrivalAirport2,
                "backArrivalAirport3"=> $request->backArrivalAirport3,
                "backDepartureLocation1"=> $request->backDepartureLocation1,
                "backDepartureLocation2"=> $request->backDepartureLocation2,
                "backDepartureLocation3"=> $request->backDepartureLocation3,
                "backArrivalLocation1"=> $request->backArrivalLocation1,
                "backArrivalLocation2"=> $request->backArrivalLocation2,
                "backArrivalLocation3"=> $request->backArrivalLocation3,
                "backDepartureTime1" => $request->backDepartureTime1,
                "backDepartureTime2"=> $request->backDepartureTime2,
                "backDepartureTime3"=> $request->backDepartureTime3,
                "backArrivalTime1"=>$request->backArrivalTime1,
                "backArrivalTime2"=> $request->backArrivalTime2,
                "backArrivalTime3"=> $request->backArrivalTime3,
                "backFlightDuration1"=> $request->backFlightDuration1,
                "backFlightDuration2"=> $request->backFlightDuration2,
                "backFlightDuration3"=> $request->backFlightDuration3,
                "backBookingCode1"=> $request->backBookingCode1,
                "backBookingCode2"=> $request->backBookingCode2,
                "backBookingCode3"=> $request->backBookingCode3,
                "backdepTerminal1" => $request->backdepTerminal1,
                "backdepTerminal2"=> $request->backdepTerminal2,
                "backdepTerminal3"=> $request->backdepTerminal3,
                "backArrTerminal1"=> $request->backArrTerminal1,
                "backArrTerminal2"=> $request->backArrTerminal2,
                "backArrTerminal3"=> $request->backArrTerminal3,
                "searchId"=> $request->searchId,
                "resultId"=> $request->resultId,
                'updated_at'=> Carbon::now(),

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
                "FailedBooking" => $SegmentReturnWay
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
                SegmentReturnWay::findOrFail($id)->delete();
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
