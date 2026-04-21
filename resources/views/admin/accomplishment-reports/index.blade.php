<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accomplishment Reports - GAD CatSU Admin</title>
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
        }
        .admin-sidebar li {
            margin-bottom: 0.5rem;
        }
        .admin-sidebar a {
            color: #667eea;
            display: block;
            padding: 0.5rem;
            border-radius: 4px;
            text-decoration: none;
        }
        .admin-sidebar a:hover {
            background-color: #f5f5f5;
            padding-left: 1rem;
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
                    <h3><i class="fas fa-chart-bar"></i> Management</h3>
                    <ul>
                        <li><a href="{{ route('admin.statistics.index') }}"><i class="fas fa-list"></i> Statistics</a></li>
                        <li><a href="{{ route('admin.banners.index') }}"><i class="fas fa-images"></i> Banners</a></li>
                        <li><a href="{{ route('admin.accomplishment-reports.index') }}"><i class="fas fa-chart-bar"></i> Accomplishment Reports</a></li>
                        <li><a href="{{ route('admin.charts.index') }}"><i class="fas fa-chart-line"></i> Charts</a></li>
                    </ul>
                </div>
            </div>

            <div class="column is-9">
                <div class="content-box">
                    <div class="page-header">
                        <h2><i class="fas fa-list"></i> Accomplishment Reports</h2>
                        <a href="{{ route('admin.accomplishment-reports.create') }}" class="button is-primary">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>New Report</span>
                        </a>
                    </div>

                    @if($message = Session::get('success'))
                        <div class="notification is-success is-light">
                            <button class="delete"></button>
                            <i class="fas fa-check-circle"></i> {{ $message }}
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div style="background-color: #f9f9f9; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 1rem;"><i class="fas fa-filter"></i> Filter by</h5>
                        <form method="GET" action="{{ route('admin.accomplishment-reports.index') }}" class="columns">
                            <div class="column is-5">
                                <div class="field">
                                    <label class="label">College</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select name="college">
                                                <option value="">-- All Colleges --</option>
                                                @foreach($colleges as $college)
                                                    <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
                                                        {{ $college }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-5">
                                <div class="field">
                                    <label class="label">Gender</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select name="gender">
                                                <option value="">-- All Genders --</option>
                                                <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-2 is-flex is-align-items-flex-end">
                                <button type="submit" class="button is-info is-fullwidth">
                                    <span class="icon"><i class="fas fa-search"></i></span>
                                    <span>Filter</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Reports Table -->
                    <div class="table-container">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr style="background-color: #f5f5f5;">
                                    <th>Title</th>
                                    <th>Year</th>
                                    <th>College</th>
                                    <th>Gender</th>
                                    <th>Participants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>
                                            <strong>{{ $report->title }}</strong><br>
                                            <small style="color: #999;">{{ Str::limit($report->content, 50) }}</small>
                                        </td>
                                        <td>{{ $report->year }}</td>
                                        <td>{{ $report->college ?? 'N/A' }}</td>
                                        <td>
                                            <span class="tag {{ $report->gender === 'male' ? 'is-info' : 'is-danger' }}">
                                                {{ ucfirst($report->gender) }}
                                            </span>
                                        </td>
                                        <td>{{ $report->participants_count }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.accomplishment-reports.edit', $report) }}" class="button is-small is-warning" title="Edit">
                                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                                </a>
                                                <form method="POST" action="{{ route('admin.accomplishment-reports.destroy', $report) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="button is-small is-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #999; padding: 2rem;">
                                            <i class="fas fa-inbox"></i> No accomplishment reports found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reports->hasPages())
                        <div style="margin-top: 2rem; display: flex; justify-content: center;">
                            {{ $reports->links('pagination::simple-bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete').forEach(deleteBtn => {
            deleteBtn.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    </script>
</body>
</html>
