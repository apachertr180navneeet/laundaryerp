<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Services;
use App\Models\Service;
use App\Models\Discount;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetail;
use App\Models\Invoice;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        DB::table('roles')->updateOrInsert(['id' => 1], ['name' => 'admin', 'guard_name' => 'web']);
        DB::table('roles')->updateOrInsert(['id' => 2], ['name' => 'client', 'guard_name' => 'web']);

        // 2. Ensure Admin User
        User::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'mobile' => '9876543210',
                'role_id' => 1,
                'is_deleted' => 0,
            ]
        );

        // 3. Realistic Clients
        $clientsData = [
            ['name' => 'Rahul Sharma', 'mobile' => '9829012345', 'email' => 'rahul.sharma@example.com'],
            ['name' => 'Priya Patel', 'mobile' => '9829123456', 'email' => 'priya.patel@example.com'],
            ['name' => 'Amitabh Verma', 'mobile' => '9829234567', 'email' => 'amitabh.verma@example.com'],
            ['name' => 'Sneha Kulkarni', 'mobile' => '9829345678', 'email' => 'sneha.k@example.com'],
            ['name' => 'Vikram Rathore', 'mobile' => '9829456789', 'email' => 'vikram.rathore@example.com'],
            ['name' => 'Ananya Iyer', 'mobile' => '9829567890', 'email' => 'ananya.iyer@example.com'],
            ['name' => 'Rajesh Meena', 'mobile' => '9829678901', 'email' => 'rajesh.meena@example.com'],
            ['name' => 'Pooja Choudhary', 'mobile' => '9829789012', 'email' => 'pooja.c@example.com'],
            ['name' => 'Manish Gupta', 'mobile' => '9829890123', 'email' => 'manish.gupta@example.com'],
            ['name' => 'Kavita Joshi', 'mobile' => '9829901234', 'email' => 'kavita.joshi@example.com'],
            ['name' => 'Sunil Singhania', 'mobile' => '9782012345', 'email' => 'sunil.s@example.com'],
            ['name' => 'Neha Agrawal', 'mobile' => '9782123456', 'email' => 'neha.agrawal@example.com'],
            ['name' => 'Deepak Mathur', 'mobile' => '9782234567', 'email' => 'deepak.mathur@example.com'],
            ['name' => 'Ritu Saxena', 'mobile' => '9782345678', 'email' => 'ritu.saxena@example.com'],
            ['name' => 'Gaurav Bhatia', 'mobile' => '9782456789', 'email' => 'gaurav.b@example.com'],
        ];

        $clientUsers = [];
        foreach ($clientsData as $client) {
            $user = User::updateOrCreate(
                ['mobile' => $client['mobile']],
                [
                    'name' => $client['name'],
                    'email' => $client['email'],
                    'password' => Hash::make('password'),
                    'role_id' => 2,
                    'is_deleted' => 0,
                ]
            );
            $clientUsers[] = $user;
        }

        // 4. Categories
        $categoriesData = [
            ['name' => 'Men', 'short_name' => 'MN', 'status' => 1],
            ['name' => 'Women', 'short_name' => 'WM', 'status' => 1],
            ['name' => 'Kids', 'short_name' => 'KD', 'status' => 1],
            ['name' => 'Household & Linen', 'short_name' => 'HL', 'status' => 1],
            ['name' => 'Footwear & Bags', 'short_name' => 'FB', 'status' => 1],
            ['name' => 'Laundry by Weight', 'short_name' => 'LW', 'status' => 1],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['name']] = Category::firstOrCreate(['name' => $c['name']], $c);
        }

        // 5. Services
        $servicesData = [
            ['name' => 'Dry Cleaning', 'short_name' => 'DC'],
            ['name' => 'Wash & Iron', 'short_name' => 'WI'],
            ['name' => 'Steam Press', 'short_name' => 'SP'],
            ['name' => 'Wash & Fold', 'short_name' => 'WF'],
            ['name' => 'Shoe Spa', 'short_name' => 'SS'],
            ['name' => 'Stain Treatment', 'short_name' => 'ST'],
        ];

        $services = [];
        foreach ($servicesData as $s) {
            $services[$s['name']] = Services::firstOrCreate(['name' => $s['name']], $s);
            Service::firstOrCreate(['name' => $s['name']]);
        }

        // 6. Discounts
        $discountsData = [
            ['name' => 'No Discount', 'amount' => 0.00],
            ['name' => 'First Order (10% Off)', 'amount' => 10.00],
            ['name' => 'Weekend Special (15% Off)', 'amount' => 15.00],
            ['name' => 'VIP Member (20% Off)', 'amount' => 20.00],
        ];

        $discounts = [];
        foreach ($discountsData as $d) {
            $discounts[] = Discount::firstOrCreate(['name' => $d['name']], $d);
        }

        // 7. Garment Catalog Items & Item Details (Rates)
        $catalog = [
            [
                'name' => 'Formal Shirt',
                'details' => [
                    ['category' => 'Men', 'service' => 'Dry Cleaning', 'price' => 110.00],
                    ['category' => 'Men', 'service' => 'Wash & Iron', 'price' => 70.00],
                    ['category' => 'Men', 'service' => 'Steam Press', 'price' => 40.00],
                ]
            ],
            [
                'name' => 'Trousers / Chinos',
                'details' => [
                    ['category' => 'Men', 'service' => 'Dry Cleaning', 'price' => 130.00],
                    ['category' => 'Men', 'service' => 'Wash & Iron', 'price' => 80.00],
                    ['category' => 'Men', 'service' => 'Steam Press', 'price' => 45.00],
                ]
            ],
            [
                'name' => 'Suit (2 Piece)',
                'details' => [
                    ['category' => 'Men', 'service' => 'Dry Cleaning', 'price' => 380.00],
                    ['category' => 'Men', 'service' => 'Steam Press', 'price' => 150.00],
                ]
            ],
            [
                'name' => 'Blazer / Coat',
                'details' => [
                    ['category' => 'Men', 'service' => 'Dry Cleaning', 'price' => 250.00],
                    ['category' => 'Men', 'service' => 'Steam Press', 'price' => 90.00],
                ]
            ],
            [
                'name' => 'Designer Saree',
                'details' => [
                    ['category' => 'Women', 'service' => 'Dry Cleaning', 'price' => 280.00],
                    ['category' => 'Women', 'service' => 'Steam Press', 'price' => 100.00],
                    ['category' => 'Women', 'service' => 'Wash & Iron', 'price' => 180.00],
                ]
            ],
            [
                'name' => 'Salwar Kurta Set',
                'details' => [
                    ['category' => 'Women', 'service' => 'Dry Cleaning', 'price' => 220.00],
                    ['category' => 'Women', 'service' => 'Wash & Iron', 'price' => 120.00],
                    ['category' => 'Women', 'service' => 'Steam Press', 'price' => 60.00],
                ]
            ],
            [
                'name' => 'Winter Jacket / Hoodie',
                'details' => [
                    ['category' => 'Men', 'service' => 'Dry Cleaning', 'price' => 320.00],
                    ['category' => 'Women', 'service' => 'Dry Cleaning', 'price' => 300.00],
                ]
            ],
            [
                'name' => 'Double Bedsheet & Pillows',
                'details' => [
                    ['category' => 'Household & Linen', 'service' => 'Wash & Iron', 'price' => 190.00],
                    ['category' => 'Household & Linen', 'service' => 'Dry Cleaning', 'price' => 250.00],
                ]
            ],
            [
                'name' => 'Heavy Blanket / Quilt',
                'details' => [
                    ['category' => 'Household & Linen', 'service' => 'Dry Cleaning', 'price' => 450.00],
                ]
            ],
            [
                'name' => 'Sneakers / Leather Shoes',
                'details' => [
                    ['category' => 'Footwear & Bags', 'service' => 'Shoe Spa', 'price' => 350.00],
                ]
            ],
            [
                'name' => 'Laundry By Weight',
                'details' => [
                    ['category' => 'Laundry by Weight', 'service' => 'Wash & Fold', 'price' => 95.00],
                ]
            ],
        ];

        $items = [];
        foreach ($catalog as $catItem) {
            $item = Item::firstOrCreate(['name' => $catItem['name']], ['image' => null]);
            $items[$catItem['name']] = $item;

            foreach ($catItem['details'] as $detail) {
                ItemDetail::updateOrCreate(
                    [
                        'item_id' => $item->id,
                        'category' => $detail['category'],
                        'service' => $detail['service']
                    ],
                    [
                        'price' => $detail['price']
                    ]
                );
            }
        }

        // 8. Orders Generation (25 Orders across dates)
        $statuses = ['pending', 'delivered', 'delivered', 'delivered', 'pending'];
        $timeSlots = ['10:00 AM - 01:00 PM', '01:00 PM - 04:00 PM', '04:00 PM - 07:00 PM'];
        $paymentMethods = ['UPI', 'Cash', 'UPI', 'Card'];

        $today = Carbon::today();

        for ($i = 1; $i <= 25; $i++) {
            $user = $clientUsers[($i - 1) % count($clientUsers)];

            // Distribution of dates: 6 today, 7 within last 3 days, 12 over past 15 days
            if ($i <= 6) {
                $orderDate = $today->copy();
            } elseif ($i <= 13) {
                $orderDate = $today->copy()->subDays(rand(1, 3));
            } else {
                $orderDate = $today->copy()->subDays(rand(4, 15));
            }

            $deliveryDate = $orderDate->copy()->addDays(rand(2, 4));
            $isToday = $orderDate->isToday();
            
            // Status: today orders are usually pending, older ones mostly delivered
            if ($isToday) {
                $status = ($i % 3 == 0) ? 'delivered' : 'pending';
            } else {
                $status = ($i % 4 == 0) ? 'pending' : 'delivered';
            }

            $orderNumber = 'WF-' . $orderDate->format('ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $invoiceNumber = 'INV-' . $orderDate->format('ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            // Select 2 to 4 items for this order
            $numItems = rand(2, 4);
            $selectedItemKeys = array_rand($items, $numItems);
            if (!is_array($selectedItemKeys)) {
                $selectedItemKeys = [$selectedItemKeys];
            }

            $totalQty = 0;
            $grossTotal = 0;
            $orderItemsToInsert = [];

            foreach ($selectedItemKeys as $key) {
                $itemObj = $items[$key];
                $itemDetail = ItemDetail::where('item_id', $itemObj->id)->first();
                $qty = rand(1, 3);
                $unitPrice = $itemDetail ? (float)$itemDetail->price : 120.00;
                $lineTotal = $qty * $unitPrice;

                $totalQty += $qty;
                $grossTotal += $lineTotal;

                $orderItemsToInsert[] = [
                    'product_item_id' => $itemObj->id,
                    'product_category_id' => 1,
                    'operation_id' => 1,
                    'operation_price' => $unitPrice,
                    'price' => $lineTotal,
                    'quantity' => $qty,
                    'status' => $status,
                    'unit' => 'Pc',
                    'weight' => null,
                ];
            }

            // Discount
            $discountObj = $discounts[rand(0, count($discounts) - 1)];
            $discountPct = (float)$discountObj->amount;
            $discountAmt = round($grossTotal * ($discountPct / 100), 2);
            $netTotal = round($grossTotal - $discountAmt, 2);

            $order = Order::updateOrCreate(
                ['order_number' => $orderNumber],
                [
                    'user_id' => $user->id,
                    'invoice_number' => $invoiceNumber,
                    'order_date' => $orderDate->format('Y-m-d'),
                    'order_time' => '11:' . str_pad(rand(10, 55), 2, '0', STR_PAD_LEFT) . ' AM',
                    'delivery_date' => $deliveryDate->format('Y-m-d'),
                    'delivery_time' => $timeSlots[array_rand($timeSlots)],
                    'discount_id' => $discountObj->id,
                    'service_id' => 1,
                    'status' => $status,
                    'total_qty' => $totalQty,
                    'total_price' => $netTotal,
                    'is_deleted' => 0,
                    'express_charge' => 0,
                ]
            );

            // Insert Order Items
            OrderItem::where('order_id', $order->id)->delete();
            foreach ($orderItemsToInsert as $oi) {
                $oi['order_id'] = $order->id;
                OrderItem::create($oi);
            }

            // Payment Detail
            $payType = $paymentMethods[array_rand($paymentMethods)];
            PaymentDetail::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'total_amount' => $netTotal,
                    'payment_type' => $payType,
                    'payment_status' => ($status === 'delivered') ? 'Paid' : 'Pending',
                ]
            );

            // Invoice
            Invoice::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'invoice_number' => $invoiceNumber,
                ]
            );
        }
    }
}
