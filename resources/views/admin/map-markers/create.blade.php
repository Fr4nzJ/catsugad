@extends('layouts.admin')

@section('title', 'Create Map Marker')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 4rem;">
    <!-- Page Header -->
    <div style="margin-bottom: 2rem;">
        <h1 style="margin: 0; color: #333; font-size: 2rem;">
            <i class="fas fa-map-pin"></i> Create Map Marker
        </h1>
        <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.95rem;">Add a new location marker to the map</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Form Section -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <form action="{{ route('admin.map-markers.store') }}" method="POST">
                @csrf

                <!-- Marker Name -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 600;">
                        Marker Name <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g., Faculty Center" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                        required>
                    @error('name')
                        <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Latitude -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 600;">
                        Latitude <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="number" name="latitude" step="0.000001" value="{{ old('latitude', 13.5936) }}" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                        required>
                    @error('latitude')
                        <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                    <small style="color: #666; display: block; margin-top: 0.25rem;">Click on the map to set the latitude</small>
                </div>

                <!-- Longitude -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 600;">
                        Longitude <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="number" name="longitude" step="0.000001" value="{{ old('longitude', 124.3615) }}" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                        required>
                    @error('longitude')
                        <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                    <small style="color: #666; display: block; margin-top: 0.25rem;">Click on the map to set the longitude</small>
                </div>

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 600;">
                        Description
                    </label>
                    <textarea name="description" rows="3" placeholder="Enter location description..." 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box; font-family: inherit;">{{ old('description') }}</textarea>
                    @error('description')
                        <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Page -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 600;">
                        Page <span style="color: #e74c3c;">*</span>
                    </label>
                    <select name="page" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" required>
                        <option value="">Select a page</option>
                        <option value="contact" {{ old('page') === 'contact' ? 'selected' : '' }}>Contact Page</option>
                        <option value="programs" {{ old('page') === 'programs' ? 'selected' : '' }}>Programs Page</option>
                    </select>
                    @error('page')
                        <span style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Active -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} 
                            style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="color: #333; font-weight: 600;">Active</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="flex: 1; background: #667eea; color: white; padding: 0.75rem; border: none; border-radius: 4px; font-size: 1rem; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-save"></i> Create Marker
                    </button>
                    <a href="{{ route('admin.map-markers.index') }}" style="display: flex; align-items: center; justify-content: center; flex: 1; background: #6c757d; color: white; padding: 0.75rem; border-radius: 4px; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Map Section -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; margin-bottom: 1rem; color: #333;">
                <i class="fas fa-map"></i> Click on map to set marker position
            </h3>
            <div id="map" style="width: 100%; height: 400px; border-radius: 4px; border: 1px solid #ddd;"></div>
            <p style="margin: 1rem 0 0 0; color: #666; font-size: 0.9rem;">
                <strong>Tip:</strong> Click anywhere on the map to place the marker. The latitude and longitude will update automatically.
            </p>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<!-- Leaflet JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    const latInput = document.querySelector('input[name="latitude"]');
    const lonInput = document.querySelector('input[name="longitude"]');
    
    // Initialize map
    const map = L.map('map').setView([{{ old('latitude', 13.5936) }}, {{ old('longitude', 124.3615) }}], 15);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    let marker = L.marker([{{ old('latitude', 13.5936) }}, {{ old('longitude', 124.3615) }}])
        .addTo(map);
    
    // Handle map clicks to set marker position
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lon = e.latlng.lng;
        
        // Update form inputs
        latInput.value = lat.toFixed(6);
        lonInput.value = lon.toFixed(6);
        
        // Update marker position
        marker.setLatLng([lat, lon]);
    });
</script>
@endsection
