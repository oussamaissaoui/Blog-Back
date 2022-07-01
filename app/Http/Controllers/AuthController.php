<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class AuthController extends Controller
{
    //

    public function register(Request $request){


        $validator = Validator::make($request->all(), [
            'name' => 'required| min:3 | max:20',
            'email' => 'required | email | max:30 | unique:users',
            'password' => 'required| min:6 | max:30',
            
        ]);
        

        if($validator->fails()){
          //  return $this->sendError('Validation Error.', $validator->errors());  
          //return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);  
          return $validator->errors();   
          
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        //return $this->sendResponse($success, 'User register successfully.');
        return $success;
    }


    public function login(Request $request){


        $validator = Validator::make($request->all(), [
           
            'email' => 'required | email | max:30 ',
            'password' => 'required| min:6 | max:30',
            
        ]);
        
        if($validator->fails()){
            //  return $this->sendError('Validation Error.', $validator->errors());  
            //return Response::json(['errors'=>$validators->getMessageBag()->toArray()]);  
            return $validator->errors();   
            
          }

          else {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $success['name'] =  $user->name;
       
                return $success;
            } 
            else{ 
                return response()->json(['Unauthorised.'=>'Unauthorised']);
            }

          }


        
        
    }


    public function getUser(Request $request){

      try{
        $user = $request->user();
        return response()->json([
            'success'=>'true',
            'user'=>$user
        ]);
      }
      catch(Exception $e){

        $code = $e->getCode(); 
        return response()->json([
            'success'=>'false',
            'user'=>$code
        ]);
      }

    }



    public function logout(Request $request){

        /*
        $id = $request->user()->id;
        return $id;*/

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];

    }
}
