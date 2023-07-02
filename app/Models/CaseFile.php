<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CaseFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'name',
        'path',
        'upload_date',
    ];

    public function removeFile($caseFileFromID)
    {
        // Define the path to the file you want to delete
        Storage::disk('s3')->delete($caseFileFromID->name);
        // Check if the file exists

        return response('{}', 204);
    }
}
