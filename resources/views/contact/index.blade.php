@extends('layouts.layout')

@section('title', 'Contact Information - Gender and Development Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <h1 style="margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-envelope"></i> Contact Information
        </h1>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">Get in touch with us</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
        <!-- Contact Information Card -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="margin-top: 0; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
                <i class="fas fa-building"></i> {{ $contactInfo['office_name'] }}
            </h2>

            <div style="margin-top: 1.5rem;">
                <!-- Address -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="margin: 0 0 0.5rem 0; color: #333; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-map-marker-alt" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Office Address
                    </h3>
                    <p style="margin: 0; color: #666; line-height: 1.6;">{{ $contactInfo['office_address'] }}</p>
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="margin: 0 0 0.5rem 0; color: #333; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-envelope" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Email
                    </h3>
                    <p style="margin: 0;"><a href="mailto:{{ $contactInfo['email'] }}" style="color: #667eea; text-decoration: none; font-weight: 500;">{{ $contactInfo['email'] }}</a></p>
                </div>

                <!-- Office Hours -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="margin: 0 0 0.5rem 0; color: #333; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-clock" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Office Hours
                    </h3>
                    <p style="margin: 0; color: #666;">{{ $contactInfo['office_hours'] }}</p>
                </div>

                <!-- Social Media -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #ddd;">
                    <h3 style="margin: 0 0 1rem 0; color: #333; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-share-alt" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Follow Us
                    </h3>
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ $contactInfo['facebook'] }}" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #667eea; color: white; border-radius: 50%; text-decoration: none; font-size: 1.2rem;">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Contact Form Area -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="margin-top: 0; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
                <i class="fas fa-comments"></i> Message Us
            </h2>

            <div style="margin-top: 1.5rem;">
                <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #667eea;">
                    <h3 style="margin-top: 0; color: #333;">Have a question?</h3>
                    <p style="margin: 0.5rem 0; color: #666;">We're here to help! Feel free to reach out to us through any of the contact methods listed on the left.</p>
                    <p style="margin: 0.5rem 0; color: #666; font-size: 0.95rem;">For inquiries about GAD-related programs and services, please contact our office during business hours.</p>
                </div>

                <div style="margin-top: 1.5rem;">
                    <h3 style="margin-top: 0; color: #333; font-size: 1rem;">Departments & Services</h3>
                    <ul style="margin: 0.5rem 0; padding-left: 1.5rem; color: #666;">
                        <li style="margin-bottom: 0.5rem;">Gender Sensitivity Training</li>
                        <li style="margin-bottom: 0.5rem;">Women Empowerment Programs</li>
                        <li style="margin-bottom: 0.5rem;">Policy & Advocacy</li>
                        <li style="margin-bottom: 0.5rem;">Documentation & Reporting</li>
                    </ul>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #ddd;">
                    <p style="margin: 0; color: #999; font-size: 0.9rem; font-style: italic;">Response time: Usually within 24-48 business hours</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div style="margin-bottom: 4rem;">
        <h2 style="font-size: 1.8rem; color: #333; margin-bottom: 1.5rem; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
            <i class="fas fa-map"></i> Find Us on the Map
        </h2>
        
        <div id="map" style="width: 100%; height: 400px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
    </div>

    <!-- Locations Section -->
    @if (!empty($contactInfo['locations']))
        <h2 style="font-size: 1.8rem; color: #333; margin-bottom: 2rem; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
            <i class="fas fa-map"></i> Our Locations
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach ($contactInfo['locations'] as $location)
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #667eea;">{{ $location['name'] }}</h3>
                    
                    <p style="margin: 0.75rem 0; color: #666;">
                        <i class="fas fa-map-marker-alt" style="color: #667eea; margin-right: 0.5rem;"></i>
                        {{ $location['address'] }}
                    </p>

                    <p style="margin: 0.75rem 0; color: #666;">
                        <i class="fas fa-clock" style="color: #667eea; margin-right: 0.5rem;"></i>
                        {{ $location['hours'] }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        div[style*="grid-template-columns: repeat"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<!-- Leaflet JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // Initialize the map
    const map = L.map('map').setView([{{ $marker->latitude ?? 13.7942 }}, {{ $marker->longitude ?? 124.4387 }}], 10);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add marker for the office location
    @if($marker)
        L.marker([{{ $marker->latitude }}, {{ $marker->longitude }}])
            .addTo(map)
            .bindPopup(`
                <div style="font-family: Arial, sans-serif; width: 250px;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #667eea;">{{ $marker->name }}</h4>
                    <p style="margin: 0.3rem 0; color: #666;"><strong>Location:</strong> {{ $marker->name }}</p>
                    <p style="margin: 0.3rem 0; color: #666;"><strong>Address:</strong> {{ $contactInfo['office_address'] }}</p>
                    <p style="margin: 0.3rem 0; color: #666;"><strong>Hours:</strong> {{ $contactInfo['office_hours'] }}</p>
                    @if($marker->description)
                        <p style="margin: 0.3rem 0; color: #666;"><strong>Description:</strong> {{ $marker->description }}</p>
                    @endif
                    <p style="margin: 0.5rem 0 0 0; color: #667eea;"><a href="mailto:{{ $contactInfo['email'] }}" style="color: #667eea; text-decoration: none;">{{ $contactInfo['email'] }}</a></p>
                </div>
            `)
            .openPopup();
            
        // Center the map on the marker
        map.setView([{{ $marker->latitude }}, {{ $marker->longitude }}], 16);
    @endif
</script>

@endsection
