<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\StudentStatistic;
use App\Models\EmployeeStatistic;
use App\Models\PageBanner;
use App\Models\AccomplishmentReport;
use App\Models\Chart;
use App\Models\Announcement;
use App\Models\OrganizationMember;
use App\Models\Program;
use App\Models\Document;
use App\Models\GADSubmission;
use App\Models\GADAgenda;
use App\Models\GADGuideline;
use App\Models\GADCoordinator;
use App\Models\GADPlanBudget;
use App\Models\Enrollment;
use App\Models\Staff;
use App\Models\College;
use App\Models\GfpsMember;
use App\Models\AboutMenu;
use App\Models\AboutPage;
use App\Models\MapMarker;

class SeederController extends Controller
{
    /**
     * Display the seeder management dashboard
     */
    public function index()
    {
        return view('admin.seeder-management', [
            'seeders' => $this->getAvailableSeeders(),
            'wipeSections' => $this->getWipeSections(),
        ]);
    }

    /**
     * Get list of available seeders
     */
    private function getAvailableSeeders()
    {
        return [
            'enrollment' => [
                'name' => 'Enrollment Data',
                'description' => 'Seeds student enrollment data across colleges and categories',
                'route' => 'admin.seeder.run',
                'seeders' => 'EnrollmentSeeder,StaffSeeder,CollegeSeeder',
            ],
            'staff' => [
                'name' => 'Staff/Employee Data',
                'description' => 'Seeds staff and employee statistic data',
                'route' => 'admin.seeder.run',
                'seeders' => 'StaffSeeder',
            ],
            'announcements' => [
                'name' => 'Announcements',
                'description' => 'Seeds sample announcement data',
                'route' => 'admin.seeder.run',
                'seeders' => 'AnnouncementSeeder',
            ],
            'programs' => [
                'name' => 'Programs & Colleges',
                'description' => 'Seeds program and college data',
                'route' => 'admin.seeder.run',
                'seeders' => 'ProgramSeeder,CollegeSeeder',
            ],
            'accomplishment' => [
                'name' => 'Accomplishment Reports',
                'description' => 'Seeds GAD accomplishment report data',
                'route' => 'admin.seeder.run',
                'seeders' => 'AccomplishmentReportSeeder',
            ],
            'gad_kpi' => [
                'name' => 'GAD KPI Data',
                'description' => 'Seeds GAD Key Performance Indicators',
                'route' => 'admin.seeder.run',
                'seeders' => 'GadKpiSeeder',
            ],
            'gad_coordinator' => [
                'name' => 'GAD Coordinators',
                'description' => 'Seeds GAD coordinators for each college',
                'route' => 'admin.seeder.run',
                'seeders' => 'GADCoordinatorSeeder',
            ],
            'gad_agenda' => [
                'name' => 'GAD Agendas',
                'description' => 'Seeds GAD strategic agendas and initiatives',
                'route' => 'admin.seeder.run',
                'seeders' => 'GADAgendaSeeder',
            ],
            'gad_plan_budget' => [
                'name' => 'GAD Plan & Budgets',
                'description' => 'Seeds GAD planning, budgeting, and program initiatives',
                'route' => 'admin.seeder.run',
                'seeders' => 'GADPlanBudgetSeeder',
            ],
            'charts' => [
                'name' => 'Analytics Charts',
                'description' => 'Seeds sample charts for dashboard analytics',
                'route' => 'admin.seeder.run',
                'seeders' => 'ChartSeeder',
            ],
            'gfps_members' => [
                'name' => 'GFPS Members',
                'description' => 'Seeds GAD Focal Point System organizational members',
                'route' => 'admin.seeder.run',
                'seeders' => 'GfpsMembersSeeder',
            ],
            'about_menu' => [
                'name' => 'About Menu',
                'description' => 'Seeds About page menu items',
                'route' => 'admin.seeder.run',
                'seeders' => 'AboutMenuSeeder',
            ],
            'about_page' => [
                'name' => 'About Pages',
                'description' => 'Seeds About page content sections',
                'route' => 'admin.seeder.run',
                'seeders' => 'AboutPageSeeder',
            ],
            'map_markers' => [
                'name' => 'Map Markers',
                'description' => 'Seeds campus map markers',
                'route' => 'admin.seeder.run',
                'seeders' => 'MapMarkerSeeder',
            ],
            'statistics' => [
                'name' => 'Statistics',
                'description' => 'Seeds student and employee statistics',
                'route' => 'admin.seeder.run',
                'seeders' => 'StatisticsSeeder',
            ],
            'all_data' => [
                'name' => 'All Data (Complete Reseed)',
                'description' => 'Seeds ALL available data - complete database population',
                'route' => 'admin.seeder.run',
                'seeders' => 'CollegeSeeder,EnrollmentSeeder,StaffSeeder,AnnouncementSeeder,ProgramSeeder,AccomplishmentReportSeeder,GadKpiSeeder,GADCoordinatorSeeder,GADAgendaSeeder,GADPlanBudgetSeeder,GfpsMembersSeeder,ChartSeeder,AboutMenuSeeder,AboutPageSeeder,MapMarkerSeeder',
            ],
        ];
    }

    /**
     * Get list of wipe sections (CRUD sections)
     */
    private function getWipeSections()
    {
        return [
            'statistics' => [
                'name' => 'Statistics',
                'description' => 'Wipes student and employee statistics data',
                'icon' => 'fa-chart-pie',
                'tables' => ['student_statistics', 'employee_statistics'],
            ],
            'banners' => [
                'name' => 'Banners',
                'description' => 'Wipes page banner data',
                'icon' => 'fa-images',
                'tables' => ['page_banners'],
            ],
            'accomplishment_reports' => [
                'name' => 'Accomplishment Reports',
                'description' => 'Wipes accomplishment report data',
                'icon' => 'fa-trophy',
                'tables' => ['accomplishment_reports'],
            ],
            'charts' => [
                'name' => 'Charts',
                'description' => 'Wipes chart configuration data',
                'icon' => 'fa-chart-line',
                'tables' => ['charts'],
            ],
            'announcements' => [
                'name' => 'Announcements',
                'description' => 'Wipes announcement data',
                'icon' => 'fa-bullhorn',
                'tables' => ['announcements'],
            ],
            'organization_members' => [
                'name' => 'Organization Members',
                'description' => 'Wipes organization member data',
                'icon' => 'fa-sitemap',
                'tables' => ['organization_members'],
            ],
            'programs' => [
                'name' => 'Programs',
                'description' => 'Wipes program data',
                'icon' => 'fa-project-diagram',
                'tables' => ['programs'],
            ],
            'documents' => [
                'name' => 'Documents',
                'description' => 'Wipes document data',
                'icon' => 'fa-file-pdf',
                'tables' => ['documents'],
            ],
            'gad_submissions' => [
                'name' => 'GAD Submissions',
                'description' => 'Wipes GAD submission data',
                'icon' => 'fa-envelope',
                'tables' => ['gad_submissions'],
            ],
            'gad_agendas' => [
                'name' => 'GAD Agendas',
                'description' => 'Wipes GAD agenda data',
                'icon' => 'fa-calendar',
                'tables' => ['gad_agendas'],
            ],
            'gad_guidelines' => [
                'name' => 'GAD Guidelines',
                'description' => 'Wipes GAD guideline data',
                'icon' => 'fa-book',
                'tables' => ['gad_guidelines'],
            ],
            'gad_coordinators' => [
                'name' => 'GAD Coordinators',
                'description' => 'Wipes GAD coordinator data',
                'icon' => 'fa-users',
                'tables' => ['gad_coordinators'],
            ],
            'gad_plan_budgets' => [
                'name' => 'GAD Plan & Budgets',
                'description' => 'Wipes GAD plan and budget data',
                'icon' => 'fa-money-bill',
                'tables' => ['gad_plan_budgets'],
            ],
            'gfps_members' => [
                'name' => 'GFPS Members',
                'description' => 'Wipes GFPS organizational members',
                'icon' => 'fa-sitemap',
                'tables' => ['gfps_members'],
            ],
            'about_menu' => [
                'name' => 'About Menu',
                'description' => 'Wipes About page menu data',
                'icon' => 'fa-list',
                'tables' => ['about_menus'],
            ],
            'about_page' => [
                'name' => 'About Pages',
                'description' => 'Wipes About page content',
                'icon' => 'fa-file-alt',
                'tables' => ['about_pages'],
            ],
            'map_markers' => [
                'name' => 'Map Markers',
                'description' => 'Wipes map marker data',
                'icon' => 'fa-map-marker-alt',
                'tables' => ['map_markers'],
            ],
            'enrollments' => [
                'name' => 'Enrollments',
                'description' => 'Wipes student enrollment data',
                'icon' => 'fa-graduation-cap',
                'tables' => ['enrollments'],
            ],
            'staff' => [
                'name' => 'Staff',
                'description' => 'Wipes staff data',
                'icon' => 'fa-id-card',
                'tables' => ['staff'],
            ],
            'colleges' => [
                'name' => 'Colleges',
                'description' => 'Wipes college data',
                'icon' => 'fa-building',
                'tables' => ['colleges'],
            ],
        ];
    }

    /**
     * Run a specific seeder
     */
    public function runSeeder(Request $request)
    {
        try {
            $seederKey = $request->input('seeder');
            $seeders = $this->getAvailableSeeders();

            if (!isset($seeders[$seederKey])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid seeder selected.',
                ], 400);
            }

            $seederNames = explode(',', $seeders[$seederKey]['seeders']);

            foreach ($seederNames as $seederName) {
                $seederName = trim($seederName);
                Artisan::call('db:seed', ['--class' => "Database\\Seeders\\{$seederName}"]);
            }

            return response()->json([
                'success' => true,
                'message' => $seeders[$seederKey]['name'] . ' has been seeded successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error running seeder: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Wipe data from a specific section
     */
    public function wipeData(Request $request)
    {
        try {
            $sectionKey = $request->input('section');
            $sections = $this->getWipeSections();

            if (!isset($sections[$sectionKey])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid section selected.',
                ], 400);
            }

            // Add confirmation check for safety
            if (!$request->input('confirmed')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Confirmation required. Please confirm data deletion.',
                    'requiresConfirmation' => true,
                ], 400);
            }

            $this->deleteDataBySection($sectionKey);

            return response()->json([
                'success' => true,
                'message' => $sections[$sectionKey]['name'] . ' data has been wiped successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error wiping data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete data for a specific section
     */
    private function deleteDataBySection($sectionKey)
    {
        switch ($sectionKey) {
            case 'statistics':
                StudentStatistic::truncate();
                EmployeeStatistic::truncate();
                break;
            case 'banners':
                PageBanner::truncate();
                break;
            case 'accomplishment_reports':
                AccomplishmentReport::truncate();
                break;
            case 'charts':
                Chart::truncate();
                break;
            case 'announcements':
                Announcement::truncate();
                break;
            case 'organization_members':
                OrganizationMember::truncate();
                break;
            case 'programs':
                Program::truncate();
                break;
            case 'documents':
                Document::truncate();
                break;
            case 'gad_submissions':
                GADSubmission::truncate();
                break;
            case 'gad_agendas':
                GADAgenda::truncate();
                break;
            case 'gad_guidelines':
                GADGuideline::truncate();
                break;
            case 'gad_coordinators':
                GADCoordinator::truncate();
                break;
            case 'gad_plan_budgets':
                GADPlanBudget::truncate();
                break;
            case 'enrollments':
                Enrollment::truncate();
                break;
            case 'staff':
                Staff::truncate();
                break;
            case 'colleges':
                College::truncate();
                break;
            case 'gfps_members':
                GfpsMember::truncate();
                break;
            case 'about_menu':
                AboutMenu::truncate();
                break;
            case 'about_page':
                AboutPage::truncate();
                break;
            case 'map_markers':
                MapMarker::truncate();
                break;
        }
    }

    /**
     * Get statistics about current data
     */
    public function getStats()
    {
        return response()->json([
            'statistics' => [
                'student_statistics' => StudentStatistic::count(),
                'employee_statistics' => EmployeeStatistic::count(),
            ],
            'banners' => PageBanner::count(),
            'accomplishment_reports' => AccomplishmentReport::count(),
            'charts' => Chart::count(),
            'announcements' => Announcement::count(),
            'organization_members' => OrganizationMember::count(),
            'programs' => Program::count(),
            'documents' => Document::count(),
            'gad_submissions' => GADSubmission::count(),
            'gad_agendas' => GADAgenda::count(),
            'gad_guidelines' => GADGuideline::count(),
            'gad_coordinators' => GADCoordinator::count(),
            'gad_plan_budgets' => GADPlanBudget::count(),
            'enrollments' => Enrollment::count(),
            'staff' => Staff::count(),
            'colleges' => College::count(),
            'gfps_members' => GfpsMember::count(),
            'about_menu' => AboutMenu::count(),
            'about_page' => AboutPage::count(),
            'map_markers' => MapMarker::count(),
        ]);
    }
}
