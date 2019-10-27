<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DailyRevenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
        
insert into daily_revenues(store_week_id,dates_dim_date,user_id,merchandise,wire,delivery,entered_date,created_at,updated_at)
SELECT 
     sw.id AS StoreWeekID,
    dd.`date` as dates_dim_date,
    1 as user_id,
    0 as wire,
    0 as delivery,
    0 as merchandise,
     dd.`date` as entered_date,
     now() as created_at,
     now() as updated_at
FROM
    dates_dim dd
        INNER JOIN
    weeks w ON CASE
        WHEN dd.week_starting_monday = 53 THEN 52
        ELSE dd.week_starting_monday
    END = w.`number`
        AND dd.week_year = w.`year`
        INNER JOIN
    store_week sw ON w.id = sw.week_id
;

DROP TABLE IF EXISTS `daily_revenue_temp`;
CREATE TABLE `daily_revenue_temp` (
  `date_id` date NOT NULL,
  `wire` decimal(10,2) NOT NULL DEFAULT '30.00',
  `delivery` decimal(10,2) NOT NULL DEFAULT '120.00',
  `merchandise` decimal(10,2) NOT NULL DEFAULT '52.00',
  `store_id` int(11) NOT NULL,
  `entered_by` int(11) NOT NULL,
  `entered_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`date_id`)
) ;

--
-- Dumping data for table `daily_revenue_temp`
--
INSERT INTO `daily_revenue_temp` VALUES 
('2016-07-03',200.00,100.00,4496.00,1,1,now()),
('2016-07-10',200.00,100.00,5774.00,1,1,now()),
('2016-07-17',200.00,100.00,4740.00,1,1,now()),
('2016-07-24',200.00,100.00,5337.00,1,1,now()),
('2016-07-31',200.00,100.00,7261.00,1,1,now()),
('2016-08-07',200.00,100.00,4780.00,1,1,now()),
('2016-08-14',200.00,100.00,6465.00,1,1,now()),
('2016-08-21',200.00,100.00,8082.00,1,1,now()),
('2016-08-28',200.00,100.00,6152.00,1,1,now()),
('2016-09-04',200.00,100.00,5222.00,1,1,now()),
('2016-09-11',200.00,100.00,7411.00,1,1,now()),
('2016-09-18',200.00,100.00,8700.00,1,1,now()),
('2016-09-25',200.00,100.00,8027.00,1,1,now()),
('2016-10-02',200.00,100.00,3432.00,1,1,now()),
('2016-10-09',200.00,100.00,13246.00,1,1,now()),
('2016-10-16',200.00,100.00,8011.00,1,1,now()),
('2016-10-23',200.00,100.00,7605.00,1,1,now()),
('2016-10-30',200.00,100.00,12848.00,1,1,now()),
('2016-11-06',200.00,100.00,8497.00,1,1,now()),
('2016-11-13',200.00,100.00,10979.00,1,1,now()),
('2016-11-20',200.00,100.00,13597.00,1,1,now()),
('2016-11-27',200.00,100.00,11731.00,1,1,now()),
('2016-12-04',200.00,100.00,12778.00,1,1,now()),
('2016-12-11',200.00,100.00,16685.00,1,1,now()),
('2016-12-18',200.00,100.00,32748.00,1,1,now()),
('2016-12-25',200.00,100.00,11811.00,1,1,now()),
('2017-01-08',200.00,100.00,8539.00,1,1,now()),
('2017-01-15',200.00,100.00,10882.00,1,1,now()),
('2017-01-22',200.00,100.00,8839.00,1,1,now()),
('2017-01-29',200.00,100.00,9141.00,1,1,now()),
('2017-02-05',200.00,100.00,11540.00,1,1,now()),
('2017-02-12',200.00,100.00,11597.00,1,1,now()),
('2017-02-19',200.00,100.00,50010.00,1,1,now()),
('2017-02-26',200.00,100.00,8026.00,1,1,now()),
('2017-03-05',200.00,100.00,14370.00,1,1,now()),
('2017-03-12',200.00,100.00,10215.00,1,1,now()),
('2017-03-19',200.00,100.00,10290.00,1,1,now()),
('2017-03-26',200.00,100.00,9001.00,1,1,now()),
('2017-04-02',200.00,100.00,11984.00,1,1,now()),
('2017-04-09',200.00,100.00,10678.00,1,1,now()),
('2017-04-16',200.00,100.00,21620.00,1,1,now()),
('2017-04-23',200.00,100.00,9961.00,1,1,now()),
('2017-04-30',200.00,100.00,9600.00,1,1,now()),
('2017-05-07',200.00,100.00,8225.00,1,1,now()),
('2017-05-14',200.00,100.00,46459.00,1,1,now()),
('2017-05-21',200.00,100.00,6467.00,1,1,now()),
('2017-05-28',200.00,100.00,5328.00,1,1,now()),
('2017-06-04',200.00,100.00,4059.00,1,1,now()),
('2017-06-11',200.00,100.00,5591.00,1,1,now()),
('2017-06-18',200.00,100.00,6909.00,1,1,now()),
('2017-06-25',200.00,100.00,5411.00,1,1,now()),
('2017-07-02',200.00,100.00,5535.00,1,1,now()),
('2017-07-09',200.00,100.00,4894.00,1,1,now()),
('2017-07-16',200.00,100.00,5761.00,1,1,now()),
('2017-07-23',200.00,100.00,12060.00,1,1,now()),
('2017-07-30',200.00,100.00,4985.00,1,1,now()),
('2017-08-06',200.00,100.00,6293.00,1,1,now()),
('2017-08-13',200.00,100.00,6789.00,1,1,now()),
('2017-08-20',200.00,100.00,7039.00,1,1,now()),
('2017-08-27',200.00,100.00,5488.00,1,1,now()),
('2017-09-03',200.00,100.00,6804.00,1,1,now()),
('2017-09-10',200.00,100.00,1100.00,1,1,now()),
('2017-09-17',200.00,100.00,4603.00,1,1,now()),
('2017-09-24',200.00,100.00,7586.00,1,1,now()),
('2017-10-01',200.00,100.00,4200.00,1,1,now()),
('2017-10-08',200.00,100.00,10074.00,1,1,now()),
('2017-10-15',200.00,100.00,7034.00,1,1,now()),
('2017-10-22',200.00,100.00,13098.00,1,1,now()),
('2017-10-29',200.00,100.00,14111.00,1,1,now()),
('2017-11-05',200.00,100.00,11686.00,1,1,now()),
('2017-11-12',200.00,100.00,14400.00,1,1,now()),
('2017-11-19',200.00,100.00,15848.00,1,1,now()),
('2017-11-26',200.00,100.00,16528.00,1,1,now()),
('2017-12-03',200.00,100.00,13080.00,1,1,now()),
('2017-12-10',200.00,100.00,12646.00,1,1,now()),
('2017-12-17',200.00,100.00,18500.00,1,1,now()),
('2017-12-24',200.00,100.00,35016.00,1,1,now()),
('2017-12-31',200.00,100.00,10500.00,1,1,now()),
('2018-01-01',200.00,100.00,0.00,1,1,now()),
('2018-01-02',200.00,100.00,1305.00,1,1,now()),
('2018-01-03',200.00,100.00,959.00,1,1,now()),
('2018-01-04',200.00,100.00,2142.00,1,1,now()),
('2018-01-05',200.00,100.00,1486.00,1,1,now()),
('2018-01-06',200.00,100.00,1372.00,1,1,now()),
('2018-01-07',200.00,100.00,0.00,1,1,now()),
('2018-01-08',200.00,100.00,1080.00,1,1,now()),
('2018-01-09',200.00,100.00,938.00,1,1,now()),
('2018-01-10',200.00,100.00,1904.00,1,1,now()),
('2018-01-11',200.00,100.00,1675.00,1,1,now()),
('2018-01-12',200.00,100.00,2553.00,1,1,now()),
('2018-01-13',200.00,100.00,2652.00,1,1,now()),
('2018-01-14',200.00,100.00,0.00,1,1,now()),
('2018-01-15',200.00,100.00,1343.00,1,1,now()),
('2018-01-16',200.00,100.00,2701.00,1,1,now()),
('2018-01-17',200.00,100.00,2100.00,1,1,now()),
('2018-01-18',200.00,100.00,787.00,1,1,now()),
('2018-01-19',200.00,100.00,1797.00,1,1,now()),
('2018-01-20',200.00,100.00,1139.00,1,1,now()),
('2018-01-21',200.00,100.00,0.00,1,1,now()),
('2018-01-22',200.00,100.00,1092.00,1,1,now()),
('2018-01-23',200.00,100.00,1397.00,1,1,now()),
('2018-01-24',200.00,100.00,1565.00,1,1,now()),
('2018-01-25',200.00,100.00,1596.00,1,1,now()),
('2018-01-26',200.00,100.00,2511.00,1,1,now()),
('2018-01-27',200.00,100.00,1777.00,1,1,now()),
('2018-01-28',200.00,100.00,0.00,1,1,now()),
('2018-01-29',200.00,100.00,1032.00,1,1,now()),
('2018-01-30',200.00,100.00,1389.00,1,1,now()),
('2018-01-31',200.00,100.00,1265.00,1,1,now()),
('2018-02-01',200.00,100.00,1825.00,1,1,now()),
('2018-02-02',200.00,100.00,2845.00,1,1,now()),
('2018-02-03',200.00,100.00,4221.00,1,1,now()),
('2018-02-04',200.00,100.00,0.00,1,1,now()),
('2018-02-05',200.00,100.00,2006.00,1,1,now()),
('2018-02-06',200.00,100.00,1381.00,1,1,now()),
('2018-02-07',200.00,100.00,1380.00,1,1,now()),
('2018-02-08',200.00,100.00,1544.00,1,1,now()),
('2018-02-09',200.00,100.00,3013.00,1,1,now()),
('2018-02-10',200.00,100.00,2227.00,1,1,now()),
('2018-02-11',200.00,100.00,193.00,1,1,now()),
('2018-02-12',200.00,100.00,2753.00,1,1,now()),
('2018-02-13',200.00,100.00,12736.00,1,1,now()),
('2018-02-14',200.00,100.00,35412.00,1,1,now()),
('2018-02-15',200.00,100.00,2509.00,1,1,now()),
('2018-02-16',200.00,100.00,2701.00,1,1,now()),
('2018-02-17',200.00,100.00,2976.00,1,1,now()),
('2018-02-18',200.00,100.00,0.00,1,1,now()),
('2018-02-19',200.00,100.00,1202.00,1,1,now()),
('2018-02-20',200.00,100.00,2044.00,1,1,now()),
('2018-02-21',200.00,100.00,1688.00,1,1,now()),
('2018-02-22',200.00,100.00,2031.00,1,1,now()),
('2018-02-23',200.00,100.00,2899.00,1,1,now()),
('2018-02-24',200.00,100.00,2079.00,1,1,now()),
('2018-02-25',200.00,100.00,0.00,1,1,now()),
('2018-02-26',200.00,100.00,850.00,1,1,now()),
('2018-02-27',200.00,100.00,3106.00,1,1,now()),
('2018-02-28',200.00,100.00,2804.00,1,1,now()),
('2018-03-01',200.00,100.00,2097.00,1,1,now()),
('2018-03-02',200.00,100.00,4090.00,1,1,now()),
('2018-03-03',200.00,100.00,2567.00,1,1,now()),
('2018-03-04',200.00,100.00,0.00,1,1,now()),
('2018-03-05',200.00,100.00,1395.00,1,1,now()),
('2018-03-06',200.00,100.00,1267.00,1,1,now()),
('2018-03-07',200.00,100.00,1039.00,1,1,now()),
('2018-03-08',200.00,100.00,2859.00,1,1,now()),
('2018-03-09',200.00,100.00,2100.00,1,1,now()),
('2018-03-10',200.00,100.00,1640.00,1,1,now()),
('2018-03-11',200.00,100.00,0.00,1,1,now()),
('2018-03-12',200.00,100.00,1199.00,1,1,now()),
('2018-03-13',200.00,100.00,2384.00,1,1,now()),
('2018-03-14',200.00,100.00,1855.00,1,1,now()),
('2018-03-15',200.00,100.00,1200.00,1,1,now()),
('2018-03-16',200.00,100.00,2291.00,1,1,now()),
('2018-03-17',200.00,100.00,2613.00,1,1,now()),
('2018-03-18',200.00,100.00,880.00,1,1,now()),
('2018-03-19',200.00,100.00,2761.00,1,1,now()),
('2018-03-20',200.00,100.00,1541.00,1,1,now()),
('2018-03-21',200.00,100.00,1589.00,1,1,now()),
('2018-03-22',200.00,100.00,1077.00,1,1,now()),
('2018-03-23',200.00,100.00,2371.00,1,1,now()),
('2018-03-24',200.00,100.00,2771.00,1,1,now()),
('2018-03-25',200.00,100.00,0.00,1,1,now()),
('2018-03-26',200.00,100.00,1144.00,1,1,now()),
('2018-03-27',200.00,100.00,2801.00,1,1,now()),
('2018-03-28',200.00,100.00,3255.00,1,1,now()),
('2018-03-29',200.00,100.00,3299.00,1,1,now()),
('2018-03-30',200.00,100.00,5629.10,1,1,now()),
('2018-03-31',200.00,100.00,7452.88,1,1,now()),
('2018-04-01',200.00,100.00,0.00,1,1,now()),
('2018-04-02',200.00,100.00,1690.00,1,1,now()),
('2018-04-03',200.00,100.00,1922.00,1,1,now()),
('2018-04-04',200.00,100.00,1399.00,1,1,now()),
('2018-04-05',200.00,100.00,1805.00,1,1,now()),
('2018-04-06',200.00,100.00,2034.00,1,1,now()),
('2018-04-07',200.00,100.00,2473.00,1,1,now()),
('2018-04-08',200.00,100.00,0.00,1,1,now()),
('2018-04-09',200.00,100.00,1665.00,1,1,now()),
('2018-04-10',200.00,100.00,2652.00,1,1,now()),
('2018-04-11',200.00,100.00,870.00,1,1,now()),
('2018-04-12',200.00,100.00,1778.00,1,1,now()),
('2018-04-13',200.00,100.00,6688.00,1,1,now()),
('2018-04-14',200.00,100.00,4524.00,1,1,now()),
('2018-04-15',200.00,100.00,0.00,1,1,now()),
('2018-04-16',200.00,100.00,1515.00,1,1,now()),
('2018-04-17',200.00,100.00,540.00,1,1,now()),
('2018-04-18',200.00,100.00,1254.00,1,1,now()),
('2018-04-19',200.00,100.00,1728.00,1,1,now()),
('2018-04-20',200.00,100.00,1759.00,1,1,now()),
('2018-04-21',200.00,100.00,2460.00,1,1,now()),
('2018-04-22',200.00,100.00,0.00,1,1,now()),
('2018-04-23',200.00,100.00,1051.00,1,1,now()),
('2018-04-24',200.00,100.00,1812.00,1,1,now()),
('2018-04-25',200.00,100.00,1962.00,1,1,now()),
('2018-04-26',200.00,100.00,2668.00,1,1,now()),
('2018-04-27',200.00,100.00,1507.00,1,1,now()),
('2018-04-28',200.00,100.00,2038.00,1,1,now()),
('2018-04-29',200.00,100.00,0.00,1,1,now()),
('2018-04-30',200.00,100.00,1435.00,1,1,now()),
('2018-05-01',200.00,100.00,1756.00,1,1,now()),
('2018-05-02',200.00,100.00,1143.00,1,1,now()),
('2018-05-03',200.00,100.00,2270.00,1,1,now()),
('2018-05-04',200.00,100.00,1662.00,1,1,now()),
('2018-05-05',200.00,100.00,1911.00,1,1,now()),
('2018-05-06',200.00,100.00,0.00,1,1,now()),
('2018-05-07',200.00,100.00,1623.00,1,1,now()),
('2018-05-08',200.00,100.00,2170.00,1,1,now()),
('2018-05-09',200.00,100.00,1660.00,1,1,now()),
('2018-05-10',200.00,100.00,2534.00,1,1,now()),
('2018-05-11',200.00,100.00,10541.00,1,1,now()),
('2018-05-12',200.00,100.00,26488.00,1,1,now()),
('2018-05-13',200.00,100.00,13230.00,1,1,now()),
('2018-05-14',200.00,100.00,1925.00,1,1,now()),
('2018-05-15',200.00,100.00,1926.00,1,1,now()),
('2018-05-16',200.00,100.00,1340.00,1,1,now()),
('2018-05-17',200.00,100.00,1308.00,1,1,now()),
('2018-05-18',200.00,100.00,1075.00,1,1,now()),
('2018-05-19',200.00,100.00,1410.00,1,1,now()),
('2018-05-20',200.00,100.00,0.00,1,1,now()),
('2018-05-21',200.00,100.00,456.00,1,1,now()),
('2018-05-22',200.00,100.00,1099.00,1,1,now()),
('2018-05-23',200.00,100.00,1109.00,1,1,now()),
('2018-05-24',200.00,100.00,1481.00,1,1,now()),
('2018-05-25',200.00,100.00,2894.00,1,1,now()),
('2018-05-26',200.00,100.00,655.00,1,1,now()),
('2018-05-27',200.00,100.00,0.00,1,1,now()),
('2018-05-28',200.00,100.00,0.00,1,1,now()),
('2018-05-29',200.00,100.00,922.00,1,1,now()),
('2018-05-30',200.00,100.00,1330.00,1,1,now()),
('2018-05-31',200.00,100.00,940.00,1,1,now()),
('2018-06-01',200.00,100.00,1390.00,1,1,now()),
('2018-06-02',200.00,100.00,2048.00,1,1,now()),
('2018-06-03',200.00,100.00,0.00,1,1,now()),
('2018-06-04',200.00,100.00,851.00,1,1,now()),
('2018-06-05',200.00,100.00,1572.00,1,1,now()),
('2018-06-06',200.00,100.00,245.00,1,1,now()),
('2018-06-07',200.00,100.00,476.00,1,1,now()),
('2018-06-08',200.00,100.00,1093.00,1,1,now()),
('2018-06-09',200.00,100.00,1663.00,1,1,now()),
('2018-06-10',200.00,100.00,0.00,1,1,now()),
('2018-06-11',200.00,100.00,766.00,1,1,now()),
('2018-06-12',200.00,100.00,1177.00,1,1,now()),
('2018-06-13',200.00,100.00,948.00,1,1,now()),
('2018-06-14',200.00,100.00,695.00,1,1,now()),
('2018-06-15',200.00,100.00,1585.00,1,1,now()),
('2018-06-16',200.00,100.00,1644.00,1,1,now()),
('2018-06-17',200.00,100.00,0.00,1,1,now()),
('2018-06-18',200.00,100.00,374.00,1,1,now()),
('2018-06-19',200.00,100.00,1377.00,1,1,now()),
('2018-06-20',200.00,100.00,730.00,1,1,now()),
('2018-06-21',200.00,100.00,577.00,1,1,now()),
('2018-06-22',200.00,100.00,1520.00,1,1,now()),
('2018-06-23',200.00,100.00,1135.00,1,1,now()),
('2018-06-24',200.00,100.00,0.00,1,1,now()),
('2018-06-25',200.00,100.00,770.00,1,1,now()),
('2018-06-26',200.00,100.00,469.00,1,1,now()),
('2018-06-27',200.00,100.00,912.00,1,1,now()),
('2018-06-28',200.00,100.00,815.00,1,1,now()),
('2018-06-29',200.00,100.00,1142.00,1,1,now()),
('2018-06-30',200.00,100.00,725.00,1,1,now()),
('2018-07-01',200.00,100.00,0.00,1,1,now()),
('2018-07-02',200.00,100.00,656.00,1,1,now()),
('2018-07-03',200.00,100.00,749.00,1,1,now()),
('2018-07-04',200.00,100.00,0.00,1,1,now()),
('2018-07-05',200.00,100.00,492.00,1,1,now()),
('2018-07-06',200.00,100.00,800.00,1,1,now()),
('2018-07-07',200.00,100.00,726.00,1,1,now()),
('2018-07-08',200.00,100.00,0.00,1,1,now()),
('2018-07-09',200.00,100.00,431.00,1,1,now()),
('2018-07-10',200.00,100.00,451.00,1,1,now()),
('2018-07-11',200.00,100.00,375.00,1,1,now()),
('2018-07-12',200.00,100.00,472.00,1,1,now()),
('2018-07-13',200.00,100.00,874.00,1,1,now()),
('2018-07-14',200.00,100.00,1282.00,1,1,now()),
('2018-07-15',200.00,100.00,0.00,1,1,now()),
('2018-07-16',200.00,100.00,870.00,1,1,now()),
('2018-07-17',200.00,100.00,419.00,1,1,now()),
('2018-07-18',200.00,100.00,1254.00,1,1,now()),
('2018-07-19',200.00,100.00,1295.00,1,1,now()),
('2018-07-20',200.00,100.00,1069.00,1,1,now()),
('2018-07-21',200.00,100.00,973.00,1,1,now()),
('2018-07-22',200.00,100.00,0.00,1,1,now()),
('2018-07-23',200.00,100.00,898.00,1,1,now()),
('2018-07-24',200.00,100.00,980.00,1,1,now()),
('2018-07-25',200.00,100.00,1258.00,1,1,now()),
('2018-07-26',200.00,100.00,1285.00,1,1,now()),
('2018-07-27',200.00,100.00,1482.00,1,1,now()),
('2018-07-28',200.00,100.00,0.00,1,1,now()),
('2018-07-29',200.00,100.00,0.00,1,1,now()),
('2018-07-30',200.00,100.00,710.00,1,1,now()),
('2018-07-31',200.00,100.00,722.00,1,1,now()),
('2018-08-01',200.00,100.00,455.00,1,1,now()),
('2018-08-02',200.00,100.00,1270.00,1,1,now()),
('2018-08-03',200.00,100.00,1067.00,1,1,now()),
('2018-08-04',200.00,100.00,1283.00,1,1,now()),
('2018-08-05',200.00,100.00,0.00,1,1,now()),
('2018-08-06',200.00,100.00,1015.00,1,1,now()),
('2018-08-07',200.00,100.00,885.00,1,1,now()),
('2018-08-08',200.00,100.00,762.00,1,1,now()),
('2018-08-09',200.00,100.00,845.00,1,1,now()),
('2018-08-10',200.00,100.00,952.00,1,1,now()),
('2018-08-11',200.00,100.00,1650.00,1,1,now()),
('2018-08-12',200.00,100.00,0.00,1,1,now()),
('2018-08-13',200.00,100.00,1178.00,1,1,now()),
('2018-08-14',200.00,100.00,632.00,1,1,now()),
('2018-08-15',200.00,100.00,1000.00,1,1,now()),
('2018-08-16',200.00,100.00,985.00,1,1,now()),
('2018-08-17',200.00,100.00,1226.00,1,1,now()),
('2018-08-18',200.00,100.00,839.00,1,1,now()),
('2018-08-19',200.00,100.00,0.00,1,1,now()),
('2018-08-20',200.00,100.00,637.00,1,1,now()),
('2018-08-21',200.00,100.00,917.00,1,1,now()),
('2018-08-22',200.00,100.00,900.00,1,1,now()),
('2018-08-23',200.00,100.00,865.00,1,1,now()),
('2018-08-24',200.00,100.00,2526.00,1,1,now()),
('2018-08-25',200.00,100.00,190.00,1,1,now()),
('2018-08-26',200.00,100.00,0.00,1,1,now()),
('2018-08-27',200.00,100.00,992.00,1,1,now()),
('2018-08-28',200.00,100.00,736.00,1,1,now()),
('2018-08-29',200.00,100.00,1192.00,1,1,now()),
('2018-08-30',200.00,100.00,1209.00,1,1,now()),
('2018-08-31',200.00,100.00,966.00,1,1,now()),
('2018-09-01',200.00,100.00,1138.00,1,1,now()),
('2018-09-02',200.00,100.00,0.00,1,1,now()),
('2018-09-03',200.00,100.00,0.00,1,1,now()),
('2018-09-04',200.00,100.00,900.00,1,1,now()),
('2018-09-05',200.00,100.00,1055.00,1,1,now()),
('2018-09-06',200.00,100.00,943.00,1,1,now()),
('2018-09-07',200.00,100.00,1009.00,1,1,now()),
('2018-09-08',200.00,100.00,1455.00,1,1,now()),
('2018-09-09',200.00,100.00,0.00,1,1,now()),
('2018-09-10',200.00,100.00,1048.00,1,1,now()),
('2018-09-11',200.00,100.00,1582.00,1,1,now()),
('2018-09-12',200.00,100.00,1047.00,1,1,now()),
('2018-09-13',200.00,100.00,2865.00,1,1,now()),
('2018-09-14',200.00,100.00,1183.00,1,1,now()),
('2018-09-15',200.00,100.00,1403.00,1,1,now()),
('2018-09-16',200.00,100.00,325.00,1,1,now()),
('2018-09-17',200.00,100.00,821.00,1,1,now()),
('2018-09-18',200.00,100.00,663.00,1,1,now()),
('2018-09-19',200.00,100.00,1068.00,1,1,now()),
('2018-09-20',200.00,100.00,1831.00,1,1,now()),
('2018-09-21',200.00,100.00,1266.00,1,1,now()),
('2018-09-22',200.00,100.00,1060.00,1,1,now()),
('2018-09-23',200.00,100.00,0.00,1,1,now()),
('2018-09-24',200.00,100.00,997.00,1,1,now()),
('2018-09-25',200.00,100.00,1491.00,1,1,now()),
('2018-09-26',200.00,100.00,1005.00,1,1,now()),
('2018-09-27',200.00,100.00,1235.00,1,1,now()),
('2018-09-28',200.00,100.00,2669.00,1,1,now()),
('2018-09-29',200.00,100.00,844.00,1,1,now()),
('2018-09-30',200.00,100.00,0.00,1,1,now()),
('2018-10-01',200.00,100.00,841.00,1,1,now()),
('2018-10-02',200.00,100.00,1297.00,1,1,now()),
('2018-10-03',200.00,100.00,740.00,1,1,now()),
('2018-10-04',200.00,100.00,1338.00,1,1,now()),
('2018-10-05',200.00,100.00,840.00,1,1,now()),
('2018-10-06',200.00,100.00,1374.00,1,1,now()),
('2018-10-07',200.00,100.00,0.00,1,1,now()),
('2018-10-08',200.00,100.00,862.00,1,1,now()),
('2018-10-09',200.00,100.00,1561.00,1,1,now()),
('2018-10-10',200.00,100.00,1253.00,1,1,now()),
('2018-10-11',200.00,100.00,1673.00,1,1,now()),
('2018-10-12',200.00,100.00,1711.00,1,1,now()),
('2018-10-13',200.00,100.00,1417.00,1,1,now()),
('2018-10-14',200.00,100.00,0.00,1,1,now()),
('2018-10-15',200.00,100.00,709.00,1,1,now()),
('2018-10-16',200.00,100.00,1202.00,1,1,now()),
('2018-10-17',200.00,100.00,3165.00,1,1,now()),
('2018-10-18',200.00,100.00,913.00,1,1,now()),
('2018-10-19',200.00,100.00,2107.00,1,1,now()),
('2018-10-20',200.00,100.00,1428.00,1,1,now()),
('2018-10-21',200.00,100.00,0.00,1,1,now()),
('2018-10-22',200.00,100.00,635.00,1,1,now()),
('2018-10-23',200.00,100.00,2082.00,1,1,now()),
('2018-10-24',200.00,100.00,1217.00,1,1,now()),
('2018-10-25',200.00,100.00,1122.00,1,1,now()),
('2018-10-26',200.00,100.00,1504.00,1,1,now()),
('2018-10-27',200.00,100.00,2548.00,1,1,now()),
('2018-10-28',200.00,100.00,0.00,1,1,now()),
('2018-10-29',200.00,100.00,1592.00,1,1,now()),
('2018-10-30',200.00,100.00,1570.00,1,1,now()),
('2018-10-31',200.00,100.00,4728.00,1,1,now()),
('2018-11-01',200.00,100.00,1668.00,1,1,now()),
('2018-11-02',200.00,100.00,2413.00,1,1,now()),
('2018-11-03',200.00,100.00,1074.00,1,1,now()),
('2018-11-04',200.00,100.00,0.00,1,1,now()),
('2018-11-05',200.00,100.00,1005.00,1,1,now()),
('2018-11-06',200.00,100.00,1920.00,1,1,now()),
('2018-11-07',200.00,100.00,1082.00,1,1,now()),
('2018-11-08',200.00,100.00,1785.00,1,1,now()),
('2018-11-09',200.00,100.00,3208.00,1,1,now()),
('2018-11-10',200.00,100.00,617.00,1,1,now()),
('2018-11-11',200.00,100.00,0.00,1,1,now()),
('2018-11-12',200.00,100.00,943.00,1,1,now()),
('2018-11-13',200.00,100.00,1498.00,1,1,now()),
('2018-11-14',200.00,100.00,967.00,1,1,now()),
('2018-11-15',200.00,100.00,1680.00,1,1,now()),
('2018-11-16',200.00,100.00,1724.00,1,1,now()),
('2018-11-17',200.00,100.00,5290.00,1,1,now()),
('2018-11-18',200.00,100.00,0.00,1,1,now()),
('2018-11-19',200.00,100.00,1548.00,1,1,now()),
('2018-11-20',200.00,100.00,2507.00,1,1,now()),
('2018-11-21',200.00,100.00,10602.00,1,1,now()),
('2018-11-22',200.00,100.00,1215.00,1,1,now()),
('2018-11-23',200.00,100.00,862.00,1,1,now()),
('2018-11-24',200.00,100.00,1623.00,1,1,now()),
('2018-11-25',200.00,100.00,0.00,1,1,now()),
('2018-11-26',200.00,100.00,753.00,1,1,now()),
('2018-11-27',200.00,100.00,1292.00,1,1,now()),
('2018-11-28',200.00,100.00,1016.00,1,1,now()),
('2018-11-29',200.00,100.00,1798.00,1,1,now()),
('2018-11-30',200.00,100.00,2370.00,1,1,now()),
('2018-12-01',200.00,100.00,2835.00,1,1,now()),
('2018-12-02',200.00,100.00,0.00,1,1,now()),
('2018-12-03',200.00,100.00,2341.00,1,1,now()),
('2018-12-04',200.00,100.00,3827.00,1,1,now()),
('2018-12-05',200.00,100.00,1869.00,1,1,now()),
('2018-12-06',200.00,100.00,1982.00,1,1,now()),
('2018-12-07',200.00,100.00,2072.00,1,1,now()),
('2018-12-08',200.00,100.00,3026.00,1,1,now()),
('2018-12-09',200.00,100.00,0.00,1,1,now()),
('2018-12-10',200.00,100.00,6275.00,1,1,now()),
('2018-12-11',200.00,100.00,1888.00,1,1,now()),
('2018-12-12',200.00,100.00,1106.00,1,1,now()),
('2018-12-13',200.00,100.00,15232.00,1,1,now()),
('2018-12-14',200.00,100.00,2542.00,1,1,now()),
('2018-12-15',200.00,100.00,3498.00,1,1,now()),
('2018-12-16',200.00,100.00,0.00,1,1,now()),
('2018-12-17',200.00,100.00,2221.00,1,1,now()),
('2018-12-18',200.00,100.00,4743.00,1,1,now()),
('2018-12-19',200.00,100.00,3517.00,1,1,now()),
('2018-12-20',200.00,100.00,2821.00,1,1,now()),
('2018-12-21',200.00,100.00,10730.00,1,1,now()),
('2018-12-22',200.00,100.00,5916.00,1,1,now()),
('2018-12-23',200.00,100.00,3660.00,1,1,now()),
('2018-12-24',200.00,100.00,8510.00,1,1,now()),
('2018-12-25',200.00,100.00,0.00,1,1,now()),
('2018-12-26',200.00,100.00,1851.00,1,1,now()),
('2018-12-27',200.00,100.00,2740.00,1,1,now()),
('2018-12-28',200.00,100.00,1371.00,1,1,now()),
('2018-12-29',200.00,100.00,4079.00,1,1,now()),
('2018-12-30',200.00,100.00,0.00,1,1,now()),
('2018-12-31',200.00,100.00,6525.00,1,1,now()),
('2019-01-01',200.00,100.00,128.00,1,1,now()),
('2019-01-02',200.00,100.00,981.00,1,1,now()),
('2019-01-03',200.00,100.00,2099.00,1,1,now()),
('2019-01-04',200.00,100.00,1785.00,1,1,now()),
('2019-01-05',200.00,100.00,1488.00,1,1,now()),
('2019-01-06',200.00,100.00,0.00 ,1,1,now()),
('2019-01-07',200.00,100.00,1087.00,1,1,now()),
('2019-01-08',200.00,100.00,2434.00,1,1,now()),
('2019-01-09',200.00,100.00,778.00,1,1,now()),
('2019-01-10',200.00,100.00,1324.00,1,1,now()),
('2019-01-11',200.00,100.00,1949.00,1,1,now()),
('2019-01-12',200.00,100.00,2065.00,1,1,now()),
('2019-01-13',200.00,100.00,0.00 ,1,1,now()),
('2019-01-14',200.00,100.00,1484.00,1,1,now()),
('2019-01-15',200.00,100.00,1798.00,1,1,now()),
('2019-01-16',200.00,100.00,1283.00,1,1,now()),
('2019-01-17',200.00,100.00,2437.00,1,1,now()),
('2019-01-18',200.00,100.00,2701.00,1,1,now()),
('2019-01-19',200.00,100.00,6317.00,1,1,now()),
('2019-01-20',200.00,100.00,0.00 ,1,1,now()),
('2019-01-21',200.00,100.00,2384.00,1,1,now()),
('2019-01-22',200.00,100.00,533.00,1,1,now()),
('2019-01-23',200.00,100.00,1626.00,1,1,now()),
('2019-01-24',200.00,100.00,2116.00,1,1,now()),
('2019-01-25',200.00,100.00,3504.00,1,1,now()),
('2019-01-26',200.00,100.00,7303.00,1,1,now()),
('2019-01-27',200.00,100.00,0.00 ,1,1,now()),
('2019-01-28',200.00,100.00,3448.00,1,1,now()),
('2019-01-29',200.00,100.00,1667.00,1,1,now()),
('2019-01-30',200.00,100.00,1353.00,1,1,now()),
('2019-01-31',200.00,100.00,1485.00,1,1,now()),
('2019-02-01',200.00,100.00,2511.00,1,1,now()),
('2019-02-02',200.00,100.00,4562.00,1,1,now()),
('2019-02-03',200.00,100.00,0.00 ,1,1,now()),
('2019-02-04',200.00,100.00,3857.00,1,1,now()),
('2019-02-05',200.00,100.00,1797.00,1,1,now()),
('2019-02-06',200.00,100.00,1168.00,1,1,now()),
('2019-02-07',200.00,100.00,4087.00,1,1,now()),
('2019-02-08',200.00,100.00,3275.00,1,1,now()),
('2019-02-09',200.00,100.00,2037.00,1,1,now()),
('2019-02-10',200.00,100.00,0.00 ,1,1,now()),
('2019-02-11',200.00,100.00,3019.00,1,1,now()),
('2019-02-12',200.00,100.00,783.00,1,1,now()),
('2019-02-13',200.00,100.00,21928.00,1,1,now()),
('2019-02-14',200.00,100.00,38078.00,1,1,now()),
('2019-02-15',200.00,100.00,4249.00,1,1,now()),
('2019-02-16',200.00,100.00,1927.00,1,1,now()),
('2019-02-17',200.00,100.00,0.00 ,1,1,now()),
('2019-02-18',200.00,100.00,3430.00,1,1,now()),
('2019-02-19',200.00,100.00,1528.00,1,1,now()),
('2019-02-20',200.00,100.00,1209.00,1,1,now()),
('2019-02-21',200.00,100.00,1480.00,1,1,now()),
('2019-02-22',200.00,100.00,1185.00,1,1,now()),
('2019-02-23',200.00,100.00,3319.00,1,1,now()),
('2019-02-24',200.00,100.00,0.00 ,1,1,now()),
('2019-02-25',200.00,100.00,4612.00,1,1,now()),
('2019-02-26',200.00,100.00,1473.00,1,1,now()),
('2019-02-27',200.00,100.00,1662.00,1,1,now()),
('2019-02-28',200.00,100.00,1754.00,1,1,now()),
('2019-03-01',200.00,100.00,6126.00,1,1,now()),
('2019-03-02',200.00,100.00,2925.00,1,1,now()),
('2019-03-03',200.00,100.00,0.00 ,1,1,now()),
('2019-03-04',200.00,100.00,776.00,1,1,now()),
('2019-03-05',200.00,100.00,1337.00,1,1,now()),
('2019-03-06',200.00,100.00,1860.00,1,1,now()),
('2019-03-07',200.00,100.00,9552.00,1,1,now()),
('2019-03-08',200.00,100.00,6133.00,1,1,now()),
('2019-03-09',200.00,100.00,1411.00,1,1,now()),
('2019-03-10',200.00,100.00,0.00 ,1,1,now()),
('2019-03-11',200.00,100.00,1343.00,1,1,now()),
('2019-03-12',200.00,100.00,1424.00,1,1,now()),
('2019-03-13',200.00,100.00,8894.00,1,1,now()),
('2019-03-14',200.00,100.00,2030.00,1,1,now()),
('2019-03-15',200.00,100.00,2917.00,1,1,now()),
('2019-03-16',200.00,100.00,3009.00,1,1,now()),
('2019-03-17',200.00,100.00,0.00 ,1,1,now()),
('2019-03-18',200.00,100.00,1573.00,1,1,now()),
('2019-03-19',200.00,100.00,1977.00,1,1,now()),
('2019-03-20',200.00,100.00,1649.00,1,1,now()),
('2019-03-21',200.00,100.00,1888.00,1,1,now()),
('2019-03-22',200.00,100.00,1714.00,1,1,now()),
('2019-03-23',200.00,100.00,3759.00,1,1,now()),
('2019-03-24',200.00,100.00,0.00 ,1,1,now()),
('2019-03-25',200.00,100.00,1151.00,1,1,now()),
('2019-03-26',200.00,100.00,1729.00,1,1,now()),
('2019-03-27',200.00,100.00,1634.00,1,1,now()),
('2019-03-28',200.00,100.00,2236.00,1,1,now()),
('2019-03-29',200.00,100.00,4686.00,1,1,now()),
('2019-03-30',200.00,100.00,5261.00,1,1,now()),
('2019-03-31',200.00,100.00,0.00 ,1,1,now()),
('2019-04-01',200.00,100.00,1298.00,1,1,now()),
('2019-04-02',200.00,100.00,2240.00,1,1,now()),
('2019-04-03',200.00,100.00,1475.00,1,1,now()),
('2019-04-04',200.00,100.00,1612.00,1,1,now()),
('2019-04-05',200.00,100.00,2834.00,1,1,now()),
('2019-04-06',200.00,100.00,1872.00,1,1,now()),
('2019-04-07',200.00,100.00,0.00 ,1,1,now()),
('2019-04-08',200.00,100.00,1140.00,1,1,now()),
('2019-04-09',200.00,100.00,1335.00,1,1,now()),
('2019-04-10',200.00,100.00,1221.00,1,1,now()),
('2019-04-11',200.00,100.00,1769.00,1,1,now()),
('2019-04-12',200.00,100.00,3626.00,1,1,now()),
('2019-04-13',200.00,100.00,10390.00,1,1,now()),
('2019-04-14',200.00,100.00,0.00 ,1,1,now()),
('2019-04-15',200.00,100.00,2435.00,1,1,now()),
('2019-04-16',200.00,100.00,2207.00,1,1,now()),
('2019-04-17',200.00,100.00,2384.00,1,1,now()),
('2019-04-18',200.00,100.00,4469.00,1,1,now()),
('2019-04-19',200.00,100.00,7762.00,1,1,now()),
('2019-04-20',200.00,100.00,12379.00,1,1,now()),
('2019-04-21',200.00,100.00,0.00 ,1,1,now()),
('2019-04-22',200.00,100.00,840.00,1,1,now()),
('2019-04-23',200.00,100.00,1661.00,1,1,now()),
('2019-04-24',200.00,100.00,2411.00,1,1,now()),
('2019-04-25',200.00,100.00,2183.00,1,1,now()),
('2019-04-26',200.00,100.00,1724.00,1,1,now()),
('2019-04-27',200.00,100.00,2765.00,1,1,now()),
('2019-04-28',200.00,100.00,0.00 ,1,1,now()),
('2019-04-29',200.00,100.00,1716.00,1,1,now()),
('2019-04-30',200.00,100.00,2269.00,1,1,now()),
('2019-05-01',200.00,100.00,1178.00,1,1,now()),
('2019-05-02',200.00,100.00,1300.00,1,1,now()),
('2019-05-03',200.00,100.00,1768.00,1,1,now()),
('2019-05-04',200.00,100.00,2034.00,1,1,now()),
('2019-05-05',200.00,100.00,0.00 ,1,1,now()),
('2019-05-06',200.00,100.00,1400.00,1,1,now()),
('2019-05-07',200.00,100.00,1547.00,1,1,now()),
('2019-05-08',200.00,100.00,2425.00,1,1,now()),
('2019-05-09',200.00,100.00,3921.00,1,1,now()),
('2019-05-10',200.00,100.00,10491.00,1,1,now()),
('2019-05-11',200.00,100.00,26249.00,1,1,now()),
('2019-05-12',200.00,100.00,18571.00 ,1,1,now()),
('2019-05-13',200.00,100.00,1519.00,1,1,now()),
('2019-05-14',200.00,100.00,801.00,1,1,now()),
('2019-05-15',200.00,100.00,1823.00,1,1,now()),
('2019-05-16',200.00,100.00,1477.00,1,1,now()),
('2019-05-17',200.00,100.00,1763.00,1,1,now()),
('2019-05-18',200.00,100.00,2465.00,1,1,now()),
('2019-05-19',200.00,100.00,0.00 ,1,1,now()),
('2019-05-20',200.00,100.00,1741.00,1,1,now()),
('2019-05-21',200.00,100.00,1249.00,1,1,now()),
('2019-05-22',200.00,100.00,799.00,1,1,now()),
('2019-05-23',200.00,100.00,1618.00,1,1,now()),
('2019-05-24',200.00,100.00,1171.00,1,1,now()),
('2019-05-25',200.00,100.00,2074.00,1,1,now()),
('2019-05-26',200.00,100.00,0.00 ,1,1,now()),
('2019-05-27',200.00,100.00,0.00,1,1,now()),
('2019-05-28',200.00,100.00,1007.00,1,1,now()),
('2019-05-29',200.00,100.00,1357.00,1,1,now()),
('2019-05-30',200.00,100.00,2654.00,1,1,now()),
('2019-05-31',200.00,100.00,3340.00,1,1,now()),
('2019-06-01',200.00,100.00,1481.00,1,1,now()),
('2019-06-02',200.00,100.00,0.00 ,1,1,now()),
('2019-06-03',200.00,100.00,586.00,1,1,now()),
('2019-06-04',200.00,100.00,75.00,1,1,now()),
('2019-06-05',200.00,100.00,0.00,1,1,now()),
('2019-06-06',200.00,100.00,0.00,1,1,now()),
('2019-06-07',200.00,100.00,0.00,1,1,now()),
('2019-06-08',200.00,100.00,0.00,1,1,now()),
('2019-06-09',200.00,100.00,0.00 ,1,1,now())
;
        

UPDATE daily_revenues target_table
        INNER JOIN
    (SELECT 
        dr.id, drt.date_id, drt.merchandise,drt.wire,drt.delivery, sw.id AS StoreWeekID
    FROM
        daily_revenue_temp drt
    INNER JOIN dates_dim dd ON drt.date_id = dd.`date`
    INNER JOIN weeks w ON CASE
        WHEN dd.week_starting_monday = 53 THEN 52
        ELSE dd.week_starting_monday
    END = w.`number`
        AND dd.week_year = w.`year`
    INNER JOIN store_week sw ON w.id = sw.week_id AND sw.store_id = drt.store_id
    INNER JOIN daily_revenues dr ON sw.id = dr.store_week_id
        AND dr.dates_dim_date = drt.date_id) source_table ON target_table.id = source_table.id 
SET 
    target_table.wire = source_table.wire;
    target_table.merchandise = source_table.merchandise;
     target_table.delivery = source_table.delivery;
      

DROP TABLE `daily_revenue_temp`;
    
EOT;
        DB::unprepared($sql);

    }
}
