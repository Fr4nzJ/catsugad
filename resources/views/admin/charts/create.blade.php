<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Chart - GAD CatSU Admin</title>
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
            margin-bottom: 2rem;
        }
        .page-header h2 {
            margin: 0;
            color: #333;
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
                        <h2><i class="fas fa-plus"></i> Create Chart</h2>
                    </div>

                    @if ($errors->any())
                        <div class="notification is-danger">
                            <button class="delete"></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.charts.store') }}" method="POST" novalidate id="chartForm">
                        @csrf

                        <div class="field">
                            <label class="label">Chart Name</label>
                            <div class="control">
                                <input class="input @error('name') is-danger @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="e.g., Annual Participation Growth" required>
                            </div>
                            @error('name')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Chart Type</label>
                            <div class="control">
                                <div class="select @error('type') is-danger @enderror">
                                    <select name="type" id="chartType" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="growth" {{ old('type') === 'growth' ? 'selected' : '' }}>Growth Chart (Line Chart)</option>
                                        <option value="distribution" {{ old('type') === 'distribution' ? 'selected' : '' }}>Distribution Chart (Doughnut Chart)</option>
                                    </select>
                                </div>
                            </div>
                            @error('type')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Chart Data</label>
                            <p class="help mb-3">Add labels and corresponding values below:</p>
                            
                            <div style="overflow-x: auto;">
                                <table class="table is-fullwidth is-hoverable" style="margin-bottom: 1rem;">
                                    <thead>
                                        <tr style="background-color: #f5f5f5;">
                                            <th style="width: 40%;">Label</th>
                                            <th style="width: 40%;">Value</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <tr class="data-row">
                                            <td><input class="input" type="text" placeholder="e.g., Year 2020"></td>
                                            <td><input class="input" type="number" placeholder="e.g., 150" step="0.01"></td>
                                            <td><button type="button" class="button is-danger is-small" onclick="removeRow(this)">Remove</button></td>
                                        </tr>
                                        <tr class="data-row">
                                            <td><input class="input" type="text" placeholder="e.g., Year 2021"></td>
                                            <td><input class="input" type="number" placeholder="e.g., 200" step="0.01"></td>
                                            <td><button type="button" class="button is-danger is-small" onclick="removeRow(this)">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" class="button is-info is-small" onclick="addRow()">
                                <span class="icon"><i class="fas fa-plus"></i></span>
                                <span>Add Row</span>
                            </button>

                            @error('labels')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                            @error('data')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden JSON fields -->
                        <input type="hidden" name="labels" id="labelsInput">
                        <input type="hidden" name="data" id="dataInput">

                        <div class="field">
                            <label class="label">Order</label>
                            <div class="control">
                                <input class="input @error('order') is-danger @enderror" type="number" name="order" value="{{ old('order', 0) }}" min="0">
                            </div>
                            @error('order')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-success">Create Chart</button>
                            </div>
                            <div class="control">
                                <a href="{{ route('admin.charts.index') }}" class="button is-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addRow() {
            const tbody = document.getElementById('dataTableBody');
            const row = document.createElement('tr');
            row.classList.add('data-row');
            row.innerHTML = `
                <td><input class="input" type="text" placeholder="e.g., Year 2022"></td>
                <td><input class="input" type="number" placeholder="e.g., 250" step="0.01"></td>
                <td><button type="button" class="button is-danger is-small" onclick="removeRow(this)">Remove</button></td>
            `;
            tbody.appendChild(row);
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('.data-row');
            if (rows.length > 1) {
                button.closest('tr').remove();
            } else {
                alert('You must have at least one row of data');
            }
        }

        function convertTableToJSON() {
            const rows = document.querySelectorAll('.data-row');
            const labels = [];
            const data = [];

            rows.forEach(row => {
                const inputs = row.querySelectorAll('input');
                const label = inputs[0].value.trim();
                const valueStr = inputs[1].value.trim();
                
                if (label && valueStr) {
                    const value = parseFloat(valueStr);
                    if (!isNaN(value)) {
                        labels.push(label);
                        data.push(value);
                    }
                }
            });

            if (labels.length === 0) {
                alert('Please add at least one label and value');
                return false;
            }

            document.getElementById('labelsInput').value = JSON.stringify(labels);
            document.getElementById('dataInput').value = JSON.stringify(data);
            console.log('Labels:', JSON.stringify(labels));
            console.log('Data:', JSON.stringify(data));
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Close notification
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });

            // Form submission handler with better selector
            const form = document.getElementById('chartForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit event fired');
                    if (!convertTableToJSON()) {
                        e.preventDefault();
                        console.log('Form submission prevented');
                    } else {
                        console.log('Form allowed to submit');
                    }
                });
            } else {
                console.log('Form not found!');
            }
        });
    </script>
</body>
</html>
