<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Carbon\Carbon;

class TourController extends Controller
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
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){
                $Tour = Tour::all();
                return response()->json($Tour);
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
        $coverImage = $request->file('coverImage');
        $coverImage_name_gen = hexdec(uniqid());
        $coverImage_ext = strtolower($coverImage->getClientOriginalExtension());
        $coverImage_name = $coverImage_name_gen.'.'.$coverImage_ext;
        $up_location_coverImage = 'images/allPacakageImg/';
        $coverImage->move($up_location_coverImage,$coverImage_name);
        $last_coverImage = $up_location_coverImage.$coverImage_name;

        //image generate system.....................
        $album = $request->file('album');
        $album_name_gen = hexdec(uniqid());
        $album_ext = strtolower($album->getClientOriginalExtension());
        $album_name = $album_name_gen.'.'.$album_ext;
        $up_location_album = 'images/album/';
        $album->move($up_location_album,$album_name);
        $last_album = $up_location_album.$album_name;

        //tripTheme generate tripTheme...............
        $tripTheme = $request->file('tripTheme');
        $tripTheme_name_gen = hexdec(uniqid());
        $tripTheme_ext = strtolower($tripTheme->getClientOriginalExtension());
        $tripTheme_name = $tripTheme_name_gen.'.'.$tripTheme_ext;
        $up_location_tripTheme = 'images/tripTheme/';
        $tripTheme->move($up_location_tripTheme,$tripTheme_name);
        $last_tripTheme = $up_location_tripTheme.$tripTheme_name;
        //slider 1.......................
        $slider1 = $request->file('slider1');
        $slider1_name_gen = hexdec(uniqid());
        $slider1_ext = strtolower($slider1->getClientOriginalExtension());
        $slider1_name = $slider1_name_gen.'.'.$slider1_ext;
        $up_slider1_location = 'images/sliders/';
        $slider1->move($up_slider1_location,$slider1_name);
        $last_upload1 = $up_slider1_location.$slider1_name;
        //slider 2.......................
        $slider2 = $request->file('slider2');
        $slider2_name_gen = hexdec(uniqid());
        $slider2_ext = strtolower($slider2->getClientOriginalExtension());
        $slider2_name = $slider2_name_gen.'.'.$slider2_ext;
        $up_slider2_location = 'images/sliders/';
        $slider2->move($up_slider2_location,$slider2_name);
        $last_upload2 = $up_slider2_location.$slider2_name;
        //slider 3.......................
        $slider3 = $request->file('slider3');
        $slider3_name_gen = hexdec(uniqid());
        $slider3_ext = strtolower($slider3->getClientOriginalExtension());
        $slider3_name = $slider3_name_gen.'.'.$slider3_ext;
        $up_slider3_location = 'images/sliders/';
        $slider3->move($up_slider3_location,$slider3_name);
        $last_upload3 = $up_slider3_location.$slider3_name;
        //slider 4.......................
        $slider4 = $request->file('slider4');
        $slider4_name_gen = hexdec(uniqid());
        $slider4_ext = strtolower($slider4->getClientOriginalExtension());
        $slider4_name = $slider4_name_gen.'.'.$slider4_ext;
        $up_slider4_location = 'images/sliders/';
        $slider4->move($up_slider4_location,$slider4_name);
        $last_upload4 = $up_slider4_location.$slider4_name;
        //slider 5.......................
        $slider5 = $request->file('slider5');
        $slider5_name_gen = hexdec(uniqid());
        $slider5_ext = strtolower($slider5->getClientOriginalExtension());
        $slider5_name = $slider5_name_gen.'.'.$slider5_ext;
        $up_slider5_location = 'images/sliders/';
        $slider5->move($up_slider5_location,$slider5_name);
        $last_upload5 = $up_slider5_location.$slider5_name;
        //slider 6.......................
        $slider6 = $request->file('slider6');
        $slider6_name_gen = hexdec(uniqid());
        $slider6_ext = strtolower($slider6->getClientOriginalExtension());
        $slider6_name = $slider6_name_gen.'.'.$slider6_ext;
        $up_slider6_location = 'images/sliders/';
        $slider6->move($up_slider6_location,$slider6_name);
        $last_upload6 = $up_slider6_location.$slider6_name;

     $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){
            $Tour = Tour::insert([
                     "pkId"              => $request->pkId,
                     "titleEN"           => $request->titleEN,
                     "titleBN"           => $request->titleBN,
                     "album"             => $request->album,
                     "coverImage"        => $last_coverImage,
                     "longTitleEN"       => $request->longTitleEN,
                     "longTitleBN"       => $request->longTitleBN,
                     "locationEN"        => $request->locationEN,
                     "locationBN"        => $request->locationBN,
                     "shortDescriptionEN"=> $request->shortDescriptionEN,
                     "shortDescriptionBN"=> $request->shortDescriptionBN,
                     "startDateEN"       => $request->startDateEN,
                     "startDateBN"       => $request->startDateBN,
                     "endDateEN"         => $request->endDateEN,
                     "endDateBN"         => $request->endDateBN,
                     "durationEN"        => $request->durationEN,
                     "durationBN"        => $request->durationBN,
                     "price"             => $request->price,
                     "tripTheme"         => $last_tripTheme,
                     "triptype"          => $request->triptype,
                     "tripplan"          => $request->tripplan,
                     "scheduledetailsEN" => $request->scheduledetailsEN,
                     "scheduledetailsBN" => $request->scheduledetailsBN,
                     "inclusionEN"       => $request->inclusionEN,
                     "inclusionBN"       => $request->inclusionBN,
                     "exclusionEN"       => $request->exclusionEN,
                     "exclusionBN"       => $request->exclusionBN,
                     "placevisitEN"      => $request->placevisitEN,
                     "placevisitBN"      => $request->placevisitBN,
                     "detailsEN"         => $request->detailsEN,
                     "detailsBN"         => $request->detailsBN,
                     "bookingpolicyEN"   => $request->bookingpolicyEN,
                     "bookingpolicyBN"   => $request->bookingpolicyBN,
                     "refundpolicyEN"    => $request->refundpolicyEN,
                     "refundpolicyBN"    => $request->refundpolicyBN,
                     "termsEN"           => $request->termsEN,
                     "termsBN"           => $request->termsBN,
                     "additionalEN"      => $request->additionalEN,
                     "additionalBN"      => $request->additionalBN,
                     "traveltipsEN"      => $request->traveltipsEN,
                     "traveltipsBN"      => $request->traveltipsBN,
                     "slider1"           => $last_upload1,
                     "slider2"           => $last_upload2,
                     "slider3"           => $last_upload3,
                     "slider4"           => $last_upload4,
                     "slider5"           => $last_upload5,
                     "slider6"           => $last_upload6,
                     "link"              => $request->link,
                     "created_at"        => Carbon::now(),
         ]);

             return response()->json([
                 'success' => 'Tour Packages added Successfully',
                 'Allpackages' => $Tour,
             ]);
            return redirect()->back()->with('success',' successfully');
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
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){
                $Tour = Tour::findOrFail($id);
                return response()->json($Tour);
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
        $header=$request->header("Authorization");
        if($header==''){
            $message="Authorization is required";
            return response()->json(['msessage'=>$message], 422);
        }else{
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){
                Tour::findOrFail($id)->update([
                    "pkId"               => $request->pkId,
                     "titleEN"           => $request->titleEN,
                     "titleBN"           => $request->titleBN,
                    //  "album"             => $request->album,
                    //  "coverImage"        => $request->coverImage,
                     "longTitleEN"       => $request->longTitleEN,
                     "longTitleBN"       => $request->longTitleBN,
                     "locationEN"        => $request->locationEN,
                     "locationBN"        => $request->locationBN,
                     "shortDescriptionEN"=> $request->shortDescriptionEN,
                     "shortDescriptionBN"=> $request->shortDescriptionBN,
                     "startDateEN"       => $request->startDateEN,
                     "startDateBN"       => $request->startDateBN,
                     "endDateEN"         => $request->endDateEN,
                     "endDateBN"         => $request->endDateBN,
                     "durationEN"        => $request->durationEN,
                     "durationBN"        => $request->durationBN,
                    //  "price"             => $request->price,
                     "tripTheme"         => $request->tripTheme,
                     "triptype"          => $request->triptype,
                     "tripplan"          => $request->tripplan,
                     "scheduledetailsEN" => $request->scheduledetailsEN,
                     "scheduledetailsBN" => $request->scheduledetailsBN,
                     "inclusionEN"       => $request->inclusionEN,
                     "inclusionBN"       => $request->inclusionBN,
                     "exclusionEN"       => $request->exclusionEN,
                     "description"       => $request->description,
                     "exclusionBN"       => $request->exclusionBN,
                     "placevisitEN"      => $request->placevisitEN,
                     "placevisitBN"      => $request->placevisitBN,
                     "detailsEN"         => $request->detailsEN,
                     "detailsBN"         => $request->detailsBN,
                     "bookingpolicyEN"   => $request->bookingpolicyEN,
                     "bookingpolicyBN"   => $request->bookingpolicyBN,
                     "refundpolicyEN"    => $request->refundpolicyEN,
                     "refundpolicyBN"    => $request->refundpolicyBN,
                     "termsEN"           => $request->termsEN,
                     "additionalEN"      => $request->additionalEN,
                     "additionalBN"      => $request->additionalBN,
                     "traveltipsEN"      => $request->traveltipsEN,
                     "traveltipsBN"      => $request->traveltipsBN,
                    //  "slider1"           => $request->slider1,
                    //  "slider2"           => $request->slider2,
                    //  "slider3"           => $request->slider3,
                    //  "slider4"           => $request->slider4,
                    //  "slider5"           => $request->slider5,
                    //  "slider6"           => $request->slider6,
                     "link"              => $request->link,
                    'updated_at'         => Carbon::now()
                ]);
                return response()->json([
                    'success' => 'Updated Successfully',
                ]);
            }else{
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
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){
                Tour::findOrFail($id)->delete();
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
