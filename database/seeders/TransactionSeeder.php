<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::where('is_active', true)->get();

        $customers = [
            'Ibu Siti Rahayu', 'Bapak Ahmad Yusuf', 'Ni Wayan Suka', 'Bapak Hadi Pranoto',
            'Ibu Diah Permata', 'Bapak Joko Santoso', 'Ibu Rina Wulandari', 'Bapak Agus Suwarno',
            'Ibu Lestari', 'Bapak Budi Hartono', 'Ibu Maya Sari', 'Bapak Eko Wibowo',
            'Ibu Fitri Ammon', 'Bapak Rudi Hermanto', 'Ibu Yuni Astuti'
        ];

        $paymentMethods = ['cash', 'cash', 'cash', 'cash', 'transfer'];

        // Generate transactions for the past 3 months
        $transactions = [];
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        for ($i = 0; $i < 150; $i++) {
            $date = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            )->setTime(
                rand(8, 20), // hour 8 AM to 8 PM
                rand(0, 59),
                rand(0, 59)
            );

            $customer = $customers[array_rand($customers)];
            $user = $users->random();
            $numItems = rand(1, 4);

            // Select random products
            $selectedProducts = $products->random($numItems)->all();

            $total = 0;
            $itemsData = [];

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $unitPrice = $product->selling_price;
                $subtotal = $qty * $unitPrice;
                $total += $subtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            // Round total to nearest 100 or 500
            $total = ceil($total / 100) * 100;

            // Payment amount - ensure enough or more
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $paidAmount = $total + rand(0, 50000);

            // If paying exactly or close
            if (rand(0, 100) > 70) {
                $paidAmount = $total;
            }

            $change = $paidAmount - $total;

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'total' => $total,
                'paid_amount' => $paidAmount,
                'change_amount' => $change,
                'transaction_date' => $date,
            ]);

            foreach ($itemsData as $itemData) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $itemData['product_id'],
                    'qty' => $itemData['qty'],
                    'unit_price' => $itemData['unit_price'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                // Update stock
                $product = Product::find($itemData['product_id']);
                if ($product) {
                    $product->decrement('stock', $itemData['qty']);
                }
            }
        }

        $this->command->info('Berhasil membuat 150 transaksi dengan ' . count($selectedProducts ?? []) . ' produk.');
    }
}
