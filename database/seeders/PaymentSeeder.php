<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PaymentMethod::create([
            'method'=>'Esewa',
            'code'=>'ESW'
        ]);

        PaymentMethod::create([
            'method'=>'Khalti',
            'code'=>'KLT'
        ]);
    }
}
