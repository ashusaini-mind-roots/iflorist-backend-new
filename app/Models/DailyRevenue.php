<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailyRevenue extends Model
{
    protected $table = 'daily_revenues';

    public function post()
    {
        return $this->belongsTo('App\Models\StoreWeek');
    }

    static function sevenDaysWeek($store_id,$week_id)
    {
        $seven_days_week = DB::table('daily_revenues')
            ->leftjoin('store_week','store_week.id','=','daily_revenues.store_week_id')
            ->leftjoin('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->select('daily_revenues.*','dates_dim.day_of_week')
            ->where('store_week.store_id',$store_id)
            ->where('store_week.week_id',$week_id)
            ->get();
        return  $seven_days_week;
    }
    static function sevenDaysWeekByWeekNumberYear($store_id,$week_number,$year)
    {
        $seven_days_week = DB::table('daily_revenues')
            ->leftjoin('store_week','store_week.id','=','daily_revenues.store_week_id')
            ->leftjoin('weeks','store_week.week_id','=','weeks.id')
            ->leftjoin('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->select('daily_revenues.*','dates_dim.day_of_week')
            ->where('store_week.store_id',$store_id)
            ->where('weeks.number',$week_number)
            ->where('weeks.year',$year)
            ->get();
        return  $seven_days_week;
    }

    static function lastDayWeek($week_number,$week_year)
    {
        $day_week = DB::table('dates_dim')
            ->where('dates_dim.week_starting_monday',$week_number)
            ->where('dates_dim.year',$week_year)
            ->where('dates_dim.day_of_week','Sunday')
            ->first();
        return $day_week;

//        $seven_days_week = DB::table('daily_revenues')
//            ->leftjoin('store_week','store_week.id','=','daily_revenues.store_week_id')
//            ->leftjoin('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
//            ->select('daily_revenues.*','dates_dim.*')
//            ->where('store_week.store_id',$store_id)
//            ->where('store_week.week_id',$week_id)
//            ->orderBy('dates_dim_date','desc')
//            ->first();
//        return  $seven_days_week;
    }

    static function totalAmtWeek($store_id,$week_id)
    {
        $total_amt_week = DB::table('daily_revenues')
            ->leftjoin('store_week','store_week.id','=','daily_revenues.store_week_id')
            ->leftjoin('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->select('daily_revenues.*','dates_dim.*',DB::raw('merchandise + wire + delivery as amt_total'))
            ->where('store_week.store_id',$store_id)
            ->where('store_week.week_id',$week_id)
            ->get()/*->sum(DB::raw('daily_revenues.wire + daily_revenues.delivery + daily_revenues.merchandise'))*/
            ;
        return  $total_amt_week;
    }

    static function amtTotal($seven_days_week)
    {
        $total = 0;
        foreach ($seven_days_week as $day){
            $total += $day->merchandise + $day->wire  + $day->delivery;
        }
        return $total;
    }
}
