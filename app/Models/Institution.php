<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institution_type_id',
        'activation'
    ];

    public function institution_type()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function cases()
    {
        return $this->hasMany(_Case::class, 'institution_id');
    }

    public function trials()
    {
        return $this->hasMany(_Trial::class, 'institution_id');
    }

    public function getInstitutions($page, $numberData)
    {
        $institutions = Institution::orderBy('name')->skip($page * $numberData)->take($numberData)->get();
        return $institutions;
    }

    public function getAllInstitutions()
    {
        $institutions =  Institution::orderBy('name')->get();
        return $institutions;
    }

    public function institutionValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'ime' => 'required|min:2|max:300',
            'vrsta' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 400);
        } else {
            return response()->json('success', 200);
        }

    }

    public function createInstitution($request)
    {
        $validation = $this->institutionValidation($request);
        if ($validation->status() == 400) {
            return response()->json($validation, 400);
        }
        $institution = Institution::create([
            'name' => $request->ime,
            'institution_type_id' => $request->vrsta['id'],
            'activation' => true,
        ]);

        return response($institution->refresh(), 200);
    }

    public function updateActivationInstitution($id)
    {
        $institution = Institution::find($id);
        if (!$institution) {
            return response()->json('', 404);
        }
        if ($institution->activation) {
            $institution->activation = false;
        } else {
            $institution->activation = true;
        }

        $institution->save();
        return response($institution, 200);

    }
}
