<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use DB;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    { 
        	DB::table('users')->insert([
            [
                'id'       => 1,
            	'name'     => 'secret',
                'kategori' => 'Admin',              
                'email'    => 'secret@gmail.com',
            	'password' => bcrypt('secret'),
                'email_verified_at' => '2024-01-03',
            ],
            [
                'id'       => 2,
                'name'     => 'boss',
                'kategori' => 'Pimpinan',              
                'email'    => 'pimpinan@gmail.com',
                'password' => bcrypt('secret'),
                'email_verified_at' => '2024-01-03',
            ],
            [
                'id'       => 3,
                'name'     => 'tamu',
                'kategori' => 'Tamu',              
                'email'    => 'tamu@gmail.com',
                'password' => bcrypt('secret'),
                'email_verified_at' => '2024-01-03',
            ],]);

            DB::table('periodes')->insert([
                ['id'       => 1,
                                'tahun'     => '123',
                                'nama' =>"Januari",],
                                ['id'       => 2,
                                'tahun'     => '2001',
                                'nama' =>"Mei",],

            ]);
            DB::table('devisis')->insert([
                [
                    'id'       => 1,
                    'periode'     => 1,
                    'nama' =>"Cuci"
                ],
                [
                    'id'       => 2,
                    'periode'     => 1,
                    'nama' =>"Strika"
                ],
                [
                    'id'       => 3,
                    'periode'     => 1,
                    'nama' =>"Packing"
                ],
                [
                    'id'       => 4,
                    'periode'     => 2,
                    'nama' =>"Cuci"
                ],
                [
                    'id'       => 5,
                    'periode'     => 2,
                    'nama' =>"Strika"
                ],
                [
                    'id'       => 6,
                    'periode'     => 2,
                    'nama' =>"Packing"
                ],
                 


            ]);
    }
} 
