<?php

namespace App\Http\Controllers;

use App\Models\MapMarker;

class ContactController extends Controller
{
    public function index()
    {
        $contactInfo = [
            'office_address' => 'Catanduanes State University / Calatagan, Virac, Catanduanes',
            'office_name' => 'GAD Office - Gender and Development Services',
            'email' => 'genderdev@catsu.edu.ph',
            'office_hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            'facebook' => 'https://www.facebook.com/profile.php?id=100081133441100',
            'locations' => [
                [
                    'name' => 'Main Office',
                    'address' => 'Calatagan, Virac, Catanduanes',
                    'hours' => 'Mon-Fri: 8:00 AM - 5:00 PM'
                ]
            ]
        ];

        // Fetch active map marker for contact page
        $marker = MapMarker::where('page', 'contact')->where('is_active', true)->first();

        return view('contact.index', compact('contactInfo', 'marker'));
    }
}
