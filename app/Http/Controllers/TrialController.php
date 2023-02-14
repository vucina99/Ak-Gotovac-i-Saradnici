<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrialResource;
use App\Models\_Case;
use App\Models\_Trial;
use App\Models\Institution;
use App\Models\User;
use Carbon\Carbon;
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

    public function createTrial(Request $request)
    {
        $createTrial = $this->trial->createTrial($request);

        if ($createTrial->status() !== 201) {
            return response()->json('Došlo je do greške', 400);
        }

        return response(new TrialResource($createTrial->original), $createTrial->status());
    }


    public function getTrials(Request $request)
    {
        $numberData = 25;
        $case_type_id = $request->caseType;
        $search = (object)$request->search;
        $page = $request->page;
        $trial = _Trial::where('date', $request->selected_date);
        $count = ceil($trial->count() / $numberData);
        if ($search->institution !== '' && $search->institution !== null) {
            $trial = $trial->where('institution_id', $search->institution['id']);
        }
        if ($search->time !== '' && $search->time !== null) {
            $time = date('H:i', strtotime(Carbon::parse($search->time)->addHour()));
            $trial = $trial->where('time', $time);
        }
        if ($search->number_office !== '' && $search->number_office !== null) {
            $trial = $trial->where('number_office', $search->number_office);
        }
        if ($search->person_1 !== '' && $search->person_1 !== null) {
            $trial = $trial->where('prosecutor', 'LIKE', '%' . $search->person_1['prosecutor'] . '%');
        }
        if ($search->person_2 !== '' && $search->person_2 !== null) {
            $trial = $trial->where('defendants', 'LIKE', '%' . $search->person_2['defendants'] . '%');
        }

        $trial = $trial->skip($page * $numberData)->take($numberData)->get();
        return response(['data' => TrialResource::collection($trial), 'count' => $count]);
    }


    public function getPersons(Request $request)
    {
        $tirals = _Trial::where('date', $request->selected_date);


        $person_1_list = (array)$tirals->select('prosecutor')->where("prosecutor", "!=", null)->distinct('prosecutor')->get()->toArray();
        $person_2_list = (array)$tirals->select('defendants')->where("defendants", "!=", null)->distinct('defendants')->get()->toArray();
        return response(['person_1_list' => $person_1_list, 'person_2_list' => $person_2_list]);
    }

}
