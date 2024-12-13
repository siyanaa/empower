@extends('backend.layouts.master')
@section('content')
    <div class="container mt-5">
        <h1>Applications</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Demand</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>WhatsApp Number</th>
                    <th>CV</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr data-application-id="{{ $application->id }}">
                    <tr data-application-id="{{ $application->id }}">
                        <td>{{ $application->demand->vacancy }}</td>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->email }}</td>
                        <td>{{ $application->address }}</td>
                        <td>{{ $application->phone_no }}</td>
                        <td>{{ $application->whatsapp_no }}</td>
                        <td>
                            @if ($application->cv)
                                <a href="{{ asset($application->cv) }}" target="_blank">View CV</a>
                            @else
                                Not uploaded
                            @endif
                        </td>
                        <td>
                            @if ($application->photo)
                                <img src="{{ asset($application->photo) }}" alt="Applicant Photo" style="max-width: 100px;">
                            @else
                                Not uploaded
                            @endif
                        </td>
                        <td class="status-column">{{ ucfirst($application->status) }}</td>
                       
                        <td class="actions-column" style="white-space: nowrap;">
                            @if ($application->status == 'pending')
                                <form class="accept-form" action="{{ route('applications.accept', $application->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <button type="button" class="btn btn-warning btn-sm accept-btn">
                                        <i class="fas fa-check"></i> Accept
                                    </button>
                                </form>
                                <form class="reject-form" action="{{ route('applications.reject', $application->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <button type="button" class="btn btn-danger btn-sm reject-btn">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            @elseif ($application->status == 'accepted')
                                <form class="reject-form" action="{{ route('applications.reject', $application->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <button type="button" class="btn btn-danger btn-sm reject-btn">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            @elseif ($application->status == 'rejected')
                                <form class="accept-form" action="{{ route('applications.accept', $application->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <button type="button" class="btn btn-warning btn-sm accept-btn">
                                        <i class="fas fa-check"></i> Accept
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Confirmation Modals -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(isset($application))
                        Are you sure you want to <span id="actionText"></span> this application of <b>{{ $application->name }}</b>?
                    @else
                        <p>No application data available.</p>
                    @endif
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentForm = null;
            let currentAction = null;
            function showConfirmModal(action, form) {
                currentForm = form;
                currentAction = action;
                $('#actionText').text(action);
                $('#confirmModal').modal('show');
            }
            $(document).on('click', '.accept-btn', function() {
                showConfirmModal('accept', $(this).closest('form'));
            });
   
            $(document).on('click', '.reject-btn', function() {
                showConfirmModal('reject', $(this).closest('form'));
            });


            $('#confirmActionBtn').click(function() {
                if (currentForm && currentAction) {
                    var form = currentForm;
                    var applicationId = form.find('input[name="application_id"]').val();
                   
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            application_id: applicationId
                        },
                        success: function(response) {
                            var row = $('tr[data-application-id="' + applicationId + '"]');
                            var actionsColumn = row.find('.actions-column');
                            var statusColumn = row.find('.status-column');


                            actionsColumn.empty();


                            statusColumn.text(response.status.charAt(0).toUpperCase() + response.status.slice(1));


                            if (response.status === 'accepted') {
                                actionsColumn.append(`
                                    <form class="reject-form" action="{{ route('applications.reject', '') }}/${applicationId}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="application_id" value="${applicationId}">
                                        <button type="button" class="btn btn-danger btn-sm reject-btn">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                `);
                            } else if (response.status === 'rejected') {
                                actionsColumn.append(`
                                    <form class="accept-form" action="{{ route('applications.accept', '') }}/${applicationId}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="application_id" value="${applicationId}">
                                        <button type="button" class="btn btn-warning btn-sm accept-btn">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                    </form>
                                `);
                            }
                            $('#confirmModal').modal('hide');
                            currentForm = null;
                            currentAction = null;
                        },
                        error: function(xhr) {
                            console.log('Error:', xhr);
                            alert('An error occurred. Please try again.');
                            $('#confirmModal').modal('hide');


                            currentForm = null;
                            currentAction = null;
                        }
                    });
                }
            });
            $('#confirmModal').on('hidden.bs.modal', function () {
                currentForm = null;
                currentAction = null;
            $('#confirmModal').on('hidden.bs.modal', function () {
                currentForm = null;
                currentAction = null;
            });
        });
    });
    </script>
@endsection

