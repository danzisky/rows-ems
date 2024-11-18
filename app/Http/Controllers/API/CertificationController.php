<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'certifications_' . md5(json_encode([
            'search' => $request->get('search'),
            'sort_by' => $request->get('sort_by'),
            'order' => $request->get('order', 'asc'),
        ]));

        $cacheDuration = now()->addMinutes(10);

        $certifications = Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            $query = Certification::query();

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('sort_by')) {
                $query->orderBy($request->sort_by, $request->get('order', 'asc'));
            }

            return $query->get();
        });
    
        return response()->json($certifications); // Return the cached or freshly queried data as JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certification $certification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificationRequest $request, Certification $certification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        //
    }
}
