<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function register(Request $request){
        $fields = $request -> validate([
            'name'=> 'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);
        $user = User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
   }
   public function login(Request $request){
    $fields = $request -> validate([
        'email'=>'required|string',
        'password'=>'required|string'
    ]);
    //Check email
    $user = User::where('email',$fields['email'])->first();

    //Check Password
    if(!$user||!Hash::check($fields['password'],$user->password)){
        return response([
            'message'=>'Bad Creds'
        ],401);
    }

    $token = $user->createToken('myapptoken')->plainTextToken;

    $response =[
        'user'=>$user,
        'token'=>$token
    ];
    return response($response,201);
}
   public function logout(Request $request){
       auth()->user()->tokens()->delete();
       return [
            'message' => 'logged Out'
       ];
   }

   public function adminRegister(Request $request){
    $fields = $request -> validate([
        'name'=> 'required|string',
        'email'=>'required|string|unique:users,email',
        'password'=>'required|string|confirmed',
        'role' => 'required|min:0|max:3|numeric'
    ]);
    $user = User::create([
        'name'=>$fields['name'],
        'email'=>$fields['email'],
        'password'=> bcrypt($fields['password']),
        'role' => $fields['role']
    ]);

    return response()->json(["msg"=> "Agent Created"]);
   }

   public function getAllUsers(){
       return User::all();
   }

   public function adminEdit(Request $request, $id) {
    //    return $request->all();
       User::findOrFail($id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password)
        ]);

       return response()->json(["msg" => "User updated successfully"]);
   }

   public function deleteUser($id){
       User::findOrFail($id)->delete();
       return response()->json(["msg" => "User Deleted successfully"]);

   }

   public function showUser($id){
       return User::findOrFail($id);
   }

}
