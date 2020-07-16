<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    protected $table = 'plans';

    static function modulesbyuser_HOLD($user_id)
    {
        $comp = null;
        $company = DB::table('company')
            ->where('company.user_id',$user_id)
            ->first();

        if($company) {//if it's a company user
            $comp = $company;
        }
        else{
            $company = DB::table('company')
                ->leftjoin('stores', 'stores.company_id', '=', 'company.id')
                ->leftjoin('employees', 'employees.store_id', '=', 'stores.id')
                ->leftjoin('users', 'users.id', '=', 'employees.user_id')
                ->where('users.id',/*$user_id*/$user_id)
                ->select('company.id as id')
                ->first();
            if($company) $comp = $company;
        }
        if($comp){
            DB::statement("SET sql_mode = ''");
            $modules = DB::table('modules')
                ->select('modules.*')
                ->leftjoin('plan_module', 'plan_module.module_id', '=', 'modules.id')
                ->leftjoin('plans', 'plans.id', '=', 'plan_module.plan_id')
                ->leftjoin('company_plan', 'company_plan.plan_id', '=', 'plans.id')
                ->where('company_plan.company_id', $company->id)
                ->groupby('modules.id')
                ->orderBy('modules.number', 'ASC')
                ->get();
            return $modules;
        }
        return null;
    }
    static function modulesbyuser($user_id)
    {
        $modules = DB::table('modules')
            ->select('modules.*')
            ->groupby('modules.id')
            ->orderBy('modules.number', 'ASC')
            ->get();
        return $modules;
    }


}
