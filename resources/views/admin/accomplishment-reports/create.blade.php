<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Accomplishment Report - GAD CatSU Admin</title>
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
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .input.is-danger,
        .textarea.is-danger,
        .select.is-danger {
            border-color: #e74c3c;
        }
        .error-text {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.25rem;
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
                        <h2><i class="fas fa-plus"></i> Create Accomplishment Report</h2>
                        <a href="{{ route('admin.accomplishment-reports.index') }}" class="button is-light">
                            <span class="icon"><i class="fas fa-arrow-left"></i></span>
                            <span>Back</span>
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="notification is-danger">
                            <button class="delete"></button>
                            <strong>Please fix the following errors:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.accomplishment-reports.store') }}">
                        @csrf

                        <div class="field">
                            <label class="label">Title *</label>
                            <div class="control">
                                <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="e.g., GAD Seminar 2024" value="{{ old('title') }}" required>
                            </div>
                            @error('title')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="columns">
                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Year *</label>
                                    <div class="control">
                                        <input class="input @error('year') is-danger @enderror" type="number" name="year" placeholder="2024" value="{{ old('year', date('Y')) }}" min="2000" max="9999" required>
                                    </div>
                                    @error('year')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">College *</label>
                                    <div class="control">
                                        <div class="select is-fullwidth @error('college') is-danger @enderror">
                                            <select name="college" required>
                                                <option value="">-- Select College --</option>
                                                <option value="College of Computer Studies" {{ old('college') === 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                                                <option value="College of Business Administration" {{ old('college') === 'College of Business Administration' ? 'selected' : '' }}>College of Business Administration</option>
                                                <option value="College of Engineering" {{ old('college') === 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                                                <option value="College of Arts and Sciences" {{ old('college') === 'College of Arts and Sciences' ? 'selected' : '' }}>College of Arts and Sciences</option>
                                                <option value="College of Education" {{ old('college') === 'College of Education' ? 'selected' : '' }}>College of Education</option>
                                            </select>
                                        </div>
                                    </div>
                                    @error('college')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Gender *</label>
                                    <div class="control">
                                        <div class="select is-fullwidth @error('gender') is-danger @enderror">
                                            <select name="gender" required>
                                                <option value="">-- Select Gender --</option>
                                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Participants Count *</label>
                                    <div class="control">
                                        <input class="input @error('participants_count') is-danger @enderror" type="number" name="participants_count" placeholder="0" value="{{ old('participants_count', 0) }}" min="0" required>
                                    </div>
                                    @error('participants_count')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Content/Description *</label>
                            <div class="control">
                                <textarea class="textarea @error('content') is-danger @enderror" name="content" placeholder="Describe the accomplishment..." rows="6" required>{{ old('content') }}</textarea>
                            </div>
                            @error('content')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    <span class="icon"><i class="fas fa-save"></i></span>
                                    <span>Create Report</span>
                                </button>
                            </div>
                            <div class="control">
                                <a href="{{ route('admin.accomplishment-reports.index') }}" class="button is-light">
                                    <span>Cancel</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
