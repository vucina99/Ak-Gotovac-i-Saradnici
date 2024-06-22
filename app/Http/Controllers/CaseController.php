<?php

namespace App\Http\Controllers;

use App\Http\Resources\CaseResource;
use App\Http\Resources\CaseTypeResource;
use App\Http\Resources\InstitutionResource;
use App\Models\_Case;
use App\Models\CaseFile;
use App\Models\CaseType;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CaseController extends Controller
{
    public $caseType;
    public $case;
    public $caseFile;

    public function __construct()
    {
        $this->caseType = new CaseType();
        $this->case = new _Case();
        $this->caseFile = new CaseFile();
    }

    public function view()
    {
        Session::put('create-case-or-trial', 'case');
        return view('case.index');
    }

    public function getCaseTypes()
    {
        $caseTypes = $this->caseType->getCaseTypes();
        return response(CaseTypeResource::collection($caseTypes));;
    }

    public function getCases(Request $request)
    {
        $numberData = 25;
        $case_type_id = $request->caseType;
        $search = (object)$request->search;
        $page = $request->page;
        $cases = _Case::where('case_type_id', $case_type_id);
        if ($search->institution !== '' && $search->institution !== null) {
            $cases = $cases->where('institution_id', $search->institution['id']);
        }
        if ($search->institution_number !== '' && $search->institution_number !== null) {
            $cases = $cases->where('number_institution', 'LIKE', '%' . $search->institution_number. '%');
        }
        if ($search->number_office !== '' && $search->number_office !== null) {
            $cases = $cases->where('number_office',  'LIKE', '%' .$search->number_office. '%');
        }
        if ($search->person_1 !== '' && $search->person_1 !== null) {
            $cases = $cases->where('prosecutor', 'LIKE', '%' . $search->person_1['prosecutor'] . '%');
        }
        if ($search->person_2 !== '' && $search->person_2 !== null) {
            $cases = $cases->where('defendants', 'LIKE', '%' . $search->person_2['defendants'] . '%');
        }
        if ($search->archive !== '' && $search->archive !== null) {
            $cases = $cases->where('archive',  'LIKE', '%' .$search->archive. '%');
        }

        $count = ceil($cases->count() / $numberData);
        $cases = $cases->orderBy(DB::raw('CAST(number_office AS SIGNED)'), 'ASC')->skip($page * $numberData)->take($numberData)->get();

        return response(['data' => CaseResource::collection($cases), 'count' => $count]);
    }

    public function getInstitutions(Request $request)
    {
        $institution = Institution::orderBy('name')->whereIn('institution_type_id', $request->institutionsType)->get();
        return response(InstitutionResource::collection($institution));
    }

    public function getPersons(Request $request)
    {
        $case = _Case::where('case_type_id', $request->case_type_id);
//        $person_1_list = (array)   array_unique( array_filter($case->pluck('prosecutor')->toArray()) );
//        $person_2_list = (array) array_unique(array_filter($case->pluck('defendants')->toArray()));

        $person_1_list = (array)$case->select('prosecutor')->where("prosecutor", "!=", null)->distinct('prosecutor')->get()->toArray();
        $person_2_list = (array)$case->select('defendants')->where("defendants", "!=", null)->distinct('defendants')->get()->toArray();
        return response(['person_1_list' => $person_1_list, 'person_2_list' => $person_2_list]);
    }

    public function createCase(Request $request)
    {
        $createCase = $this->case->createCase($request);

        if ($createCase->status() !== 200) {
            return response()->json('Došlo je do greške', 400);
        }
        return response(new CaseResource($createCase->original), 201);
    }

    public function filesUpload(Request $request)
    {
        $data = [];
        if ($request->hasfile('files')) {

            foreach ($request->file('files') as $file) {
                $nameOriginalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-G-' . date('Y-m-d') . '-' . rand(10, 100000) . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                Storage::disk('s3')->put($name, file_get_contents($file));

                $file = new CaseFile();
                $file->name = $name;
                $file->path = $nameOriginalName;
                $file->upload_date = date('Y-m-d');
                $file->save();
                $data[] = $file->id;
            }
        }

        return response(['ids' => $data]);
    }

    public function updateFiles(Request $request)
    {

        if (count($request->dataUploadedID) > 0) {
            foreach ($request->dataUploadedID as $data) {
                $file = CaseFile::find($data);

                if ($file) {
                    $file->case_id = $request->case_id;
                    $file->save();
                }
            }
        }
        return response('{}', 204);
    }

    public function getCaseById($id)
    {
        if (is_numeric($id)) {
            $caseAndFiles = $this->case->getCaseById($id);
            return $caseAndFiles;
        } else {
            return [];
        }
    }

    public function removeFile($id)
    {
        if (is_numeric($id)) {
            $caseFileFromID = CaseFile::find($id);

            if (!$caseFileFromID) {
                return response('{}', 404);
            }

            $removeFile = $this->caseFile->removeFile($caseFileFromID);

            if ($removeFile->status() == 204) {
                $caseFileFromID->delete();
            }


            return response('{}', 204);

        }

        return response('Došlo je do greške', 500);
    }




    public function updateFilePath($id, Request $request)
    {

        if (is_numeric($id)) {
            $caseFile = CaseFile::find($id);

            if (!$caseFile) {

                return response('{}', 404);
            }
            $caseFile->path = $request->path;
            $caseFile->save();



            return response('{}', 204);

        }

        return response('Došlo je do greške', 500);
    }




    public function updateCase($id, Request $request)
    {

        if (is_numeric($id)) {
            $case = _Case::find($id);

            if (!$case) {

                return response('{}', 404);
            }


            $updateCase = $this->case->editCase($case, $request);

            return response('{}', 204);

        }

        return response('Došlo je do greške', 500);
    }


    public function deleteCase($id)
    {
        if (is_numeric($id)) {
            $case = _Case::find($id);

            if (!$case) {
                return response('{}', 404);
            }

            foreach ($case->case_files as $file) {
                $removeFile = $this->caseFile->removeFile($file);
                if ($removeFile->status() == 204) {
                    $file->delete();
                }

            }

            $updateCase = $this->case->deleteCase($case);

            return response('{}', 204);

        }

        return response('Došlo je do greške', 500);
    }
}
