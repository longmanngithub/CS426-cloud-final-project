<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('email', 200)->unique();
            $table->string('password', 200);
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('phone_number', 100)->nullable();
            $table->date('date_of_birth');
            $table->timestamps();
        });

        // Organizers table
        Schema::create('organizers', function (Blueprint $table) {
            $table->id('organizer_id');
            $table->string('email', 200)->unique();
            $table->string('password', 200);
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('phone_number', 100)->nullable();
            $table->date('date_of_birth');
            $table->string('organization_name', 200);
            $table->string('company_name', 200)->nullable();
            $table->string('website', 200)->nullable();
            $table->string('business_reg_no', 100)->nullable();
            $table->timestamps();
        });

        // Categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('name', 100)->unique();
            $table->timestamps();
        });

        // Events table
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->unsignedBigInteger('organizer_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('location', 200);
            $table->string('link', 200)->nullable();
            $table->string('picture_url', 200)->nullable();
            $table->timestamps();
            $table->foreign('organizer_id')->references('organizer_id')->on('organizers')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null');
        });

        // Favorite events table
        Schema::create('favorite_events', function (Blueprint $table) {
            $table->id('favorite_event_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->timestamp('favorited_at')->useCurrent();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
        });

        // User admin table
        Schema::create('user_admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('email', 200)->unique();
            $table->string('password', 200);
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('phone_number', 100)->nullable();
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_events');
        Schema::dropIfExists('events');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('organizers');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_admin');
    }
};
