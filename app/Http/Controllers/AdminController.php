<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstitutionResource;
use App\Http\Resources\InstitutionTypeResource;
use App\Http\Resources\UserResource;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public $user;
    public $institutionType;
    public $institution;

    public function __construct()
    {
        $this->middleware('admin');
        $this->institutionType = new InstitutionType();
        $this->user = new User();
        $this->institution = new Institution();
    }

    public function institutions()
    {
        return view('admin.institutions');
    }

    public function staff()
    {
        return view('admin.staff');
    }

    public function createUser(Request $request)
    {
        $user = $this->user->createUser($request);
        if ($user->status() == 400) {
            return response()->json($user->original, 400);
        }
        return response(new UserResource($user->original));
    }

    public function getUsers()
    {
        $users = $this->user->getUsers();
        return response(UserResource::collection($users));;
    }

    public function deleteUser($id)
    {
        $user = $this->user->deleteUser($id);
        if ($user->status() == 204) {
            return response('{}', 204);
        }
        return response('nesto nije u redu', 404);
    }

    public function getType()
    {
        $institutionsType = $this->institutionType->getType();
        return response(InstitutionTypeResource::collection($institutionsType));
    }

    public function getInstitutions($page)
    {
        $numberData = 25;
        $institutions = $this->institution->getInstitutions($page, $numberData);
        $institutionsCount = ceil(Institution::count() / $numberData);
        return response(["data" => InstitutionResource::collection($institutions), "count" => $institutionsCount]);
    }

    public function createInstitution(Request $request)
    {
        $institution = $this->institution->createInstitution($request);
        if ($institution->status() == 400) {
            return response()->json($institution->original, 400);
        }
        return response(new InstitutionResource($institution->original));
    }

    public function updateActivationInstitution($id)
    {
        $institution = $this->institution->updateActivationInstitution($id);
        if ($institution->status() == 404) {
            return response()->json('', 404);
        }
        return response(new InstitutionResource($institution->original));
    }
}
