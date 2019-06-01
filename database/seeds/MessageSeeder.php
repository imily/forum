<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $sql = sprintf("
            INSERT INTO `Message`
            (`ixMessage`, `ixUser`, `sDescription`, `dtCreate`, `dtUpdate`)
            VALUES
            (1, 1, 'description01', '2011-11-11 00:00:00', '2011-11-12 00:00:00'),
            (2, 2, 'description02', '2011-11-12 00:00:00', '2011-11-13 00:00:00'),
            (3, 3, 'description03', '2011-11-13 00:00:00', '2011-11-14 00:00:00'),
            (4, 1, 'description04', '2011-11-14 00:00:00', '2011-11-15 00:00:00'),
            (5, 2, 'description05', '2011-11-15 00:00:00', '2011-11-16 00:00:00'),
            (6, 3, 'description06', '2011-11-16 00:00:00', '2011-11-17 00:00:00'),
            (7, 1, 'description07', '2011-11-17 00:00:00', '2011-11-18 00:00:00'),
            (8, 3, 'description08', '2011-11-18 00:00:00', '2011-11-19 00:00:00')");
        DB::insert($sql);
    }
}
