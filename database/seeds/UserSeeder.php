<?php

use App\Classes\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $sql = sprintf("
            INSERT INTO `User`
            (`ixUser`, `sUserName`, `sPassword`, `nStickerType`, `fAdmin`, `sDescription`, `dtCreate`, `dtUpdate`)
            VALUES
            ('2', 'imily', '%s', '3', FALSE, '', '2011-11-11 00:00:00', '2011-11-12 00:00:00'),
            ('3', 'Mary', '%s', '1', FALSE, '', '2011-11-12 00:00:00', '2011-11-13 00:00:00'),
            ('4', 'Jessie', '%s', '2', FALSE, '', '2011-11-13 00:00:00', '2011-11-14 00:00:00')"
            , User::hashPassword(1234)
            , User::hashPassword(1234)
            , User::hashPassword(1234));
        DB::insert($sql);
    }
}
