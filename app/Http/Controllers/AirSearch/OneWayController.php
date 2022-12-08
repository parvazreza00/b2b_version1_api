<?php

namespace App\Http\Controllers\AirSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class OneWayController extends Controller
{
    public function Oneway(Request $request){
        $All = array();
        $FlightType;
//erwrrrrrrrrrrrrrrrrrrrrrrrrrrr
        $controlrow = DB::table('control')->find(1);
        // return response()->json($controlrow);

        if(!empty($controlrow)){
            $sabre = $controlrow->sabre;
            $Galileo = $controlrow->galileo;
            $FlyHub = $controlrow->flyhub;
            $Amadeus = $controlrow->amadeus;
            $gdsPrice = $controlrow->gdsPrice;
            $farePrice = $controlrow->farePrice;
        }

        $Airportsql = DB::table('airports')->select('name', 'cityName','countryCode');

        if(array_key_exists('tripType', $_GET)){
            $Way = $_GET['tripType'];

            if($Way == 'oneway'){

                if(array_key_exists('journeyFrom', $_GET) && array_key_exists('journeyto', $_GET) && array_key_exists('departuredate',$_GET)){
                    $From = $request->input('journeyfrom');
                    $To = $request->input('journeyto');
                    $Date = $request->input('departuredate');
                    $ActualDate = $Date."T00:00:00";

                    print_r($From);


                    //trip type
                    $fromrow = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $From);

                    if(!empty($fromrow)){
                        $fromCountry = $fromrow['countryCode'];
                    }

                    $torow = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $To);

                    if(!empty($torow)){
                        $toCountry = $torow['countryCode'];
                    }

                    if($fromCountry == 'BD' && $toCountry == 'BD'){
                        $TripType = 'Inbound';
                    }else{
                        $TripType = 'Outbound';
                    }

                    if((array_key_exists('adult', $_GET)) && (array_key_exists('child', $_GET)) && (array_key_exists('infant', $_GET))){

                        $adult = $_GET['adult'];
                        $child = $_GET['child'];
                        $infants = $_GET['infant'];

                        $SeatReq = $adult + $child;

                        if($adult > 0 && $child > 0 && $infants > 0){
                            $SabreRequest = '{
                                "Code": "ADT",
                                "Quantity": '.$adult.'
                            },
                            {
                                "Code": "C09",
                                "Quantity": '.$child.'
                            },
                            {
                                "Code": "INF",
                                "Quantity": '.$infants.'
                            }';
                        }else if($adult > 0 && $child > 0){
                            $SabreRequest = '{
                                "Code": "ADT",
                                "Quantity": '.$adult.'
                            },
                            {
                                "Code": "C09",
                                "Quantity": '.$child.'
                            }';
                        }else if($adult > 0 && $infants > 0){
                            $SabreRequest = '{
                                "Code": "ADT",
                                "Quantity": '.$adult.'
                            },
                            {
                                "Code": "INF",
                                "Quantity": '.$infants.'
                            }';
                        }else{
                            $SabreRequest = '{
                                "Code": "ADT",
                                "Quantity": '.$adult.'
                            }';
                        }

                        $jsonreq = '{
                            "OTA_AirLowFareSearchRQ": {
                                "Version": "4",
                                "POS": {
                                    "Source": [{
                                            "PseudoCityCode": "Z01K",
                                            "RequestorID": {
                                                "Type": "1",
                                                "ID": "1",
                                                "CompanyName": {
                                                    "Code": "TN"
                                                }
                                            }
                                        }
                                    ]
                                },
                                "OriginDestinationInformation": [{
                                        "RPH": "1",
                                        "DepartureDateTime": "'.$ActualDate.'",
                                        "OriginLocation": {
                                            "LocationCode": "'.$From.'"
                                        },
                                        "DestinationLocation": {
                                            "LocationCode": "'.$To.'"
                                        }
                                    }
                                ],
                                "TravelPreferences": {
                                    "TPA_Extensions": {
                                        "DataSources": {
                                            "NDC": "Disable",
                                            "ATPCO": "Enable",
                                            "LCC": "Disable"
                                        },
                                "PreferNDCSourceOnTie": {
                                "Value": true
                                }
                                    }
                                },
                                "TravelerInfoSummary": {
                                    "AirTravelerAvail": [{
                                            "PassengerTypeQuantity": ['.$SabreRequest.']
                                        }
                                    ]
                                },
                                "TPA_Extensions": {
                                    "IntelliSellTransaction": {
                                        "RequestType": {
                                            "Name": "50ITINS"
                                        }
                                    }
                                }
                            }
                        }';

                if($Sabre == 1)//Sabre Start

                    try{

                        $client_id= base64_encode("V1:735082:Z01K:AA");
                        //$client_secret = base64_encode("280ff537"); //cert
                        $client_secret = base64_encode("flf73508"); //prod

                        $token = base64_encode($client_id.":".$client_secret);
                        $data='grant_type=client_credentials';

                            $headers = array(
                                'Authorization: Basic '.$token,
                                'Accept: /',
                                'Content-Type: application/x-www-form-urlencoded'
                            );

                            $apiURL1 = "https://api.havail.sabre.com/v2/auth/token";

                            $res1 = Http::withHeaders($headers)->get($apiURL1, $data);

                            $resf1 = json_decode($res1,1);
                            $access_token = $resf1['access_token'];

                            // print_r($resf1);

                        }catch (Exception $e){

                        }


                        if(isset($access_token)){
                            $apiURL2 = "https://api.havail.sabre.com/v4/offers/shop";
                            $res2 = Http::acceptsJson($jsonreq)->array(
                                'Content-Type: application/json',
                                'Conversation-ID: 2021.01.DevStudio',
                                'Authorization: Bearer '.$access_token,
                            )->post($apiURL2);

                            $result = json_decode($res2, true);

                            if(isset($result['groupedItineraryResponse']['itineraryGroups'])){
                                $SabreItenary = $result['groupedItineraryResponse']['itineraryGroups'];
                                // print_r($result);

                                if(array_key_exists('groupedItineraryResponse', $result)){
                                    if($result['groupedItineraryResponse']['statistics']['itineraryCount'] > 0){
                                        if($To == 'DXB' || $From == 'DXB'){
                                            if(isset($SabreItenary[0]['itineraries']) && isset($SabreItenary[1]['itineraries'])){
                                                if(count($SabreItenary[0]['itineraries']) > count($SabreItenary[1]['itineraries'])){
                                                    $flightListSabre = $SabreItenary[0]['itineraries'];
                                                }else{
                                                    $flightListSabre = $SabreItenary[1]['itineraries'];
                                                }
                                            }else{
                                                $flightListSabre = $SabreItenary[0]['itineraries'];
                                            }
                                        }else{
                                            $flightListSabre = $SabreItenary[0]['itineraries'];
                                            // echo count($flightList);
                                        }

                                        $scheduleDescs = $result['groupedItineraryResponse']['scheduleDescs'];
						                $legDescs = $result['groupedItineraryResponse']['legDescs'];

						                $Bag = $result['groupedItineraryResponse']['baggageAllowanceDescs'];
                                    }
                                }
                            }
                        }

                    }


                    if(isset($flightListSabre)){
                        $i = 0;
                            foreach($flightListSabre as $var){
                                $i++;
                                $idd = $var['id'];
                                $pricingSource = $var['pricingSource'];
                                $vCarCode = $var['pricingInformation'][0]['fare']['validatingCarrierCode'];+

                            $sqlrow = DB::table('airlines')->select('nameBangla', 'name', 'commission')->where('code', $vCarCode)->get();


                                if(!empty($sqlrow)){
                                    $CarrieerName = $sqlrow->name;
                                    $fareRate= $sqlrow->commission;
                                }



                                $passengerInfo =  $var['pricingInformation'][0]['fare']['passengerInfoList'][0]['passengerInfo'];
                                $fareComponents = $passengerInfo['fareComponents'];

                                $Class = $fareComponents[0]['segments'][0]['segment']['cabinCode'];


                                $BookingCode = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                $Seat = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];


                                //$lessFare = floor((($baseFareAmount * 0.93) + $totalTaxAmount) + ($totalFare* 0.003));
                                //$Commission = $totalFare - $Exact;

                                $PriceInfo = $var['pricingInformation'][0]['fare']['passengerInfoList'];

                                if($fareRate == 7){
                                    if($From != "DAC" && $vCarCode =="SV"){
                                        $baseFareAmount =  ceil(($var['pricingInformation'][0]['fare']['totalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                        $totalTaxAmount = ceil(($var['pricingInformation'][0]['fare']['totalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);
                                        $totalFare = ceil(($var['pricingInformation'][0]['fare']['totalFare']['totalPrice'] / $gdsPrice) * $farePrice);

                                        $AgentPrice = floor((($baseFareAmount * 0.93) + $totalTaxAmount) + ($totalFare* 0.003));
                                        $Commission = $totalFare - $AgentPrice;

                                        //Price Break Down
                                        if($adult > 0 && $child > 0 &&  $infants > 0){


                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $childBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $childTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $infantBasePrice = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $infantTaxAmount = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0"),
                                                                "2" =>
                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );



                                        }else if($adult > 0 && $child > 0){
                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount']/ $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $childBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $childTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount']  / $gdsPrice) * $farePrice);

                                        }else if($adult > 0 && $infants > 0){
                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $infantBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $infantTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                        }else if($adult> 0){

                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount']/ $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );
                                        }



                                    }else if($From != "DAC" && $vCarCode =="SQ"){

                                        $baseFareAmount =  $var['pricingInformation'][0]['fare']['totalFare']['equivalentAmount'];
                                        $totalTaxAmount = $var['pricingInformation'][0]['fare']['totalFare']['totalTaxAmount'];
                                        $totalFare = $var['pricingInformation'][0]['fare']['totalFare']['totalPrice'] ;

                                        $AgentPrice = $totalFare;
                                        $Commission = 0;


                                        if($adult > 0 && $child > 0 &&  $infants > 0){

                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $childBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $childTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $infantBasePrice = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $infantTaxAmount = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0"),
                                                                "2" =>
                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );



                                        }else if($adult > 0 && $child > 0){
                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $childBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $childTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );

                                        }else if($adult > 0 && $infants > 0){
                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $infantBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                            $infantTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount']  / $gdsPrice) * $farePrice);
                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );

                                        }else if($adult> 0){

                                            $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount']/ $gdsPrice) * $farePrice);
                                            $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );
                                        }

                                    }else{
                                        $baseFareAmount =  $var['pricingInformation'][0]['fare']['totalFare']['equivalentAmount'];
                                        $totalTaxAmount = $var['pricingInformation'][0]['fare']['totalFare']['totalTaxAmount'];
                                        $totalFare = $var['pricingInformation'][0]['fare']['totalFare']['totalPrice'] ;

                                        $AgentPrice = floor((($baseFareAmount * 0.93) + $totalTaxAmount) + ($totalFare* 0.003));
                                        $Commission = $totalFare - $AgentPrice;

                                        if($adult > 0 && $child > 0 &&  $infants > 0){

                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $childBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $childTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $infantBasePrice = $PriceInfo[2]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $infantTaxAmount = $PriceInfo[2]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0"),
                                                                "2" =>
                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );



                                        }else if($adult > 0 && $child > 0){
                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $childBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $childTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );


                                        }else if($adult > 0 && $infants > 0){
                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $infantBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $infantTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>

                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );


                                        }else if($adult> 0){

                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );
                                        }
                                    }
                                }else if($fareRate == 3){
                                    if($vCarCode == "FZ"){
                                        $baseFareAmount =  $var['pricingInformation'][0]['fare']['totalFare']['equivalentAmount'];
                                        $totalTaxAmount = $var['pricingInformation'][0]['fare']['totalFare']['totalTaxAmount'];
                                        $totalFare = $var['pricingInformation'][0]['fare']['totalFare']['totalPrice'] ;

                                        $AgentPrice = $totalFare;
                                        $Commission = $totalFare - $AgentPrice;

                                        if($adult > 0 && $child > 0 &&  $infants > 0){

                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $childBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $childTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $infantBasePrice = $PriceInfo[2]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $infantTaxAmount = $PriceInfo[2]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0"),
                                                                "2" =>
                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );



                                        }else if($adult > 0 && $child > 0){
                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $childBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $childTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>
                                                                array("BaseFare"=> "$childBasePrice",
                                                                "Tax"=> "$childTaxAmount",
                                                                "PaxCount"=> $child,
                                                                "PaxType"=> "CNN",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );


                                        }else if($adult > 0 && $infants > 0){
                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                            $infantBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $infantTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")
                                                                ,
                                                                "1" =>

                                                                array("BaseFare"=> "$infantBasePrice",
                                                                "Tax"=> "$infantTaxAmount",
                                                                "PaxCount"=> $infants,
                                                                "PaxType"=> "INF",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );


                                        }else if($adult> 0){

                                            $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                            $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                            $PriceBreakDown = array("0" =>
                                                                array("BaseFare"=> "$adultBasePrice",
                                                                "Tax"=> "$adultTaxAmount",
                                                                "PaxCount"=> $adult,
                                                                "PaxType"=> "ADT",
                                                                "Discount"=> "0",
                                                                "OtherCharges"=> "0",
                                                                "ServiceFee"=> "0")

                                                        );
                                        }

                                    }
                                }else{
                                    $baseFareAmount =  ceil(($var['pricingInformation'][0]['fare']['totalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                    $totalTaxAmount = ceil(($var['pricingInformation'][0]['fare']['totalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);
                                    $totalFare = ceil(($var['pricingInformation'][0]['fare']['totalFare']['totalPrice'] / $gdsPrice) * $farePrice);

                                    $AgentPrice = floor((($baseFareAmount * 0.93) + $totalTaxAmount) + ($totalFare* 0.003));
                                    $Commission = $totalFare - $AgentPrice;

                                    //Price Break Down
                                    if($adult > 0 && $child > 0 &&  $infants > 0){


                                        $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                        $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                        $childBasePrice = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                        $childTaxAmount = ceil(($PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                        $infantBasePrice = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                        $infantTaxAmount = ceil(($PriceInfo[2]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);


                                        $PriceBreakDown = array("0" =>
                                                            array("BaseFare"=> "$adultBasePrice",
                                                            "Tax"=> "$adultTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "ADT",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")
                                                            ,
                                                            "1" =>
                                                            array("BaseFare"=> "$childBasePrice",
                                                            "Tax"=> "$childTaxAmount",
                                                            "PaxCount"=> $child,
                                                            "PaxType"=> "CNN",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0"),
                                                            "2" =>
                                                            array("BaseFare"=> "$infantBasePrice",
                                                            "Tax"=> "$infantTaxAmount",
                                                            "PaxCount"=> $infants,
                                                            "PaxType"=> "INF",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")

                                                    );



                                    }else if($adult > 0 && $child > 0){
                                        $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                        $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];


                                        $childBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                        $childTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                        $PriceBreakDown = array("0" =>
                                                            array("BaseFare"=> "$adultBasePrice",
                                                            "Tax"=> "$adultTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "ADT",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")
                                                            ,
                                                            "1" =>
                                                            array("BaseFare"=> "$childBasePrice",
                                                            "Tax"=> "$childTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "CNN",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")


                                                    );

                                    }else if($adult > 0 && $infants > 0){
                                        $adultBasePrice = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                        $adultTaxAmount = $PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                        $infantBasePrice = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['equivalentAmount'];
                                        $infantTaxAmount = $PriceInfo[1]['passengerInfo']['passengerTotalFare']['totalTaxAmount'];

                                        $PriceBreakDown = array("0" =>
                                                            array("BaseFare"=> "$adultBasePrice",
                                                            "Tax"=> "$adultTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "ADT",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")
                                                            ,
                                                            "1" =>

                                                            array("BaseFare"=> "$infantBasePrice",
                                                            "Tax"=> "$infantTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "INF",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")

                                                    );
                                    }else if($adult> 0){

                                        $adultBasePrice = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['equivalentAmount'] / $gdsPrice) * $farePrice);
                                        $adultTaxAmount = ceil(($PriceInfo[0]['passengerInfo']['passengerTotalFare']['totalTaxAmount'] / $gdsPrice) * $farePrice);

                                        $PriceBreakDown = array("0" =>
                                                            array("BaseFare"=> "$adultBasePrice",
                                                            "Tax"=> "$adultTaxAmount",
                                                            "PaxCount"=> $adult,
                                                            "PaxType"=> "ADT",
                                                            "Discount"=> "0",
                                                            "OtherCharges"=> "0",
                                                            "ServiceFee"=> "0")

                                        );
                                    }
                                }




                                $Segment = $fareComponents[0]['segments'];

                                $BookingCode = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                $Seat = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];

                                if(isset($passengerInfo['baggageInformation'][0]['allowance']['ref'])){
                                    $BegRef= $passengerInfo['baggageInformation'][0]['allowance']['ref'];
                                    $BegId = $BegRef - 1;
                                    if(isset($Bag[$BegId]['weight'])){
                                        $Bags = $Bag[$BegId]['weight'];
                                    }else if(isset($Bag[$BegId]['pieceCount'])){
                                        $Bags = $Bag[$BegId]['pieceCount'];
                                    }else{
                                        $Bags = "0";
                                    }
                                }else{
                                    $Bags = "0";
                                }

                                if($Class == 'Y'){
                                    $CabinClass = "Economy";

                                }


                            $nonRefundable = $passengerInfo['nonRefundable'];
                            if($nonRefundable == 1){
                                $nonRef = "Nonrefundable";

                            }else{
                                $nonRef = "Refundable";
                            }




                                $ref = $var['legs'][0]['ref'];
                                $id = $ref - 1;

                                $sgCount = count($legDescs[$id]['schedules']);

                                $ElapedTime = $legDescs[$id]['elapsedTime'];
                                $JourneyDuration = floor($ElapedTime / 60)."H ".($ElapedTime - ((floor($ElapedTime / 60)) * 60))."Min";


                                if($sgCount ==  1){

                                    $lf = $legDescs[$id]['schedules'][0]['ref'];
                                    $legref = $lf- 1;

                                    $ElapsedTime = $scheduleDescs[$legref]['elapsedTime'];
                                    $TravelTime = floor($ElapsedTime / 60)."H ".($ElapsedTime - ((floor($ElapsedTime / 60)) * 60))."Min";

                                    $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                    $arrAt2 = substr($ArrivalTime1,0,5);

                                    $arrivalDate = 0;
                                    if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                            $arrivalDate += 1;
                                    }


                                    if($arrivalDate == 1){
                                            $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                            }else{
                                            $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                        }



                                    $departureTime1 = $scheduleDescs[$legref]['departure']['time'];
                                    $depAt1 = substr($departureTime1,0,5);

                                    $fromTime1 = str_split($departureTime1, 8);
                                    $dpTime1 = date("D d M Y", strtotime($Date." ".$fromTime1[0]));

                                    $toTime1 = str_split($ArrivalTime1, 8);
                                    $arrTime2 = date("D d M Y", strtotime($aDate." ".$toTime1[0]));

                                    $ArrivalTo = $scheduleDescs[$legref]['arrival']['airport'];
                                    $DepartureFrom = $scheduleDescs[$legref]['departure']['airport'];


                                    $ArrivalTime = $scheduleDescs[$legref]['arrival']['time'];
                                    $departureTime = $scheduleDescs[$legref]['departure']['time'];
                                    $markettingCarrier = $scheduleDescs[$legref]['carrier']['marketing'];

                                    $sqlrow = DB::table('airlines')->select('name')->where('code', $markettingCarrier)->get();
                                    // $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);

                                    if(!empty($sqlrow)){
                                        $markettingCarrierName = $sqlrow->name;
                                    }

                                    // Departure Country
                                    $sql1row = $Airportsql->where('code', $DepartureFrom)->get();

                                    if(!empty($sql1row)){
                                        $dAirport = $sql1row->name;
                                        $dCity = $sql1row->cityName;
                                        $dCountry = $sql1row->countryCode;
                                    }

                                    // Arrival Country
                                    $sql2row = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo)->get();

                                    if(!empty($sql2row)){
                                        $aAirport = $sql2row->name;
                                        $aCity = $row2->cityName;
                                        $aCountry = $sql2row->countryCode;

                                    }


                                    $markettingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier = $scheduleDescs[$legref]['carrier']['operating'];
                                    $operatingFN = $scheduleDescs[$legref]['carrier']['operatingFlightNumber'];

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }else if(!isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat = "Available Seat Invisible";
                                    }

                                    $arrivalDate = 0;
                                    if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                            $arrivalDate += 1;
                                    }


                                    if($arrivalDate == 1){
                                            $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                            }else{
                                            $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                    $fromTime = str_split($departureTime, 8);
                                    $dpTime = $Date."T".$fromTime[0];

                                    $toTime = str_split($ArrivalTime, 8);
                                    $arrTime = $aDate."T".$toTime[0];

                                //Array Push

                                $stopOverDetails = array();

                                if(isset($scheduleDescs[$legref]['hiddenStops'])){
                                $hiddenStopOver = $scheduleDescs[$legref]['hiddenStops'];

                                    foreach($hiddenStopOver as $hidestop){
                                        $airpot = $hidestop->airpot;
                                        $duration = $airpot->elapsedLayoverTime;
                                        $time = date('H:i', mktime(0,$duration));
                                        $stopoverdetails = array("airport" => $airpot,
                                                                "time"=> $time);
                                        array_push($stopOverDetails, $stopoverdetails);
                                    }
                                }



                                $segment = array("0" =>
                                                  array("marketingcareer"=> "$markettingCarrier",
                                                        "marketingcareerName"=> "$markettingCarrierName",
                                                        "marketingflight"=> "$markettingFN",
                                                        "operatingcareer"=> "$operatingCarrier",
                                                        "operatingflight"=> "$operatingFN",
                                                        "departure"=> "$DepartureFrom",
                                                        "departureAirport"=> "$dAirport ",
                                                        "departureLocation"=> "$dCity , $dCountry",
                                                        "departureTime" => "$dpTime",
                                                        "arrival"=> "$ArrivalTo",
                                                        "arrivalTime" => "$arrTime",
                                                        "arrivalAirport"=> "$aAirport",
                                                        "arrivalLocation"=> "$aCity , $aCountry",
                                                        "flightduration"=> "$TravelTime",
                                                        "bookingcode"=> "$BookingCode",
                                                        "seat"=> "$Seat")

                                                );

                                $transitDetails = array("transit1" => "0");

                                $basic = array("system"=>"Sabre",
                                                    "segment"=> "1",
                                                    "triptype"=>$TripType,
                                                    "career"=> "$vCarCode",
                                                    "careerName" => "$CarrieerName",
                                                    "BasePrice" => "$baseFareAmount",
                                                    "Taxes" => "$totalTaxAmount",
                                                    "price" => "$AgentPrice",
                                                    "clientPrice"=> "$totalFare",
                                                    "comission"=> "$Commission",
                                                    "pricebreakdown"=> $PriceBreakDown,
                                                    "departure"=> "$From",
                                                    "departureTime" => "$depAt1",
                                                    "departureDate" => "$dpTime1",
                                                    "arrival"=> "$To",
                                                    "arrivalTime" => "$arrAt2",
                                                    "arrivalDate" => "$arrTime2",
                                                    "flightduration"=> "$JourneyDuration",
                                                    "bags" => "$Bags",
                                                    "seat" => "$Seat",
                                                    "class" => "$CabinClass",
                                                    "refundable"=> "$nonRef",
                                                    "segments" => $segment,
                                                    "transit" => $transitDetails,
                                                    "stopover"=> $stopOverDetails

                                            );

                                array_push($All,$basic);


                                }if($sgCount ==  2){

                                $lf = $legDescs[$id]['schedules'][0]['ref'];
                                $legref = $lf- 1;

                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime1,0,5);

                                $arrivalDate1 = 0;
                                if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                        $arrivalDate1 += 1;
                                }


                                if($arrivalDate1 == 1){
                                        $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                        }else{
                                        $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                $ElapsedTime1 = $scheduleDescs[$legref]['elapsedTime'];
                                $TravelTime1 = floor($ElapsedTime1 / 60)."H ".($ElapsedTime1 - ((floor($ElapsedTime1 / 60)) * 60))."Min";


                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt1 = substr($ArrivalTime1,0,5);

                                $departureTime1 = $scheduleDescs[$legref]['departure']['time'];
                                $depAt1 = substr($departureTime1,0,5);

                                $fromTime1 = str_split($departureTime1, 8);
                                $dpTime1 = date("D d M Y", strtotime($Date." ".$fromTime1[0]));

                                $toTime1 = str_split($ArrivalTime1, 8);
                                $arrTime1 = date("D d M Y", strtotime($aDate." ".$toTime1[0]));


                                $ArrivalTo = $scheduleDescs[$legref]['arrival']['airport'];
                                    $DepartureFrom = $scheduleDescs[$legref]['departure']['airport'];


                                    $ArrivalTime = $scheduleDescs[$legref]['arrival']['time'];
                                    $departureTime = $scheduleDescs[$legref]['departure']['time'];




                                    // Departure Country
                                    $sql1row1 = $Airportsql->where('code', $DepartureFrom)->get();

                                    if(!empty($sql1row1)){
                                    $dAirport = $sql1row1->name;
                                    $dCity = $sql1row1->cityName;
                                    $dCountry = $sql1row1->countryCode;

                                    }

                                    // Departure Country
                                    $sql2row2 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo)->get();

                                    if(!empty($sql2row2)){
                                    $aAirport = $sql2row2->name;
                                    $aCity = $sql2row2->cityName;
                                    $aCountry = $sql2row2->countryCode;

                                    }

                                    $markettingCarrier = $scheduleDescs[$legref]['carrier']['marketing'];
                                    $markettingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier = $scheduleDescs[$legref]['carrier']['operating'];
                                    $operatingFN = $scheduleDescs[$legref]['carrier']['operatingFlightNumber'];


                                    $carriersqlrow = DB::table('airlines')->select('name')->where('code', $markettingCarrier)->get();

                                    if(!empty($carriersqlrow)){
                                        $markettingCarrierName = $carriersqlrow->name;
                                    }

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat1 = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }


                                    if(isset($fareComponents[0]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }



                                    $arrivalDate = 0;
                                    if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                            $arrivalDate += 1;
                                    }


                                    if($arrivalDate == 1){
                                            $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                            }else{
                                            $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                    $fromTime = str_split($departureTime, 8);
                                    $dpTime = $Date."T".$fromTime[0];

                                    $toTime = str_split($ArrivalTime, 8);
                                    $arrTime = $aDate."T".$toTime[0];



                                //2nd Leg

                                    $lf2 = $legDescs[$id]['schedules'][1]['ref'];
                                    $legref1 = $lf2- 1;


                                    $dateAdjust2 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                        $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $NewDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime2 = $scheduleDescs[$legref1]['elapsedTime'];
                                $TravelTime2 = floor($ElapsedTime2 / 60)."H ".($ElapsedTime2 - ((floor($ElapsedTime2 / 60)) * 60))."Min";

                                $ArrivalTime2 = $scheduleDescs[$legref1]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime2,0,5);

                                $departureTime2 = $scheduleDescs[$legref1]['departure']['time'];
                                $depAt2 = substr($departureTime2,0,5);

                                $fromTime2 = str_split($departureTime2, 8);
                                $dpTime2 = date("D d M Y", strtotime($NewDate2." ".$fromTime2[0]));

                                $toTime2 = str_split($ArrivalTime2, 8);
                                $arrTime2 = date("D d M Y", strtotime($NewDate2." ".$toTime2[0]));

                                $TransitInt = $ElapedTime - ($ElapsedTime1 + $ElapsedTime2);
                                $Transit = floor($TransitInt / 60)."H ".($TransitInt - ((floor($TransitInt / 60)) * 60))."Min";

                                $dateAdjust2 = 0;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $descid = $scheduleDescs[$legref1]['id'];
                                    $ArrivalTo1 = $scheduleDescs[$legref1]['arrival']['airport'];
                                    $DepartureFrom1 = $scheduleDescs[$legref1]['departure']['airport'];


                                    $ArrivalTime1 = $scheduleDescs[$legref1]['arrival']['time'];
                                    $departureTime1 = $scheduleDescs[$legref1]['departure']['time'];
                                    $markettingCarrier1 = $scheduleDescs[$legref1]['carrier']['marketing'];


                                    $carrierrsql1row1 = DB::table('airlines')->select('name')->where('code', $markettingCarrier1)->get();


                                    if(!empty($carrierrsql1row1)){
                                        $markettingCarrierName1 = $carrierrsql1row1->name;
                                    }

                                    // Departure Country
                                    $sql3row3 = $Airportsql->where('code', $DepartureFrom1)->get();

                                    if(!empty($sql3row3)){
                                        $dAirport1 = $sql3row3->name;
                                        $dCity1 = $sql3row3->cityName;
                                        $dCountry1 = $sql3row3->countryCode;
                                    }

                                    // Departure Country
                                    $sql4row4 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo1)->get();

                                    if(!empty($sql4row4)){
                                        $aAirport1 = $sql4row4->name;
                                        $aCity1 = $sql4row4->cityName;
                                        $aCountry1 = $sql4row4->countryCode;

                                    }


                                    $markettingFN1 = $scheduleDescs[$legref1]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier1 = $scheduleDescs[$legref1]['carrier']['operating'];
                                    $operatingFN1 = $scheduleDescs[$legref1]['carrier']['operatingFlightNumber'];

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat2 = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }

                                    if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode1 = $fareComponents[0]['segments'][1]['segment']['bookingCode'];
                                    }

                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $dDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate2 = 0;
                                    if(isset($scheduleDescs[$legref1]['arrival']['dateAdjustment'])){
                                            $arrivalDate2 += 1;
                                    }


                                    if($arrivalDate2 == 1){
                                            $aDate2 = date('Y-m-d', strtotime("+1 day", strtotime($dDate2)));
                                            }else{
                                            $aDate2 = date('Y-m-d', strtotime("+0 day", strtotime($dDate2)));
                                    }


                                    $fromTime1 = str_split($departureTime1, 8);
                                    $depTime1 = $dDate2."T".$fromTime1[0];

                                    $toTime1 = str_split($ArrivalTime1, 8);
                                    $arrTime1 = $aDate2."T".$toTime1[0];

                                    //Array

                                    $transitDetails = array("transit1" => "$Transit");

                                    $segment = array("0" =>
                                                        array("marketingcareer"=> "$markettingCarrier",
                                                              "marketingcareerName"=> "$markettingCarrierName",
                                                                "marketingflight"=> "$markettingFN",
                                                                "operatingcareer"=> "$operatingCarrier",
                                                                "operatingflight"=> "$operatingFN",
                                                                "departure"=> "$DepartureFrom",
                                                                "departureAirport"=> "$dAirport ",
                                                                "departureLocation"=> "$dCity , $dCountry",
                                                                "departureTime" => "$dpTime",
                                                                "arrival"=> "$ArrivalTo",
                                                                "arrivalTime" => "$arrTime",
                                                                "arrivalAirport"=> "$aAirport",
                                                                "arrivalLocation"=> "$aCity , $aCountry",
                                                                "flightduration"=> "$TravelTime1",
                                                                "bookingcode"=> "$BookingCode",
                                                                "seat"=> "$Seat1"),
                                                    "1" =>
                                                        array("marketingcareer"=> "$markettingCarrier1",
                                                              "marketingcareerName"=> "$markettingCarrierName1",
                                                                "marketingflight"=> "$markettingFN1",
                                                                "operatingcareer"=> "$operatingCarrier1",
                                                                "operatingflight"=> "$operatingFN1",
                                                                "departure"=> "$DepartureFrom1",
                                                                "departureAirport"=> "$dAirport1",
                                                                "departureLocation"=> "$dCity1 , $dCountry1",
                                                                "departureTime" => "$depTime1",
                                                                "arrival"=> "$ArrivalTo1",
                                                                "arrivalTime" => "$arrTime1",
                                                                "arrivalAirport"=> "$aAirport1",
                                                                "arrivalLocation"=> "$aCity1 , $aCountry1",
                                                                "flightduration"=> "$TravelTime2",
                                                                "bookingcode"=> "$BookingCode1",
                                                                "seat"=> "$Seat2")



                                                );

                                $basic = array("system" => "Sabre",
                                                    "segment"=> "2",
                                                    "triptype"=>$TripType,
                                                    "career"=> "$vCarCode",
                                                    "careerName" => "$CarrieerName",
                                                    "BasePrice" => "$baseFareAmount",
                                                    "Taxes" => "$totalTaxAmount",
                                                    "price" => "$AgentPrice",
                                                    "clientPrice"=> "$totalFare",
                                                    "comission"=> "$Commission",
                                                    "pricebreakdown"=> $PriceBreakDown,
                                                    "departure"=> "$From",
                                                    "departureTime" => "$depAt1",
                                                    "departureDate" => $dpTime1,
                                                    "arrival"=> "$To",
                                                    "arrivalTime" => "$arrAt2",
                                                    "arrivalDate" => "$arrTime2",
                                                    "flightduration"=> "$JourneyDuration",
                                                    "bags" => "$Bags",
                                                    "seat" => "$Seat",
                                                    "class" => "$CabinClass",
                                                    "refundable"=> "$nonRef",
                                                    "segments" => $segment,
                                                    "transit" => $transitDetails

                                            );

                                array_push($All,$basic);

                                }if($sgCount ==  3){


                                $lf = $legDescs[$id]['schedules'][0]['ref'];
                                $legref = $lf- 1;

                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime1,0,5);

                                $arrivalDate1 = 0;
                                if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                        $arrivalDate1 += 1;
                                }


                                if($arrivalDate1 == 1){
                                        $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                        }else{
                                        $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                $ElapsedTime1 = $scheduleDescs[$legref]['elapsedTime'];
                                $TravelTime1 = floor($ElapsedTime1 / 60)."H ".($ElapsedTime1 - ((floor($ElapsedTime1 / 60)) * 60))."Min";

                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt1 = substr($ArrivalTime1,0,5);

                                $departureTime1 = $scheduleDescs[$legref]['departure']['time'];
                                $depAt1 = substr($departureTime1,0,5);

                                $fromTime1 = str_split($departureTime1, 8);
                                $dpTime1 = date("D d M Y", strtotime($Date." ".$fromTime1[0]));

                                $toTime1 = str_split($ArrivalTime1, 8);
                                $arrTime1 = date("D d M Y", strtotime($aDate." ".$toTime1[0]));

                                $ArrivalTo = $scheduleDescs[$legref]['arrival']['airport'];
                                    $DepartureFrom = $scheduleDescs[$legref]['departure']['airport'];


                                    $ArrivalTime = $scheduleDescs[$legref]['arrival']['time'];
                                    $departureTime = $scheduleDescs[$legref]['departure']['time'];
                                    $markettingCarrier = $scheduleDescs[$legref]['carrier']['marketing'];

                                    $carriersqlrow = DB::table('airlines')->select('name')->where('code', $markettingCarrier)->get();

                                    if(!empty($carriersqlrow)){
                                        $markettingCarrierName = $carriersqlrow->name;
                                    }

                                    // Departure Country
                                    $sql1row1 = $Airportsql->where('code', $DepartureFrom)->get();

                                    if(!empty($sql1row1)){
                                    $dAirport = $sql1row1->name;
                                    $dCity = $sql1row1->cityName;
                                    $dCountry = $sql1row1->countryCode;

                                    }

                                    // Departure Country
                                    $sql2row2 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo)->get();

                                    if(!empty($sql2row2)){
                                    $aAirport = $sql2row2->name;
                                    $aCity = $sql2row2->cityName;
                                    $aCountry = $sql2row2->countryCode;

                                    }


                                    $markettingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier = $scheduleDescs[$legref]['carrier']['operating'];
                                    if(isset($scheduleDescs[$legref]['carrier']['operatingFlightNumber'])){
                                        $operatingFN = $scheduleDescs[$legref]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    }

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat1 = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }


                                    if(isset($fareComponents[0]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode1 = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }

                                    $arrivalDate = 0;
                                    if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                            $arrivalDate += 1;
                                    }


                                    if($arrivalDate == 1){
                                            $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                            }else{
                                            $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                    $fromTime = str_split($departureTime, 8);
                                    $dpTime = $Date."T".$fromTime[0];

                                    $toTime = str_split($ArrivalTime, 8);
                                    $arrTime = $aDate."T".$toTime[0];



                                //2nd Leg

                                    $lf2 = $legDescs[$id]['schedules'][1]['ref'];
                                    $legref1 = $lf2- 1;


                                    $dateAdjust2 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                        $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $NewDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime2 = $scheduleDescs[$legref1]['elapsedTime'];
                                $TravelTime2 = floor($ElapsedTime2 / 60)."H ".($ElapsedTime2 - ((floor($ElapsedTime2 / 60)) * 60))."Min";

                                $ArrivalTime2 = $scheduleDescs[$legref1]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime2,0,5);

                                $departureTime2 = $scheduleDescs[$legref1]['departure']['time'];
                                $depAt2 = substr($departureTime2,0,5);

                                $fromTime2 = str_split($departureTime2, 8);
                                $dpTime2 = date("D d M Y", strtotime($NewDate2." ".$fromTime2[0]));

                                $toTime2 = str_split($ArrivalTime2, 8);
                                $arrTime2 = date("D d M Y", strtotime($NewDate2." ".$toTime2[0]));


                                $dateAdjust2 = 0;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $descid = $scheduleDescs[$legref1]['id'];
                                    $ArrivalTo1 = $scheduleDescs[$legref1]['arrival']['airport'];
                                    $DepartureFrom1 = $scheduleDescs[$legref1]['departure']['airport'];


                                    $ArrivalTime1 = $scheduleDescs[$legref1]['arrival']['time'];
                                    $departureTime1 = $scheduleDescs[$legref1]['departure']['time'];
                                    $markettingCarrier1 = $scheduleDescs[$legref1]['carrier']['marketing'];


                                    $carriersql1row1 = DB::table('airlines')->select('name')->where('code', $markettingCarrier1)->get();

                                    if(!empty($carriersql1row1)){
                                    $markettingCarrierName1 = $carriersql1row1->name;

                                    }

                                    // Departure Country
                                    $sql3row3 = $Airportsql->where('code', $DepartureFrom1)->get();

                                    if(!empty($sql3row3)){
                                    $dAirport1 = $sql3row3->name;
                                    $dCity1 = $sql3row3->cityName;
                                    $dCountry1 = $sql3row3->countryCode;

                                    }

                                    // Departure Country
                                    $sql4row4 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo1)->get();

                                    if(!empty($sql4row4)){
                                        $aAirport1 = $sql4row4->name;
                                        $aCity1 = $sql4row4->cityName;
                                        $aCountry1 = $sql4row4->countryCode;

                                    }


                                    $markettingFN1 = $scheduleDescs[$legref1]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier1 = $scheduleDescs[$legref1]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref1]['carrier']['operatingFlightNumber'])){
                                        $operatingFN1 = $scheduleDescs[$legref1]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN1 = 0;
                                    }

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat2 = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }

                                    if(isset($fareComponents[0]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[0]['segments'][1]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode1 = $fareComponents[0]['segments'][1]['segment']['bookingCode'];
                                    }



                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $dDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate2 = 0;
                                    if(isset($scheduleDescs[$legref1]['arrival']['dateAdjustment'])){
                                            $arrivalDate2 += 1;
                                    }


                                    if($arrivalDate2 == 1){
                                            $aDate2 = date('Y-m-d', strtotime("+1 day", strtotime($dDate2)));
                                            }else{
                                            $aDate2 = date('Y-m-d', strtotime("+0 day", strtotime($dDate2)));
                                    }


                                    $fromTime1 = str_split($departureTime1, 8);
                                    $dpTime1 = $dDate2."T".$fromTime1[0];

                                    $toTime1 = str_split($ArrivalTime1, 8);
                                    $arrTime1 = $aDate2."T".$toTime1[0];


                                // 3rd Leg

                                $lf3 = $legDescs[$id]['schedules'][2]['ref'];
                                $legref2 = $lf3- 1;


                                    $dateAdjust3 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][2]['departureDateAdjustment'])){
                                        $dateAdjust3 = $legDescs[$id]['schedules'][2]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $NewDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime3 = $scheduleDescs[$legref2]['elapsedTime'];
                                $TravelTime3 = floor($ElapsedTime3 / 60)."H ".($ElapsedTime3 - ((floor($ElapsedTime3 / 60)) * 60))."Min";

                                $ArrivalTime3 = $scheduleDescs[$legref2]['arrival']['time'];
                                $arrAt3 = substr($ArrivalTime3,0,5);

                                $departureTime3 = $scheduleDescs[$legref2]['departure']['time'];
                                $depAt3 = substr($departureTime3,0,5);

                                $fromTime3 = str_split($departureTime3, 8);
                                $dpTime3 = date("D d M Y", strtotime($NewDate3." ".$fromTime3[0]));

                                $toTime3 = str_split($ArrivalTime3, 8);
                                $arrTime3 = date("D d M Y", strtotime($NewDate3." ".$toTime3[0]));


                                $dateAdjust3 = 0;

                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust3 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $ArrivalTo2 = $scheduleDescs[$legref2]['arrival']['airport'];
                                    $DepartureFrom2 = $scheduleDescs[$legref2]['departure']['airport'];
                                    $ArrivalTime2 = $scheduleDescs[$legref2]['arrival']['time'];
                                    $departureTime2 = $scheduleDescs[$legref2]['departure']['time'];
                                    $markettingCarrier2 = $scheduleDescs[$legref2]['carrier']['marketing'];


                                    $carriersql2row2 = DB::table('airlines')->select('name')->where('code', $markettingCarrier2)->get();

                                    if(!empty($carriersql2row2)){
                                        $markettingCarrierName2 = $carriersql2row2->name;
                                    }

                                    // Departure Country
                                    $dsql3drow3 = $Airportsql->where('code', $DepartureFrom2)->get();

                                    if(!empty($dsql3drow3)){
                                    $dAirport2 = $dsql3drow3->name;
                                    $dCity2 = $dsql3drow3->cityName;
                                    $dCountry2 = $dsql3drow3->countryCode;

                                    }

                                    // Arrival Country

                                    $asql4arow4 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo2)->get();

                                    if(!empty($asql4arow4)){
                                        $aAirport2 = $asql4arow4->name;
                                        $aCity2 = $asql4arow4->cityName;
                                        $aCountry2 = $asql4arow4->countryCode;

                                    }

                                    $markettingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier2 = $scheduleDescs[$legref2]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref2]['carrier']['operatingFlightNumber'])){
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    }


                                    if(isset($fareComponents[0]['segments'][2]['segment']['seatsAvailable'])){
                                        $Seat3 = $fareComponents[0]['segments'][2]['segment']['seatsAvailable'];
                                    }

                                    if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][1]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode2 = $fareComponents[0]['segments'][2]['segment']['bookingCode'];
                                    }

                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $dDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate3 = 0;
                                    if(isset($scheduleDescs[$legref2]['arrival']['dateAdjustment'])){
                                            $arrivalDate3 += 1;
                                    }


                                    if($arrivalDate3 == 1){
                                            $aDate3 = date('Y-m-d', strtotime("+1 day", strtotime($dDate3)));
                                            }else{
                                            $aDate3 = date('Y-m-d', strtotime("+0 day", strtotime($dDate3)));
                                    }


                                    $fromTime2 = str_split($departureTime2, 8);
                                    $dpTime2 = $dDate3."T".$fromTime2[0];

                                    $toTime2 = str_split($ArrivalTime2, 8);
                                    $arrTime2 = $aDate3."T".$toTime2[0];


                                    // 3rd Leg

                                $lf3 = $legDescs[$id]['schedules'][2]['ref'];
                                $legref2 = $lf3- 1;


                                    $dateAdjust3 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][2]['departureDateAdjustment'])){
                                        $dateAdjust3 = $legDescs[$id]['schedules'][2]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $NewDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime3 = $scheduleDescs[$legref2]['elapsedTime'];
                                $TravelTime3 = floor($ElapsedTime3 / 60)."H ".($ElapsedTime3 - ((floor($ElapsedTime3 / 60)) * 60))."Min";

                                $ArrivalTime3 = $scheduleDescs[$legref2]['arrival']['time'];
                                $arrAt3 = substr($ArrivalTime3,0,5);

                                $departureTime3 = $scheduleDescs[$legref2]['departure']['time'];
                                $depAt3 = substr($departureTime3,0,5);

                                $fromTime3 = str_split($departureTime3, 8);
                                $dpTime3 = date("D d M Y", strtotime($NewDate3." ".$fromTime3[0]));

                                $toTime3 = str_split($ArrivalTime3, 8);
                                $arrTime3 = date("D d M Y", strtotime($NewDate3." ".$toTime3[0]));


                                $dateAdjust3 = 0;

                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust3 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $ArrivalTo2 = $scheduleDescs[$legref2]['arrival']['airport'];
                                    $DepartureFrom2 = $scheduleDescs[$legref2]['departure']['airport'];
                                    $ArrivalTime2 = $scheduleDescs[$legref2]['arrival']['time'];
                                    $departureTime2 = $scheduleDescs[$legref2]['departure']['time'];
                                    $markettingCarrier2 = $scheduleDescs[$legref2]['carrier']['marketing'];


                                    $carriersql2row2 = DB::table('airlines')->select('name')->where('code', $markettingCarrier2)->get();

                                    if(!empty($carriersql2row2)){
                                        $markettingCarrierName2 = $carriersql2row2->name;
                                    }

                                    // Departure Country
                                    $dsql3drow3 = $Airportsql->where('code', $DepartureFrom2)->get();

                                    if(!empty($dsql3drow3)){
                                    $dAirport2 = $dsql3drow3->name;
                                    $dCity2 = $dsql3drow3->cityName;
                                    $dCountry2 = $dsql3drow3->countryCode;

                                    }

                                    // Arrival Country
                                    $asql4arow4 = DB::table('airports')->select('name', 'cityName','countryCode')->where('code', $ArrivalTo2);

                                    if(!empty($asql4arow4)){
                                        $aAirport2 = $asql4arow4->name;
                                        $aCity2 = $asql4arow4->cityName;
                                        $aCountry2 = $asql4arow4->countryCode;

                                    }

                                    $markettingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier2 = $scheduleDescs[$legref2]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref2]['carrier']['operatingFlightNumber'])){
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    }


                                    if(isset($fareComponents[0]['segments'][2]['segment']['seatsAvailable'])){
                                        $Seat3 = $fareComponents[0]['segments'][2]['segment']['seatsAvailable'];
                                    }

                                    if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][1]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode2 = $fareComponents[0]['segments'][2]['segment']['bookingCode'];
                                    }

                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $dDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate3 = 0;
                                    if(isset($scheduleDescs[$legref2]['arrival']['dateAdjustment'])){
                                            $arrivalDate3 += 1;
                                    }


                                    if($arrivalDate3 == 1){
                                            $aDate3 = date('Y-m-d', strtotime("+1 day", strtotime($dDate3)));
                                            }else{
                                            $aDate3 = date('Y-m-d', strtotime("+0 day", strtotime($dDate3)));
                                    }


                                    $fromTime2 = str_split($departureTime2, 8);
                                    $dpTime2 = $dDate3."T".$fromTime2[0];

                                    $toTime2 = str_split($ArrivalTime2, 8);
                                    $arrTime2 = $aDate3."T".$toTime2[0];



                                    $segment = array("0" =>
                                                        array("marketingcareer"=> "$markettingCarrier",
                                                        "marketingcareerName"=> "$markettingCarrierName",
                                                                "marketingflight"=> "$markettingFN",
                                                                "operatingcareer"=> "$operatingCarrier",
                                                                "operatingflight"=> "$operatingFN",
                                                                "departure"=> "$DepartureFrom",
                                                                "departureAirport"=> "$dAirport ",
                                                                "departureLocation"=> "$dCity , $dCountry",
                                                                "departureTime" => "$dpTime",
                                                                "arrival"=> "$ArrivalTo",
                                                                "arrivalTime" => "$arrTime",
                                                                "arrivalAirport"=> "$aAirport",
                                                                "arrivalLocation"=> "$aCity , $aCountry",
                                                                "flightduration"=> "$TravelTime1",
                                                                "bookingcode"=> "$BookingCode",
                                                                "seat"=> "$Seat"),
                                                    "1" =>
                                                        array("marketingcareer"=> "$markettingCarrier1",
                                                        "marketingcareerName"=> "$markettingCarrierName1",
                                                                "marketingflight"=> "$markettingFN1",
                                                                "operatingcareer"=> "$operatingCarrier1",
                                                                "operatingflight"=> "$operatingFN1",
                                                                "departure"=> "$DepartureFrom1",
                                                                "departureAirport"=> "$dAirport1",
                                                                "departureLocation"=> "$dCity1 , $dCountry1",
                                                                "departureTime" => "$dpTime1",
                                                                "arrival"=> "$ArrivalTo1",
                                                                "arrivalTime" => "$arrTime1",
                                                                "arrivalAirport"=> "$aAirport1",
                                                                "arrivalLocation"=> "$aCity1 , $aCountry1",
                                                                "flightduration"=> "$TravelTime2",
                                                                "bookingcode"=> "$BookingCode1",
                                                                "seat"=> "$Seat1"),
                                                    "2" =>
                                                        array("marketingcareer"=> "$markettingCarrier2",
                                                        "marketingcareerName"=> "$markettingCarrierName2",
                                                                "marketingflight"=> "$markettingFN2",
                                                                "operatingcareer"=> "$operatingCarrier2",
                                                                "operatingflight"=> "$operatingFN2",
                                                                "departure"=> "$DepartureFrom2",
                                                                "departureAirport"=> "$dAirport2",
                                                                "departureLocation"=> "$dCity2 , $dCountry2",
                                                                "departureTime" => "$dpTime2",
                                                                "arrival"=> "$ArrivalTo2",
                                                                "arrivalTime" => "$arrTime2",
                                                                "arrivalAirport"=> "$aAirport2",
                                                                "arrivalLocation"=> "$aCity1 , $aCountry2",
                                                                "flightduration"=> "$TravelTime3",
                                                                "bookingcode"=> "$BookingCode2",
                                                                "seat"=> "$Seat2")

                                                );
                                $TransitTime = round(abs(strtotime($dpTime1) - strtotime($arrTime)) / 60,2);
                                $TransitDuration = floor($TransitTime / 60)."H ".($TransitTime - ((floor($TransitTime / 60)) * 60))."Min";

                                $TransitTime1 = round(abs(strtotime($dpTime2) - strtotime($arrTime1)) / 60,2);
                                $TransitDuration1 = floor($TransitTime1 / 60)."H ".($TransitTime1 - ((floor($TransitTime1 / 60)) * 60))."Min";

                                $transitDetails = array("transit1"=> $TransitDuration,
                                                         "transit2"=> $TransitDuration1);

                                $basic = array("system" =>"Sabre",
                                                    "segment"=> "3",
                                                    "triptype"=>$TripType,
                                                    "career"=> "$vCarCode",
                                                    "careerName" => "$CarrieerName",
                                                    "BasePrice" => "$baseFareAmount",
                                                    "Taxes" => "$totalTaxAmount",
                                                    "price" => "$AgentPrice",
                                                    "clientPrice"=> "$totalFare",
                                                    "comission"=> "$Commission",
                                                    "pricebreakdown"=> $PriceBreakDown,
                                                    "departure"=> "$From",
                                                    "departureTime" => "$depAt1",
                                                    "departureDate" => "$dpTime1",
                                                    "arrival"=> "$To",
                                                    "arrivalTime" => "$arrAt2",
                                                    "arrivalDate" => "$arrTime2",
                                                    "flightduration"=> "$JourneyDuration",
                                                    "bags" => "$Bags",
                                                    "seat" => "$Seat",
                                                    "class" => "$CabinClass",
                                                    "refundable"=> "$nonRef",
                                                    "segments" => $segment,
                                                    "transit" => $transitDetails

                                            );

                                array_push($All,$basic);


                                }else if($sgCount == 4){

                                $lf = $legDescs[$id]['schedules'][0]['ref'];
                                $legref = $lf- 1;

                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime1,0,5);

                                $arrivalDate1 = 0;
                                if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                        $arrivalDate1 += 1;
                                }


                                if($arrivalDate1 == 1){
                                        $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                        }else{
                                        $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                $ElapsedTime1 = $scheduleDescs[$legref]['elapsedTime'];
                                $TravelTime1 = floor($ElapsedTime1 / 60)."H ".($ElapsedTime1 - ((floor($ElapsedTime1 / 60)) * 60))."Min";

                                $ArrivalTime1 = $scheduleDescs[$legref]['arrival']['time'];
                                $arrAt1 = substr($ArrivalTime1,0,5);

                                $departureTime1 = $scheduleDescs[$legref]['departure']['time'];
                                $depAt1 = substr($departureTime1,0,5);

                                $fromTime1 = str_split($departureTime1, 8);
                                $dpTime1 = date("D d M Y", strtotime($Date." ".$fromTime1[0]));

                                $toTime1 = str_split($ArrivalTime1, 8);
                                $arrTime1 = date("D d M Y", strtotime($aDate." ".$toTime1[0]));

                                $ArrivalTo = $scheduleDescs[$legref]['arrival']['airport'];
                                    $DepartureFrom = $scheduleDescs[$legref]['departure']['airport'];


                                    $ArrivalTime = $scheduleDescs[$legref]['arrival']['time'];
                                    $departureTime = $scheduleDescs[$legref]['departure']['time'];
                                    $markettingCarrier = $scheduleDescs[$legref]['carrier']['marketing'];


                                    $carriersqlrow = DB::table('airlines')->select('name')->where('code', $markettingCarrier)->get();

                                    if(!empty($carriersqlrow)){
                                        $markettingCarrierName = $carriersqlrow->name;
                                    }

                                    // Departure Country
                                    $sql1row1 = $Airportsql->where('code', $DepartureFrom)->get();

                                    if(!empty($sql1row1)){
                                    $dAirport = $sql1row1->name;
                                    $dCity = $sql1row1->cityName;
                                    $dCountry = $sql1row1->countryCode;

                                    }

                                    // Departure Country

                                    $sql2row2 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo)->get();

                                    if(!empty($sql2row2)){
                                    $aAirport = $sql2row2->name;
                                    $aCity = $sql2row2->cityName;
                                    $aCountry = $sql2row2->countryCode;

                                    }


                                    $markettingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier = $scheduleDescs[$legref]['carrier']['operating'];
                                    if(isset($scheduleDescs[$legref]['carrier']['operatingFlightNumber'])){
                                        $operatingFN = $scheduleDescs[$legref]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN = $scheduleDescs[$legref]['carrier']['marketingFlightNumber'];
                                    }

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }


                                    if(isset($fareComponents[0]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode1 = $fareComponents[0]['segments'][0]['segment']['bookingCode'];
                                    }

                                    $arrivalDate = 0;
                                    if(isset($scheduleDescs[$legref]['arrival']['dateAdjustment'])){
                                            $arrivalDate += 1;
                                    }


                                    if($arrivalDate == 1){
                                            $aDate = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                            }else{
                                            $aDate = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }


                                    $fromTime = str_split($departureTime, 8);
                                    $dpTime = $Date."T".$fromTime[0];

                                    $toTime = str_split($ArrivalTime, 8);
                                    $arrTime = $aDate."T".$toTime[0];



                                //2nd Leg

                                    $lf2 = $legDescs[$id]['schedules'][1]['ref'];
                                    $legref1 = $lf2- 1;


                                    $dateAdjust2 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                        $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $NewDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime2 = $scheduleDescs[$legref1]['elapsedTime'];
                                $TravelTime2 = floor($ElapsedTime2 / 60)."H ".($ElapsedTime2 - ((floor($ElapsedTime2 / 60)) * 60))."Min";

                                $ArrivalTime2 = $scheduleDescs[$legref1]['arrival']['time'];
                                $arrAt2 = substr($ArrivalTime2,0,5);

                                $departureTime2 = $scheduleDescs[$legref1]['departure']['time'];
                                $depAt2 = substr($departureTime2,0,5);

                                $fromTime2 = str_split($departureTime2, 8);
                                $dpTime2 = date("D d M Y", strtotime($NewDate2." ".$fromTime2[0]));

                                $toTime2 = str_split($ArrivalTime2, 8);
                                $arrTime2 = date("D d M Y", strtotime($NewDate2." ".$toTime2[0]));


                                $dateAdjust2 = 0;
                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust2 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $descid = $scheduleDescs[$legref1]['id'];
                                    $ArrivalTo1 = $scheduleDescs[$legref1]['arrival']['airport'];
                                    $DepartureFrom1 = $scheduleDescs[$legref1]['departure']['airport'];


                                    $ArrivalTime1 = $scheduleDescs[$legref1]['arrival']['time'];
                                    $departureTime1 = $scheduleDescs[$legref1]['departure']['time'];
                                    $markettingCarrier1 = $scheduleDescs[$legref1]['carrier']['marketing'];


                                    $carriersql1row1 = DB::table('airlines')->select('name')->where('code',$markettingCarrier1)->get();

                                    if(!empty($carriersql1row1)){
                                    $markettingCarrierName1 = $carriersql1row1['name'];

                                    }

                                    // Departure Country

                                    $sql3row3 = $Airportsql->where('code', $DepartureFrom1)->get();

                                    if(!empty($sql3row3)){
                                    $dAirport1 = $sql3row3->name;
                                    $dCity1 = $sql3row3->cityName;
                                    $dCountry1 = $sql3row3->countryCode;

                                    }

                                    // Departure Country

                                    $sql4row4 = DB::table('airports')->select('name', 'cityName', 'contryCode')->where('code', $ArrivalTo1)->get();

                                    if(!empty($sql4row4)){
                                        $aAirport1 = $sql4row4->name;
                                        $aCity1 = $sql4row4->cityName;
                                        $aCountry1 = $sql4row4->countryCode;

                                    }


                                    $markettingFN1 = $scheduleDescs[$legref1]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier1 = $scheduleDescs[$legref1]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref1]['carrier']['operatingFlightNumber'])){
                                        $operatingFN1 = $scheduleDescs[$legref1]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN1 = 0;
                                    }

                                    if(isset($fareComponents[0]['segments'][0]['segment']['seatsAvailable'])){
                                        $Seat1 = $fareComponents[0]['segments'][0]['segment']['seatsAvailable'];
                                    }

                                    if(isset($fareComponents[0]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[0]['segments'][1]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode1 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode1 = $fareComponents[0]['segments'][1]['segment']['bookingCode'];
                                    }



                                    //Store Data
                                    if($dateAdjust2 == 1){
                                        $dDate2 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate2 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate2 = 0;
                                    if(isset($scheduleDescs[$legref1]['arrival']['dateAdjustment'])){
                                            $arrivalDate2 += 1;
                                    }


                                    if($arrivalDate2 == 1){
                                            $aDate2 = date('Y-m-d', strtotime("+1 day", strtotime($dDate2)));
                                            }else{
                                            $aDate2 = date('Y-m-d', strtotime("+0 day", strtotime($dDate2)));
                                    }


                                    $fromTime1 = str_split($departureTime1, 8);
                                    $dpTime1 = $dDate2."T".$fromTime1[0];

                                    $toTime1 = str_split($ArrivalTime1, 8);
                                    $arrTime1 = $aDate2."T".$toTime1[0];


                                // 3rd Leg

                                $lf3 = $legDescs[$id]['schedules'][2]['ref'];
                                $legref2 = $lf3- 1;


                                    $dateAdjust3 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][2]['departureDateAdjustment'])){
                                        $dateAdjust3 = $legDescs[$id]['schedules'][2]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $NewDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                $ElapsedTime3 = $scheduleDescs[$legref2]['elapsedTime'];
                                $TravelTime3 = floor($ElapsedTime3 / 60)."H ".($ElapsedTime3 - ((floor($ElapsedTime3 / 60)) * 60))."Min";

                                $ArrivalTime3 = $scheduleDescs[$legref2]['arrival']['time'];
                                $arrAt3 = substr($ArrivalTime3,0,5);

                                $departureTime3 = $scheduleDescs[$legref2]['departure']['time'];
                                $depAt3 = substr($departureTime3,0,5);

                                $fromTime3 = str_split($departureTime3, 8);
                                $dpTime3 = date("D d M Y", strtotime($NewDate3." ".$fromTime3[0]));

                                $toTime3 = str_split($ArrivalTime3, 8);
                                $arrTime3 = date("D d M Y", strtotime($NewDate3." ".$toTime3[0]));


                                $dateAdjust3 = 0;

                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust3 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $ArrivalTo2 = $scheduleDescs[$legref2]['arrival']['airport'];
                                    $DepartureFrom2 = $scheduleDescs[$legref2]['departure']['airport'];
                                    $ArrivalTime2 = $scheduleDescs[$legref2]['arrival']['time'];
                                    $departureTime2 = $scheduleDescs[$legref2]['departure']['time'];
                                    $markettingCarrier2 = $scheduleDescs[$legref2]['carrier']['marketing'];


                                    $carriersql2row2 = DB::table('airlines')->select('name')->where('code', $markettingCarrier2)->get();

                                    if(!empty($carriersql2row2)){
                                        $markettingCarrierName2 = $carriersql2row2->name;
                                    }

                                    // Departure Country

                                    $dsql3drow3 = $Airportsql->where('code', $DepartureFrom2)->get();

                                    if(!empty($dsql3drow3)){
                                    $dAirport2 = $dsql3drow3->name;
                                    $dCity2 = $dsql3drow3->cityName;
                                    $dCountry2 = $dsql3drow3->countryCode;

                                    }

                                    // Arrival Country

                                    $asql4arow4 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo2)->get();

                                    if(!empty($asql4arow4)){
                                        $aAirport2 = $asql4arow4->name;
                                        $aCity2 = $asql4arow4->cityName;
                                        $aCountry2 = $asql4arow4->countryCode;

                                    }

                                    $markettingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier2 = $scheduleDescs[$legref2]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref2]['carrier']['operatingFlightNumber'])){
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN2 = $scheduleDescs[$legref2]['carrier']['marketingFlightNumber'];
                                    }


                                    if(isset($fareComponents[0]['segments'][2]['segment']['seatsAvailable'])){
                                        $Seat2 = $fareComponents[0]['segments'][2]['segment']['seatsAvailable'];
                                    }else{
                                        $Seat2 = $Seat1;
                                    }

                                    if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode2 = $fareComponents[1]['segments'][1]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode2 = $fareComponents[0]['segments'][2]['segment']['bookingCode'];
                                    }

                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $dDate3 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate3 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate3 = 0;
                                    if(isset($scheduleDescs[$legref2]['arrival']['dateAdjustment'])){
                                            $arrivalDate3 += 1;
                                    }


                                    if($arrivalDate3 == 1){
                                            $aDate3 = date('Y-m-d', strtotime("+1 day", strtotime($dDate3)));
                                            }else{
                                            $aDate3 = date('Y-m-d', strtotime("+0 day", strtotime($dDate3)));
                                    }


                                    $fromTime2 = str_split($departureTime2, 8);
                                    $dpTime2 = $dDate3."T".$fromTime2[0];

                                    $toTime2 = str_split($ArrivalTime2, 8);
                                    $arrTime2 = $aDate3."T".$toTime2[0];


                                    // 4rth Leg

                                    $lf4 = $legDescs[$id]['schedules'][3]['ref'];
                                    $legref3 = $lf4- 1;


                                    $dateAdjust4 = 0 ;
                                    if(isset($legDescs[$id]['schedules'][3]['departureDateAdjustment'])){
                                        $dateAdjust3 = $legDescs[$id]['schedules'][3]['departureDateAdjustment'];
                                    }


                                    //Store Data
                                    if($dateAdjust4 == 1){
                                        $NewDate4 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $NewDate4 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $ElapsedTime4 = $scheduleDescs[$legref3]['elapsedTime'];
                                    $TravelTime4 = floor($ElapsedTime4 / 60)."H ".($ElapsedTime4 - ((floor($ElapsedTime4 / 60)) * 60))."Min";

                                    $ArrivalTime4 = $scheduleDescs[$legref3]['arrival']['time'];
                                    $arrAt4 = substr($ArrivalTime4,0,5);

                                    $departureTime4 = $scheduleDescs[$legref3]['departure']['time'];
                                    $depAt4 = substr($departureTime4,0,5);

                                    $fromTime4 = str_split($departureTime4, 8);
                                    $dpTime4 = date("D d M Y", strtotime($NewDate4." ".$fromTime4[0]));

                                    $toTime4 = str_split($ArrivalTime4, 8);
                                    $arrTime4 = date("D d M Y", strtotime($NewDate4." ".$toTime4[0]));


                                    $dateAdjust4 = 0;

                                    if(isset($legDescs[$id]['schedules'][1]['departureDateAdjustment'])){
                                            $dateAdjust4 = $legDescs[$id]['schedules'][1]['departureDateAdjustment'];
                                    }

                                    $ArrivalTo3 = $scheduleDescs[$legref3]['arrival']['airport'];
                                    $DepartureFrom3 = $scheduleDescs[$legref3]['departure']['airport'];
                                    $ArrivalTime3 = $scheduleDescs[$legref3]['arrival']['time'];
                                    $departureTime3 = $scheduleDescs[$legref3]['departure']['time'];
                                    $markettingCarrier3 = $scheduleDescs[$legref3]['carrier']['marketing'];


                                    $carriersql3row3 = DB::table('airlines')->select('name')->where('code', $markettingCarrier3)->get();

                                    if(!empty($carriersql3row3)){
                                        $markettingCarrierName3 = $carriersql3row3->name;
                                    }

                                    // Departure Country
                                    $dsql4drow4 = $Airportsql->where('code', $DepartureFrom3)->get();

                                    if(!empty($dsql4drow4)){
                                    $dAirport3 = $dsql4drow4->name;
                                    $dCity3 = $dsql4drow4->cityName;
                                    $dCountry3 = $dsql4drow4->countryCode;

                                    }

                                    // Arrival Country
                                    $asql4arow4 = DB::table('airports')->select('name', 'cityName', 'countryCode')->where('code', $ArrivalTo3)->get();

                                    if(!empty($asql4arow4)){
                                        $aAirport3 = $asql4arow4->name;
                                        $aCity3 = $asql4arow4->cityName;
                                        $aCountry3 = $asql4arow4->countryCode;

                                    }

                                    $markettingFN3 = $scheduleDescs[$legref3]['carrier']['marketingFlightNumber'];
                                    $operatingCarrier3 = $scheduleDescs[$legref3]['carrier']['operating'];

                                    if(isset($scheduleDescs[$legref3]['carrier']['operatingFlightNumber'])){
                                        $operatingFN3 = $scheduleDescs[$legref3]['carrier']['operatingFlightNumber'];
                                    }else{
                                        $operatingFN3 = $scheduleDescs[$legref3]['carrier']['marketingFlightNumber'];
                                    }


                                    if(isset($fareComponents[0]['segments'][3]['segment']['seatsAvailable'])){
                                        $Seat3 = $fareComponents[0]['segments'][3]['segment']['seatsAvailable'];
                                    }else{
                                        $Seat3 = $Seat1;
                                    }

                                    if(isset($fareComponents[1]['segments'][0]['segment']['bookingCode'])){
                                            $BookingCode3 = $fareComponents[1]['segments'][0]['segment']['bookingCode'];
                                    }else if(isset($fareComponents[1]['segments'][1]['segment']['bookingCode'])){
                                            $BookingCode3 = $fareComponents[1]['segments'][1]['segment']['bookingCode'];
                                    }else{
                                        $BookingCode3 = $fareComponents[0]['segments'][3]['segment']['bookingCode'];
                                    }

                                    //Store Data
                                    if($dateAdjust3 == 1){
                                        $dDate4 = date('Y-m-d', strtotime("+1 day", strtotime($Date)));
                                    }else{
                                        $dDate4 = date('Y-m-d', strtotime("+0 day", strtotime($Date)));
                                    }

                                    $arrivalDate4 = 0;
                                    if(isset($scheduleDescs[$legref3]['arrival']['dateAdjustment'])){
                                            $arrivalDate4 += 1;
                                    }


                                    if($arrivalDate4 == 1){
                                            $aDate4 = date('Y-m-d', strtotime("+1 day", strtotime($dDate4)));
                                            }else{
                                            $aDate4 = date('Y-m-d', strtotime("+0 day", strtotime($dDate4)));
                                    }


                                    $fromTime3 = str_split($departureTime3, 8);
                                    $dpTime3 = $dDate4."T".$fromTime3[0];

                                    $toTime3 = str_split($ArrivalTime3, 8);
                                    $arrTime3 = $aDate4."T".$toTime3[0];



                                    $segment = array("0" =>
                                                        array("marketingcareer"=> "$markettingCarrier",
                                                        "marketingcareerName"=> "$markettingCarrierName",
                                                                "marketingflight"=> "$markettingFN",
                                                                "operatingcareer"=> "$operatingCarrier",
                                                                "operatingflight"=> "$operatingFN",
                                                                "departure"=> "$DepartureFrom",
                                                                "departureAirport"=> "$dAirport ",
                                                                "departureLocation"=> "$dCity , $dCountry",
                                                                "departureTime" => "$dpTime",
                                                                "arrival"=> "$ArrivalTo",
                                                                "arrivalTime" => "$arrTime",
                                                                "arrivalAirport"=> "$aAirport",
                                                                "arrivalLocation"=> "$aCity , $aCountry",
                                                                "flightduration"=> "$TravelTime1",
                                                                "bookingcode"=> "$BookingCode",
                                                                "seat"=> "$Seat"),
                                                    "1" =>
                                                        array("marketingcareer"=> "$markettingCarrier1",
                                                        "marketingcareerName"=> "$markettingCarrierName1",
                                                                "marketingflight"=> "$markettingFN1",
                                                                "operatingcareer"=> "$operatingCarrier1",
                                                                "operatingflight"=> "$operatingFN1",
                                                                "departure"=> "$DepartureFrom1",
                                                                "departureAirport"=> "$dAirport1",
                                                                "departureLocation"=> "$dCity1 , $dCountry1",
                                                                "departureTime" => "$dpTime1",
                                                                "arrival"=> "$ArrivalTo1",
                                                                "arrivalTime" => "$arrTime1",
                                                                "arrivalAirport"=> "$aAirport1",
                                                                "arrivalLocation"=> "$aCity1 , $aCountry1",
                                                                "flightduration"=> "$TravelTime2",
                                                                "bookingcode"=> "$BookingCode1",
                                                                "seat"=> "$Seat1"),
                                                    "2" =>
                                                        array("marketingcareer"=> "$markettingCarrier2",
                                                        "marketingcareerName"=> "$markettingCarrierName2",
                                                                "marketingflight"=> "$markettingFN2",
                                                                "operatingcareer"=> "$operatingCarrier2",
                                                                "operatingflight"=> "$operatingFN2",
                                                                "departure"=> "$DepartureFrom2",
                                                                "departureAirport"=> "$dAirport2",
                                                                "departureLocation"=> "$dCity2 , $dCountry2",
                                                                "departureTime" => "$dpTime2",
                                                                "arrival"=> "$ArrivalTo2",
                                                                "arrivalTime" => "$arrTime2",
                                                                "arrivalAirport"=> "$aAirport2",
                                                                "arrivalLocation"=> "$aCity1 , $aCountry2",
                                                                "flightduration"=> "$TravelTime3",
                                                                "bookingcode"=> "$BookingCode2",
                                                                "seat"=> "$Seat2"),
                                                    "3" =>
                                                        array("marketingcareer"=> "$markettingCarrier3",
                                                        "marketingcareerName"=> "$markettingCarrierName3",
                                                                "marketingflight"=> "$markettingFN3",
                                                                "operatingcareer"=> "$operatingCarrier3",
                                                                "operatingflight"=> "$operatingFN3",
                                                                "departure"=> "$DepartureFrom3",
                                                                "departureAirport"=> "$dAirport3",
                                                                "departureLocation"=> "$dCity3 , $dCountry3",
                                                                "departureTime" => "$dpTime3",
                                                                "arrival"=> "$ArrivalTo3",
                                                                "arrivalTime" => "$arrTime3",
                                                                "arrivalAirport"=> "$aAirport3",
                                                                "arrivalLocation"=> "$aCity3 , $aCountry3",
                                                                "flightduration"=> "$TravelTime4",
                                                                "bookingcode"=> "$BookingCode3",
                                                                "seat"=> "$Seat3")

                                                );
                                $TransitTime = round(abs(strtotime($dpTime1) - strtotime($arrTime)) / 60,2);
                                $TransitDuration = floor($TransitTime / 60)."H ".($TransitTime - ((floor($TransitTime / 60)) * 60))."Min";

                                $TransitTime1 = round(abs(strtotime($dpTime2) - strtotime($arrTime1)) / 60,2);
                                $TransitDuration1 = floor($TransitTime1 / 60)."H ".($TransitTime1 - ((floor($TransitTime1 / 60)) * 60))."Min";

                                $TransitTime2 = round(abs(strtotime($dpTime3) - strtotime($arrTime2)) / 60,2);
                                $TransitDuration2 = floor($TransitTime2 / 60)."H ".($TransitTime2 - ((floor($TransitTime2 / 60)) * 60))."Min";

                                $transitDetails = array("transit1"=> $TransitDuration,
                                                         "transit2"=> $TransitDuration1,
                                                        "transit3"=> $TransitDuration2);

                                $basic = array("system" =>"Sabre",
                                                    "segment"=> "4",
                                                    "career"=> "$vCarCode",
                                                    "careerName" => "$CarrieerName",
                                                    "BasePrice" => "$baseFareAmount",
                                                    "Taxes" => "$totalTaxAmount",
                                                    "price" => "$AgentPrice",
                                                    "clientPrice"=> "$totalFare",
                                                    "comission"=> "$Commission",
                                                    "pricebreakdown"=> $PriceBreakDown,
                                                    "departure"=> "$From",
                                                    "departureTime" => "$depAt1",
                                                    "departureDate" => "$dpTime1",
                                                    "arrival"=> "$To",
                                                    "arrivalTime" => "$arrAt3",
                                                    "arrivalDate" => "$arrTime3",
                                                    "flightduration"=> "$JourneyDuration",
                                                    "bags" => "$Bags",
                                                    "seat" => "$Seat",
                                                    "class" => "$CabinClass",
                                                    "refundable"=> "$nonRef",
                                                    "segments" => $segment,
                                                    "transit" => $transitDetails

                                            );

                                }

                        //$All[$Exact] = $basic;

                        }


                    }

                }
            }///sabre end




        }



    }
}
