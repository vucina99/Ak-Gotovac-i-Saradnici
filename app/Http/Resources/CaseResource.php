<?php

namespace App\Http\Resources;

use App\Models\Institution;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'numberOffice' => $this->number_office,
            'numberInstitution' => $this->number_institution ?? null,
            'prosecutor' => $this->prosecutor,
            'defendants' => $this->defendants,
            'institution' => new InstitutionResource($this->institution),
            'note' => $this->note,
            'mark' => $this->mark,
            'failDay' => $this->fail_day,
            'caseType' => new CaseTypeResource($this->case_type),
            'archive' => $this->archive,
        ];
    }
}
