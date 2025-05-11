<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
       return [
            'id' => $this->id,
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
            'description' => $this->description,
            'status' => $this->status,
            'posted_at' => $this->posted_at,
            'closing_at' => $this->closing_at,
            'job_type' => $this->job_type,
            'salary' => $this->salary,
            'contact_email' => $this->contact_email
       ];
    }
}
