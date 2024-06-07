<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherProfileResource;
use App\Models\teacher;
use App\Models\Volunteer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\VolunteerProfileResource; // تصحيح الاستيراد هنا

class VolunteerController extends Controller
{
    public function add_volunteer(Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
            "mobile_phone" => "required",
            "gender" => "required",
            "role_id" => "required",
            "birth_date" => "required",
            "address" => "required",
            "nationality" => "required",
            "supervisor_id" => "required",
            "group_id" => "required"
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->mobile_phone = isset($request->mobile_phone) ? $request->mobile_phone : "";
        $user->address = $request->address;
        $user->birth_date = $request->birth_date;
        $user->role_id = $request->role_id;
        $user->nationality = $request->nationality;
        $user->save();
        $token = $user->createToken("auth_token")->plainTextToken;

        $volunteer = new Volunteer();
        // $volunteer->certificate_and_specialization = $request->certificate_and_specialization;
        $volunteer->user_id = $user->id;
        $volunteer->group_id = $request->group_id;
        $volunteer->supervisor_id = $request->supervisor_id;
        $volunteer->save();

        return response()->json([
            "status" => "1",
            "message" => "registered successfully",
            "access_token" => $token,
            'data1' => $user,
            "data2" => $volunteer
        ]);
    }

    public function volunteer_profile()
    {
        if (auth()->user()->role_id == 3) {
            $volunteer = Volunteer::where('user_id', auth()->user()->id)->first();
            return response()->json([
                "status" => 200,
                "message" => "volunteer profile",
                "data" => new VolunteerProfileREsource($volunteer), // تصحيح اسم الكلاس هنا
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "you are not Volunteer",
                "data" => null,
            ]);
        }
    }
    public function update_volunteer_profile(Request $request)
    {
        if (auth()->user()->role_id == 3) {
            $user = User::where('id', auth()->user()->id)->first();
            $volunteer = Volunteer::where('user_id', auth()->user()->id)->first();

            $user->address = $request->address;
            $user->email = $request->email;
            $user->mobile_phone = $request->mobile_phone;
            $user->save();


            $volunteer->save();

            return response()->json([
                "status" => 200,
                "message" => "update profile successfully",
                "data" => new VolunteerProfileREsource($volunteer),
            ]);
        }
        else {
            return response()->json([
                "status"=> 401,
                "message"=>"you are not Volunteer",
                "data" => null,
            ]);
        }}

    public function admin_update_volunteer_profile(Request $request)
    {
        if(auth()->user()->role_id == 1){

            $volunteer = Volunteer::where('id',$request->volunteer_id)->first();
            $user = User::where('id',$volunteer->user_id)->first();

            $user->address = $request->address;
            $user->email = $request->email;
            $user->mobile_phone = $request->mobile_phone;
            $user->save();

            $volunteer->group_id = $request->group_id;
            $volunteer->supervisor_id = $request->supervisor_id;
            $volunteer->save();

            return response()->json([
                "status"=> 200,
                "message"=>"update profile successfully",
                "data" => new VolunteerProfileResource($volunteer),
            ]);

        } else {
            return response()->json([
                "status"=> 401,
                "message"=>"you are not admin",
                "data" => null,
            ]);
        }
    }
    // بقية الدوال كما هي
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
