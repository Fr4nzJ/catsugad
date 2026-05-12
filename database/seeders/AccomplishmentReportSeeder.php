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
            // College of Business and Accountancy
            [
                'title' => 'Women Leadership Summit 2026',
                'content' => 'Successfully organized and conducted the Women Leadership Summit bringing together 150+ women leaders from various sectors. The event featured keynote speeches, panel discussions, and networking sessions focused on breaking barriers and accelerating gender equality in leadership positions.',
                'year' => 2026,
                'college' => 'College of Business and Accountancy',
                'gender' => 'female',
                'participants_count' => 150,
            ],
            [
                'title' => 'Inclusive Workplace Policies Workshop',
                'content' => 'Workshop conducted on implementing inclusive workplace policies with participation from 120 business professionals and students. Topics covered maternity benefits, non-discrimination policies, and equal pay practices.',
                'year' => 2026,
                'college' => 'College of Business and Accountancy',
                'gender' => 'male',
                'participants_count' => 120,
            ],
            [
                'title' => 'Women Entrepreneurs Mentoring Program',
                'content' => 'Mentoring program connecting 90 female entrepreneurs with established business leaders. Participants received guidance on business planning, financial management, and market expansion strategies.',
                'year' => 2025,
                'college' => 'College of Business and Accountancy',
                'gender' => 'female',
                'participants_count' => 90,
            ],

            // College of Education
            [
                'title' => 'Gender Sensitivity Workshop for Faculty',
                'content' => 'Conducted comprehensive gender sensitivity training for 200+ faculty members across all colleges. The workshop covered topics including gender stereotypes, workplace equality, inclusive pedagogy, and creating safe learning environments for all students.',
                'year' => 2026,
                'college' => 'College of Education',
                'gender' => 'female',
                'participants_count' => 200,
            ],
            [
                'title' => 'Boys and Men as Advocates for Gender Equality',
                'content' => 'Special program engaging 180 male students as advocates for gender equality. Program focused on positive masculinity, dismantling gender stereotypes, and male engagement in gender equality initiatives.',
                'year' => 2026,
                'college' => 'College of Education',
                'gender' => 'male',
                'participants_count' => 180,
            ],
            [
                'title' => 'Inclusive Education Training for Teachers',
                'content' => 'Training program for 160 teachers on inclusive education practices that address the needs of students of all genders and abilities.',
                'year' => 2025,
                'college' => 'College of Education',
                'gender' => 'female',
                'participants_count' => 160,
            ],

            // College of Agriculture and Fisheries
            [
                'title' => 'Community Outreach: Women Empowerment Program',
                'content' => 'Implemented community-based women empowerment program reaching 500 women from underprivileged communities. The program provided skills training in digital literacy, entrepreneurship, and financial management to promote economic independence.',
                'year' => 2026,
                'college' => 'College of Agriculture and Fisheries',
                'gender' => 'female',
                'participants_count' => 500,
            ],
            [
                'title' => 'Women in Agriculture: Sustainable Farming Initiative',
                'content' => 'Program supporting 200 women farmers in adopting sustainable and profitable farming practices. Included training on organic farming, crop diversification, and market linkages.',
                'year' => 2026,
                'college' => 'College of Agriculture and Fisheries',
                'gender' => 'female',
                'participants_count' => 200,
            ],
            [
                'title' => 'Young Farmers Cooperative Development',
                'content' => 'Support program for 140 young farmers (both male and female) in establishing agricultural cooperatives for better resource management and market access.',
                'year' => 2025,
                'college' => 'College of Agriculture and Fisheries',
                'gender' => 'male',
                'participants_count' => 140,
            ],

            // College of Engineering and Architecture
            [
                'title' => 'Career Development Mentoring Program',
                'content' => 'Launched career mentoring program connecting 80 female students with professionals from industry and academia. Through one-on-one mentoring sessions and group workshops, students gained valuable insights into career planning and professional development.',
                'year' => 2026,
                'college' => 'College of Engineering and Architecture',
                'gender' => 'female',
                'participants_count' => 80,
            ],
            [
                'title' => 'Women in STEM: Networking and Collaboration Forum',
                'content' => 'Forum bringing together 110 female engineering and architecture students with industry professionals to discuss career opportunities and collaborative projects in STEM.',
                'year' => 2026,
                'college' => 'College of Engineering and Architecture',
                'gender' => 'female',
                'participants_count' => 110,
            ],
            [
                'title' => 'Inclusive Design Workshop for All Engineers',
                'content' => 'Workshop on designing inclusive spaces and products with participation from 95 male and female engineering students covering universal design principles.',
                'year' => 2025,
                'college' => 'College of Engineering and Architecture',
                'gender' => 'male',
                'participants_count' => 95,
            ],

            // College of Health Sciences
            [
                'title' => 'Gender-Based Violence Prevention Campaign',
                'content' => 'Conducted awareness campaign on gender-based violence prevention involving 1000+ participants from various campus organizations. Activities included seminars, poster campaigns, and peer mentoring sessions to promote respectful relationships and consent.',
                'year' => 2026,
                'college' => 'College of Health Sciences',
                'gender' => 'female',
                'participants_count' => 1000,
            ],
            [
                'title' => 'Women\'s Health and Wellness Program',
                'content' => 'Comprehensive health program providing 450 women with information and services related to reproductive health, mental wellness, and preventive healthcare.',
                'year' => 2026,
                'college' => 'College of Health Sciences',
                'gender' => 'female',
                'participants_count' => 450,
            ],
            [
                'title' => 'Male Health and Gender Awareness Seminar',
                'content' => 'Seminar for 170 male students focusing on male health issues and the role of men in supporting gender equality and family wellness.',
                'year' => 2025,
                'college' => 'College of Health Sciences',
                'gender' => 'male',
                'participants_count' => 170,
            ],

            // College of Information and Communications Technology
            [
                'title' => 'STEM Scholarship Award Ceremony',
                'content' => 'Awarded STEM scholarships to 50 deserving girls pursuing science and technology programs. The ceremony recognized academic excellence and celebrated the achievements of young women in STEM fields, inspiring future generations.',
                'year' => 2026,
                'college' => 'College of Information and Communications Technology',
                'gender' => 'female',
                'participants_count' => 50,
            ],
            [
                'title' => 'Women in Tech: Hackathon and Innovation Challenge',
                'content' => 'Technology hackathon featuring 75 female participants developing tech solutions for social and environmental challenges with focus on gender-inclusive innovation.',
                'year' => 2026,
                'college' => 'College of Information and Communications Technology',
                'gender' => 'female',
                'participants_count' => 75,
            ],
            [
                'title' => 'Cybersecurity Awareness for All: Gender Perspective',
                'content' => 'Training program for 130 IT professionals (male and female) on cybersecurity with emphasis on protection against gender-based online harassment and digital safety.',
                'year' => 2025,
                'college' => 'College of Information and Communications Technology',
                'gender' => 'male',
                'participants_count' => 130,
            ],

            // College of Humanities and Social Sciences
            [
                'title' => 'Gender and Social Justice Seminar Series',
                'content' => 'Series of seminars attracting 220 students exploring gender issues through lens of social justice, intersectionality, and human rights with contributions from 12 international speakers.',
                'year' => 2026,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'female',
                'participants_count' => 220,
            ],
            [
                'title' => 'Masculinity and Emotional Intelligence Workshop',
                'content' => 'Workshop for 105 male students exploring healthy expressions of masculinity, emotional intelligence, and supportive relationships in the context of gender equality.',
                'year' => 2026,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'male',
                'participants_count' => 105,
            ],
            [
                'title' => 'Historical Women Leaders Lecture Series',
                'content' => 'Lecture series featuring 18 renowned historians discussing contributions of women leaders throughout history with 350 audience members including 165 male attendees.',
                'year' => 2025,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'female',
                'participants_count' => 350,
            ],

            // College of Humanities and Social Sciences
            [
                'title' => 'Gender Policy Advocacy Training',
                'content' => 'Training program for 140 social science students on gender policy analysis and advocacy skills for promoting gender-responsive governance and institutional reforms.',
                'year' => 2026,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'female',
                'participants_count' => 140,
            ],
            [
                'title' => 'Men\'s Engagement in Family and Community Care',
                'content' => 'Program highlighting positive models of male engagement in caregiving roles within families and communities, reaching 95 male participants.',
                'year' => 2026,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'male',
                'participants_count' => 95,
            ],
            [
                'title' => 'Gender and Development Research Symposium',
                'content' => 'Symposium showcasing research projects on gender and development by 85 faculty and graduate students with focus on evidence-based gender equality initiatives.',
                'year' => 2025,
                'college' => 'College of Humanities and Social Sciences',
                'gender' => 'female',
                'participants_count' => 85,
            ],
        ];

        foreach ($reports as $report) {
            AccomplishmentReport::create($report);
        }
    }
}
