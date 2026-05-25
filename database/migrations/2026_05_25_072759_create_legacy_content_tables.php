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
        if (! Schema::hasTable('announcements')) {
            Schema::create('announcements', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('bac_matters')) {
            Schema::create('bac_matters', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('file')->nullable();
                $table->string('link')->nullable();
                $table->enum('type', ['ITB', 'RFQ', 'NOA', 'NTP', 'Bid Bulletin', 'Bid Bulletin 2'])->nullable()->index();
                $table->timestamp('date')->nullable()->index();
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('photo');
                $table->string('link')->nullable();
                $table->string('title')->nullable();
                $table->longText('content')->nullable();
                $table->integer('office_id')->nullable()->index();
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('campuses')) {
            Schema::create('campuses', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('slug')->index();
                $table->longText('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('colleges')) {
            Schema::create('colleges', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('code');
                $table->string('name');
                $table->string('slug')->index();
                $table->string('banner')->nullable();
                $table->longText('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('downloadable_files')) {
            Schema::create('downloadable_files', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('slug')->index();
                $table->string('name');
                $table->string('link');
                $table->integer('office_id')->nullable()->index();
                $table->boolean('is_published')->nullable()->index();
                $table->timestamps();
                $table->string('type')->nullable()->index();
            });
        }

        if (! Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('photo')->nullable();
                $table->string('name');
                $table->string('slug')->index();
                $table->longText('description')->nullable();
                $table->string('location')->nullable();
                $table->dateTime('start_date')->nullable()->index();
                $table->dateTime('end_date')->nullable();
                $table->boolean('is_allday')->default(false);
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->longText('description')->nullable();
                $table->enum('type', ['event', 'facility'])->default('event')->index();
                $table->integer('office_id')->nullable()->index();
                $table->dateTime('date')->nullable()->index();
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('gallery_photos')) {
            Schema::create('gallery_photos', function (Blueprint $table) {
                $table->id();
                $table->string('photo');
                $table->longText('caption')->nullable();
                $table->integer('gallery_id')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('job_opportunities')) {
            Schema::create('job_opportunities', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('slug')->index();
                $table->longText('content');
                $table->timestamp('date')->useCurrent()->useCurrentOnUpdate()->index();
                $table->boolean('is_hiring')->default(false)->index();
                $table->boolean('is_published')->default(false)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->string('slug')->unique();
                $table->longText('short_description')->nullable();
                $table->longText('content');
                $table->string('photo')->nullable();
                $table->string('author')->nullable();
                $table->integer('office_id')->nullable()->index();
                $table->enum('type', ['news', 'announcement'])->default('news')->index();
                $table->boolean('is_published')->nullable()->index();
                $table->dateTime('date')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('news_views')) {
            Schema::create('news_views', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('news_id')->index();
                $table->unsignedInteger('views')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('offices')) {
            Schema::create('offices', function (Blueprint $table) {
                $table->id();
                $table->string('banner')->nullable();
                $table->string('code');
                $table->string('name');
                $table->string('slug')->index();
                $table->string('category')->nullable()->index();
                $table->longText('description')->nullable();
                $table->integer('campus_id')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('code')->nullable();
                $table->string('name');
                $table->string('loa')->nullable();
                $table->string('prospectus')->nullable();
                $table->longText('description')->nullable();
                $table->uuid('college_id')->nullable()->index();
                $table->uuid('campus_id')->index();
                $table->enum('degree_program', ['graduate studies', 'baccalaureate', 'associate'])->default('baccalaureate')->index();
                $table->boolean('is_archived')->default(false)->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('news_views');
        Schema::dropIfExists('news');
        Schema::dropIfExists('job_opportunities');
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('events');
        Schema::dropIfExists('downloadable_files');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('colleges');
        Schema::dropIfExists('campuses');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('bac_matters');
        Schema::dropIfExists('announcements');
    }
};
