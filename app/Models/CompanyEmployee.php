<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyEmployee extends Model
{
    protected $table = 'companyemployee';

    static function getAll($company_id){
        $employees = DB::table('companyemployee')
            ->leftjoin('company','companyemployee.company_id','=','company.id')
            ->leftjoin('status', 'status.id', '=', 'companyemployee.status_id')
            ->where('companyemployee.company_id',$company_id)
            ->select('companyemployee.*','company.name as company_name','status.name as status_name','companyemployee.user_id as employees_user_id')
            ->get();

        return $employees;
    }
}
