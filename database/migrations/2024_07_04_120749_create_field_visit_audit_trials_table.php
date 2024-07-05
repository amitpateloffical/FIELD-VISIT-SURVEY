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
        Schema::create('field_visit_audit_trials', function (Blueprint $table) {
            $table->id();
            $table->string('FieldVisit_id');
            $table->string('activity_type');
            $table->longText('previous')->nullable();
            $table->string('stage')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('origin_state')->nullable();
            $table->text('change_to')->nullable();
            $table->text('change_from')->nullable();
            $table->text('action_name')->nullable();
            $table->string('user_role')->nullable();
            $table->string('action')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_visit_audit_trials');
    }
};
