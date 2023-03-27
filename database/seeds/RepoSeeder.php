<?php

use App\Http\Models\Repositories;
use Illuminate\Config\Repository;
use Illuminate\Database\Seeder;

class RepoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100000; $i++) {
            Repositories::create(
                [
                    'name' => '870 Exchange Repository',
                    'type' => 'Exchange',
                    'used_space' => '0.046 GB',
                    'actions' => 'testing action',
                    'is_active' => false,
                ]
            );
            Repositories::create(
                [
                    'name' => '870 OneDrive Repository',
                    'type' => 'OneDrive',
                    'used_space' => '0.507 GB',
                    'actions' => 'testing action',
                    'is_active' => false,
                ]
            );
            Repositories::create(
                [
                    'name' => '870 SharePoint & Teams Repository',
                    'type' => 'SharePoint & Teams',
                    'used_space' => '1.561 GB',
                    'actions' => 'testing action',
                    'is_active' => false,
                ]
            );
        }
    }
}
