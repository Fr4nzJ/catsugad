<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        $contactInfo = [
            'office_address' => 'Office of the Sangguniang Barangay, Catsuwuan, Bulacan, Philippines',
            'office_name' => 'GAD Office - Gender and Development Services',
            'email' => 'gad@catsugad.gov.ph',
            'phone' => '+63 (44) 123-4567',
            'mobile' => '+63 917 456 7890',
            'office_hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            'facebook' => 'https://facebook.com/catsugad',
            'locations' => [
                [
                    'name' => 'Main Office',
                    'address' => 'Catsuwuan, Bulacan',
                    'phone' => '+63 (44) 123-4567',
                    'hours' => 'Mon-Fri: 8:00 AM - 5:00 PM'
                ]
            ]
        ];

        return view('contact.index', compact('contactInfo'));
    }
}
