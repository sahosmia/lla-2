<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecommendedTutor\RecommendedTutorResource;
use App\Http\Resources\FindTutors\TutorCollection;
use App\Http\Resources\TutorDetail\TutorDetailResource;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\User;
use App\Services\ProfileService;
use App\Services\SiteService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TutorController extends Controller
{
    use ApiResponser;

    public function __construct()
    {

        $token = request()->bearerToken();

        $sanctumToken = PersonalAccessToken::findToken($token) ?? null;

        if (!empty($sanctumToken) && $sanctumToken->expires_at && Carbon::parse($sanctumToken->expires_at)->isFuture()) {
            $this->middleware('auth:sanctum');
        }
    }

    public function getRecommendedTutors()
    {
        $recommendedTutors  = (new SiteService)->getRecommendedTutors(['order_by' => 'ratings', 'total' => 10]);
        $tutors             =  $this->getFavouriateTutors($recommendedTutors);
        return $this->success(data: RecommendedTutorResource::collection($tutors));
    }

    public function findTutots(Request $request)
    {
        $data               = $request->all();
        $findTutors         = (new SiteService)->getTutors($data);
        $tutorsCollection   = $findTutors->getCollection();
        $tutors             =  $this->getFavouriateTutors($tutorsCollection);
        $findTutors         = $findTutors->setCollection($tutors);

        return $this->success(data: new TutorCollection($findTutors));
    }

    public function getTutorDetail($slug)
    {
        $profile = Profile::whereSlug($slug)->first();
 
        if(!$profile){
            return $this->error(message: 'Tutor not found.',code: Response::HTTP_NOT_FOUND);
        }

        $tutor   = (new SiteService)->getTutorDetail($slug);

        if (!$tutor) {
            return $this->error(message: 'Tutor profile not verified.',code: Response::HTTP_UNAUTHORIZED);
        }

        $tutor      = $this->getFavouriateTutors($tutor);
        return $this->success(data: new TutorDetailResource($tutor));
    }

    public function getFavouriateTutors($tutors)
    {
        $favoritesTutor = [];
        if (Auth::check()) {
            $user           = Auth::user();
            $userService    = new UserService($user);
            $favoritesTutor = $userService->getFavouriteUsers()->get(['favourite_user_id'])?->pluck('favourite_user_id')->toArray();
        }

        if (is_array($tutors) || $tutors instanceof \Illuminate\Support\Collection) {
            $usersWithFavorites = $tutors->map(function ($user) use ($favoritesTutor) {
            $user->is_favorite  = in_array($user->id, $favoritesTutor);
            return $user;
        });
        } else {
            $user                   = $tutors;
            $user->is_favorite      = in_array($user->id, $favoritesTutor);
            $usersWithFavorites     = $user;
        }
        return $usersWithFavorites;
    }

    public function getStates(Request $request)
    {
        $countryId = $request?->country_id;
        $profileService = new ProfileService();
        $states = $profileService->countryStates($countryId);
        if($states->isEmpty()){
            return $this->error(data: null,message: __('api.no_states_found'),code: Response::HTTP_NOT_FOUND);
        }else{
            return $this->success(data: $states,message: __('api.states_fetched_successfully'));
        }
    }
}
