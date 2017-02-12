<?php

use Illuminate\Database\Seeder;

class PhasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('phases');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $table->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            [
                'name' => 'Phase 1',
                'count' => 1,
            ],
            [
                'name' => 'Phase 2',
                'count' => 2,
            ],
            [
                'name' => 'Phase 3',
                'count' => 3,
            ],
        ];

        $ins_array = [];
        foreach($data as $key => $val) {
            $ins_array[] = [
                'name' => $val['name'],
                'count' => $val['count'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $table->insert($ins_array);
    }
}
