<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $administrator = new \App\Models\User();
    $administrator->name = 'Admin';
    $administrator->email = 'admin@gmail.com';
    $administrator->roles = 'admin';
    $administrator->password = bcrypt('1');
    $administrator->save();
    $this->command->info('Data User Berhasil Di Insert !1');
  }
}