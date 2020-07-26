<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KomponenBiayaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        \DB::statement('DELETE FROM pe3_kombi'); 
        
        \DB::table('pe3_kombi')->insert([
            'id'=>"101",
            'nama'=>'BIAYA PENDAFTARAN + BIAYA FORMULIR',
            'periode'=>'sekali',
        ]);          

        \DB::table('pe3_kombi')->insert([
            'id'=>"102",
            'nama'=>'BIAYA DAFTAR ULANG MHS. BARU',
            'periode'=>'sekali',
        ]);          
    }
}
