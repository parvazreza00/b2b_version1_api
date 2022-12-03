<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visa;
use Carbon\Carbon;

class VisaController extends Controller

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
                $Visa = Visa::all();
                return response()->json($Visa);
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
        //pdfEN generate system...............
        $pdfEN = $request->file('pdfEN');
        $pdfEN_name_gen = hexdec(uniqid());
        $pdfEN_ext = strtolower($pdfEN->getClientOriginalExtension());
        $pdfEN_name = $pdfEN_name_gen.'.'.$pdfEN_ext;
        $up_location_pdfEN = 'images/visapdfEN/';
        $pdfEN->move($up_location_pdfEN,$pdfEN_name);
        $last_pdfEN = $up_location_pdfEN.$pdfEN_name;

        //pdfBN generate system...............
        $pdfBN = $request->file('pdfBN');
        $pdfBN_name_gen = hexdec(uniqid());
        $pdfBN_ext = strtolower($pdfBN->getClientOriginalExtension());
        $pdfBN_name = $pdfBN_name_gen.'.'.$pdfBN_ext;
        $up_location_pdfBN = 'images/visapdfBN/';
        $pdfBN->move($up_location_pdfBN,$pdfBN_name);
        $last_pdfBN = $up_location_pdfBN.$pdfBN_name;

        $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $Visa = Visa::insert([
                 'country'       => $request->country,
                 'visatype'       => $request->visatype,
                 'visaDetailsEN'          => $request->visaDetailsEN,
                 'visaDetailsBN'         => $request->visaDetailsBN,
                 'pdfEN'      => $last_pdfEN,
                 'pdfBN'         => $last_pdfBN,
                 'uploadedAt'       => Carbon::now(),

             ]);
             return response()->json([
                 'success' => 'Visa info added Successful',
                 'Visa' => $Visa,
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
                $Visa = Visa::findOrFail($id);
                return response()->json($Visa);
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

        //pdfEN generate system...............
        $pdfEN = $request->file('pdfEN');
        $pdfEN_name_gen = hexdec(uniqid());
        $pdfEN_ext = strtolower($pdfEN->getClientOriginalExtension());
        $pdfEN_name = $pdfEN_name_gen.'.'.$pdfEN_ext;
        $up_location_pdfEN = 'images/visapdfEN/';
        $pdfEN->move($up_location_pdfEN,$pdfEN_name);
        $last_pdfEN = $up_location_pdfEN.$pdfEN_name;

        //pdfBN generate system...............
        $pdfBN = $request->file('pdfBN');
        $pdfBN_name_gen = hexdec(uniqid());
        $pdfBN_ext = strtolower($pdfBN->getClientOriginalExtension());
        $pdfBN_name = $pdfBN_name_gen.'.'.$pdfBN_ext;
        $up_location_pdfBN = 'images/visapdfBN/';
        $pdfBN->move($up_location_pdfBN,$pdfBN_name);
        $last_pdfBN = $up_location_pdfBN.$pdfBN_name;
        
        $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $Visa = Visa::findOrFail($id)->update([
                'country'       => $request->country,
                'visatype'       => $request->visatype,
                'visaDetailsEN'          => $request->visaDetailsEN,
                'visaDetailsBN'         => $request->visaDetailsBN,
                'pdfEN'      => $last_pdfEN,
                'pdfBN'         => $last_pdfBN,

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
               'staffData' => $Visa

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
                Visa::findOrFail($id)->delete();
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
