<?php

namespace Database\Seeders;

use App\Models\BookingStatus;
use App\Models\OrderStatus;
use App\Models\VisitsStatus;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();
        BookingStatus::query()->truncate();
        OrderStatus::query()->truncate();
        VisitsStatus::query()->truncate();

        $bookingStatuses = [
            [
                'name_ar' => 'مؤكد',
                'name_en' => 'confirmed',
            ],
            [
                'name_ar' => 'ملغي',
                'name_en' => 'canceled',
            ]
        ];
        $orderStatuses = [
            [
                'name_ar' => 'مؤكد',
                'name_en' => 'confirmed',
            ],
            [
                'name_ar' => 'غير مؤكد',
                'name_en' => 'not confirmed',
            ],
            [
                'name_ar' => 'تحت الإجراء',
                'name_en' => 'under processing',
            ],
            [
                'name_ar' => 'مكتمل',
                'name_en' => 'complete',
            ],
            [
                'name_ar' => 'ملغي',
                'name_en' => 'canceled',
            ]
        ];
        $visitStatuses = [
            [
                'name_ar' => 'في الطريق',
                'name_en' => 'on way',
            ],
            [
                'name_ar' => 'تم البدء بالعمل',
                'name_en' => 'start working',
            ],
            [
                'name_ar' => 'تم التسليم',
                'name_en' => 'delivered handed',
            ],
            [
                'name_ar' => 'مكتمل',
                'name_en' => 'complete',
            ],
        ];

        foreach ($bookingStatuses as $bookingStatus){
            BookingStatus::query()->create($bookingStatus);
        }
        foreach ($orderStatuses as $orderStatus){
            OrderStatus::query()->create($orderStatus);
        }
        foreach ($visitStatuses as $visitStatus){
            VisitsStatus::query()->create($visitStatus);
        }
        \Schema::enableForeignKeyConstraints();
    }
}
