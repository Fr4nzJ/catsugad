<?php

namespace Database\Seeders;

use App\Models\AboutMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutMenu::truncate();

        $menus = [
            [
                'title' => 'Mission, Vision and Goal',
                'route' => 'about.mission-vision',
                'icon' => 'fas fa-bullseye',
                'content' => 'The Gender and Development Services is committed to promoting gender equality and women empowerment through various programs and initiatives within the university community.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Background',
                'route' => 'about.background',
                'icon' => 'fas fa-history',
                'content' => 'The Gender and Development Services office was established to address gender concerns and advocate for equal opportunities among all members of the university community.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Laws and Issuances',
                'route' => 'about.laws-issuances',
                'icon' => 'fas fa-file-alt',
                'content' => 'Our programs and operations are guided by various national laws, issuances, and policies promoting gender equality and women\'s rights in the Philippines.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Definition of Terms',
                'route' => 'about.definition-terms',
                'icon' => 'fas fa-book',
                'content' => 'This section provides clear definitions of key gender-related terms used in our programs, services, and communications.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($menus as $menu) {
            AboutMenu::create($menu);
        }
    }
}
