@extends('frontend.layouts.master')


@section('content')






<!-- herosection for about contact and dem -->


  @extends('frontend.layouts.master')
@section('content')
<!-- herosection for about contact and dem -->
<section class="herosectionforallpage my-4">
    <div class="container">
    <img src="./image/demandbg.png" alt="" class="rounded">
    <div class="d-flex flex-column innercontent">
     <span class="maintitle">Testimonial</span>
     <span class="navigatetitle py-2 px-3 mb-1">
      <a href="" style="color: white !important; text-decoration: none;">Home</a> > <span>Testimonial</span>
  </span>
    </div>
  </div>
  </section>
  <!-- what our client say -->
  <section class="client-messages py-5" style="background-color: #f7f7f7;">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($clientMessages as $message)
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card shadow-sm rounded border-0">
                        <div class="card-body">
                            <p class="lead text-muted xs-text">
                                {!! app()->getLocale() === 'ne' ? $message->message_ne : $message->message !!}
                            </p>
                            <h5 class="text-end mt-4 mb-0 md-text greenhighlight">
                                - {!! app()->getLocale() === 'ne' ? $message->name_ne : $message->name !!}
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>


@endsection



