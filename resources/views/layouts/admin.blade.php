<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - GAD CatSU')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(to right, rgb(255, 30, 199), rgb(78, 228, 255));
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-item {
            color: white !important;
            font-weight: 600;
        }
        .admin-sidebar {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }
        .admin-sidebar h3 {
            margin-bottom: 1rem;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 0.5rem;
        }
        .admin-sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .admin-sidebar li {
            margin-bottom: 0.5rem;
        }
        .admin-sidebar a {
            color: #667eea;
            display: block;
            padding: 0.75rem;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .admin-sidebar a:hover {
            background-color: #f5f5f5;
            padding-left: 1.5rem;
            color: #333;
        }
        .content-box {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #667eea;
        }
        .page-header h2 {
            color: #333;
            margin: 0;
        }
        .page-header-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .table-container {
            overflow-x: auto;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .action-buttons a,
        .action-buttons form {
            margin: 0;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge.blue { background-color: #e3f2fd; color: #1976d2; }
        .badge.green { background-color: #e8f5e9; color: #388e3c; }
        .badge.orange { background-color: #fff3e0; color: #f57c00; }
        .badge.red { background-color: #ffebee; color: #d32f2f; }
        .dashboard-link {
            display: block;
            margin-bottom: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            text-align: center;
        }
        .dashboard-link:hover {
            color: #333;
        }
        @yield('extra-styles')
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="navbar-item">
                <span style="color: white; font-weight: bold; font-size: 1.25rem;">GAD CatSU Admin</span>
            </div>
        </div>

        <div class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="button is-danger is-small">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="columns">
            <div class="column is-3">
                <div class="admin-sidebar">
                    <h3><i class="fas fa-home"></i> Dashboard</h3>
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Main Dashboard</a></li>
                    </ul>

                    <h3 style="margin-top: 2rem;"><i class="fas fa-cog"></i> Management</h3>
                    <ul>
                        <li><a href="{{ route('admin.statistics.index') }}"><i class="fas fa-chart-pie"></i> Statistics</a></li>
                        <li><a href="{{ route('admin.banners.index') }}"><i class="fas fa-images"></i> Banners</a></li>
                        <li><a href="{{ route('admin.accomplishment-reports.index') }}"><i class="fas fa-trophy"></i> Accomplishment Reports</a></li>
                        <li><a href="{{ route('admin.charts.index') }}"><i class="fas fa-chart-line"></i> Charts</a></li>
                        <li><a href="{{ route('admin.announcements.index') }}"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                        <li><a href="{{ route('admin.organization-members.index') }}"><i class="fas fa-sitemap"></i> Organization Members</a></li>
                        <li><a href="{{ route('admin.programs.index') }}"><i class="fas fa-project-diagram"></i> Programs</a></li>
                        <li><a href="{{ route('admin.documents.index') }}"><i class="fas fa-file-pdf"></i> Documents</a></li>
                    </ul>

                    <h3 style="margin-top: 2rem;"><i class="fas fa-heart"></i> GAD Modules</h3>
                    <ul>
                        <li><a href="{{ route('admin.gad-submissions.index') }}"><i class="fas fa-file-alt"></i> GAD Submissions</a></li>
                        <li><a href="{{ route('admin.gad-agendas.index') }}"><i class="fas fa-calendar-alt"></i> GAD Agendas</a></li>
                        <li><a href="{{ route('admin.gad-guidelines.index') }}"><i class="fas fa-book"></i> GAD Guidelines</a></li>
                    </ul>

                    <h3 style="margin-top: 2rem;"><i class="fas fa-lock"></i> Security & Logs</h3>
                    <ul>
                        <li><a href="{{ route('admin.activity-logs.index') }}"><i class="fas fa-history"></i> Activity History</a></li>
                    </ul>
                </div>
            </div>

            <div class="column is-9">
                <div class="content-box">
                    @if (session('success'))
                        <div class="notification is-success">
                            <button class="delete"></button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', () => {
                button.parentElement.style.display = 'none';
            });
        });
    </script>

    @yield('extra-scripts')
</body>
</html>
