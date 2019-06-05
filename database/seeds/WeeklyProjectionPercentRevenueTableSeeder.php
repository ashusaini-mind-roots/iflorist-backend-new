<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentRevenueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
INSERT INTO `weekly_projection_percent_revenues`(`store_week_id`,`year_proyection`,`year_reference`,`percent`,`created_at`,`updated_at`)
SELECT 
    sw.id AS store_week_id,
    w.`year` AS year_proyection,
    w.`year` - 1 AS year_reference,
    0 as percent,now(),now() 
FROM
    store_week sw
        INNER JOIN
    weeks w ON sw.week_id = w.id
    ;

UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '26' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '27' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '28' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '29' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '30' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '31' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '32' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '33' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '34' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '35' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '36' AND `year` = 2017) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =6 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '37' AND `year` = 2017) AND store_id = 3);    
UPDATE weekly_projection_percent_revenues set percent =10 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '02' AND `year` = 2018) AND store_id = 3);
UPDATE weekly_projection_percent_revenues set percent =50 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '09' AND `year` = 2018) AND store_id = 3);

EOT;
        DB::unprepared($sql);
    }
}
