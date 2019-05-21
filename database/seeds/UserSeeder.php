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
            (`ixUser`, `sUserName`, `sPassword`
            , `nStickerType`, `fAdmin`, `dtCreate`, `dtUpdate`)
            VALUES
            ('2', 'imily', '%s'
            , '3', 'false', '2011-11-11 00:00:00', '2011-11-11 00:00:00'),
            ('3', 'finch', '%s'
            , '1', 'false', '2011-11-12 00:00:00', '2011-11-12 00:00:00')"
            , User::hashPassword(1234)
            , User::hashPassword(1234));
        DB::insert($sql);
    }
}
