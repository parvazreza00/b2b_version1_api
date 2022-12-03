<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Carbon\Carbon;

class AgentController extends Controller
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
                $allActivityLog = Agent::all();
                return response()->json($allActivityLog);
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
        $companyImage = $request->file('companyImage');
        $companyImage_name_gen = hexdec(uniqid());
        $companyImage_ext = strtolower($companyImage->getClientOriginalExtension());
        $companyImage_name = $companyImage_name_gen.'.'.$companyImage_ext;
        $up_location_companyImage = 'images/companyImage/';
        $companyImage->move($up_location_companyImage,$companyImage_name);
        $last_companyImage = $up_location_companyImage.$companyImage_name;


     $header = $request->header("Authorization");
     if($header==''){
         $message = "Authorization is required";
         return response()->json(['Message'=>$message], 422);
     }else{
         if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc'){//jwtToken->b2bapi
             $AgentData = Agent::insert([
                 'agentId'        => $request->agentId,
                 'name'           => $request->name,
                 'email'          => $request->email,
                 'password'       => $request->password,
                 'phone'          => $request->phone,
                 'joinAt'         => Carbon::now(),
                 'status'         => $request->status,
                 'isActive'       => $request->isActive,
                 'company'        => $request->company,
                 'companyadd'     => $request->companyadd,
                 'area'           => $request->area,
                 'companyImage'   => $last_companyImage,
                 'logoPermission' => $request->logoPermission,
                 'markup'         => $request->markup,
                 'bonus'          => $request->bonus,
                 'credit'         => $request->credit

             ]);
             return response()->json([
                 'success' => 'Ledger added Successful',
                 'Ticketing' => $AgentData,
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
                $editActivityLog = Agent::findOrFail($id);
                return response()->json($editActivityLog);
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

    //image generate system...............
    $companyImage = $request->file('companyImage');
    $companyImage_name_gen = hexdec(uniqid());
    $companyImage_ext = strtolower($companyImage->getClientOriginalExtension());
    $companyImage_name = $companyImage_name_gen.'.'.$companyImage_ext;
    $up_location_companyImage = 'images/companyImage/';
    $companyImage->move($up_location_companyImage, $companyImage_name);
    $last_companyImage = $up_location_companyImage.$companyImage_name;


    $header = $request->header("Authorization");
    if ($header=='') {
        $message = "Authorization is required";
        return response()->json(['Message'=>$message], 422);
    } else {
        if ($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImIyYmFwaSIsImlhdCI6MTUxNjIzOTAyMn0.YcdrmjBHNwwVdxN_SuKzyFrmj8zt-rBssgI0orrIJXc') {//jwtToken->b2bapi
            $AgentData = Agent::insert([
                'agentId'        => $request->agentId,
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => $request->password,
                'phone'          => $request->phone,
                'joinAt'         => Carbon::now(),
                'status'         => $request->status,
                'isActive'       => $request->isActive,
                'company'        => $request->company,
                'companyadd'     => $request->companyadd,
                'area'           => $request->area,
                'companyImage'   => $last_companyImage,
                'logoPermission' => $request->logoPermission,
                'markup'         => $request->markup,
                'bonus'          => $request->bonus,
                'credit'         => $request->credit

            ]);
            return response()->json([
               'success' => 'Updated Successfully',
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
                Agent::findOrFail($id)->delete();
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
