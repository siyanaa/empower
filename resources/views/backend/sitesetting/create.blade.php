@extends('backend.layouts.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.site-settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Site Settings</h3>
                </div>
                <div class="card-body">
                    <!-- Office Name -->
                    <div class="form-group">
                        <label for="office_name">Office Name </label>
                        <input name="office_name" class="form-control" placeholder="Office Name" id="office_name">
                    </div>
                    
                    
                    <!-- Office Address (English) -->
                    <div class="form-group">
                        <label>Office Address</label>
                        <div id="office_addresses_container">
                            <div class="input-group mb-3">
                                <input type="text" name="office_address[]" class="form-control" placeholder="Office Address">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-address" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Office Contact (English) -->
                    <div class="form-group">
                        <label>Office Contact </label>
                        <div id="office_contacts_container">
                            <div class="input-group mb-3">
                                <input type="text" name="office_contact[]" class="form-control" placeholder="Office Contact">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-contact" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Office Emails -->
                    <div class="form-group">
                        <label>Office Emails</label>
                        <div id="office_emails_container">
                            <div class="input-group mb-3">
                                <input type="text" name="office_email[]" class="form-control" placeholder="Office Email">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-email" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Whatsapp Number -->
                    <div class="form-group">
                        <label for="whatsapp_number">Whatsapp Number </label>
                        <input type="text" name="whatsapp_number" class="form-control" placeholder="Whatsapp Number" id="whatsapp_number">
                    </div>

                    <!-- Main Logo -->
                    <div class="form-group">
                        <label for="main_logo">Main Logo</label>
                        <input type="file" name="main_logo" class="form-control" id="main_logo" onchange="previewImage(this, 'main_logo_preview')">
                        <img id="main_logo_preview" src="#" alt="Main Logo Preview" style="max-width: 200px; margin-top: 10px; display: none;">
                    </div>

                    <!-- Side Logo -->
                    <div class="form-group">
                        <label for="side_logo">Side Logo</label>
                        <input type="file" name="side_logo" class="form-control" id="side_logo" onchange="previewImage(this, 'side_logo_preview')">
                        <img id="side_logo_preview" src="#" alt="Side Logo Preview" style="max-width: 200px; margin-top: 10px; display: none;">
                    </div>

                    <!-- Slogan  -->
                    <div class="form-group">
                        <label for="slogan">Slogan </label>
                        <input type="text" name="slogan" class="form-control" placeholder="Slogan" id="slogan">
                    </div>

                    <!-- Company Registered Date -->
                    <div class="form-group">
                        <label for="company_registered_date">Company Registered Date</label>
                        <input type="date" name="company_registered_date" class="form-control" id="company_registered_date">
                    </div>

                    <!-- Facebook URL -->
                    <div class="form-group">
                        <label for="facebook_link">Facebook URL</label>
                        <input type="url" name="facebook_link" class="form-control" placeholder="Facebook URL (https://)" id="facebook_link">
                    </div>

                    <!-- Instagram URL -->
                    <div class="form-group">
                        <label for="instagram_link">Insta URL</label>
                        <input type="url" name="instagram_link" class="form-control" placeholder="Insta URL (https://)" id="instagram_link">
                    </div>

                    <!-- Snapchat URL -->
                    <div class="form-group">
                        <label for="snapchat_link">Snapchat URL</label>
                        <input type="url" name="snapchat_link" class="form-control" placeholder="Snapchat URL (https://)" id="snapchat_link">
                    </div>

                    <!-- LinkedIn URL -->
                    <div class="form-group">
                        <label for="linkedin_link">Linkedin URL</label>
                        <input type="url" name="linkedin_link" class="form-control" placeholder="LinkedIn URL (https://)" id="linkedin_link">
                    </div>

                    <!-- Google Maps URL -->
                    <div class="form-group">
                        <label for="google_maps_link">Google Maps</label>
                        <input type="url" name="google_maps_link" class="form-control" placeholder="Google Maps URL (https://)" id="google_maps_link">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Function to add a new input field
    function addField(containerId, fieldName) {
        var container = document.getElementById(containerId);
        var newField = document.createElement('div');
        newField.className = 'input-group mb-3';
        newField.innerHTML = `
            <input type="text" name="${fieldName}[]" class="form-control" placeholder="Enter value">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary remove-field" type="button">-</button>
            </div>
        `;
        container.appendChild(newField);
    }

    // Function to remove an input field
    function removeField(event) {
        if (event.target.classList.contains('remove-field')) {
            event.target.closest('.input-group').remove();
        }
    }

    // Event listener to add fields when document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to "+" buttons for each container
        document.getElementById('add-address').addEventListener('click', function() {
            addField('office_addresses_container', 'office_address');
        });

        document.getElementById('add-address-ne').addEventListener('click', function() {
            addField('office_addresses_container_ne', 'office_address_ne');
        });

        document.getElementById('add-contact').addEventListener('click', function() {
            addField('office_contacts_container', 'office_contact');
        });

        document.getElementById('add-contact-ne').addEventListener('click', function() {
            addField('office_contacts_container_ne', 'office_contact_ne');
        });

        document.getElementById('add-email').addEventListener('click', function() {
            addField('office_emails_container', 'office_email');
        });

        // Add event listener for removing fields
        document.addEventListener('click', removeField);
    });
</script>
@endsection
