<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\service;
use App\Models\service_category;


class category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $category = ['Auto Repair','Bus Repair','Truck Repair','Car Repair'];
        $service   = ['Oil Change','AC Repair','washing','Tair Change','Seat Cover','break Repair'];
        
        service_category::truncate();
        service::truncate();

        foreach($category as $value)
        { 
            $data = new service_category();
            $data->name = $value;
            $data->save();

            foreach($service as $key)
            {
                $auto = new service();
                $auto->service_category_id = $data->id;
                $auto->service_name  = $key;
                $auto->save();
            }
        }
    }
}
