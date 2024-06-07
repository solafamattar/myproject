<?php

namespace App\Http\Controllers;

use App\Http\Resources\VolunteerProfileResource;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SupervisorProfileResource;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function add_supervisor (Request $request){
        $request-> validate([
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required|confirmed",
            "mobile_phone"=>"required",
            "gender"=>"required",
            "role_id" => "required",
            "birth_date"=>"required",
            "address"=>"required",
            "nationality"=>"required",

        ]);
        $user = new User ();
        $user->first_name = $request->first_name ;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->mobile_phone = isset ($request->mobile_phone )? $request->mobile_phone:"" ;
        $user->address = $request->address;
        $user->birth_date = $request->birth_date;
        $user->role_id = $request->role_id;
        $user->nationality = $request->nationality;
        $user ->save();
        $token=$user->createtoken("auth_token")->plainTextToken;


        $supervisor = new Supervisor();

        // $volunteer->certificate_and_specialization = $request-> certificate_and_specialization;
        $supervisor->user_id = $user->id;

        $supervisor->save();
        return response()->json([
            "status"=>"1",
            "message"=>"registed successfully",
            "access_token"=>$token,
            'data1' => $user,
            "data2" =>  $supervisor

        ],);

    }
    public function supervisor_profile()
    {
        if (auth()->user()->role_id == 2) {
            $supervisor = Supervisor::where('user_id', auth()->user()->id)->first();
            return response()->json([
                "status" => 200,
                "message" => "Supervisor profile",
                "data" => new SupervisorProfileREsource($supervisor), // تصحيح اسم الكلاس هنا
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "you are not Supervisor",
                "data" => null,
            ]);
        }
    }
    public function update_supervisor_profile(Request $request)
    {
        if (auth()->user()->role_id == 2) {
            $user = User::where('id', auth()->user()->id)->first();
            $supervisor = Supervisor::where('user_id', auth()->user()->id)->first();

            $user->address = $request->address;
            $user->email = $request->email;
            $user->mobile_phone = $request->mobile_phone;
            $user->save();


            $supervisor ->save();

            return response()->json([
                "status" => 200,
                "message" => "update profile successfully",
                "data" => new SupervisorProfileREsource($supervisor),
            ]);
        }
        else {
            return response()->json([
                "status"=> 401,
                "message"=>"you are not Supervisor",
                "data" => null,
            ]);
        }}

    public function admin_update_supervisor_profile(Request $request)
    {
        if(auth()->user()->role_id == 1){

            $supervisor = Supervisor::where('id',$request->supervisor_id)->first();
            $user = User::where('id',$supervisor->user_id)->first();

            $user->address = $request->address;
            $user->email = $request->email;
            $user->mobile_phone = $request->mobile_phone;
            $user->save();


            $supervisor ->save();

            return response()->json([
                "status"=> 200,
                "message"=>"update profile successfully",
                "data" => new SupervisorProfileResource($supervisor ),
            ]);

        } else {
            return response()->json([
                "status"=> 401,
                "message"=>"you are not admin",
                "data" => null,
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
