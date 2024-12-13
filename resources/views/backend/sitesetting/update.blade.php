@extends('backend.layouts.master')

@section('content')
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

    <div class="row mb-0"> 
        <div class="col-sm-6">
            <h1 class="m-0">{{ $page_title }}</h1>
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form id="quickForm" method="POST" action="{{ route('admin.site-settings.update', $sitesetting->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $sitesetting->id }}">
                <div class="card-body">
                    <div>
                        <div class="form-group">
                            <label for="office_name">Office Name </label>
                            <input type="text" name="office_name" class="form-control" placeholder="Office Name"
                                id="office_name" value="{{ $sitesetting->office_name }}">
                        </div>

                        <div class="form-group" id="office_addresses_container_en">
                            <label for="office_address">Office Address</label>
                            @foreach(json_decode($sitesetting->office_address) as $address)
                                <div class="input-group mb-3">
                                    <input type="text" name="office_address[]" class="form-control" placeholder="Address" value="{{ $address }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary remove-address" type="button">-</button>
                                        <button class="btn btn-outline-secondary add-address" type="button">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group" id="office_contacts_container_en">
                            <label for="office_contact">Office Contact</label>
                            @foreach(json_decode($sitesetting->office_contact) as $contact)
                                <div class="input-group mb-3">
                                    <input type="text" name="office_contact[]" class="form-control" placeholder="Office Contact" value="{{ $contact }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary remove-contact" type="button">-</button>
                                        <button class="btn btn-outline-secondary add-contact" type="button">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group" id="office_emails_container">
                            <label for="office_email">Office Emails</label>
                            @php
                            $emails = json_decode($sitesetting->office_email) ?? [];
                            @endphp
                            @foreach($emails as $email)
                                <div class="input-group mb-3">
                                    <input type="email" name="office_email[]" class="form-control" placeholder="Email" value="{{ $email }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary remove-email" type="button">-</button>
                                        <button class="btn btn-outline-secondary add-email" type="button">+</button>
                                    </div>
                                </div>
                            @endforeach
                            @if(empty($emails))
                                <div class="input-group mb-3">
                                    <input type="email" name="office_email[]" class="form-control" placeholder="Email">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary remove-email" type="button">-</button>
                                        <button class="btn btn-outline-secondary add-email" type="button">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="whatsapp_number">Whatsapp Number</label>
                            <input type="text" name="whatsapp_number" class="form-control" placeholder="Whatsapp Number"
                                id="whatsapp_number" value="{{ $sitesetting->whatsapp_number }}">
                        </div>


                        <div class="form-group">
                            <label for="company_registered_date">Company Registered Date</label>
                            <input type="date" name="company_registered_date" class="form-control"
                                placeholder="Enter Registered Date" id="company_registered_date"
                                value="{{ $sitesetting->company_registered_date }}">
                        </div>

                        <div class="form-group">
                            <label for="main_logo">Main Logo</label>
                            <input type="file" name="main_logo" class="form-control" placeholder="Main Logo"
                                id="main_logo" onchange="previewMainImage(event)">

                            <img id="main_preview" src="{{ asset('uploads/sitesetting/' . $sitesetting->main_logo) }}"
                                style="max-width: 300px; max-height:300px" />
                        </div>

                        <div class="form-group">
                            <label for="side_logo">Side Logo</label>
                            <input type="file" name="side_logo" class="form-control" placeholder="Side Logo"
                                id="side_logo" onchange="previewSideImage(event)">

                            <img id="side_preview" src="{{ asset('uploads/sitesetting/' . $sitesetting->side_logo) }}"
                                style="max-width: 300px; max-height:300px" />
                        </div>

                        <div class="form-group">
                            <label for="slogan">Slogan </label>
                            <input type="text" name="slogan" class="form-control" placeholder="Slogan" id="slogan"
                                value="{{ $sitesetting->slogan }}">
                        </div>


                        <div class="form-group">
                            <label for="facebook_link">Facebook URL</label>
                            <input name="facebook_link" class="form-control" placeholder="Facebook URL (https://)"
                                id="facebook_link" value="{{ $sitesetting->facebook_link }}">
                        </div>

                        <div class="form-group">
                            <label for="instagram_link">Insta URL</label>
                            <input name="instagram_link" class="form-control" placeholder="Insta URL (https://)"
                                id="instagram_link" value="{{ $sitesetting->instagram_link }}">
                        </div>

                        <div class="form-group">
                            <label for="linkedin_link">Linkedin URL</label>
                            <input name="linkedin_link" class="form-control" placeholder="Linkedin URL (https://)"
                                id="linkedin_link" value="{{ $sitesetting->linkedin_link }}">
                        </div>

                        <div class="form-group">
                            <label for="twitter_link">Twitter URL</label>
                            <input name="twitter_link" class="form-control" placeholder="Twitter URL (https://)"
                                id="twitter_link" value="{{ $sitesetting->twitter_link }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const previewMainImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                document.getElementById('main_preview').src = reader.result;
            };
        };

        const previewSideImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                document.getElementById('side_preview').src = reader.result;
            };
        };

        document.addEventListener('click', e => {
            if (e.target.classList.contains('add-address')) {
                const container = document.getElementById('office_addresses_container_en');
                const newAddress = document.createElement('div');
                newAddress.classList.add('input-group', 'mb-3');
                newAddress.innerHTML = `
                    <input type="text" name="office_address[]" class="form-control" placeholder="Address">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-address" type="button">-</button>
                        <button class="btn btn-outline-secondary add-address" type="button">+</button>
                    </div>
                `;
                container.appendChild(newAddress);
            }

            if (e.target.classList.contains('remove-address')) {
                e.target.closest('.input-group').remove();
            }

            if (e.target.classList.contains('add-address-ne')) {
                const container = document.getElementById('office_addresses_container_ne');
                const newAddress = document.createElement('div');
                newAddress.classList.add('input-group', 'mb-3');
                newAddress.innerHTML = `
                    <input type="text" name="office_address_ne[]" class="form-control" placeholder="Address">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-address-ne" type="button">-</button>
                        <button class="btn btn-outline-secondary add-address-ne" type="button">+</button>
                    </div>
                `;
                container.appendChild(newAddress);
            }

            if (e.target.classList.contains('remove-address-ne')) {
                e.target.closest('.input-group').remove();
            }

            if (e.target.classList.contains('add-contact')) {
                const container = document.getElementById('office_contacts_container_en');
                const newContact = document.createElement('div');
                newContact.classList.add('input-group', 'mb-3');
                newContact.innerHTML = `
                    <input type="text" name="office_contact[]" class="form-control" placeholder="Office Contact">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-contact" type="button">-</button>
                        <button class="btn btn-outline-secondary add-contact" type="button">+</button>
                    </div>
                `;
                container.appendChild(newContact);
            }

            if (e.target.classList.contains('remove-contact')) {
                e.target.closest('.input-group').remove();
            }

            if (e.target.classList.contains('add-contact-ne')) {
                const container = document.getElementById('office_contacts_container_ne');
                const newContact = document.createElement('div');
                newContact.classList.add('input-group', 'mb-3');
                newContact.innerHTML = `
                    <input type="text" name="office_contact_ne[]" class="form-control" placeholder="Office Contact">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-contact-ne" type="button">-</button>
                        <button class="btn btn-outline-secondary add-contact-ne" type="button">+</button>
                    </div>
                `;
                container.appendChild(newContact);
            }

            if (e.target.classList.contains('remove-contact-ne')) {
                e.target.closest('.input-group').remove();
            }

            if (e.target.classList.contains('add-email')) {
                const container = document.getElementById('office_emails_container');
                const newEmail = document.createElement('div');
                newEmail.classList.add('input-group', 'mb-3');
                newEmail.innerHTML = `
                    <input type="email" name="office_email[]" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-email" type="button">-</button>
                        <button class="btn btn-outline-secondary add-email" type="button">+</button>
                    </div>
                `;
                container.appendChild(newEmail);
            }

            if (e.target.classList.contains('remove-email')) {
                e.target.closest('.input-group').remove();
            }
        });
    </script>
@endsection
