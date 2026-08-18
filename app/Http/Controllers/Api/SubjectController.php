<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectGroupResource;
use App\Http\Resources\SubjectResource;
use App\Services\SubjectService;
use App\Traits\ApiResponser;

class SubjectController extends Controller
{
    use ApiResponser;

    public function getSubjectGroups()
    {
        $subjectGroups = (new SubjectService)->getSubjectGroups();
        return $this->success(data: SubjectGroupResource::collection($subjectGroups));
    }

    public function getSubjects()
    {
        $subjects = (new SubjectService)->getSubjects();
        return $this->success(data: SubjectResource::collection($subjects));
    }
}
