<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use Validator;
// use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {

    }

    public function getUsers() {

        // $images = DB::table("userpictures")
        $results = DB::table("users")
                   ->select('users.*','userlocations.longitude','userlocations.latitude')
                   // ->selectRaw('GROUP_CONCAT(userpictures.image) as images')
                   ->leftjoin('userpictures', 'userpictures.userid', '=', 'users.id')
                   ->leftjoin('userlocations', 'userlocations.userid', '=', 'users.id')
                   ->orderBy("users.id", "desc")
                   ->get();

        // $reports = DB::table("reports")
        //         ->select('reports.*', 'users.fullname')
        //         ->join('users', 'users.id', '=', 'reports.createrid')
        //         ->whereBetween('published_at', [$sdate, $edate])
        //         ->whereNotIn('reports.catid', [8])
        //         ->orderBy("published_at", "desc")
        //         ->get();

        // $results = app('db')->select("SELECT * FROM users");
        return response()->json($results);

    }

    public function createUser(Request $request) {



        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|integer',
            'business' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors());
        }

        $user = new User;

        $user->name = $request->get("name");
        $user->age = $request->get("age");
        $user->business = $request->get("business");;
        $user->email = $request->get("email");
        $user->password = $request->get("password");
        // $user->api_token = $request->get("api_token");

        $user->save();

        $lastId = $user->id;

        return response()->json($lastId);

    }
    
}