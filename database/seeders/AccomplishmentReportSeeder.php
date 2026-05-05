<?php

namespace Database\Seeders;

use App\Models\AccomplishmentReport;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccomplishmentReportSeeder extends Seeder
{
    public function run()
    {
        // Only seed if table is empty
        if (AccomplishmentReport::count() > 0) {
            return;
        }

        $reports = [
            [
                'title' => 'Women Leadership Summit 2026',
                'content' => 'Successfully organized and conducted the Women Leadership Summit bringing together 150+ women leaders from various sectors. The event featured keynote speeches, panel discussions, and networking sessions focused on breaking barriers and accelerating gender equality in leadership positions.',
                'year' => 2026,
                'college' => 'College of Business and Accountancy',
                'gender' => 'female',
                'participants_count' => 150,
            ],
            [
                'title' => 'Gender Sensitivity Workshop for Faculty',
                'content' => 'Conducted comprehensive gender sensitivity training for 200+ faculty members across all colleges. The workshop covered topics including gender stereotypes, workplace equality, inclusive pedagogy, and creating safe learning environments for all students.',
                'year' => 2026,
                'college' => 'College of Education',
                'gender' => 'female',
                'participants_count' => 200,
            ],
            [
                'title' => 'Community Outreach: Women Empowerment Program',
                'content' => 'Implemented community-based women empowerment program reaching 500 women from underprivileged communities. The program provided skills training in digital literacy, entrepreneurship, and financial management to promote economic independence.',
                'year' => 2026,
                'college' => 'College of Agriculture and Fisheries',
                'gender' => 'female',
                'participants_count' => 500,
            ],
            [
                'title' => 'Career Development Mentoring Program',
                'content' => 'Launched career mentoring program connecting 80 female students with professionals from industry and academia. Through one-on-one mentoring sessions and group workshops, students gained valuable insights into career planning and professional development.',
                'year' => 2026,
                'college' => 'College of Engineering and Architecture',
                'gender' => 'male',
                'participants_count' => 80,
            ],
            [
                'title' => 'Gender-Based Violence Prevention Campaign',
                'content' => 'Conducted awareness campaign on gender-based violence prevention involving 1000+ participants from various campus organizations. Activities included seminars, poster campaigns, and peer mentoring sessions to promote respectful relationships and consent.',
                'year' => 2026,
                'college' => 'College of Health Sciences',
                'gender' => 'female',
                'participants_count' => 1000,
            ],
            [
                'title' => 'STEM Scholarship Award Ceremony',
                'content' => 'Awarded STEM scholarships to 50 deserving girls pursuing science and technology programs. The ceremony recognized academic excellence and celebrated the achievements of young women in STEM fields, inspiring future generations.',
                'year' => 2026,
                'college' => 'College of Information and Communication Technology',
                'gender' => 'female',
                'participants_count' => 50,
            ],
        ];

        foreach ($reports as $report) {
            AccomplishmentReport::create($report);
        }
    }
}
