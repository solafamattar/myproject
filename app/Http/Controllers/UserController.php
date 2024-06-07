<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherProfileResource;
use App\Models\Role;
use App\Models\teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ForgetMail; // Correct import statement for ForgetMail class


class UserController extends Controller
{
    public function login (Request $request){
        $request-> validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        $user=User::where("email",$request ->email)->first();
        if(isset ($user->id)){
            if (Hash::check($request->password,$user->password)){
                $token2=$user->createToken("auth_token2")->plainTextToken;
                $role_id = $user->role_id;
                $role = Role::where('id',$role_id)->first();
                return response()->json([
                    "status"=>"1",
                    "message"=>"logged successfully",
                    "access_token"=>$token2,
                    'data' => $user,
                    'role' => $role->name,
                ]);
            }
            else{
                return response()->json([
                    "status"=>"0",
                    "message"=>"password don't match",
                ],404);
            }
        }else{
            return response()->json([
                "status"=>"0",
                "message"=>"user not found",
            ],404);
        }
    }




    public function forget_password(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        $code = rand(11111,99999);
        $user->code = $code;
        $user->save();
        Mail::to($user->email)->send(new ForgetMail($code));
        return response()->json([
            "status"=> 200,
            "message"=>"send code successfully",
        ]);
    }
    public function check_forget_code(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if($user->code == $request->code){

            return response()->json([
                "status"=> 200,
                "message"=>"Code Is valid",
            ]);
        } else {
            return response()->json([
                "status"=> 401,
                "message"=>"Code Is Invalid",
            ]);
        }
    }
    public function reset_password(Request $request)
    {
        $request-> validate([
            "password"=>"required|confirmed",
            "email"=>"required"
        ]);

        $user = User::where('email',$request->email)->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "status"=> 200,
            "message"=>"update password successfuly",
        ]);

    }
    public function logout (){

        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>"1",
            "message"=>"logout successfully",

        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
