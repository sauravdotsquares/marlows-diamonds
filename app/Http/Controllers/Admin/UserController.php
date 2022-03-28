<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $getData = User::where('user_role',3)->latest()->get();
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Users", "url" => route("admin.users"), "icon" => "fa fa-users"],

        ];
        populate_breadcrumb($breadcrumb);

        $result = [
            'getData'=>$getData,
        ];
        return view('admin.users.index',$result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'nicename' => 'required',
            'password' => isset($request->table_id)?'nullable':'required',
            'description' => 'required',
            'email' => 'required|email|unique:users',
        ]);
     
        if(isset($request->table_id) && !empty($request->table_id)){
            $password = User::where('id',$request->table_id)->pluck('password')->first();
            if(isset($request->password) && !empty($request->password)){
                $password = bcrypt($request->password);
            }elseif(isset($password) && !empty($password)){
                $password = $password;
            }else{
                return response()->json(['error'=>'Record not found']);
            }
            $updateUsers = [
                'name'  => $request->name,
                'username' => $request->username,
                'nicename' => $request->nicename,
                'password' => $password,
                'description' => $request->description,
            ];
            $msg = 'Updated records.';
        }else{
            $password = bcrypt($request->password);
            $msg = 'Added new records.';
            $updateUsers = [
                'name'  => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'nicename' => $request->nicename,
                'password' => $password,
                'description' => $request->description,
                'user_role' => 3,
            ];
        }
        if ($validator->passes()) {
            $user = User::updateOrCreate(['id'=>$request->table_id],$updateUsers);
            return response()->json(['success'=>$msg]);
        }else{
            if(isset($request->table_id) && !empty($request->table_id)){
                $user = User::updateOrCreate(['id'=>$request->table_id],$updateUsers);

                return response()->json(['success'=>$msg]);
            }
        }
     
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function status(Request $request)
    {
        $statusChange = User::findOrFail($request->id);
        if($statusChange){
            $statusChange->update([
                'is_active'=>$request->status,
            ]);
            return response()->json($statusChange);
        }
        return response()->json(['error'=>'geterror'],422);
    }

    public function delete(Request $request)
    {
        $post = User::find($request->id)->delete();
        return response()->json($post);
    }
}
