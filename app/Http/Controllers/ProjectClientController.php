<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\ProjectClient;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = ProjectClient::orderByDesc('id')->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        //
        DB::transaction(function() use ($request){
            $validated = $request->validated();

            if($request->hasFile('avatar')){
                $iconPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $iconPath;
            }
            if($request->hasFile('logo')){
                $iconPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $iconPath;
            }

            $newClient = ProjectClient::create($validated);

        });

        return redirect()->route('admin.clients.index')->with('success','berhsil cok');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectClient $projectClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectClient $projectClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, ProjectClient $projectClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectClient $client)
    {
        //
        DB::transaction(function() use ($client){
            $client->delete();
        });

        return redirect()->route('admin.clients.index');
    }
}
