<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AccomplishmentReportController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\OrganizationStructureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GADPlanBudgetController;
use App\Http\Controllers\EnrollmentDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\AccomplishmentReportController as AdminAccomplishmentReportController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\OrganizationMemberController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\GADSubmissionController;
use App\Http\Controllers\Admin\GADAgendaController;
use App\Http\Controllers\Admin\GADGuidelineController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\GADCoordinatorController;
use App\Http\Controllers\Admin\GADPlanBudgetController as AdminGADPlanBudgetController;
use App\Http\Controllers\Admin\StaffImportController;

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

// News/Announcements (alias for announcements)
Route::get('/news-announcements', [AnnouncementController::class, 'index'])->name('news-announcements');

// New Announcements Routes
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/accomplishment-report', [AccomplishmentReportController::class, 'index'])->name('accomplishment-report');

// Accomplishment Report AJAX endpoints for sex-disaggregated data
Route::get('/api/accomplishment-report/college-chart-data', [AccomplishmentReportController::class, 'getCollegeChartData'])->name('accomplishment-report.college-chart-data');
Route::get('/api/accomplishment-report/college-programs/{collegeId}', [AccomplishmentReportController::class, 'getCollegeProgramData'])->name('accomplishment-report.college-programs');
Route::get('/api/accomplishment-report/university-summary', [AccomplishmentReportController::class, 'getUniversitySummaryData'])->name('accomplishment-report.university-summary');

// GAD Plan & Budget Routes
Route::get('/gad-plan-budgets', [GADPlanBudgetController::class, 'index'])->name('gad-plan-budgets.index');
Route::get('/gad-plan-budgets/{gadPlanBudget}', [GADPlanBudgetController::class, 'show'])->name('gad-plan-budgets.show');

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/students-by-college', [DashboardController::class, 'getStudentsByCollege'])->name('dashboard.students-by-college');
Route::get('/dashboard/students-by-program', [DashboardController::class, 'getStudentsByProgram'])->name('dashboard.students-by-program');
Route::get('/dashboard/employee-stats', [DashboardController::class, 'getEmployeeStats'])->name('dashboard.employee-stats');
Route::get('/dashboard/programs-by-college', [DashboardController::class, 'getProgramsByCollege'])->name('dashboard.programs-by-college');

// Enrollment Dashboard Routes
Route::prefix('enrollment')->group(function () {
    Route::get('/', [EnrollmentDashboardController::class, 'index'])->name('enrollment.dashboard');
    Route::get('/college/{id}', [EnrollmentDashboardController::class, 'getCollegeDetails'])->name('enrollment.college-detail');
    Route::get('/chart-data', [EnrollmentDashboardController::class, 'getChartData'])->name('enrollment.chart-data');
    Route::get('/export', [EnrollmentDashboardController::class, 'export'])->name('enrollment.export');
    Route::get('/trends/{id}', [EnrollmentDashboardController::class, 'getTrends'])->name('enrollment.trends');
});

// Documents Routes
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/reports', function () {
    return view('reports');
})->name('reports');

Route::get('/gad-plan-budget', [DocumentController::class, 'gadPlanBudget'])->name('gad-plan-budget');

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
        
        // GAD Submissions CRUD (LGU-Based GAD Processing)
        Route::resource('/gad-submissions', GADSubmissionController::class, ['names' => 'admin.gad-submissions']);
        
        // GAD Agendas CRUD (2026-2031 Strategic Plans)
        Route::resource('/gad-agendas', GADAgendaController::class, ['names' => 'admin.gad-agendas']);
        
        // GAD Guidelines CRUD (Policies & Memorandum)
        Route::resource('/gad-guidelines', GADGuidelineController::class, ['names' => 'admin.gad-guidelines']);
        
        // GAD Coordinators CRUD
        Route::resource('/gad-coordinators', GADCoordinatorController::class, ['names' => 'admin.gad-coordinators']);

        // GAD Plan & Budget CRUD
        Route::resource('/gad-plan-budgets', AdminGADPlanBudgetController::class, ['names' => 'admin.gad-plan-budgets']);
        
        // Activity Logs - Admin Activity History
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('/activity-logs/filter', [ActivityLogController::class, 'filter'])->name('admin.activity-logs.filter');
        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('admin.activity-logs.show');
        Route::post('/activity-logs/export', [ActivityLogController::class, 'export'])->name('admin.activity-logs.export');
        Route::post('/activity-logs/clear', [ActivityLogController::class, 'clearOldLogs'])->name('admin.activity-logs.clear');

        // Staff Import (Sex-Disaggregated Data)
        Route::get('/staff/import', [StaffImportController::class, 'index'])->name('admin.staff.import');
        Route::post('/staff/import', [StaffImportController::class, 'import'])->name('admin.staff.import.post');
    });
});
