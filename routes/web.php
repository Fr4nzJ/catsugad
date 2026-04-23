<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AccomplishmentReportController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\OrganizationStructureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\AccomplishmentReportController as AdminAccomplishmentReportController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\OrganizationMemberController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/about/mission-vision', function () {
    return view('about.mission-vision');
})->name('about.mission-vision');

Route::get('/about/background', function () {
    return view('about.background');
})->name('about.background');

Route::get('/about/organizational-chart', function () {
    return view('about.organizational-chart');
})->name('about.organizational-chart');

// Organization Structure Routes
Route::get('/organizational-structure', [OrganizationStructureController::class, 'index'])->name('organization-structure.index');

Route::get('/about/laws-issuances', function () {
    return view('about.laws-issuances');
})->name('about.laws-issuances');

Route::get('/about/gad-planning-budgeting', function () {
    return view('about.gad-planning-budgeting');
})->name('about.gad-planning-budgeting');

Route::get('/about/definition-terms', function () {
    return view('about.definition-terms');
})->name('about.definition-terms');

Route::get('/programs-services', function () {
    return view('programs-services');
})->name('programs-services');

// Programs Routes
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/programs-services/gadvocacy', function () {
    return view('programs-services.gadvocacy');
})->name('programs-services.gadvocacy');

Route::get('/programs-services/gawad-medalyang-ginto', function () {
    return view('programs-services.gawad-medalyang-ginto');
})->name('programs-services.gawad-medalyang-ginto');

Route::get('/programs-services/campaign-vawc-2022', function () {
    return view('programs-services.campaign-vawc-2022');
})->name('programs-services.campaign-vawc-2022');

Route::get('/news-announcements', function () {
    return view('news-announcements');
})->name('news-announcements');

// New Announcements Routes
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/accomplishment-report', [AccomplishmentReportController::class, 'index'])->name('accomplishment-report');

// Documents Routes
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/reports', function () {
    return view('reports');
})->name('reports');

Route::get('/gad-plan-budget', function () {
    return view('gad-plan-budget');
})->name('gad-plan-budget');

// Admin Routes
Route::prefix('admin')->group(function () {
    // Admin Auth Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    
    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        // Statistics CRUD
        Route::resource('/statistics', StatisticsController::class, ['names' => 'admin.statistics']);
        
        // Page Banners CRUD
        Route::resource('/banners', PageBannerController::class, ['names' => 'admin.banners']);
        
        // Accomplishment Reports CRUD
        Route::resource('/accomplishment-reports', AdminAccomplishmentReportController::class, ['names' => 'admin.accomplishment-reports']);
        
        // Charts CRUD
        Route::resource('/charts', ChartController::class, ['names' => 'admin.charts']);
        
        // Announcements CRUD
        Route::resource('/announcements', AdminAnnouncementController::class, ['names' => 'admin.announcements']);
        
        // Organization Members CRUD
        Route::resource('/organization-members', OrganizationMemberController::class, ['names' => 'admin.organization-members']);
        
        // Programs CRUD
        Route::resource('/programs', AdminProgramController::class, ['names' => 'admin.programs']);
        
        // Documents CRUD
        Route::resource('/documents', AdminDocumentController::class, ['names' => 'admin.documents']);
    });
});
