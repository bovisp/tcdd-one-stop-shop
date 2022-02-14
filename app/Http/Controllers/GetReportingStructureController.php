<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserReportingStructureRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepositoryContract;
use Inertia\Inertia;

class GetReportingStructureController extends Controller
{
    /** @var UserRepositoryContract */
    private $repo;

    public function __construct(UserRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(UserReportingStructureRequest $request, User $user)
    {
        /** @var User $user */
        $user = User::query()->with(['role', 'section', 'moodleInfo'])->find($user->id);

        $reportingStructure = $this->repo->getUserReportingStructure($user);

        return Inertia::render('ReportingStructure', [
            'profile' => UserResource::fromUser($user),
            'reporting_structure' => $reportingStructure->all(),
        ]);
    }
}
