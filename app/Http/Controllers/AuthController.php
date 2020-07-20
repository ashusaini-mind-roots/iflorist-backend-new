<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Store;
use Illuminate\Support\Str;
use App\Models\NufloristUserRoles;
use App\Models\NufloristUserTokens;
use App\Helpers\Utils;

class AuthController extends Controller
{
    public function index()
    {
        dd('hello');
    }

    public function users()
    {
        $users = DB::table('users')
            ->leftjoin('stores','users.store_id','=','stores.id')
            ->leftjoin('roles','users.role_id','=','roles.id')
            ->select('stores.store_name','users.*','roles.name as role_name')
            ->get();
        return response()->json(['users' => $users], 200);
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role_id' => 'required',
            'store_id' => 'required',
            /*'password' => 'required|min:8|confirmed'*/
            'password' => 'required|min:8'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->store_id = $request->store_id;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://nuflorist.com/nfadmin-dev/nuflorist-backend-dev/api/nuflorist_user_login',
            CURLOPT_USERAGENT => 'cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => [
                'email' => $request->email,
                'password' => $request->password,
                'app_id' => 'ilBJkOELnv'
            ]
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        $resp=json_decode($resp);

        if($resp->status == 1){

            $access_token = Utils::random_strings(32);

            $data=array();
            $data['userid']=$resp->admin_id;
            $data['access_token']=$access_token;
            $data['token_type']='custom';
            $data['expires_in']='';

            $data['user']['id']=$resp->admin_id;
            $data['user']['name']='nuflorist';
            $data['user']['email']=$request->email;

            $data['company']=!empty($resp->companyInfo)?$resp->companyInfo:'';
            $data['storeInfo']=!empty($resp->storeInfo)?$resp->storeInfo:'';

            $NufloristUserTokens = DB::table('nuflorist_user_tokens')
            ->select('nuflorist_user_tokens.id')
            ->where('nuflorist_user_tokens.nuflorist_user_id',$resp->admin_id)
            ->first();

            if(empty($nufloristUT)){
                $NufloristUserTokens = new NufloristUserTokens();
                $NufloristUserTokens->nuflorist_user_id = $resp->admin_id;
                $NufloristUserTokens->access_token =$access_token;
                $NufloristUserTokens->expiryDate = date('Y-m-d H:i:s', strtotime('1 hour'));
                $NufloristUserTokens->save();
            }else{
                //update access token
                $NufloristUserTokens = NufloristUserTokens::where('nuflorist_user_id', $resp->admin_id)->firstOrFail();
                $NufloristUserTokens->access_token =$access_token;
                $NufloristUserTokens->expiryDate = date('Y-m-d H:i:s', strtotime('1 hour'));
                $NufloristUserTokens->update();
            }
            
            $NufloristUserRoles = DB::table('nuflorist_user_roles')
            ->select('nuflorist_user_roles.id')
            ->where('nuflorist_user_roles.nuflorist_user_id',$resp->admin_id)
            ->first();

            if(empty($NufloristUserRoles)){
                $NufloristUserRoles = new NufloristUserRoles();
                $NufloristUserRoles->nuflorist_user_id=$resp->admin_id;
                $NufloristUserRoles->role_id=4;
                $NufloristUserRoles->save();
            }

            $roles = DB::table('roles')
            ->leftjoin('nuflorist_user_roles','nuflorist_user_roles.role_id','=','roles.id')
            ->where('nuflorist_user_roles.nuflorist_user_id',$resp->admin_id)
            ->select('roles.name')
            ->get();
            $data['roles']=$roles;

            return response()->json($data);
        }else{
            return response()->json(['error'=>'Unauthorized'],401);
        }
    }

    public function login_HOLD()
    {
		$credentials = request(['email', 'password']);

        if(!$token = auth()->attempt($credentials))
        {
            return response()->json(['error'=>'Unauthorized'],401);
        }

        $user = new User();

        if($user->if_active(auth()->user()->id)==false)
        {
            if($user->if_code_expired(auth()->user()->id))
            {
                $new_activation_code = Str::random(16);
                $texto = config('app.api_url_activation_company').'/'.auth()->user()->id.'-'.$new_activation_code;

                $this->send_mail(auth()->user()->email, $texto);
            $user->id = auth()->user()->id;
            $user->activation_code = $new_activation_code;
            $user->activation_code_expired_date = date('Y-m-d H-i-s');
            $user->update(['activation_code_expired_date'=>date('Y-m-d H-i-s'),'activation_code'=>$new_activation_code]);
            return response()->json(['error' => 'Your activation code has expired, we have sent you a new activation code'], 200);
        }

        return response()->json(['error'=>'Company deactivated'],200);
        }
      return $this->responseWithToken($token);
    }

    public function loginApp()
    {
        $credentials = request(['email', 'password']);

        if(!$token = auth()->attempt($credentials))
        {
            return response()->json(['error'=>'Unauthorized'],401);
        }

        return $this->responseAppWithToken($token);
    }

    public function send_mail($email,$text)
    {

    }

    public function me()
    {
        $users = DB::table('users')
            ->leftjoin('roles','users.role_id','=','roles.id')
            ->select('users.*','roles.name as role_name')
            ->where('users.id',auth()->user()->id)
            ->first();

        return response()->json($users);
    }

    public function exis_user()
    {
        $email = request(['email']);

        $user = DB::table('users')
            ->select('users.*')
            ->where('users.email',$email)
            ->first();

        if($user)
        {
            $_user = new User();
            $_user->id = $user->id;
            //return response()->json(['error' => $users->id], 200);

            if($_user->if_code_expired($user->id))
            {
                $new_activation_code = Str::random(16);
                $texto = config('app.api_url_activation_company').'/'.$user->id.'-'.$new_activation_code;
                //$this->send_mail($user->email, $texto);
//                $companyFind = Company::where('user_id',$user->id);
                $_user->activation_code = $new_activation_code;
                $_user->activation_code_expired_date = date('Y-m-d H-i-s');
                $_user->update(['activation_code_expired_date'=>date('Y-m-d H-i-s'),'activation_code'=>$new_activation_code]);
                return response()->json(['error' => 'Your activation code has expired, we have sent you a new activation code'], 200);
            }

            return response()->json(['error' => 'The email is in use, try another'], 200);
        }

        return response()->json(['success' => $user], 200);

        //return response()->json($users);
    }

    public function user_rol()
    {
        $rol_id = auth()->user()->role_id;
        return response()->json(['role' => Role::findOrFail($rol_id)],200);
    }

    protected function responseWithToken($token)
    {
        $company = Company::where('user_id',auth()->user()->id)->first();
		if($company==null)
		{
			$company = DB::table('company')
            ->leftjoin('stores','stores.company_id','=','company.id')
			->leftjoin('employees','employees.store_id','=','stores.id')
            ->where('employees.user_id',auth()->user()->id)
            ->select('company.*')
            ->first();
		}
		$roles = DB::table('roles')
            ->leftjoin('user_role','user_role.role_id','=','roles.id')
            ->where('user_role.user_id',auth()->user()->id)
            ->select('roles.name')
            ->get();
        return response()->json([
            'userid' => auth()->user()->id,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 8760,
            'user' => auth()->user(),
            'company' => $company,
			'roles' => $roles
        ]);
    }

    protected function responseAppWithToken($token)
    {
        $user_id = auth()->user()->id;
        $company = Company::getCompanyAppUser($user_id);
        $store = Store::getStoreAppUser($user_id);
//        $roles = DB::table('roles')
//            ->leftjoin('user_role','user_role.role_id','=','roles.id')
//            ->where('user_role.user_id',auth()->user()->id)
//            ->select('roles.name')
//            ->get();
        return response()->json([
            'userid' => auth()->user()->id,
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
//            'roles' => $roles,
            'store' => $store,
            'company' => $company,
        ]);
    }

    /*public function logout()
    {
        $this->guard()->logout();
        return respose()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully'
        ], 200);
    }*/

    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => 'success'], 200);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 302);
    }

    private function guard()
    {
        return Auth::guard();
    }

    public function delete(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function getById($id)
    {
        return response()->json(['user' => User::find($id)], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'store_id' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->store_id = $request->store_id;
        $user->password = bcrypt($request->password);
        $user->update();

        return response()->json(['status' => 'success'], 200);
    }
}
