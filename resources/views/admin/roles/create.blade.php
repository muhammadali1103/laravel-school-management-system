@extends('admin.layouts.app')

@section('styles')
<style>
    .permission-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 2px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        padding: 0.75rem 1rem !important;
    }
    
    .permission-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .permission-card:hover {
        border-color: #6366f1;
        background-color: #faf5ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
    }
    
    .permission-card:hover::before {
        opacity: 1;
    }
    
    .permission-card.checked {
        border-color: #6366f1;
        background: linear-gradient(135deg, #eef2ff 0%, #faf5ff 100%);
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    }
    
    .permission-card.checked::before {
        opacity: 1;
    }

    .permission-card .form-check-input {
        width: 1.25em;
        height: 1.25em;
        cursor: pointer;
        border: 2px solid #d1d5db;
        transition: all 0.2s ease;
    }
    
    .permission-card .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
        box-shadow: 0 2px 4px rgba(99, 102, 241, 0.4);
    }
    
    .permission-card label {
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        color: #374151;
    }
    
    .permission-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .badge-view {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }
    
    .badge-create {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .badge-edit {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .badge-delete {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .badge-manage, .badge-assign, .badge-submit, .badge-mark, .badge-send, .badge-change {
        background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
        color: #6b21a8;
    }

    .permission-group-container {
        border: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
        transition: all 0.3s ease;
    }
    
    .permission-group-container:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .group-header {
        border-bottom: 2px solid #e5e7eb;
        margin: -1rem -1rem 1rem -1rem;
        padding: 1rem;
    }
    
    .group-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 0.875rem;
        letter-spacing: 0.025em;
        margin: 0;
    }

    .btn-soft-primary {
        color: #ffffff;
        background-color: #6366f1;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(99, 102, 241, 0.3);
    }

    .btn-soft-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(99, 102, 241, 0.4);
        background-color: #4f46e5;
        color: #ffffff;
    }

    /* CSS Grid Layout */
    .permission-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .permission-list-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .permission-card {
        flex: 0 0 auto;
        min-width: fit-content;
    }
    
    @media (max-width: 768px) {
        .permission-list-horizontal {
            flex-direction: column;
        }
        
        .permission-card {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4"> <!-- Increased shadow and radius -->
                <div class="card-header bg-white py-4 px-4 border-bottom-0"> <!-- More padding -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-plus fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Create New Role</h5>
                                <p class="text-muted small mb-0">Define role identity and access levels</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <div class="row g-4"> <!-- Using Grid gap -->
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="name" class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                        id="description" name="description" style="height: 60px" required 
                                        >{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4 ps-1">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-ui-checks me-2 text-primary"></i>Assign Permissions
                                </h6>
                            </div>
                            
                            <div class="permission-grid">
                                @forelse($permissions as $group => $groupPermissions)
                                    <div class="permission-group-container rounded-4 p-4 shadow-sm">
                                        <!-- Gradient Header -->
                                        <div class="group-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="group-title mb-0 d-flex align-items-center">
                                                    <i class="bi bi-shield-lock-fill me-2"></i>
                                                    {{ $group ?? 'General' }}
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-soft-primary border-0 py-1 px-3 rounded-pill" 
                                                        style="font-size: 0.65rem;" onclick="toggleGroupPermissions(this)">
                                                    <i class="bi bi-check2-all me-1"></i><span>Select All</span>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Permission List (Horizontal) -->
                                        <div class="permission-list-horizontal">
                                            @foreach($groupPermissions as $permission)
                                                @php
                                                    // Extract permission action type
                                                    $permName = $permission->name;
                                                    $badgeClass = 'badge-manage';
                                                    $icon = 'bi-gear-fill';
                                                    
                                                    if(str_contains($permName, '.view')) {
                                                        $badgeClass = 'badge-view';
                                                        $icon = 'bi-eye-fill';
                                                    } elseif(str_contains($permName, '.create') || str_contains($permName, '.add')) {
                                                        $badgeClass = 'badge-create';
                                                        $icon = 'bi-plus-circle-fill';
                                                    } elseif(str_contains($permName, '.edit') || str_contains($permName, '.update')) {
                                                        $badgeClass = 'badge-edit';
                                                        $icon = 'bi-pencil-fill';
                                                    } elseif(str_contains($permName, '.delete')) {
                                                        $badgeClass = 'badge-delete';
                                                        $icon = 'bi-trash-fill';
                                                    } elseif(str_contains($permName, '.assign')) {
                                                        $badgeClass = 'badge-manage';
                                                        $icon = 'bi-link-45deg';
                                                    } elseif(str_contains($permName, '.mark')) {
                                                        $badgeClass = 'badge-manage';
                                                        $icon = 'bi-check-circle-fill';
                                                    } elseif(str_contains($permName, '.send')) {
                                                        $badgeClass = 'badge-manage';
                                                        $icon = 'bi-send-fill';
                                                    } elseif(str_contains($permName, '.submit')) {
                                                        $badgeClass = 'badge-manage';
                                                        $icon = 'bi-upload';
                                                    } elseif(str_contains($permName, '.change')) {
                                                        $badgeClass = 'badge-manage';
                                                        $icon = 'bi-arrow-repeat';
                                                    }
                                                @endphp
                                                
                                                <div class="permission-card bg-white rounded-3 px-3 py-2.5 d-flex align-items-center justify-content-between shadow-sm" 
                                                     onclick="toggleCheckbox(this)">
                                                    <div class="d-flex align-items-center flex-grow-1">
                                                        <input class="form-check-input my-0 me-3 flex-shrink-0" type="checkbox" 
                                                            name="permissions[]" 
                                                            value="{{ $permission->id }}" 
                                                            id="perm_{{ $permission->id }}"
                                                            {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                                        <label class="mb-0 user-select-none flex-grow-1" for="perm_{{ $permission->id }}">
                                                            {{ $permission->display_name }}
                                                        </label>
                                                    </div>
                                                    <span class="permission-badge {{ $badgeClass }} ms-2 flex-shrink-0">
                                                        <i class="bi {{ $icon }}"></i>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-clipboard-x display-4 text-secondary opacity-50 mb-3 d-block"></i>
                                        No permissions definitions found.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-light text-secondary fw-medium px-4">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-2"></i>Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function toggleCheckbox(element) {
        // Prevent double triggering if clicking directly on input or label
        if (event.target.type === 'checkbox' || event.target.tagName === 'LABEL') return;
        
        const checkbox = element.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        updateCardStyle(element, checkbox.checked);
    }

    function toggleGroupPermissions(btn) {
        const container = btn.closest('.permission-group-container');
        const allCards = container.querySelectorAll('.permission-card');
        const allCheckboxes = container.querySelectorAll('.permission-card input[type="checkbox"]');
        
        // Check if all are currently checked to determine toggle state
        const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
        const newState = !allChecked;

        allCheckboxes.forEach(cb => {
            cb.checked = newState;
        });

        allCards.forEach(card => {
            updateCardStyle(card, newState);
        });
        
        // Update button text
        const span = btn.querySelector('span');
        if (span) {
            span.textContent = newState ? 'Deselect All' : 'Select All';
        }
    }

    // Initial styling and event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.permission-card');
        cards.forEach(card => {
            const checkbox = card.querySelector('input[type="checkbox"]');
            
            // Initial check
            if(checkbox.checked) {
                card.classList.add('checked');
            }

            // Listen for change on the input itself (if clicked directly)
            checkbox.addEventListener('change', function() {
                updateCardStyle(card, this.checked);
            });
        });
    });

    function updateCardStyle(card, isChecked) {
        if (isChecked) {
            card.classList.add('checked');
        } else {
            card.classList.remove('checked');
        }
    }
</script>
@endsection