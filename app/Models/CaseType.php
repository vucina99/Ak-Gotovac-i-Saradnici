<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function getCaseTypes()
    {
        $caseType = CaseType::all();
        return $caseType;
    }

    public function cases()
    {
        return $this->hasMany(_Case::class, 'institution_id');
    }
}
