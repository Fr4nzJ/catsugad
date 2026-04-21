<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Statistic - GAD CatSU Admin</title>
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
        .textarea.is-danger {
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
                        <li><a href="{{ route('admin.charts.index') }}"><i class="fas fa-chart-line"></i> Charts</a></li>
                    </ul>
                </div>
            </div>

            <div class="column is-9">
                <div class="content-box">
                    <div class="page-header">
                        <h2><i class="fas fa-edit"></i> Edit Statistic</h2>
                        <a href="{{ route('admin.statistics.index') }}" class="button is-light">
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

                    <form method="POST" action="{{ route('admin.statistics.update', $statistic) }}">
                        @csrf
                        @method('PUT')

                        <div class="field">
                            <label class="label">Value *</label>
                            <div class="control">
                                <input class="input @error('value') is-danger @enderror" type="text" name="value" placeholder="e.g., 500+" value="{{ old('value', $statistic->value) }}" required>
                            </div>
                            @error('value')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Label *</label>
                            <div class="control">
                                <input class="input @error('label') is-danger @enderror" type="text" name="label" placeholder="e.g., Beneficiaries Reached" value="{{ old('label', $statistic->label) }}" required>
                            </div>
                            @error('label')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="textarea @error('description') is-danger @enderror" name="description" placeholder="Enter description..." rows="4">{{ old('description', $statistic->description) }}</textarea>
                            </div>
                            @error('description')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Icon</label>
                            <div class="control">
                                <div class="select is-fullwidth @error('icon') is-danger @enderror">
                                    <select name="icon">
                                        <option value="">-- Select an icon --</option>
                                        <option value="fas fa-users" {{ old('icon', $statistic->icon) === 'fas fa-users' ? 'selected' : '' }}>👥 Users</option>
                                        <option value="fas fa-chart-bar" {{ old('icon', $statistic->icon) === 'fas fa-chart-bar' ? 'selected' : '' }}>📊 Chart Bar</option>
                                        <option value="fas fa-heart" {{ old('icon', $statistic->icon) === 'fas fa-heart' ? 'selected' : '' }}>❤️ Heart</option>
                                        <option value="fas fa-star" {{ old('icon', $statistic->icon) === 'fas fa-star' ? 'selected' : '' }}>⭐ Star</option>
                                        <option value="fas fa-handshake" {{ old('icon', $statistic->icon) === 'fas fa-handshake' ? 'selected' : '' }}>🤝 Handshake</option>
                                        <option value="fas fa-globe" {{ old('icon', $statistic->icon) === 'fas fa-globe' ? 'selected' : '' }}>🌍 Globe</option>
                                        <option value="fas fa-lightbulb" {{ old('icon', $statistic->icon) === 'fas fa-lightbulb' ? 'selected' : '' }}>💡 Lightbulb</option>
                                        <option value="fas fa-rocket" {{ old('icon', $statistic->icon) === 'fas fa-rocket' ? 'selected' : '' }}>🚀 Rocket</option>
                                        <option value="fas fa-briefcase" {{ old('icon', $statistic->icon) === 'fas fa-briefcase' ? 'selected' : '' }}>💼 Briefcase</option>
                                        <option value="fas fa-graduation-cap" {{ old('icon', $statistic->icon) === 'fas fa-graduation-cap' ? 'selected' : '' }}>🎓 Graduation Cap</option>
                                        <option value="fas fa-award" {{ old('icon', $statistic->icon) === 'fas fa-award' ? 'selected' : '' }}>🏆 Award</option>
                                        <option value="fas fa-thumbs-up" {{ old('icon', $statistic->icon) === 'fas fa-thumbs-up' ? 'selected' : '' }}>👍 Thumbs Up</option>
                                        <option value="fas fa-tree" {{ old('icon', $statistic->icon) === 'fas fa-tree' ? 'selected' : '' }}>🌳 Tree</option>
                                        <option value="fas fa-book" {{ old('icon', $statistic->icon) === 'fas fa-book' ? 'selected' : '' }}>📖 Book</option>
                                        <option value="fas fa-user" {{ old('icon', $statistic->icon) === 'fas fa-user' ? 'selected' : '' }}>👤 User</option>
                                        <option value="fas fa-check-circle" {{ old('icon', $statistic->icon) === 'fas fa-check-circle' ? 'selected' : '' }}>✓ Check Circle</option>
                                        <option value="fas fa-comments" {{ old('icon', $statistic->icon) === 'fas fa-comments' ? 'selected' : '' }}>💬 Comments</option>
                                        <option value="fas fa-folder" {{ old('icon', $statistic->icon) === 'fas fa-folder' ? 'selected' : '' }}>📁 Folder</option>
                                        <option value="fas fa-calendar" {{ old('icon', $statistic->icon) === 'fas fa-calendar' ? 'selected' : '' }}>📅 Calendar</option>
                                        <option value="fas fa-bullseye" {{ old('icon', $statistic->icon) === 'fas fa-bullseye' ? 'selected' : '' }}>🎯 Bullseye</option>
                                    </select>
                                </div>
                            </div>
                            @error('icon')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Color *</label>
                            <div class="control">
                                <div class="select is-fullwidth @error('color') is-danger @enderror">
                                    <select name="color" required>
                                        <option value="blue" {{ old('color', $statistic->color) === 'blue' ? 'selected' : '' }}>Blue</option>
                                        <option value="green" {{ old('color', $statistic->color) === 'green' ? 'selected' : '' }}>Green</option>
                                        <option value="orange" {{ old('color', $statistic->color) === 'orange' ? 'selected' : '' }}>Orange</option>
                                        <option value="red" {{ old('color', $statistic->color) === 'red' ? 'selected' : '' }}>Red</option>
                                    </select>
                                </div>
                            </div>
                            @error('color')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-info">
                                    <span class="icon"><i class="fas fa-save"></i></span>
                                    <span>Update Statistic</span>
                                </button>
                            </div>
                            <div class="control">
                                <a href="{{ route('admin.statistics.index') }}" class="button is-light">
                                    <span>Cancel</span>
                                </a>
                            </div>
                        </div>
                    </form>
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
