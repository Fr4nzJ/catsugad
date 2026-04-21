<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Page Banners - GAD CatSU Admin</title>
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
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background-color: #e3f2fd;
            color: #1976d2;
        }
        .banner-preview {
            width: 150px;
            height: 100px;
            border-radius: 4px;
            object-fit: cover;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
                        <h2><i class="fas fa-images"></i> Manage Page Banners</h2>
                        <a href="{{ route('admin.banners.create') }}" class="button is-info">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>Add Banner</span>
                        </a>
                    </div>

                    @if ($banners->count() > 0)
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Page</th>
                                        <th>Preview</th>
                                        <th>Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td><strong>{{ $banner->name }}</strong></td>
                                            <td>
                                                <span class="badge">{{ ucfirst($banner->page) }}</span>
                                            </td>
                                            <td>
                                                <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->name }}" class="banner-preview">
                                            </td>
                                            <td>
                                                @if ($banner->is_active)
                                                    <span class="tag is-success is-light">Active</span>
                                                @else
                                                    <span class="tag is-danger is-light">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="button is-small is-info is-light">
                                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button is-small is-danger is-light">
                                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            {{ $banners->links() }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem;">
                            <p style="color: #999; font-size: 1.1rem;">No banners found. <a href="{{ route('admin.banners.create') }}">Create one now</a></p>
                        </div>
                    @endif
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
</body>
</html>
