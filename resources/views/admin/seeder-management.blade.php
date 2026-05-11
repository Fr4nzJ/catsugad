@extends('layouts.admin')

@section('title', 'Seeder Management - Admin Dashboard')

@section('content')
<div class="content">
    <div class="mb-5">
        <h1 class="title is-3 mb-4">
            <i class="fas fa-database"></i> Seeder & Data Management
        </h1>
        <p class="subtitle is-6">Manage database seeding and data cleanup for development and testing</p>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- Statistics Section -->
    <div class="box mb-6">
        <h2 class="title is-5 mb-4">
            <i class="fas fa-chart-bar"></i> Current Data Statistics
        </h2>
        <div class="columns is-multiline" id="statsContainer">
            <div class="column is-12 has-text-centered">
                <p class="has-text-grey">Loading statistics...</p>
            </div>
        </div>
    </div>

    <!-- Seeders Section -->
    <div class="box mb-6">
        <h2 class="title is-5 mb-4">
            <i class="fas fa-seed"></i> Available Seeders
        </h2>
        <p class="mb-4 has-text-grey is-size-7">Click to run seeders and populate database with sample data.</p>
        
        <div class="columns is-multiline">
            @foreach($seeders as $key => $seeder)
                <div class="column is-half-tablet is-one-third-desktop">
                    <div class="card">
                        <div class="card-content">
                            <div class="level mb-3">
                                <div class="level-left">
                                    <div class="level-item">
                                        <div class="icon has-text-info is-large">
                                            <i class="fas fa-2x fa-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <span class="tag is-info">Seeder</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="title is-6">{{ $seeder['name'] }}</p>
                            <p class="help mb-4">{{ $seeder['description'] }}</p>
                            
                            <div class="field">
                                <button type="button" 
                                        class="button is-fullwidth is-info is-light run-seeder"
                                        data-seeder="{{ $key }}"
                                        title="Run seeder to populate database">
                                    <span class="icon"><i class="fas fa-play"></i></span>
                                    <span>Run Seeder</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Wipe Data Section -->
    <div class="box">
        <h2 class="title is-5 mb-4">
            <i class="fas fa-trash-alt"></i> Wipe Data by Section
        </h2>
        <p class="mb-4 has-text-grey is-size-7 has-text-danger">
            <i class="fas fa-exclamation-triangle"></i> Warning: This will permanently delete all data in the selected section. This action cannot be undone.
        </p>
        
        <div class="columns is-multiline">
            @foreach($wipeSections as $key => $section)
                <div class="column is-half-tablet is-one-third-desktop">
                    <div class="card">
                        <div class="card-content">
                            <div class="level mb-3">
                                <div class="level-left">
                                    <div class="level-item">
                                        <div class="icon has-text-danger">
                                            <i class="fas fa-2x {{ $section['icon'] }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <span class="tag is-danger">Wipe</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="title is-6">{{ $section['name'] }}</p>
                            <p class="help mb-4">{{ $section['description'] }}</p>
                            
                            <div class="field">
                                <button type="button" 
                                        class="button is-fullwidth is-danger is-light wipe-data"
                                        data-section="{{ $key }}"
                                        title="Permanently delete all data in this section">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                    <span>Wipe Data</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">
                <span id="modalTitle"></span>
            </p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <section class="modal-card-body">
            <p id="modalMessage"></p>
        </section>
        <footer class="modal-card-foot">
            <button class="button" onclick="closeModal()">Cancel</button>
            <button class="button is-danger" id="confirmButton" onclick="confirmAction()">
                <span id="confirmButtonText"></span>
            </button>
        </footer>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .button {
        transition: all 0.3s ease;
    }
    
    .button:hover:not(:disabled) {
        transform: translateY(-1px);
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .alert {
        margin-bottom: 1rem;
    }
</style>

<script>
    let pendingAction = null;

    // Load statistics on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadStatistics();
    });

    // Load statistics
    function loadStatistics() {
        fetch('{{ route("admin.seeder.stats") }}')
            .then(response => response.json())
            .then(data => {
                displayStatistics(data);
            })
            .catch(error => {
                console.error('Error loading statistics:', error);
            });
    }

    // Display statistics
    function displayStatistics(data) {
        const container = document.getElementById('statsContainer');
        container.innerHTML = '';
        
        const stats = data.statistics || data;
        
        for (const [key, count] of Object.entries(stats)) {
            if (typeof count === 'object') continue;
            
            const columnHtml = `
                <div class="column is-one-quarter-desktop is-one-third-tablet is-half-mobile">
                    <div class="box has-background-white-bis">
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="level-item">
                                    <div>
                                        <p class="heading is-size-7">${formatLabel(key)}</p>
                                        <p class="title is-4">${count}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <div class="tag is-info">${count > 0 ? 'Data Found' : 'Empty'}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += columnHtml;
        }
    }

    // Format label from snake_case to Title Case
    function formatLabel(key) {
        return key
            .replace(/_/g, ' ')
            .replace(/\b\w/g, char => char.toUpperCase());
    }

    // Handle seeder button clicks
    document.querySelectorAll('.run-seeder').forEach(button => {
        button.addEventListener('click', function() {
            const seeder = this.dataset.seeder;
            showConfirmation(
                'Run Seeder',
                `Are you sure you want to run this seeder? It will add sample data to the database.`,
                () => runSeeder(seeder),
                'Run'
            );
        });
    });

    // Handle wipe data button clicks
    document.querySelectorAll('.wipe-data').forEach(button => {
        button.addEventListener('click', function() {
            const section = this.dataset.section;
            const sectionName = this.closest('.card').querySelector('.title').textContent;
            showConfirmation(
                'Confirm Data Deletion',
                `⚠️ <strong>WARNING:</strong> You are about to permanently delete all data in <strong>${sectionName}</strong>.<br><br>This action <strong>cannot be undone</strong>. Are you absolutely sure?`,
                () => wipeData(section),
                'Delete Permanently',
                true
            );
        });
    });

    // Show confirmation modal
    function showConfirmation(title, message, confirmCallback, buttonText = 'Confirm', isDangerous = false) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').innerHTML = message;
        document.getElementById('confirmButtonText').textContent = buttonText;
        
        const confirmButton = document.getElementById('confirmButton');
        confirmButton.className = isDangerous ? 'button is-danger' : 'button is-info';
        
        pendingAction = confirmCallback;
        document.getElementById('confirmationModal').classList.add('is-active');
    }

    // Close modal
    function closeModal() {
        document.getElementById('confirmationModal').classList.remove('is-active');
        pendingAction = null;
    }

    // Confirm action
    function confirmAction() {
        if (pendingAction) {
            closeModal();
            pendingAction();
        }
    }

    // Run seeder
    function runSeeder(seeder) {
        const button = document.querySelector(`[data-seeder="${seeder}"]`);
        button.classList.add('is-loading');
        
        fetch('{{ route("admin.seeder.run") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ seeder: seeder })
        })
        .then(response => response.json())
        .then(data => {
            button.classList.remove('is-loading');
            showAlert(data.success ? 'success' : 'danger', data.message);
            if (data.success) {
                setTimeout(loadStatistics, 1000);
            }
        })
        .catch(error => {
            button.classList.remove('is-loading');
            showAlert('danger', 'Error: ' + error.message);
        });
    }

    // Wipe data
    function wipeData(section) {
        const button = document.querySelector(`[data-section="${section}"]`);
        button.classList.add('is-loading');
        
        fetch('{{ route("admin.seeder.wipe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ section: section, confirmed: true })
        })
        .then(response => response.json())
        .then(data => {
            button.classList.remove('is-loading');
            showAlert(data.success ? 'success' : 'danger', data.message);
            if (data.success) {
                setTimeout(loadStatistics, 1000);
            }
        })
        .catch(error => {
            button.classList.remove('is-loading');
            showAlert('danger', 'Error: ' + error.message);
        });
    }

    // Show alert message
    function showAlert(type, message) {
        const container = document.getElementById('alertContainer');
        const alertClass = type === 'success' ? 'is-success' : 'is-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="notification ${alertClass} alert">
                <button class="delete"></button>
                <div>
                    <strong><i class="fas ${icon}"></i> ${type === 'success' ? 'Success' : 'Error'}</strong>
                    <p>${message}</p>
                </div>
            </div>
        `;
        
        container.innerHTML = alertHtml;
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            container.innerHTML = '';
        }, 5000);
        
        // Allow manual close
        container.querySelector('.delete')?.addEventListener('click', function() {
            this.parentElement.remove();
        });
    }

    // Close modal when clicking outside
    document.getElementById('confirmationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
