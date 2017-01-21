<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('roles');
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      $table->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS = 1');

      $data = [
          'D.L.S.P Head',
          'L.I.F.E. Director',
          'Executive Commitee',
          'Champion',
          'Finance Employee',
          'Volunteer',
      ];

      $ins_array = [];
      foreach($data as $key => $val) {
          $ins_array[] = [
              'name' => $val,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s'),
          ];
      }

      $table->insert($ins_array);
    }
}
