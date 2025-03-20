<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

// Главная

Route::get('/', function () {
    // $jobs = Job::all();
    // dd($jobs[0]);
    return view('home');
});

// Контакты

Route::get('/contact', function () {
    return view('contact');
});


// Все job с employer и нумерацией страниц

Route::get('/jobs', function (){
    $jobs = Job::with('employer')->latest()->simplePaginate(3);
    
    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

//Создание job

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Каждый отдельный job по id

Route::get('/jobs/{id}', function ($id){

    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});

Route::post('/jobs', function () {
    // dd('Hello from the post');
    // dd(request()->all());

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});




