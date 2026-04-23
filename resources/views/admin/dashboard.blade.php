@extends('layouts.admin')

@section('title', 'Admin Dashboard - GAD CatSU')

@section('content')
<div class="welcome-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
    <h2 style="margin: 0 0 0.5rem 0; color: white;"><i class="fas fa-tachometer-alt"></i> Welcome to Admin Dashboard</h2>
    <p style="margin: 0; color: rgba(255, 255, 255, 0.9);">Manage your GAD CatSU website content from here.</p>
</div>

<div style="text-align: center; padding: 2rem;">
    <p style="color: #666; font-size: 1.1rem; margin-bottom: 3rem;">Select an option from the menu to manage content.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
        <a href="{{ route('admin.statistics.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-chart-pie"></i></div>
            <div style="color: #333; font-weight: 600;">Statistics</div>
        </a>
        
        <a href="{{ route('admin.banners.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-images"></i></div>
            <div style="color: #333; font-weight: 600;">Banners</div>
        </a>
        
        <a href="{{ route('admin.accomplishment-reports.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-trophy"></i></div>
            <div style="color: #333; font-weight: 600;">Accomplishment Reports</div>
        </a>
        
        <a href="{{ route('admin.charts.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-chart-line"></i></div>
            <div style="color: #333; font-weight: 600;">Charts</div>
        </a>
        
        <a href="{{ route('admin.announcements.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-bullhorn"></i></div>
            <div style="color: #333; font-weight: 600;">Announcements</div>
        </a>
        
        <a href="{{ route('admin.organization-members.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-sitemap"></i></div>
            <div style="color: #333; font-weight: 600;">Organization Members</div>
        </a>
        
        <a href="{{ route('admin.programs.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-project-diagram"></i></div>
            <div style="color: #333; font-weight: 600;">Programs</div>
        </a>
        
        <a href="{{ route('admin.documents.index') }}" style="text-decoration: none; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: block;">
            <div style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"><i class="fas fa-file-pdf"></i></div>
            <div style="color: #333; font-weight: 600;">Documents</div>
        </a>
    </div>
</div>

<style>
    a:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px);
    }
</style>
@endsection
