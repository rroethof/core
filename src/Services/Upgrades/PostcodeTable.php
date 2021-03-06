<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class PostcodeTable implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Schema::hasTable('postcodes')
            || Schema::hasColumn('postcodes', 'street');
    }

    public function migrateTable(): void
    {
        Schema::table('postcodes', function (Blueprint $table) {
            $table->string('street')->nullable()->after('city');
        });
    }
}
