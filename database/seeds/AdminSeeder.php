<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\User;
        $administrator->username = 'admin';
        $administrator->name = 'YouuDan';
        $administrator->email = 'admin@youudan.test';
        $administrator->roles = json_encode(['ADMIN']);
        $administrator->password = \Hash::make('admin');
        $administrator->avatar = 'tar-aja-photonya.png';
        $administrator->address = 'Cipongkor, Bandung Barat, Jawa Barat';
        $administrator->phone = '087823331789';
        $administrator->status = 'ACTIVE';
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }
}
