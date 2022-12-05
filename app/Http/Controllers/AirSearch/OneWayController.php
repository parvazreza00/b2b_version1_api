<?php

namespace App\Http\Controllers\AirSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Control;



class OneWayController extends Controller
{
    public function Oneway(){
        $All = array();
        $FlightType;

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
                    $From = $_GET['journeyfrom'];
                    $To = $_GET['journeyto'];
                    $Date = $_GET['departuredate'];
                    $ActualDate = $Date."T00:00:00";

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


                            $apiURL = "https://api.havail.sabre.com/v2/auth/token";

                            $res = Http::withHeaders($headers)->get($apiURL, $data);
                            $resf = json_decode($res,1);
                            $access_token = $resf['access_token'];
                            print_r($resf);


                        }catch (Exception $e){

                        }




                    }
                }
            }
        }



    }
}
