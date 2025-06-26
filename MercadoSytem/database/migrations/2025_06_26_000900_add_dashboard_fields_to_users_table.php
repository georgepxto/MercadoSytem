<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dashboard_name')->nullable()->after('name');
            $table->enum('user_type', ['common', 'admin'])->default('common')->after('dashboard_name');
            $table->boolean('has_dashboard_access')->default(true)->after('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dashboard_name', 'user_type', 'has_dashboard_access']);
        });
    }
};
