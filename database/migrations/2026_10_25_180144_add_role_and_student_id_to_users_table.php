
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            !Schema::hasColumn('users', 'student_id') ||
            !Schema::hasColumn('users', 'role')
        ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'student_id')) {
                    $table->string('student_id')->nullable()->unique();
                }

                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('Student');
                }
            });
        }
    }

    public function down(): void
    {
        // Preserve existing columns and user data.
    }
};
