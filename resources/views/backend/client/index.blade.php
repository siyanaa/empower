@extends('backend.layouts.master')

@section('content')
    <div class="container mt-5">
        <!-- Display success and error messages -->
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Clients</h1>

                <!-- Link to create a new Client -->
                <a href="{{ route('admin.client.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</a>
                <!-- Link to go back to admin dashboard -->
                <a href="{{ url('admin') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="col-sm-6">
                <!-- Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Clients</li>
                </ol>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serialNumber = ($client->currentPage() - 1) * $client->perPage() + 1;
                @endphp
              @foreach ($client as $clients)
              <tr>
                  <td>{{ $serialNumber++ }}</td>
                  <td>{{ $clients->name }}</td>
                  <td>
                      @if ($clients->image)
                          <img src="{{ asset('uploads/client/' . $clients->image) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                      @else
                          Not uploaded
                      @endif
                  </td>
                  <td style="white-space: nowrap;">
                      <a href="{{ route('admin.client.edit', $clients->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                      <form action="{{ route('admin.client.destroy', $clients->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this client?');"><i class="fa fa-trash"></i> Delete</button>
                      </form>
                  </td>
              </tr>
          @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $client->links() }}
        </div>
    </div>

    <!-- Modal for Deleting Client -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Client Deleted Successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for handling AJAX and Modals -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#deleteModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });

            // Close modal on click outside or on close button
            $('.modal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
@endsection
