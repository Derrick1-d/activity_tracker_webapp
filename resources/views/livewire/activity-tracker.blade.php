<div class="container">

    <h1 class="my-4 stylish-heading">Activity List</h1>

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">

        {{-- Add activity button --}}
        <button class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#addActivityModal">Add Activity</button>

        {{-- Print Summary Button --}}

             

        <!-- Search Bar -->
        <div class="mr-2 mb-2" style="flex: 0 1 400px;">
            <input type="text" wire:model="search" placeholder="Search activities..." class="form-control" />
        </div>

        <div x-data="{ completionPercentage: @entangle('completionPercentage') }">
            <label for="progress-bar">Activity Completion Progress</label>
            <div class="progress-3d" id="progress-bar" aria-label="Activity Completion Progress">
                <div
                    class="progress-bar-3d"
                    role="progressbar"
                    :style="{ width: Math.min(Math.max(completionPercentage, 0), 100) + '%' }"
                    :aria-valuenow="Math.min(Math.max(completionPercentage, 0), 100)"
                    aria-valuemin="0"
                    aria-valuemax="100">

                    <span x-text="Math.round(Math.min(Math.max(completionPercentage, 0), 100)) + '%'"></span>

                    <!-- Moving bubbles -->
                    <div class="bubbles">
                        <div
                            class="bubble"
                            x-bind:style="{ left: Math.min(Math.max(completionPercentage, 0), 100) + '%' }">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Success Alert Message -->
        @if (session()->has('message'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @include('livewire.delete-activity')
        <table class="table table-bordered mt-0">
            <thead class="table-dark">
                <tr>
                    <th>Tick</th>
                    <th>Date</th>
                    <th>Name</th>
                    {{-- <th>Status</th> --}}
                    {{-- <th>Comments</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>
                            <input type="checkbox" wire:click="toggleDeleteIcon({{ $activity->id }})"
                                aria-label="Select activity for deletion">
                        </td>
                        <td>{{ $activity->date }}</td>
                        <td>{{ $activity->name }}</td>
                        {{-- <td>
                            <span class="badge"
                                style="
                                    background-color: {{ $activity->status == 'Completed' ? '#28a745' : ($activity->status == 'In Progress' ? '#ffc107' : ($activity->status == 'Not Started' ? '#6c757d' : '')) }};
                                    color: {{ $activity->status == 'Completed' ? 'white' : ($activity->status == 'In Progress' ? 'black' : ($activity->status == 'Not Started' ? 'white' : '')) }};
                                ">
                                {{ $activity->status }}
                            </span>
                        </td> --}}
                        {{-- <td>{{ $activity->comments }}</td> --}}
                        <td>
                            <button class="btn btn-info btn-sm" wire:click="viewActivity({{ $activity->id }})"
                                data-toggle="modal" data-target="#viewActivityModal"
                                aria-label="View details of {{ $activity->name }}" title="View Activity">
                                View
                            </button>
                            <button class="btn btn-secondary btn-sm" wire:click="editActivity({{ $activity->id }})"
                                data-toggle="modal" data-target="#editActivityModal"
                                aria-label="Edit details of {{ $activity->name }}" title="Edit Activity">
                                Edit
                            </button>
                            @if (in_array($activity->id, $showDelete))
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $activity->id }})"
                                    aria-label="Delete {{ $activity->name }}" title="Delete Activity">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        <!-- Add Activity Modal -->
        <div wire:ignore.self class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="createActivity">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addActivityModalLabel">Add Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('livewire.add-activity') <!-- comming from partial views -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Activity</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Activity Modal -->
        <div wire:ignore.self class="modal fade" id="editActivityModal" tabindex="-1"
            aria-labelledby="editActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="updateActivity">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editActivityModalLabel">Edit Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('livewire.edit-activity')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Activity Modal -->
        <div wire:ignore.self class="modal fade" id="viewActivityModal" tabindex="-1"
     aria-labelledby="viewActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" style="min-height: 100vh;">
        <div class="modal-content" style="font-size: 1.2rem;"> <!-- Increased font size -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewActivityModalLabel" style="font-size: 1.5rem;">View Activity</h5> <!-- Larger heading -->
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body text-center">
                        <!-- Date with custom background color -->
                        <p><strong>Date:</strong> <span class="badge badge-info">{{ $date }}</span></p>

                        <!-- Name of the activity -->
                        <p><strong>Name:</strong> {{ $name }}</p>

                        <!-- Status with conditional color -->
                        <span class="badge {{ $status == 'Completed' ? 'bg-success text-white' : ($status == 'In Progress' ? 'bg-warning text-black' : ($status == 'Not Started' ? 'bg-secondary text-white' : 'bg-dark text-white')) }} font-size-lg py-2">
                            {{ $status }}
                        </span>

                        <!-- Large text area for Comments -->
                        <p><strong>Comments:</strong></p>
                        <textarea class="form-control" rows="5" readonly style="font-size: 1rem;">{{ $comments }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

   <div class="d-flex justify-content-center mt-4">
    {{ $activities->links('pagination::bootstrap-4') }}
  </div>

  <div>
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" wire:model="start_date" required>
    
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" wire:model="end_date" required>
    
    <a href="javascript:void(0)" onclick="validateAndRedirect()" class="btn btn-primary">
        Custom Print
    </a>
</div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    // Ensures Livewire is loaded before attaching events
    if (typeof Livewire === 'undefined') {
        console.error('Livewire is not loaded.');
        return;
    }

    // Close modals and display success alert on activity save
    Livewire.on('activitySaved', () => {
        $('#addActivityModal, #editActivityModal').modal('hide');

        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.display = 'block';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }
    });

    // Update progress bar dynamically
    Livewire.on('progressUpdated', (percentage) => {
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        progressBar.style.width = `${percentage}%`;
        progressBar.setAttribute('aria-valuenow', percentage);
        progressBar.innerText = `${Math.round(percentage)}%`;
    }
});

   document.addEventListener('DOMContentLoaded', function () {
    const bubbleContainer = document.querySelector('.bubbles');

    for (let i = 0; i < 10; i++) {
        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        bubble.style.left = `${Math.random() * 100}%`;
        bubble.style.animationDuration = `${Math.random() * 3 + 2}s`; // Random duration between 2-5 seconds
        bubbleContainer.appendChild(bubble);
    }
});


    // Confirm deletion modal handler
    window.confirmDelete = function (activityId) {
        const confirmModal = $('#deleteConfirmModal');
        const confirmButton = document.getElementById('confirmDeleteBtn');

        if (confirmModal.length && confirmButton) {
            confirmModal.modal('show');
            confirmButton.onclick = () => {
                Livewire.emit('deleteConfirmed', activityId);
                confirmModal.modal('hide');
            };
        } else {
            console.error('Confirm Delete Modal or Button not found.');
        }
    };



});

// Define the function globally
function validateAndRedirect() {
                // Get the values of the date inputs
                const start_date = document.getElementById('start_date').value;
                const end_date = document.getElementById('end_date').value;
        
                // Check if both dates are selected
                if (!start_date || !end_date) {
                    alert('Please select both start and end dates before printing.');
                    return; // Stop further execution if validation fails
                }
        
                // Construct the custom URL with the selected dates
                const url = `{{ route('activities.custom-print') }}?start_date=${start_date}&end_date=${end_date}`;
                
                // Open the URL in a new tab
                window.open(url, '_blank');
            }

    </script>
