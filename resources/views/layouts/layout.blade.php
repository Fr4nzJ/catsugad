<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Gender and Development Services')</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js for Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        .banner {
            background-color:#8f1eae;
            padding: 0rem 1rem;
            padding-top: 3rem;
        }
        .facebook-info {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        }

        .facebook-info .text {
        display: block;
        }
        .footer{
            background-color: #f665b7;
            color: #000000;
            text-align: center;
            padding: 1rem 0;
            height: 200px;
            border-top: #282626 solid 1px;
            box-shadow: 0 -4px 10px rgba(0,0,0,0.2);
        }
        .footer-container{
            display:flex;
            justify-content: space-between;
            align-items: center; 
            gap:40px;
        }
        .footer-content-1{
            text-align: left;
        }
        .footer-content-2{
            text-align: left;
        }
        .footer-image-container{
            display:flex;
            justify-content: center;
            align-items:center;
            padding-left: 3rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .footer-image-container img{
            width: 150px;
            height: auto;
            opacity: 0.8;
        }
        .footer-image-container img:hover{
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        .footer-image-container-2{
            display:flex;
            justify-content: center;
            align-items:center;
            padding-right: 3rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .footer-image-container-2 img{
            width: 150px;
            height: auto;
            opacity: 0.8;
        }
        .footer-image-container-2 img:hover{
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        .navbar {
            background: linear-gradient(to right, #ff0191, rgb(0, 64, 255));
            height: 65px;
            padding: 0rem 1rem;
            position: fixed;
            z-index: 1000;
            width: 100%;
             box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
             color: #ffffff;
             font-weight: normal;
        }
        .navbar-dropdown .navbar-item{
            color:#000000 !important;
        }
        .navbar-dropdown .navbar-item:hover{
            background-color: #8f1eae !important;
        }
        .navbar-item {
            color: #ffffff;
            font-weight: normal;
            transition: color 0.3s ease, background-color 0.3s ease;
        }
        .navbar-item.has-dropdown .navbar-link {
            color: #ffffff;
        }
        .navbar-item.has-dropdown .navbar-link:hover {
            color: #000000;
        }
        .navbar-item.is-active {
            color:#8d15f0 !important;
                background-color: #ffffff !important;
                font-weight: bold;
        }

        .navbar-item:hover {
            color: #000000 !important;
            background-color: #ffffff !important;
        }
        .icon-text .icon {
            margin-right: 5px;
        }
        .navbar-brand .navbar-item img {
            height: 50px !important;
            width: auto !important;
            margin: 0 !important;
            max-height: 50px !important;
        }
        .pre-footer {
            background-color: #ff41ad;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            height: 500px;
             display: flex;
             align-items: center;
             justify-content: center;
        }
        .pre-footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar" role="navigation" aria-label="main navigation" x-data="{ navOpen: false }">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ route('home') }}">
                <span class="icon-text">
                    <img src="{{ asset('images/GAD CatSU.png')}}" alt="CatSu GAD" style="height: 50px; margin: 0;">
                </span>
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" 
               @click="navOpen = !navOpen" :class="{ 'is-active': navOpen }">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu" :class="{ 'is-active': navOpen }">
            <div class="navbar-start">
                <a class="navbar-item {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">
                    <span class="icon-text">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span>Home</span>
                    </span>
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link {{ request()->routeIs('about') ? 'is-active' : '' }}" href="{{ route('about') }}">
                        <span class="icon-text">
                            <span class="icon"><i class="fas fa-info-circle"></i></span>
                            <span>About</span>
                        </span>
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="{{ route('about.mission-vision') }}">
                            <span class="icon"><i class="fas fa-bullseye"></i></span>
                            <span>Mission, Vision and Goal</span>
                        </a>
                        <a class="navbar-item" href="{{ route('about.background') }}">
                            <span class="icon"><i class="fas fa-history"></i></span>
                            <span>Background</span>
                        </a>
                        <a class="navbar-item" href="{{ route('about.organizational-chart') }}">
                            <span class="icon"><i class="fas fa-sitemap"></i></span>
                            <span>Organizational Chart</span>
                        </a>
                        <a class="navbar-item" href="{{ route('about.laws-issuances') }}">
                            <span class="icon"><i class="fas fa-file-alt"></i></span>
                            <span>Laws and Issuances</span>
                        </a>
                        <a class="navbar-item" href="{{ route('about.gad-planning-budgeting') }}">
                            <span class="icon"><i class="fas fa-chart-bar"></i></span>
                            <span>Policy Imperatives for GAD Planning and Budgeting</span>
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('about.definition-terms') }}">
                            <span class="icon"><i class="fas fa-book"></i></span>
                            <span>Definition of Terms</span>
                        </a>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link {{ request()->routeIs('programs.index') ? 'is-active' : '' }}" href="{{ route('programs.index') }}">
                            <span class="icon-text">
                                <span class="icon"><i class="fas fa-project-diagram"></i></span>
                                <span>Programs and Services</span>
                            </span>
                        </a>
                        <div class="navbar-dropdown">
                            @forelse($navPrograms as $program)
                                <a class="navbar-item" href="{{ route('programs.show', $program) }}">
                                    <span class="icon"><i class="fas fa-project-diagram"></i></span>
                                    <span>{{ $program->program_name }}</span>
                                </a>
                            @empty
                                <a class="navbar-item" disabled style="color: #999;">
                                    <span>No programs available</span>
                                </a>
                            @endforelse
                        </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link {{ request()->routeIs('gad-plan-budget') ? 'is-active' : '' }}" href="{{ route('documents.index', ['category' => 'GAD Plan and Budget']) }}">
                        <span class="icon-text">
                            <span class="icon"><i class="fas fa-book"></i></span>
                            <span>GAD Plan and Budget</span>
                        </span>
                    </a>
                    <div class="navbar-dropdown">
                        @forelse($navGadDocuments as $document)
                            <a class="navbar-item" href="{{ route('documents.download', $document) }}" target="_blank">
                                <span class="icon"><i class="fas fa-file-pdf"></i></span>
                                <span>{{ $document->title }}</span>
                            </a>
                        @empty
                            <a class="navbar-item" disabled style="color: #999;">
                                <span>No documents available</span>
                            </a>
                        @endforelse
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('documents.index', ['category' => 'GAD Plan and Budget']) }}">
                            <span class="icon"><i class="fas fa-folder-open"></i></span>
                            <span>View All Documents</span>
                        </a>
                    </div>
                </div>
                <a class="navbar-item {{ request()->routeIs('news-announcements') ? 'is-active' : '' }}" href="{{ route('news-announcements') }}">
                    <span class="icon-text">
                        <span class="icon"><i class="fas fa-bullhorn"></i></span>
                        <span>News/Announcements</span>
                    </span>
                </a>
                <a class="navbar-item {{ request()->routeIs('accomplishment-report') ? 'is-active' : '' }}" href="{{ route('accomplishment-report') }}">
                    <span class="icon-text">
                        <span class="icon"><i class="fas fa-chart-bar"></i></span>
                        <span>Accomplishment Reports</span>
                    </span>
                </a>
                <a class="navbar-item {{ request()->routeIs('contact') ? 'is-active' : '' }}" href="{{ route('contact') }}">
                    <span class="icon-text">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <span>Contact</span>
                    </span>
                </a>
            </div>
        </div>
    </nav>
    <div class="banner">
        <span class="banner-text">
            <img src="{{ asset('images/GAD CatSU Banner.png')}}" alt="CatSu GAD Logo" style="height: 130px">
        </span>
    </div>
    <main>
        @yield('content')
    </main>
<section class="pre-footer">
        <p>&copy; {{ date('Y') }} GAD CatSU. All rights reserved.</p>
</section>
<footer class="footer">
    <div class="footer-container">
      <div class="footer-image-container">
        <img src="{{ asset('images/catsu hr.png')}}" alt="CatSu Logo">
      </div>
      <div class="footer-content-1">
        <h3><strong>Catanduanes State University</strong></h3>
        <p><i class="fas fa-map-marker-alt"></i> Calatagan, Virac, Catanduanes</p>
        <p><i class="fas fa-phone"></i> 0927 876 7574</p>
        <p><i class="fas fa-link"></i> <a href="https://www.catsu.edu.ph" target="_blank">www.catsu.edu.ph</a></p>
        <p><i class="fab fa-facebook"></i> Catanduanes State University</p>
        <p><i class="fas fa-envelope"></i> catsu1961@catsu.edu.ph</p>
      </div>
      <div class="footer-content-2">
        <h3><strong>Gender and Development Services</strong></h3>
        <p><i class="fas fa-map-marker-alt"></i> Calatagan, Virac, Catanduanes</p>
        <div class="facebook-info">
            <i class="fab fa-facebook"></i>
            <div class="text">
                Gender and Development Services<br>
                Catanduanes State University<br>
                Official Facebook Page
            </div>
            </div>
        <p><i class="fas fa-envelope"></i> genderdev@catsu.edu.ph</p>
      </div>
      <div class="footer-image-container-2">
        <img src="{{ asset('images/GAD CatSU.png')}}" alt="GAD Logo">
      </div>
    </div>
</footer>
</body>
</html>