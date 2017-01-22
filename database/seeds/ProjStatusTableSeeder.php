<?php

use Illuminate\Database\Seeder;

class ProjStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('proj_status');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $table->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            'On-Going',
            'For Approval - Finance',
            'Completed',
            'Disapproved',
            'Approved',
            'For Approval - Life Director',
            'Incomplete'
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
