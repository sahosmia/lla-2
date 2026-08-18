<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Courses\Models\Curriculum;
use Modules\Courses\Models\Enrollment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    /**
     * Streams a curriculum video with proper HTTP Range (partial content)
     * support, so seeking works regardless of the underlying server
     * (php artisan serve does not support Range on statically-served files,
     * which made the player's progress bar / arrow-key seeking restart the
     * video instead of jumping to the requested time).
     */
    public function streamCurriculumVideo(Request $request, int $curriculumId)
    {
        $curriculum = Curriculum::with('section.course')->findOrFail($curriculumId);
        $course = $curriculum->section?->course;

        if (!$course) {
            abort(404);
        }

        $user = Auth::user();
        $hasAccess = $course->instructor_id === $user->id
            || Enrollment::query()
                ->where('course_id', $course->id)
                ->where('student_id', $user->id)
                ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $disk = Storage::disk(getStorageDisk());

        if (empty($curriculum->media_path) || !$disk->exists($curriculum->media_path)) {
            abort(404);
        }

        return response()->file($disk->path($curriculum->media_path), [
            'Content-Type' => 'video/mp4',
        ]);
    }

    public function play(Request $request, $path)
    {
        if (base64_decode($request->get('type')) == 'courses') {
            $relativePath = "courses/$path";
        } elseif (base64_decode($request->get('type')) == 'curriculum_videos') {
            $relativePath = "curriculum_videos/$path";
        } else {
            $relativePath = $path;
        }

        if (
            !Auth::check() || 
            !$request->hasValidSignature() || 
            !Storage::disk(getStorageDisk())->exists($relativePath) ||
            parse_url($request->headers->get('referer'), PHP_URL_HOST) !== parse_url(config('app.url'), PHP_URL_HOST)
            ) {
            abort(404);
        }   

        $path = Storage::disk(getStorageDisk())->path($relativePath);

        $stream = new StreamedResponse(function() use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        });

        $stream->headers->set('Content-Type', mime_content_type($path));
        $stream->headers->set('Content-Disposition', 'inline; filename="' . $path . '"');

        return $stream;
        
    }
}
