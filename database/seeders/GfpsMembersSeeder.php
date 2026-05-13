<?php

namespace Database\Seeders;

use App\Models\GfpsMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GfpsMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GfpsMember::truncate();

        $members = [
            // Top Level
            [
                'section' => 'Top Level',
                'sort_order' => 1,
                'gfps_position' => 'SUC President',
                'gfps_role' => 'Head of Agency',
                'name' => 'Gemma G. Acedo',
                'designation' => 'SUC President III',
                'remarks' => null,
                'is_vacant' => false,
            ],
            [
                'section' => 'Top Level',
                'sort_order' => 2,
                'gfps_position' => 'VP for Administrative and Financial Affairs',
                'gfps_role' => 'Chair',
                'name' => 'Arthur I. Tabirara',
                'designation' => 'Associate Professor I (CHUMSS)',
                'remarks' => null,
                'is_vacant' => false,
            ],

            // Members Level
            [
                'section' => 'Members Level',
                'sort_order' => 1,
                'gfps_position' => 'VP for Academic Affairs',
                'gfps_role' => 'Member',
                'name' => 'Kristian Q. Aldea',
                'designation' => 'Associate Professor III / OIC, VP-AA',
                'remarks' => null,
                'is_vacant' => false,
            ],
            [
                'section' => 'Members Level',
                'sort_order' => 2,
                'gfps_position' => 'VP for Research, Extension and Production Affairs',
                'gfps_role' => 'Member',
                'name' => 'Roberto B. Barba Jr.',
                'designation' => 'Associate Professor I / OIC, VP REPA',
                'remarks' => null,
                'is_vacant' => false,
            ],
            [
                'section' => 'Members Level',
                'sort_order' => 3,
                'gfps_position' => 'Chief Administrative Officer - Finance',
                'gfps_role' => 'Member',
                'name' => 'Rommel S. Torres',
                'designation' => 'Chief Administrative Officer',
                'remarks' => null,
                'is_vacant' => false,
            ],
            [
                'section' => 'Members Level',
                'sort_order' => 4,
                'gfps_position' => 'Administrative Officer V - Budget Services',
                'gfps_role' => 'Member',
                'name' => 'Maryshiel S. Tabios',
                'designation' => 'Administrative Officer V (Budget Officer III)',
                'remarks' => null,
                'is_vacant' => false,
            ],

            // Technical Working Group
            [
                'section' => 'Technical Working Group',
                'sort_order' => 1,
                'gfps_position' => 'GAD Coordinator',
                'gfps_role' => 'Chair',
                'name' => null,
                'designation' => null,
                'remarks' => null,
                'is_vacant' => true,
            ],
            [
                'section' => 'Technical Working Group',
                'sort_order' => 2,
                'gfps_position' => 'Gender Mainstreaming and Monitoring System',
                'gfps_role' => 'Focal Person',
                'name' => null,
                'designation' => null,
                'remarks' => null,
                'is_vacant' => true,
            ],

            // Deans / Campus Level
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 1,
                'gfps_position' => 'Campus Administrator',
                'gfps_role' => 'Member',
                'name' => 'Rosalie M. Ocillos',
                'designation' => 'Campus Director, Associate Professor III',
                'remarks' => 'CatSU Panganiban Campus',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 2,
                'gfps_position' => 'Dean, College of Agriculture and Fisheries (CAF)',
                'gfps_role' => 'Member',
                'name' => 'Medie M. Lopez',
                'designation' => 'Dean, Assistant Professor IV',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 3,
                'gfps_position' => 'Dean, College of Humanities and Social Sciences (CHUMSS)',
                'gfps_role' => 'Member',
                'name' => null,
                'designation' => null,
                'remarks' => 'No Dean entry found in March 2026 employee roster',
                'is_vacant' => true,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 4,
                'gfps_position' => 'Dean, College of Science (COS)',
                'gfps_role' => 'Member',
                'name' => 'Marilou A. Aldea',
                'designation' => 'Dean, Assistant Professor IV',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 5,
                'gfps_position' => 'Dean, College of Business and Accountancy (CBA)',
                'gfps_role' => 'Member',
                'name' => 'Ian V. Aranel',
                'designation' => 'Dean (Acting), Assistant Professor III',
                'remarks' => 'Also Acting Executive Assistant III',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 6,
                'gfps_position' => 'Dean, College of Education (COEd)',
                'gfps_role' => 'Member',
                'name' => 'Maria Sheila R. Gregorio',
                'designation' => 'Dean, Associate Professor V',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 7,
                'gfps_position' => 'Dean, College of Health Sciences (CHS)',
                'gfps_role' => 'Member',
                'name' => 'Maria Alma V. Tabirara',
                'designation' => 'Dean, Associate Professor IV',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 8,
                'gfps_position' => 'Dean, College of Engineering and Architecture (CEA)',
                'gfps_role' => 'Member',
                'name' => 'Dexter M. Toyado',
                'designation' => 'Dean, Associate Professor IV',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 9,
                'gfps_position' => 'Dean, College of Industrial Technology (CIT)',
                'gfps_role' => 'Member',
                'name' => 'Edwin T. Romero',
                'designation' => 'Dean, Associate Professor V',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 10,
                'gfps_position' => 'Dean, College of Information and Communications Technology (CICT)',
                'gfps_role' => 'Member',
                'name' => 'Maria Concepcion S. Vera',
                'designation' => 'Dean, Associate Professor II',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 11,
                'gfps_position' => 'Dean, College of Law',
                'gfps_role' => 'Member',
                'name' => null,
                'designation' => null,
                'remarks' => 'Associate Dean on record: Gregorio M. Sarmiento Jr.',
                'is_vacant' => true,
            ],
            [
                'section' => 'Deans / Campus Level',
                'sort_order' => 12,
                'gfps_position' => 'Dean, Graduate School',
                'gfps_role' => 'Member',
                'name' => 'Rene V. Torres',
                'designation' => 'Associate Professor III (COS)',
                'remarks' => 'Listed under Advanced Education Services',
                'is_vacant' => false,
            ],

            // Directors / Other Members
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 1,
                'gfps_position' => 'Director, Planning Development and Information System',
                'gfps_role' => 'Member',
                'name' => 'Mae Lizza D. Bublo',
                'designation' => 'Planning Officer III',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 2,
                'gfps_position' => 'Director, Student Support Services',
                'gfps_role' => 'Member',
                'name' => 'Gemma M. Samas',
                'designation' => 'Director, OSSS / Associate Professor V',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 3,
                'gfps_position' => 'Director, Research Services',
                'gfps_role' => 'Member',
                'name' => 'Jose Z. Tria',
                'designation' => 'Director, Associate Professor III',
                'remarks' => '',
                'is_vacant' => false,
            ],
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 4,
                'gfps_position' => 'Director, Extension Services',
                'gfps_role' => 'Member',
                'name' => null,
                'designation' => null,
                'remarks' => '',
                'is_vacant' => true,
            ],
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 5,
                'gfps_position' => 'President, Federated Faculty Union',
                'gfps_role' => 'Member',
                'name' => null,
                'designation' => null,
                'remarks' => '',
                'is_vacant' => true,
            ],
            [
                'section' => 'Directors / Other Members',
                'sort_order' => 6,
                'gfps_position' => 'President, Federated College Student Council',
                'gfps_role' => 'Member',
                'name' => null,
                'designation' => null,
                'remarks' => '',
                'is_vacant' => true,
            ],
        ];

        foreach ($members as $member) {
            GfpsMember::create($member);
        }
    }
}
