<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    protected $table = 'modules';

    public function modules($plan_id)
    {
        $plans = DB::table('modules')
            ->leftjoin('plan_module', 'plan_module.module_id', '=', 'modules.id')
            ->leftjoin('plans', 'plans.id', '=', 'plan_module.plan_id')
            ->select('modules.name as modules_name')
            ->where('plans.id',$plan_id)
            ->get();
        return $plans;
    }
    public static function allModules(){
        $modules = DB::table('modules')
            ->leftjoin('plan_module', 'plan_module.module_id', '=', 'modules.id')
            ->leftjoin('plans', 'plans.id', '=', 'plan_module.plan_id')
            ->select('modules.*')
            ->get();
        return $modules;
    }
    
}
