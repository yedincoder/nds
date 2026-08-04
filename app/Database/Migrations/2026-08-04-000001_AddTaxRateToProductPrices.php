<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTaxRateToProductPrices extends Migration
{
    public function up()
    {
        // Add tax_rate to product_prices
        $this->forge->addColumn('product_prices', [
            'tax_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
                'after' => 'discount_price'
            ],
        ]);

        // Add tax_rate to cart_items for individual tax calculation
        $this->forge->addColumn('cart_items', [
            'tax_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
                'after' => 'price'
            ],
            'tax_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0.00,
                'after' => 'tax_rate'
            ],
            'discount_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
                'after' => 'tax_amount'
            ],
            'discount_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0.00,
                'after' => 'discount_rate'
            ],
        ]);

        // Update existing product_prices with default 10% tax
        $this->db->table('product_prices')->update(['tax_rate' => 10.00]);
    }

    public function down()
    {
        $this->forge->dropColumn('product_prices', 'tax_rate');
        $this->forge->dropColumn('cart_items', 'tax_rate');
        $this->forge->dropColumn('cart_items', 'tax_amount');
        $this->forge->dropColumn('cart_items', 'discount_rate');
        $this->forge->dropColumn('cart_items', 'discount_amount');
    }
}
