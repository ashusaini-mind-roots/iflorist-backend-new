<?php
namespace App\Http\Controllers;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
Use App\Models\Category;
Use App\Models\Schedule;
Use App\Models\Week;
Use App\Models\DateDim;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    public function schedule_week($store_id, $week_id)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
        //$employee_store_week = EmployeeStoreWeek::findByStoreWeekId($store_week_id);
        $employee_store_week_id = -1;
       // if($employee_store_week)
       //     $employee_store_week_id = $employee_store_week->id;
//        $schedules = Schedule::findByEmployeeStoreWeekId($employee_store_week->id);

        $categories = Category::all();
        $response = [];

        foreach ($categories as $category) {
            $employees = Employee::findByCategoryStore($category->id,$store_id);
            $employees_response = [];//employees de esta categoria
            foreach ($employees as $employee) {
                $schedules = Schedule::findByEmployeeAndStoreWeekIds($employee->id,$store_week_id);//los 7 schedules days de este employee;
                $employees_response[] = [
                    'name' => $employee->name,
                    'schedule_days' => $schedules,
                    'employee_store_week_id' => EmployeeStoreWeek::findByEmployeeANDStoreWeekId($employee->id,$store_week_id)->id
                ];
            }
            $response[] = ['category_name' => $category->name,'employees' => $employees_response];
        }
        return response()->json(['categories_schedules' => $response], 200);
    }

    public function updateoradd(Request $request)
    {
        $schedule_days = json_decode($request->schedule_days);
        $week_number = week::find($request->week_id)->number;
        $year = $request->year;

        $arrayre = [];

        if(is_array($schedule_days))
        {
           foreach ($schedule_days as $sche)
           {
               if(isset($sche->time_in) && isset($sche->time_out) && isset($sche->employee_store_week_id))
               {
                   if($sche->id==-1)
                   {
                       $chedule = new Schedule();
                       $chedule->employee_store_week_id = $sche->employee_store_week_id;
                       $chedule->time_in = Carbon::parse($sche->time_in)->format('Y-m-d H:i:s');
                       $chedule->time_out = Carbon::parse($sche->time_out)->format('Y-m-d H:i:s');
                       $chedule->break_time = !isset($sche->break_time) ? 0 : $sche->break_time;
                       $dimdate = DateDim::findBy_($year, $sche->day_of_week, $week_number);
                       $chedule->dates_dim_date = $dimdate->date;
                       //$chedule->dates_dim_date = date('Y-m-d');
                       $chedule->save();
                   }
                   else
                   {
                       $chedule = Schedule::findOrFail($sche->id);
                       $chedule->employee_store_week_id = $sche->employee_store_week_id;
                       $chedule->time_in = Carbon::parse($sche->time_in)->format('Y-m-d H:i:s');
                       $chedule->time_out = Carbon::parse($sche->time_out)->format('Y-m-d H:i:s');
                       $chedule->break_time = !isset($sche->break_time) ? $chedule->break_time : $sche->break_time;
                       $dimdate = DateDim::findBy_($year, $sche->day_of_week, $week_number);
                       //$arrayre[] =$dimdate;
                       $chedule->dates_dim_date =  $dimdate->date;
                       //$chedule->dates_dim_date = date('Y-m-d');
                       $chedule->update();
                   }
               }

            }

            return response()->json(['status' => 'success','weeknumber'=>$week_number, "year"=>$year/*,'arrayre'=>$arrayre*/], 200);
        }

        return response()->json([
            'status' => 'error',
            'errors' => 'Schedule array invalid'
        ], 422);
    }
}
