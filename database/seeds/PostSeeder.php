<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run()
    {
        $sql = sprintf("
            INSERT INTO `Post`
            (`ixPost`, `ixUser`, `sMessagePerson`, `sTopic`, `sDescription`
            , `sLikes`,  `dtCreate`, `dtUpdate`)
            VALUES
            (1, 1, '[1,2,3,5]',  'topic01', 'description01'
            , '[1,2,3]', '2011-11-11 00:00:00', '2011-11-12 00:00:00'),
            (2, 2, '[1,7,6]',  'topic02', 'description02'
            , '[1,2,3]', '2011-11-12 00:00:00', '2011-11-13 00:00:00'),            
            (3, 3, '[1,4,8]',  'topic03', 'description03'
            , '[1,2,3]', '2011-11-13 00:00:00', '2011-11-14 00:00:00'),
            (4, 2, '[1,2,3,5,8]',  'topic04', 'description04'
            , '[1,2,3]', '2011-11-14 00:00:00', '2011-11-15 00:00:00'),
            (5, 1, '[1,2,3,4]',  'topic05', 'description05'
            , '[2,3]', '2011-11-15 00:00:00', '2011-11-16 00:00:00'),
            (6, 3, '[1,5,8]',  'topic06', 'description06'
            , '[1,2]', '2011-11-16 00:00:00', '2011-11-17 00:00:00'),
            (7, 2, '[2,5,6]',  'topic07', 'description07'
            , '[1,2]', '2011-11-17 00:00:00', '2011-11-18 00:00:00')");
        DB::insert($sql);
    }
}
