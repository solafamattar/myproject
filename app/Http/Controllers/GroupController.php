<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function add_group(Request $request)
    {
        if(auth()->user()->role_id == 1){
            $group = new Group();
            $group->name = $request->name;
            $group->supervisor_id = $request->supervisor_id;


            $group->save();
            return response()->json([
                "status"=>"1",
                "message"=>"the group is added",
                'data' => $group
            ]);
        } else {
            return response()->json([
                "status"=> 401,
                "message"=>"you are not admin",
                "data" => null,
            ]);
        }

    }
}
