<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('short_name')->nullable();
                $table->string('image')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('short_name')->nullable();
                $table->string('image')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('operations')) {
            Schema::create('operations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('discounts')) {
            Schema::create('discounts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('amount', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_items')) {
            Schema::create('product_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('name');
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_categories')) {
            Schema::create('product_categories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_item_id')->nullable();
                $table->unsignedBigInteger('operation_id')->nullable();
                $table->string('name');
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_types')) {
            Schema::create('product_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('invoice_number')->nullable();
                $table->string('order_number')->nullable();
                $table->date('order_date')->nullable();
                $table->string('order_time')->nullable();
                $table->date('delivery_date')->nullable();
                $table->string('delivery_time')->nullable();
                $table->unsignedBigInteger('discount_id')->nullable();
                $table->unsignedBigInteger('service_id')->nullable();
                $table->string('status')->default('pending');
                $table->integer('total_qty')->default(0);
                $table->decimal('total_price', 10, 2)->default(0);
                $table->tinyInteger('is_deleted')->default(0);
                $table->decimal('express_charge', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id')->nullable();
                $table->unsignedBigInteger('product_item_id')->nullable();
                $table->unsignedBigInteger('product_category_id')->nullable();
                $table->unsignedBigInteger('operation_id')->nullable();
                $table->decimal('operation_price', 10, 2)->default(0);
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('quantity')->default(1);
                $table->string('status')->default('pending');
                $table->string('unit')->nullable();
                $table->string('weight')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('lundary_order_item')) {
            Schema::create('lundary_order_item', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_item_id')->nullable();
                $table->string('ProductName')->nullable();
                $table->integer('ProductQty')->default(1);
                $table->unsignedBigInteger('ProductCategroyId')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('payment_details')) {
            Schema::create('payment_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id')->nullable();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->string('payment_type')->nullable();
                $table->string('payment_status')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id')->nullable();
                $table->string('invoice_number')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payment_details');
        Schema::dropIfExists('lundary_order_item');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_items');
        Schema::dropIfExists('products');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('operations');
        Schema::dropIfExists('services');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('roles');
    }
};

