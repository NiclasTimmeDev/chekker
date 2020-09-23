<?php

namespace App\Http\Controllers;

use App\processes;
use Illuminate\Http\Request;

class ProcessesController extends Controller
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Apply middlware.
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\processes  $processes
     * @return \Illuminate\Http\Response
     */
    public function show(processes $processes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\processes  $processes
     * @return \Illuminate\Http\Response
     */
    public function edit(processes $processes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\processes  $processes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, processes $processes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\processes  $processes
     * @return \Illuminate\Http\Response
     */
    public function destroy(processes $processes)
    {
        //
    }
}