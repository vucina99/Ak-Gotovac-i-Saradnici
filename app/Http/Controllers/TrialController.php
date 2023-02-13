<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrialResource;
use App\Models\_Trial;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrialController extends Controller
{
    public $institution;
    public $user;
    public $trial;

    public function __construct()
    {
        $this->institution = new Institution();
        $this->user = new User();
        $this->trial = new _Trial();
    }

    public function view()
    {
        Session::put('create-case-or-trial', 'trial');
        return view('trial.index');
    }

    public function dateResult($date)
    {
        return view('trial.date_results', compact('date'));
    }

    public function getInstitutions()
    {
        $getInstitution = $this->institution->getAllInstitutions();
        return response($getInstitution, 200);
    }

    public function getUsers()
    {
        $getUsers = $this->user->getUsersWithOutAdmin();
        return response($getUsers, 200);
    }

    public function createTrial(Request $request){
        $createTrial = $this->trial->createTrial($request);

        if ($createTrial->status() !== 201) {
            return response()->json('Došlo je do greške', 400);
        }

        return response( new TrialResource( $createTrial->original) , $createTrial->status());
    }

}
