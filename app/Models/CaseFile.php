<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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
        $path = public_path('files/' . $caseFileFromID->name);

        // Check if the file exists
        if (File::exists($path)) {
            // Delete the file
            File::delete($path);
            return response('{}', 204);
        }
        return response('{}', 404);
    }
}
