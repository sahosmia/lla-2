<?php

namespace Modules\Courses\Observers;

use Modules\Courses\Models\Course;
use Illuminate\Support\Str;

class CourseObserver
{
    /**
     * Handle the Course "creating" event.
     *
     * @param  \Modules\Courses\Models\Course  $course
     * @return void
     */
    public function creating(Course $course)
    {
        if (empty($course->slug)) {
            $course->slug = Str::slug($course->title);
        }
        $course->slug = $this->uniqueSlug($course->slug);
    }

    /**
     * Handle the Course "updating" event.
     *
     * @param  \Modules\Courses\Models\Course  $course
     * @return void
     */
    public function updating(Course $course)
    {
        if ($course->isDirty('slug')) {
            $course->slug = $this->uniqueSlug($course->slug, $course->id);
        }
    }

    /**
     * Create unique slug automatically
     * @return string unique slug
     */
    protected function uniqueSlug($slug, $ignoreId = null)
    {
        $originalSlug = $slug;
        $counter = 1;
        while (Course::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, function ($query, $ignoreId) {
                return $query->where('id', '!=', $ignoreId);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    /**
     * Listen to the Course updated event.
     *
     * @param  \Modules\Courses\Models\Course $course
     * @return void
     */
    public function updated(Course $course): void {}
}
