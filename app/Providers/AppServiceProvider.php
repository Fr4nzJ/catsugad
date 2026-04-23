<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Program;
use App\Models\Document;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share Programs data with all views for navigation dropdown
        View::composer('layouts.layout', function ($view) {
            $programs = Program::all();
            $gadDocuments = Document::where('category', 'GAD Plan and Budget')->orderBy('year', 'desc')->get();
            $view->with('navPrograms', $programs)
                 ->with('navGadDocuments', $gadDocuments);
        });
    }
}
