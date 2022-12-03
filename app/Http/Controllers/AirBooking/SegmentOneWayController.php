<?php

namespace App\Http\Controllers\AirBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SegmentOneWay;
use Carbon\Carbon;

class SegmentOneWayController extends Controller
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
                $SegmentOneWay = SegmentOneWay::all();
                return response()->json($SegmentOneWay);
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
             $SegmentOneWay = SegmentOneWay::insert([
                "system" => $request->system,
                "pnr"=> $request->pnr,
                "segment"=> $request->segment,
                "departure1"=> $request->departure1,
                "departure2"=> $request->departure2,
                "departure3"=> $request->departure3,
                "departure4"=> $request->departure4,
                "arrival1"=> $request->arrival1,
                "arrival2"=> $request->arrival2,
                "arrival3"=> $request->arrival3,
                "arrival4"=> $request->arrival4,
                "departureTime1"=> Carbon::now(),
                "departureTime2" => Carbon::now(),
                "departureTime3"=> Carbon::now(),
                "departureTime4"=> Carbon::now(),
                "arrivalTime1"=> Carbon::now(),
                "arrivalTime2"=> Carbon::now(),
                "arrivalTime3"=> Carbon::now(),
                "arrivalTime4"=> Carbon::now(),
                "flightDuration1"=> $request->flightDuration1,
                "flightDuration2"=> $request->flightDuration2,
                "flightDuration3"=> $request->flightDuration3,
                "flightDuration4"=> $request->flightDuration4,
                "transit1"=> $request->transit1,
                "transit2" => $request->transit2,
                "transit3"=> $request->transit3,
                "marketingCareer1"=> $request->marketingCareer1,
                "marketingCareer2"=> $request->marketingCareer2,
                "marketingCareer3"=> $request->marketingCareer3,
                "marketingCareer4"=> $request->marketingCareer4,
                "marketingCareerName1"=> $request->marketingCareerName1,
                "marketingCareerName2"=> $request->marketingCareerName2,
                "marketingCareerName3"=> $request->marketingCareerName3	,
                "marketingCareerName4"=> $request->marketingCareerName4,
                "marketingFlight1"=> $request->marketingFlight1,
                "marketingFlight2"=> $request->marketingFlight2,
                "marketingFlight3" => $request->marketingFlight3,
                "marketingFlight4"=> $request->marketingFlight4,
                "operatingCareer1"=> $request->operatingCareer1,
                "operatingCareer2"=> $request->operatingCareer2,
                "operatingCareer3"=> $request->operatingCareer3,
                "operatingCareer4"=> $request->operatingCareer4,
                "operatingFlight1"=> $request->operatingFlight1,
                "operatingFlight2"=> $request->operatingFlight2,
                "operatingFlight3"=> $request->operatingFlight3,
                "operatingFlight4"=> $request->operatingFlight4,
                "departureAirport1"=> $request->departureAirport1,
                "departureAirport2"=> $request->departureAirport2,
                "departureAirport3"=> $request->departureAirport3,
                "departureAirport4"=> $request->departureAirport4,
                "arrivalAirport1"=> $request->arrivalAirport1,
                "arrivalAirport2"=> $request->arrivalAirport2,
                "arrivalAirport3"=> $request->arrivalAirport3,
                "arrivalAirport4"=> $request->arrivalAirport4,
                "departureLocation1"=> $request->departureLocation1,
                "departureLocation2"=> $request->departureLocation2,
                "departureLocation3"=> $request->departureLocation3,
                "departureLocation4"=> $request->departureLocation4,
                "arrivalLocation1"=> $request->arrivalLocation1,
                "arrivalLocation2"=> $request->arrivalLocation2,
                "arrivalLocation3"=> $request->arrivalLocation3,
                "arrivalLocation4"=> $request->arrivalLocation4,
                "bookingcode1"=> $request->bookingcode1,
                "bookingcode2"=> $request->bookingcode2,
                "bookingcode3"=> $request->bookingcode3,
                "bookingcode4"=> $request->bookingcode4,
                "departureTerminal1"=> $request->departureTerminal1,
                "departureTerminal2"=> $request->departureTerminal2,
                "departureTerminal3"=> $request->departureTerminal3,
                "departureTerminal4"=> $request->departureTerminal4,
                "arrivalTerminal1"=> $request->arrivalTerminal1,
                "arrivalTerminal2"=> $request->arrivalTerminal2,
                "arrivalTerminal3"=> $request->arrivalTerminal3,
                "arrivalTerminal4"=> $request->arrivalTerminal4,
                "adultBag"=> $request->adultBag,
                "childBag"=> $request->childBag,
                "infantBag"=> $request->infantBag,
                "resultId"=> $request->resultId,
                "searchId"=> $request->searchId,
                'createdAt' => Carbon::now()

             ]);
             return response()->json([
                 'success' => 'Ledger added Successful',
                 'Ticketing' => $SegmentOneWay,
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
                $SegmentOneWay = SegmentOneWay::findOrFail($id);
                return response()->json($SegmentOneWay);
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
            $SegmentOneWay = SegmentOneWay::findOrFail($id)->update([
                "system" => $request->system,
                "pnr"=> $request->pnr,
                "segment"=> $request->segment,
                "departure1"=> $request->departure1,
                "departure2"=> $request->departure2,
                "departure3"=> $request->departure3,
                "departure4"=> $request->departure4,
                "arrival1"=> $request->arrival1,
                "arrival2"=> $request->arrival2,
                "arrival3"=> $request->arrival3,
                "arrival4"=> $request->arrival4,
                "departureTime1"=> Carbon::now(),
                "departureTime2" => Carbon::now(),
                "departureTime3"=> Carbon::now(),
                "departureTime4"=> Carbon::now(),
                "arrivalTime1"=> Carbon::now(),
                "arrivalTime2"=> Carbon::now(),
                "arrivalTime3"=> Carbon::now(),
                "arrivalTime4"=> Carbon::now(),
                "flightDuration1"=> $request->flightDuration1,
                "flightDuration2"=> $request->flightDuration2,
                "flightDuration3"=> $request->flightDuration3,
                "flightDuration4"=> $request->flightDuration4,
                "transit1"=> $request->transit1,
                "transit2" => $request->transit2,
                "transit3"=> $request->transit3,
                "marketingCareer1"=> $request->marketingCareer1,
                "marketingCareer2"=> $request->marketingCareer2,
                "marketingCareer3"=> $request->marketingCareer3,
                "marketingCareer4"=> $request->marketingCareer4,
                "marketingCareerName1"=> $request->marketingCareerName1,
                "marketingCareerName2"=> $request->marketingCareerName2,
                "marketingCareerName3"=> $request->marketingCareerName3	,
                "marketingCareerName4"=> $request->marketingCareerName4,
                "marketingFlight1"=> $request->marketingFlight1,
                "marketingFlight2"=> $request->marketingFlight2,
                "marketingFlight3" => $request->marketingFlight3,
                "marketingFlight4"=> $request->marketingFlight4,
                "operatingCareer1"=> $request->operatingCareer1,
                "operatingCareer2"=> $request->operatingCareer2,
                "operatingCareer3"=> $request->operatingCareer3,
                "operatingCareer4"=> $request->operatingCareer4,
                "operatingFlight1"=> $request->operatingFlight1,
                "operatingFlight2"=> $request->operatingFlight2,
                "operatingFlight3"=> $request->operatingFlight3,
                "operatingFlight4"=> $request->operatingFlight4,
                "departureAirport1"=> $request->departureAirport1,
                "departureAirport2"=> $request->departureAirport2,
                "departureAirport3"=> $request->departureAirport3,
                "departureAirport4"=> $request->departureAirport4,
                "arrivalAirport1"=> $request->arrivalAirport1,
                "arrivalAirport2"=> $request->arrivalAirport2,
                "arrivalAirport3"=> $request->arrivalAirport3,
                "arrivalAirport4"=> $request->arrivalAirport4,
                "departureLocation1"=> $request->departureLocation1,
                "departureLocation2"=> $request->departureLocation2,
                "departureLocation3"=> $request->departureLocation3,
                "departureLocation4"=> $request->departureLocation4,
                "arrivalLocation1"=> $request->arrivalLocation1,
                "arrivalLocation2"=> $request->arrivalLocation2,
                "arrivalLocation3"=> $request->arrivalLocation3,
                "arrivalLocation4"=> $request->arrivalLocation4,
                "bookingcode1"=> $request->bookingcode1,
                "bookingcode2"=> $request->bookingcode2,
                "bookingcode3"=> $request->bookingcode3,
                "bookingcode4"=> $request->bookingcode4,
                "departureTerminal1"=> $request->departureTerminal1,
                "departureTerminal2"=> $request->departureTerminal2,
                "departureTerminal3"=> $request->departureTerminal3,
                "departureTerminal4"=> $request->departureTerminal4,
                "arrivalTerminal1"=> $request->arrivalTerminal1,
                "arrivalTerminal2"=> $request->arrivalTerminal2,
                "arrivalTerminal3"=> $request->arrivalTerminal3,
                "arrivalTerminal4"=> $request->arrivalTerminal4,
                "adultBag"=> $request->adultBag,
                "childBag"=> $request->childBag,
                "infantBag"=> $request->infantBag,
                "resultId"=> $request->resultId,
                "searchId"=> $request->searchId,
                'updated_at'=> Carbon::now(),

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
                "FailedBooking" => $SegmentOneWay
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
                SegmentOneWay::findOrFail($id)->delete();
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
