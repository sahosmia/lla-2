<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;

return new class extends Migration
{
    public function up(): void
    {
        $courseService = new CourseService();

        Course::query()->pluck('id')->each(function (int $courseId) use ($courseService) {
            $courseService->syncCourseContentLength($courseId);
        });
    }

    public function down(): void
    {
        // No rollback needed.
    }
};
