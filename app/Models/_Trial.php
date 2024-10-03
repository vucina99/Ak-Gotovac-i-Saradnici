<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _Trial extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_office',
        'number_institution',
        'user_id',
        'prosecutor',
        'defendants',
        'institution_id',
        'note',
        'date',
        'time',
        'courtroom_number',
        'archive'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function createTrial($request)
    {
        $institutionID = null;
        $userID = null;
        if ($request->institution && $request->institution !== null && $request->institution !== '') {
            $institutionID = $request->institution['id'];
        }
        if ($request->user && $request->user !== null && $request->user !== '') {
            $userID = $request->user['id'];
        }
        $date =  Carbon::parse($request->date)->format("Y-m-d");
        $trial = _Trial::create([
            'number_office' => $request->number_office,
            'number_institution' => $request->number_institution,
            'user_id' => $userID,
            'prosecutor' => $request->person_1,
            'defendants' => $request->person_2,
            'institution_id' => $institutionID,
            'note' => $request->note,
            'date' =>$date,
            'time' => $request->time,
            'archive' => $request->archive,
            'courtroom_number' => $request->courtroom_number
        ]);

        return response($trial->refresh(), 201);
    }

    public function edit($trial , $request){
        $institutionID = null;
        $userID = null;
        if ($request->institution && $request->institution !== null && $request->institution !== '') {
            $institutionID = $request->institution['id'];
        }
        if ($request->user && $request->user !== null && $request->user !== '') {
            $userID = $request->user['id'];
        }
        $date =  Carbon::parse($request->date)->format("Y-m-d");

        $trial->update([
            'number_office' => $request->numberOffice,
            'number_institution' => $request->numberInstitution,
            'user_id' => $userID,
            'prosecutor' => $request->prosecutor,
            'defendants' => $request->defendants,
            'institution_id' => $institutionID,
            'note' => $request->note,
            'date' =>$date,
            'time' => $request->time,
            'archive' => $request->archive,
            'courtroom_number' => $request->courtroom_number
        ]);

        return $trial;
    }
}
