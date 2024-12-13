@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->

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
            <h1 class="m-0">{{ $page_title }}</h1>
            <a href="{{ route('admin.demands.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                </a>
            <a href="{{ url('admin') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Country</th>
                <th>Number of people required</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Content</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = ($demands->currentPage() - 1) * $demands->perPage() + 1;
            @endphp

            @foreach ($demands as $demand)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $serialNumber }}</td>
                    <td>{{ $demand->country->name }}</td>
                    <td>{{ $demand->number_of_people_required }}</td>
                    <td>{{ $demand->from_date }}</td>
                    <td>{{ $demand->to_date }}</td>
                    <td>{!! $demand->content !!}</td>
                    <td>
                        <img src="{{ asset('uploads/demands/' . $demand->image) }}" alt="Demand Image"
                            style="max-width: 100px;">
                    </td>
                    <td>
                        <div style="display: flex; flex-direction:row;">
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editModal{{ $demand->id }}" style="margin-right: 5px;"><i
                                    class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal{{ $demand->id }}"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </td>
                </tr>
                @php
        $serialNumber++;
    @endphp

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $demand->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $demand->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $demand->id }}">Are you sure you want to
                                    Edit Demands ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="{{ route('admin.demands.edit', $demand->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $demand->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel{{ $demand->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $demand->id }}">Delete Demand</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this demand?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form id="deleteForm{{ $demand->id }}"
                                    action="{{ route('admin.demands.destroy', $demand->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
     <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($demands->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $demands->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($demands->getUrlRange(1, $demands->lastPage()) as $page => $url)
            @if ($page == $demands->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($demands->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $demands->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>

    <script>
        const previewImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
            };
        };
    </script>
@endsection
