<?php

namespace App\Models;

use App\Http\Resources\CaseFileResource;
use App\Http\Resources\CaseResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class _Case extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_office',
        'number_institution',
        'prosecutor',
        'defendants',
        'institution_id',
        'note',
        'mark',
        'fail_day',
        'case_type_id',
        'archive'
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function case_type()
    {
        return $this->belongsTo(CaseType::class);
    }

    public function case_files()
    {
        return $this->hasMany(CaseFile::class, "case_id");
    }

    public function createCase($request)
    {
        $institutionID = null;
        if ($request->institutions && $request->institutions !== null && $request->institutions !== '') {
            $institutionID = $request->institutions['id'];
        }

        $case = _Case::create([
            'number_office' => $request->number_office,
            'number_institution' => $request->number_court,
            'prosecutor' => $request->prosecutor,
            'defendants' => $request->defendants,
            'institution_id' => $institutionID,
            'note' => $request->notes,
            'mark' => $request->marks,
            'fail_day' => Carbon::parse($request->fail_day)->format('Y-m-d'),
            'case_type_id' => $request->case_type_id,
            'archive' => $request->archive
        ]);

        return response($case->refresh(), 200);
    }

    public function getCaseById($id)
    {
        $case = _Case::where("id", $id)->first();
        if (!$case) {
            $case = null;
        }
        $caseFiles = CaseFile::where("case_id", $id)->get();
        return response(['case' => new CaseResource($case), 'caseFiles' => CaseFileResource::collection($caseFiles)], 200);
    }

    public function editCase($case, $request)
    {
        $institutionID = null;
        if ($request->institution && $request->institution !== null && $request->institution !== '') {
            $institutionID = $request->institution['id'];
        }
        $case->update([
            'number_office' => $request->numberOffice,
            'number_institution' => $request->numberInstitution,
            'prosecutor' => $request->prosecutor,
            'defendants' => $request->defendants,
            'institution_id' => $institutionID,
            'note' => $request->note,
            'mark' => $request->mark,
            'fail_day' => $request->failDay,
            'case_type_id' => $request->case_type_id,
            'archive' => $request->archive
        ]);

        return response($case, 200);
    }

    public function deleteCase($case)
    {
        $case->delete();
        return response('{}', 204);
    }
}
