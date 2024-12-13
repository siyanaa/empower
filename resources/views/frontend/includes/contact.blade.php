

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<section class="container-fluid contactstart">
    <div class="container my-5">
        <div class="d-flex flex-column justify-content-center row customconnectwithus rounded align-items-center ">
        <div class="d-flex flex-column justify-content-center row customconnectwithus rounded align-items-center ">
        <div class="d-flex flex-column justify-content-center row customconnectwithus rounded align-items-center ">
            <span class="d-flex flex-column justify-content-center align-items-center containertitle">
                <h2 class="d-flex justify-content-center"></h2>
                <h2 class="text-center pb-2 section_title">{{ trans('messages.inquiry') }}</h2>
            </span>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <p class=" col-md-11 text-center xs-text">
                    Are you prepared to enhance your skills, unlock new career opportunities, and achieve personal
                    growth? Join our Professional Development and Training program, and connect with us to discover the
                    empowering potential of targeted learning and career advancement.
                </p>


                <div class="customconnectwithus-innersection fcc gap-md-3 pb-4">
                    <div class="customconnectwithus-innersection-left col-md-6">
                        <form id="contactForm" class="form-horizontal" method="POST"
                            action="{{ route('Contact.store') }}">
                            @csrf
                            <div class="customconnectwithus-innersection-left_inputcontainer d-flex flex-column">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="NAME" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="customconnectwithus-innersection-left_inputcontainer d-flex flex-column">
                                <label for="phone_no">Contact Number</label>
                                <input type="tel" class="form-control @error('phone_no') is-invalid @enderror"
                                    id="phone_no" placeholder="Phone No." name="phone_no" value="{{ old('phone_no') }}"
                                    required>
                                @error('phone_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="customconnectwithus-innersection-left_inputcontainer d-flex flex-column">
                                <input hidden type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="customconnectwithus-innersection-left_inputcontainer d-flex flex-column">
                                <label for="message">Message</label>
                                <textarea class="form-control message-box @error('message') is-invalid @enderror"
                                    rows="4" placeholder="MESSAGE" name="message"
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            <div class="customconnectwithus-innersection-left_inputcontainer d-flex flex-column my-1">
                                <button type="submit sm-text">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="customconnectwithus-innersection-right p-4 col-md-5">
                        <span class="customconnectwithus-innersection-right-text xs-text whitehighlight">Please don't hesitate to reach out
                            using the contact information below for any inquiries or to get in touch. We are eager to
                            assist you and provide support in a friendly and helpful way.</span>
                        <div class="customconnectwithus-innersection-right-ourdetail my-4 px-4 py-3">
                            <h6>Contact</h6>
                            <div class="py-2">
                                @if (!empty($sitesetting->office_contact))
                                                                @php
                                                                    $officeContacts = json_decode($sitesetting->office_contact, true);
                                                                @endphp
                                                                @if (is_array($officeContacts))
                                                                    @foreach ($officeContacts as $contact)
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fa-solid fa-phone"></i>
                                                                            <span class="px-2 sm-text">{{ $contact }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="fa-solid fa-phone"></i>
                                                                        <span class="px-2 sm-text">{{ $sitesetting->office_contact }}</span>
                                                                    </div>
                                                                @endif
                                @endif
                            </div>
                            <div class="">
                                @if (!empty($sitesetting->office_email))
                                                                @php
                                                                    $officeEmails = json_decode($sitesetting->office_email, true);
                                                                @endphp
                                                                @if (is_array($officeEmails))
                                                                    @foreach ($officeEmails as $email)
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fa-solid fa-envelope"></i>
                                                                            <span class="px-2 sm-text">{{ $email }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="fa-solid fa-envelope"></i><span
                                                                            class="px-2 sm-text">{{ $sitesetting->office_email }}</span>
                                                                    </div>
                                                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="customconnectwithus-innersection-right-ourdetail px-4 py-3">
                       
                       
                            <h6>Address</h6>
                            <div class="py-2">
                                @if (!empty($sitesetting->office_address))
                                                                @php
                                                                    $officeAddresses = json_decode($sitesetting->office_address, true);
                                                                @endphp
                                                                @if (is_array($officeAddresses))
                                                                    @foreach ($officeAddresses as $address)
                                                                        <div class="d-flex align-items-start py-1">
                                                                            <i class="fa-solid fa-location-dot"></i>
                                                                            <span class="px-2 sm-text">{{ $address }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fa-solid fa-location-dot"></i>
                                                                        <span class="px-2 ">{{ $sitesetting->office_address }}</span>
                                                                    </div>
                                                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        // Override the alert function to prevent normal alert popups
        window.alert = function() {};


        $('#contactForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            var form = $(this);
            var formData = new FormData(this);
            var recaptchaResponse = grecaptcha.getResponse();
            if (recaptchaResponse.length === 0) {


                swal.fire({
                    icon: "warning",
                    title: "Hold up",
                    text: "Please tick the RECAPTCHA box before submitting.",
                    confirmButtonText: 'Got it!',
                    confirmButtonColor: '#f39c12'
                });
                return;
            }
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Assuming the server returns JSON with 'success' and 'message'
                    if (response.success) {
                        swal.fire({
                            icon: "success",
                            title: "Let happy",
                            text: "Message sent successfully!",
                            confirmButtonText: 'Got it!',
                            confirmButtonColor: '#f39c12'
                        });
                        swal.fire({
                            icon: "success",
                            title: "Let happy",
                            text: "Message sent successfully!",
                            confirmButtonText: 'Got it!',
                            confirmButtonColor: '#f39c12'
                        });
                    } else {
                        swal.fire({
                            icon: "warning",
                            title: "Hold up",
                            text: "Error in sending message. Please try again.",
                            confirmButtonText: 'Got it!',
                            confirmButtonColor: '#f39c12'
                        });
                        swal.fire({
                            icon: "warning",
                            title: "Hold up",
                            text: "Error in sending message. Please try again.",
                            confirmButtonText: 'Got it!',
                            confirmButtonColor: '#f39c12'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    swal.fire({
                        icon: "error",
                        title: "Hold up",
                        text: "An unexpected error occurred. Please try again.",
                        confirmButtonText: 'Got it!',
                        confirmButtonColor: '#f39c12'
                    });
                    swal.fire({
                        icon: "error",
                        title: "Hold up",
                        text: "An unexpected error occurred. Please try again.",
                        confirmButtonText: 'Got it!',
                        confirmButtonColor: '#f39c12'
                    });
                }
            });
        });
    });
</script>

















