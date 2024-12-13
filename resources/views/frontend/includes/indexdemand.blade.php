
<section class="container-fluid Demand mt-4">
    <div class="container">
        <div class="text-center py-2">
            <h1 class="extralarger whitehighlight">DEMAND JOBS</h1>
            <p class="xs-text whitehighlight">Seek a foreign job that aligns with your qualifications and expertise.</p>
        </div>
        <div class="row mt-3">
            @forelse($demands->where('to_date', '>=', now()->toDateString())->take(6) as $demand)
                <div class="col-md-6">
                    <div class=" row card shadow rounded">
                        <div class="card-body d-flex gap-2 rounded">
                            <img src="{{ asset('uploads/demands/' . $demand->image) }}" class="card-img-top rounded col-2"
                                alt="Job Image">
                            <div class="d-flex flex-column gap-2 col-8">
                                <h5 class="sm-text-bd">{{ $demand->vacancy }}</h5>
                                <div class="card-text d-flex justify-content-between">
                                    <div class="d-flex">
                                        <i class="bi bi-calendar mx-1 forhide"></i>
                                        <span class="xs-text">Valid Upto : {{ $demand->to_date }}</span>
                                    </div>
                                    <p class="card-text sm-text-bd mr-4 mb-0 d-flex">
                                        <i class="bi bi-people mx-1"></i>
                                        <span>{{ $demand->number_of_people_required }}</span>
                                    </p>
                                </div>
                                <div class="d-flex pt-2 gap-2">
                                    @if($demand->vacancy > 0)
                                        <a href="{{ route('apply', $demand->id) }}"
                                            class="btn btn-outline-warning btn-yellow btn-sm">Apply</a>
                                    @else
                                        <span class="text-danger">No Vacancy</span>
                                    @endif
                                    <a href="{{ route('SingleDemand', $demand->id) }}"
                                        class="btn btn-outline-primary btn-blue btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="alert alert-info sm-text-md">No active job demands available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>