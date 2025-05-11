<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class JobsController extends Controller
{

    public function index()
{
    $Jobs = \App\Models\Jobs::get();

    if ($Jobs->count() > 0) {
        return \App\Http\Resources\JobsResource::collection($Jobs);
    } else {
        return response()->json(["message" => "No Jobs found!"], 404);
    }
}


    public function show(\App\Models\Jobs $job)
    {
        if($job){
            return new \App\Http\Resources\JobsResource($job);
        }
        return response()->json(["message"=>"Job not found!"],404);
    }
  
    public function store(Request $request)
    {
        $validator=Validator::make(request()->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'posted_at' => 'required|date',
            'closing_at' => 'required|date',
            'job_type' => 'required|string|max:50',
            'salary' => 'required|numeric',
            'contact_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $job=\App\Models\Jobs::create([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'posted_at' => $request->posted_at,
            'closing_at' => $request->closing_at,
            'job_type' => $request->job_type,
            'salary' => $request->salary,
            'contact_email' => $request->contact_email
        ]);
        return response()->json(['message' => 'Job created successfully', 'data'=> new \App\Http\Resources\JobsResource($job)] , 201);

    }

    public function update(\App\Models\Jobs $job, Request $request)
    {
        $validator=Validator::make(request()->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'posted_at' => 'required|date',
            'closing_at' => 'required|date',
            'job_type' => 'required|string|max:50',
            'salary' => 'required|numeric',
            'contact_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $job->update([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'posted_at' => $request->posted_at,
            'closing_at' => $request->closing_at,
            'job_type' => $request->job_type,
            'salary' => $request->salary,
            'contact_email' => $request->contact_email
        ]);
        return response()->json(['message' => "Job updated successfully", "data"=> new \App\Http\Resources\JobsResource($job)], 200);   
    }

    public function destroy(\App\Models\Jobs $job)
    {
        if($job){
            $job->delete();
            return response()->json(['message' => 'Job deleted successfully'], 200);
        }else{
        return response()->json(['message' => 'Job not found'], 404);
        }
    }

    public function search(Request $request)
{
    $query = $request->input('query');

    if (empty($query)) {
        return response()->json(['message' => 'Search query is required.'], 400);
    }

    $jobs = \App\Models\Jobs::where('title', 'ILIKE', "%{$query}%")
        ->orWhere('company', 'ILIKE', "%{$query}%")
        ->orWhere('location', 'ILIKE', "%{$query}%")
        ->orWhere('status', 'ILIKE', "%{$query}%")
        ->paginate(10);

    if ($jobs->total() == 0) {
        return response()->json(['message' => 'No jobs found'], 404);
    }

    return \App\Http\Resources\JobsResource::collection($jobs);
}


public function filter(Request $request)
{
    $query = \App\Models\Jobs::query();

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('location')) {
        $query->where('location', 'LIKE', '%' . $request->location . '%');
    }

    if ($request->filled('company')) {
        $query->where('company', 'LIKE', '%' . $request->company . '%');
    }

    $jobs = $query->paginate(10);

    if ($jobs->isEmpty()) {
        return response()->json(['message' => 'No jobs found'], 404);
    }

    return \App\Http\Resources\JobsResource::collection($jobs);
}



}
