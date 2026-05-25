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
        if (! Schema::hasTable('content_pages')) {
            Schema::create('content_pages', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('section')->nullable()->index();
                $table->longText('body')->nullable();
                $table->text('excerpt')->nullable();
                $table->string('status')->default('draft')->index();
                $table->boolean('is_published')->default(false)->index();
                $table->dateTime('published_at')->nullable()->index();
                $table->unsignedBigInteger('office_id')->nullable()->index();
                $table->uuid('campus_id')->nullable()->index();
                $table->string('legacy_table')->nullable()->index();
                $table->string('legacy_id')->nullable()->index();
                $table->unsignedInteger('sort_order')->default(0)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('navigation_items')) {
            Schema::create('navigation_items', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('parent_id')->nullable()->index();
                $table->string('location')->index();
                $table->string('label');
                $table->string('url')->nullable();
                $table->string('route_name')->nullable();
                $table->string('target_type')->nullable()->index();
                $table->string('target_id')->nullable()->index();
                $table->unsignedInteger('sort_order')->default(0)->index();
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('media_assets')) {
            Schema::create('media_assets', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('disk')->default('public')->index();
                $table->string('path')->index();
                $table->string('url')->nullable();
                $table->string('title')->nullable();
                $table->string('alt_text')->nullable();
                $table->string('mime_type')->nullable()->index();
                $table->unsignedBigInteger('size')->nullable();
                $table->string('legacy_path')->nullable()->index();
                $table->boolean('is_published')->default(true)->index();
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('office_profiles')) {
            Schema::create('office_profiles', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('office_id')->nullable()->unique();
                $table->unsignedBigInteger('parent_office_id')->nullable()->index();
                $table->string('vp_cluster')->nullable()->index();
                $table->longText('short_background')->nullable();
                $table->string('unit_head')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('address')->nullable();
                $table->json('services')->nullable();
                $table->string('status')->default('draft')->index();
                $table->boolean('is_published')->default(false)->index();
                $table->dateTime('published_at')->nullable()->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('program_details')) {
            Schema::create('program_details', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('program_id')->nullable()->unique();
                $table->longText('objectives')->nullable();
                $table->longText('learning_outcomes')->nullable();
                $table->longText('curriculum')->nullable();
                $table->uuid('prospectus_file_id')->nullable()->index();
                $table->longText('admission_requirements')->nullable();
                $table->string('status')->default('draft')->index();
                $table->boolean('is_published')->default(false)->index();
                $table->dateTime('published_at')->nullable()->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('campus_profiles')) {
            Schema::create('campus_profiles', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('campus_id')->nullable()->unique();
                $table->string('director')->nullable();
                $table->json('contact_details')->nullable();
                $table->longText('facilities')->nullable();
                $table->longText('services')->nullable();
                $table->longText('campus_life')->nullable();
                $table->longText('student_government')->nullable();
                $table->string('status')->default('draft')->index();
                $table->boolean('is_published')->default(false)->index();
                $table->dateTime('published_at')->nullable()->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('site_metrics')) {
            Schema::create('site_metrics', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('label');
                $table->string('value');
                $table->string('scope')->default('system')->index();
                $table->uuid('campus_id')->nullable()->index();
                $table->string('academic_year')->nullable()->index();
                $table->unsignedInteger('sort_order')->default(0)->index();
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_metrics');
        Schema::dropIfExists('campus_profiles');
        Schema::dropIfExists('program_details');
        Schema::dropIfExists('office_profiles');
        Schema::dropIfExists('media_assets');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('content_pages');
    }
};
