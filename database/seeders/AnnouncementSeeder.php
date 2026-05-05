<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        // Only seed if table is empty
        if (Announcement::count() > 0) {
            return;
        }

        $announcements = [
            [
                'title' => 'Women Empowerment Program Launched',
                'slug' => 'women-empowerment-program-launched',
                'content' => 'We are thrilled to announce the launch of our new Women Empowerment Program. This initiative aims to provide skills training, mentorship, and career development opportunities for women across the region. Through partnerships with local organizations and industry leaders, we will create pathways for economic independence and professional growth.',
                'excerpt' => 'We are thrilled to announce the launch of our new Women Empowerment Program. This initiative aims to provide skills training, mentorship, and career development...',
                'image_path' => 'images/announcements/women-empowerment.jpg',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Gender Equality Workshop Series Begins',
                'slug' => 'gender-equality-workshop-series-begins',
                'content' => 'Join us for our comprehensive Gender Equality Workshop Series running throughout the academic year. Our expert facilitators will guide participants through topics including gender sensitivity, workplace equality, and community development. All faculty, staff, and students are welcome to participate.',
                'excerpt' => 'Join us for our comprehensive Gender Equality Workshop Series running throughout the academic year. Our expert facilitators will guide participants through topics...',
                'image_path' => 'images/announcements/workshop.jpg',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Scholarship Opportunities for Underprivileged Girls',
                'slug' => 'scholarship-opportunities-underprivileged-girls',
                'content' => 'We are proud to announce new scholarship opportunities for underprivileged girls in our community. These scholarships will cover tuition fees, books, and living expenses to ensure that financial barriers do not prevent talented students from pursuing their education. Applications are now open for the 2026 academic year.',
                'excerpt' => 'We are proud to announce new scholarship opportunities for underprivileged girls in our community. These scholarships will cover tuition fees, books, and living expenses...',
                'image_path' => 'images/announcements/scholarship.jpg',
                'status' => 'published',
                'published_at' => Carbon::now()->subDay(1),
            ],
            [
                'title' => 'Community Outreach Drive Successfully Concluded',
                'slug' => 'community-outreach-drive-concluded',
                'content' => 'Our recent community outreach drive was a tremendous success. Over 500 individuals participated in awareness sessions about gender-based violence prevention and women\'s rights. Special thanks to all volunteers and partners who made this event possible.',
                'excerpt' => 'Our recent community outreach drive was a tremendous success. Over 500 individuals participated in awareness sessions about gender-based violence prevention...',
                'image_path' => null,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'International Women\'s Day Celebration',
                'slug' => 'international-womens-day-celebration',
                'content' => 'Mark your calendars for our International Women\'s Day celebration featuring keynote speakers, interactive panels, and cultural performances. This year\'s theme focuses on breaking barriers and accelerating gender equality. Event details and registration link coming soon!',
                'excerpt' => 'Mark your calendars for our International Women\'s Day celebration featuring keynote speakers, interactive panels, and cultural performances. This year\'s theme...',
                'image_path' => null,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
