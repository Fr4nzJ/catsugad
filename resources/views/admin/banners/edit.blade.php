<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner - GAD CatSU Admin</title>
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
        .banner-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 4px;
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .image-preview-container {
            margin-top: 1rem;
        }
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 150px;
            border: 2px dashed #667eea;
            border-radius: 8px;
            cursor: pointer;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .file-upload-label:hover {
            background-color: #f0f0f0;
            border-color: #764ba2;
        }
        .file-upload-label.drag-over {
            background-color: #e8e4f3;
            border-color: #764ba2;
        }
        #imageInput {
            display: none;
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
                    </ul>
                </div>
            </div>

            <div class="column is-9">
                <div class="content-box">
                    <div class="page-header">
                        <h2><i class="fas fa-edit"></i> Edit Banner</h2>
                        <a href="{{ route('admin.banners.index') }}" class="button is-light">
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

                    <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="field">
                            <label class="label">Banner Name *</label>
                            <div class="control">
                                <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="e.g., Main Home Banner" value="{{ old('name', $banner->name) }}" required>
                            </div>
                            @error('name')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Upload Image</label>
                            <div class="control">
                                <label class="file-upload-label" for="imageInput" id="uploadLabel">
                                    <span>
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"></i><br>
                                        Click to upload or drag and drop<br>
                                        <small style="color: #999;">Leave empty to keep current image</small>
                                    </span>
                                </label>
                                <input type="file" id="imageInput" name="image" accept="image/*" @error('image') is-danger @enderror>
                                <div class="image-preview-container">
                                    <p style="color: #666; margin-bottom: 0.5rem; font-weight: 600;">Current Image:</p>
                                    <img id="previewImage" src="{{ asset($banner->image_path) }}" alt="{{ $banner->name }}" class="banner-preview">
                                </div>
                            </div>
                            @error('image')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Page *</label>
                            <div class="control">
                                <div class="select is-fullwidth @error('page') is-danger @enderror">
                                    <select name="page" required>
                                        <option value="">Select a page</option>
                                        <option value="home" {{ old('page', $banner->page) === 'home' ? 'selected' : '' }}>Home</option>
                                        <option value="about" {{ old('page', $banner->page) === 'about' ? 'selected' : '' }}>About</option>
                                        <option value="programs" {{ old('page', $banner->page) === 'programs' ? 'selected' : '' }}>Programs</option>
                                        <option value="news" {{ old('page', $banner->page) === 'news' ? 'selected' : '' }}>News</option>
                                        <option value="events" {{ old('page', $banner->page) === 'events' ? 'selected' : '' }}>Events</option>
                                        <option value="reports" {{ old('page', $banner->page) === 'reports' ? 'selected' : '' }}>Reports</option>
                                        <option value="contact" {{ old('page', $banner->page) === 'contact' ? 'selected' : '' }}>Contact</option>
                                    </select>
                                </div>
                            </div>
                            @error('page')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="textarea @error('description') is-danger @enderror" name="description" placeholder="Enter banner description..." rows="4">{{ old('description', $banner->description) }}</textarea>
                            </div>
                            @error('description')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                Active Banner
                            </label>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-info">
                                    <span class="icon"><i class="fas fa-save"></i></span>
                                    <span>Update Banner</span>
                                </button>
                            </div>
                            <div class="control">
                                <a href="{{ route('admin.banners.index') }}" class="button is-light">
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

        const imageInput = document.getElementById('imageInput');
        const uploadLabel = document.getElementById('uploadLabel');
        const previewImage = document.getElementById('previewImage');

        // Click to upload
        uploadLabel.addEventListener('click', () => {
            imageInput.click();
        });

        // File selection preview
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImage.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop
        uploadLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadLabel.classList.add('drag-over');
        });

        uploadLabel.addEventListener('dragleave', () => {
            uploadLabel.classList.remove('drag-over');
        });

        uploadLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadLabel.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImage.src = event.target.result;
                };
                reader.readAsDataURL(files[0]);
            }
        });
    </script>
</body>
</html>
