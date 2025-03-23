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

//Адрессация на создание job

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Каждый отдельный job по id

Route::get('/jobs/{id}', function ($id){

    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});

// Создание job
Route::post('/jobs', function () {
    // dd('Hello from the post');
    // dd(request()->all());

    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// Редактируй
Route::get('/jobs/{id}/edit', function ($id){

    $job = Job::find($id);
    return view('jobs.edit', ['job' => $job]);
});

// Обновить

Route::patch('/jobs/{id}', function ($id){

    //Validation

    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    //authorize

    $job = Job::findOrFail($id); // null if we cant find

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]); 

    //redirect
    return redirect('/jobs/' . $job->id);   
});

// remove

Route::delete('/jobs/{id}', function ($id){
    Job::findOrFail($id)->delete();

    return redirect('/jobs');
});




