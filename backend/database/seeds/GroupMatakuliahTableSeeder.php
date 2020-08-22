<?php

use Illuminate\Database\Seeder;

class GroupMatakuliahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('DELETE FROM pe3_group_matakuliah');
        
        \DB::table('pe3_group_matakuliah')->insert([
            'id_group'=>1,
            'nama_group'=>'MATAKULIAH PENGEMBANGAN KEAHLIAN',
            'group_alias'=>'MPK',
        ]);  

        \DB::table('pe3_group_matakuliah')->insert([
            'id_group'=>1,
            'nama_group'=>'MATAKULIAH KEAHLIAN KHUSUS',
            'group_alias'=>'MKK',
        ]);  
        
        \DB::table('pe3_group_matakuliah')->insert([
            'id_group'=>1,
            'nama_group'=>'MATAKULIAH KEAHLIAN BERKARYA',
            'group_alias'=>'MKB',
        ]);  

        \DB::table('pe3_group_matakuliah')->insert([
            'id_group'=>1,
            'nama_group'=>'MATAKULIAH PERILAKU BERAGAM',
            'group_alias'=>'MPB',
        ]);  

        \DB::table('pe3_group_matakuliah')->insert([
            'id_group'=>1,
            'nama_group'=>'MATAKULIAH BERKEHIDUPAN BERMASYARAKATA',
            'group_alias'=>'MBB',
        ]);  
        
    }
}
