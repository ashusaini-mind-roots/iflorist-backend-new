<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        
        
       $accessToken=!empty($request->accessToken)?$request->accessToken:'';
       $nuflorist_user_id=!empty($request->nuflorist_user_id)?$request->nuflorist_user_id:'';

       if(empty($accessToken)){
       	 return response()->json(['message' => 'Please, attach an access token to your request','success'=>false], 401);
       }

       $checkToken = DB::table('nuflorist_user_tokens')
            ->where('nuflorist_user_tokens.nuflorist_user_id',$nuflorist_user_id)
            ->where('nuflorist_user_tokens.access_token',$accessToken)
            ->select('nuflorist_user_tokens.expiryDate')
            ->get();

       if(empty($checkToken[0]->expiryDate)){
       	 return response()->json(['message' => 'Your access token is invalid. Please, login again.','success'=>false], 401);
       }

       if($checkToken[0]->expiryDate < date("Y-m-d H:i:s")){
       	  return response()->json(['message' => 'Your token has expired. Please, login again.','success'=>false], 401);
       }

		$userRoles = DB::table('roles')
        ->leftjoin('nuflorist_user_roles','nuflorist_user_roles.role_id','=','roles.id')
        ->where('nuflorist_user_roles.nuflorist_user_id',$nuflorist_user_id)
        ->select('roles.name')
        ->get();
		
		/*Check valid store by user*/
		if($request->route('store_id'))
		{
			$store_id = $request->route('store_id');
			$userRolesParse = $this->parseArrayObjectRoles($userRoles);
			if(in_array("COMPANYADMIN",$userRolesParse))
			{
				$stores = Company::hasStore($store_id,$user->id);
				if(sizeof($stores)==0)
					return response()->json(['message' => 'You have no access to store data ','success'=>false], 401);
			}
			else if(in_array("EMPLOYEE",$userRolesParse) || in_array("STOREMANAGER",$userRolesParse))
			{
				$employees = Employee::findByStore($store_id);
				if(sizeof($employees)==0)
					return response()->json(['message' => 'You have no access to store data ','success'=>false], 401);
			}
		}
		/*----------------------------------*/

		if($roles[0] == 'ALL_GRANTED')
        {
            foreach($userRoles as $role)
            {
                $request->merge(['auth_roles' => $userRoles]);
                return $next($request);
            }
        }
        else
		foreach($userRoles as $role)
		{
			if (in_array($role->name,$roles)) {
				$request->merge(['auth_roles' => $userRoles]);
				$request->merge(['auth_roles_parse' => $this->parseArrayObjectRoles($userRoles)]);
				return $next($request);
			}
		}
		return $this->unauthorized();
	}
	
    public function parseArrayObjectRoles($roles)
	{
		$array = array();
		foreach($roles as $role)
		{
			$array[] = $role->name;
		}
		
		return $array;
	}

	private function unauthorized($message = null){
		return response()->json([
			'message' => $message ? $message : 'You are unauthorized to access this resource',
			'success' => false
		], 200);
    }
}
