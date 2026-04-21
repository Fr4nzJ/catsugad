<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Charts - GAD CatSU Admin</title>
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
            transition: all 0.3s ease;
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
        }
        .page-header h2 {
            margin: 0;
            color: #333;
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
                        <li><a href="{{ route('admin.charts.index') }}"><i class="fas fa-chart-line"></i> Charts</a></li>
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

                    <div class="page-header">
                        <h2><i class="fas fa-chart-line"></i> Manage Charts</h2>
                        <a href="{{ route('admin.charts.create') }}" class="button is-info">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>Add Chart</span>
                        </a>
                    </div>

                    @if ($charts->count() > 0)
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($charts as $chart)
                                        <tr>
                                            <td>{{ $chart->name }}</td>
                                            <td>
                                                <span class="tag {{ $chart->type === 'growth' ? 'is-info' : 'is-warning' }}">
                                                    {{ ucfirst($chart->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($chart->is_active)
                                                    <span class="tag is-success">Active</span>
                                                @else
                                                    <span class="tag is-light">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $chart->order }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.charts.edit', $chart) }}" class="button is-small is-info">Edit</a>
                                                    <form action="{{ route('admin.charts.destroy', $chart) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button is-small is-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $charts->links() }}
                        </div>
                    @else
                        <div class="notification is-info">
                            <p>No charts found. <a href="{{ route('admin.charts.create') }}">Create one</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
</body>
</html>
