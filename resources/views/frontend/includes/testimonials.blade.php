<!-- what our client say -->

<section class=" clientssay py-3">
    <div class="container">
        <h2 class="text-center pb-3 section_title">{{ trans('messages.clientsay') }}</h2>
        <div class="row py-2 g-4">
            @if(isset($clientMessages) && $clientMessages->count() > 0)
                @foreach($clientMessages->take(4) as $clientMessage)
                    <div class="col-lg-3 col-md-3 Ebox-wrap">
                        <div class="Ebox1 clientcard pt-3 px-3 d-flex flex-column position-relative">
                            <!-- Adjusted positioning for the icon -->
                            <div class="clientcard-icon position-absolute top-2 left-4">
                                <i class="fa-solid fa-user heart-icon"></i>
                            </div>
                            <h4 class="md-text mt-2">@if (app()->getLocale() == 'ne')
                                {{ $clientMessage->name_ne }}
                            @else
                                {{ $clientMessage->name }}
                            @endif
                            </h4>

                            <p class="xs-text">{{ \Str::limit(strip_tags($clientMessage->message), 500) }}</p>

                        </div>
                    </div>
                    
                @endforeach
            @else
                <div class="col-md-12">
                    <p class="sm-text-md">No client messages available at this time.</p>
                </div>
            @endif
        </div>
    </div>
</section>