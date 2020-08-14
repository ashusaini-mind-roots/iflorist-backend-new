<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use App\Helpers\Utils;

class PlansController extends Controller
{
    public function plans()
    {
        $plans = Plan::all();
        $result = array();
        foreach ($plans as $plan)
        {
            $plan_data = array();
            $plan_data['plan'] = $plan;
            $module = new Module();
            $plan_modules = $module->modules($plan->id);
            $plan_data['modules'] = $plan_modules;
            $result[] = $plan_data;
        }
        return response()->json(['plans' => $result], 200);
    }

    public function plansbyuser($user_id)
    {
        $company = DB::table('company')
        ->where('company.user_id',$user_id)
        ->first();

        $plans = DB::table('plans')
        ->leftjoin('company_plan','company_plan.plan_id','=','plans.id')
        ->where('company_plan.company_id',$company->id)
        ->get();

        $result = array();
        foreach ($plans as $plan)
        {
            $plan_data = array();
            $plan_data['plan'] = $plan;
            $module = new Module();
            $plan_modules = $module->modules($plan->id);
            $plan_data['modules'] = $plan_modules;
            $result[] = $plan_data;
        }
        return response()->json(['plans' => $result], 200);
    }


    public function modulesbyuser_HOLD(Request $request)
    {
        $modules_return = array();
        $user_roles = $request->auth_roles->toArray();

        if(Utils::hasRole('ROOT',$user_roles)){
            $modules = Module::allModules();
        }
        else
            $modules = Plan::modulesbyuser(/*$user_id*/auth()->user()->id);
        foreach ($modules as $module){
            $found = false;
            if($module->roles != null){
                $module_roles = explode (",", $module->roles);
                foreach ($module_roles as $module_role){
                    foreach ($user_roles as $user_role){
                        if(trim($user_role->name) == trim($module_role)){
                            $found = true;
                            break;
                        }
                    }
                    if($found) break;
                }
            }
            if($found == true) $modules_return[] = $module;
        }

        return response()->json(['modules' => $modules_return/*,'test'=>$company*/], 200);
    }

    public function modulesbyuser(Request $request)
    {
        $modules_return = Module::allModules();

        return response()->json(['modules' => $modules_return], 200);
    }


}