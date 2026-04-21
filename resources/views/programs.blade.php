@extends('layouts.layout')
@section('title', 'Our Programs')
@section('content')

<style>
    .hero-content {
        background: linear-gradient(to right, rgba(102, 126, 234, 0.1), rgba(78, 228, 255, 0.1));
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
    }
    .hero-content h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }
    .hero-content .subtitle {
        font-size: 1.25rem;
        color: #666;
    }
    .main-banner img {
        width: 100%;
        height: auto;
        object-fit: cover;
        display: block;
        margin: 2rem auto;
    }
</style>
<div class="hero-content">
    <h1>Our Programs</h1>
    <p class="subtitle">Dedicated to promoting gender equality and empowering communities</p>
</div>
<div class="main-banner">
    @if ($banner)
        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->name }}">
    @else
        <img src="{{ asset('images/sliders/4ft x 11ft Streamer.png') }}" alt="Main Banner">
    @endif
</div>
@endsection