<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" aria-label="Toggle Navigation" data-bs-original-title="Toggle Navigation">
                <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
            </button>
        </div>
        <a class="navbar-brand" href="#">
            <div class="d-flex align-items-center py-3">
                <img class="me-2" src="{{ asset('adminassets/assets/img/icons/spot-illustrations/falcon.png') }}"
                    alt="" width="40">
                <span class="font-sans-serif">Admin</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <svg class="svg-inline--fa fa-chart-pie fa-w-17" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="chart-pie" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 544 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M527.79 288H290.5l158.03 158.03c6.04 6.04 15.98 6.53 22.19.68 38.7-36.46 65.32-85.61 73.13-140.86 1.34-9.46-6.51-17.85-16.06-17.85zm-15.83-64.8C503.72 103.74 408.26 8.28 288.8.04 279.68-.59 272 7.1 272 16.24V240h223.77c9.14 0 16.82-7.68 16.19-16.8zM224 288V50.71c0-9.55-8.39-17.4-17.84-16.06C86.99 51.49-4.1 155.6.14 280.37 4.5 408.51 114.83 513.59 243.03 511.98c50.4-.63 96.97-16.87 135.26-44.03 7.9-5.6 8.42-17.23 1.57-24.08L224 288z">
                                    </path>
                                </svg>
                                <a href="#"><span class="nav-link-text ps-1">Dashboard</span></a>
                            </span>
                        </div>
                    </a>
                </li>

                {{-- Beginning of Site Settings --}}
                @hasanyrole('superadmin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Site Settings</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'site-settings' ? '' : 'collapsed' }}"
                            href="#dashboard6" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'site-settings' ? 'true' : 'false' }}"
                            aria-controls="dashboard6">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Site Settings</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'site-settings' ? 'show' : '' }}" id="dashboard6">
                            @can('list_site_settings')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'site-settings' ? 'active' : '' }}"
                                        href="{{ route('admin.site-settings.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-angle-double-right"></i> Site Setting
                                        </div>
                                    </a>
                                </li>
                            @endcan
                            {{-- Insert Favicon Menu Item here --}}
                            @can('list_favicons')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'favicons' ? 'active' : '' }}"
                                        href="{{ route('admin.favicons.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-angle-double-right"></i> Favicon
                                        </div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of Site Settings --}}




                {{-- Beginning of Contact Details --}}
                @hasanyrole('superadmin|admin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Contact Details</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                            href="#dashboard18" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                            aria-controls="dashboard18">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Contact Details</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'contact-details' ? 'show' : '' }}"
                            id="dashboard18">
                            {{-- Visitors Book --}}
                            @can('list_visitors_book')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'visitors-book' ? 'active' : '' }}"
                                        href="{{ route('admin.visitors-book.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Visitors Book
                                        </div>
                                    </a>
                                </li>
                            @endcan

                            {{-- CEO Message
                            @can('list_ceomessage')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'ceomessage' ? 'active' : '' }}"
                                        href="{{ route('admin.ceomessage.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            CEO Message
                                        </div>
                                    </a>
                                </li>
                            @endcan --}}

                            {{-- Student Details --}}
                            @can('list_student_details')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'student-details' ? 'active' : '' }}"
                                        href="{{ route('admin.student-details.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Worker Details
                                        </div>
                                    </a>
                                </li>
                            @endcan

                            {{-- Contacts --}}
                            @can('list_contacts')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'contacts' ? 'active' : '' }}"
                                        href="{{ route('admin.contacts.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Contacts
                                        </div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of Contact Details --}}



                {{-- Beginning of Informations --}}
                @hasanyrole('superadmin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Informations</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#dashboard15" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard15">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Informations</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'informations' ? 'show' : '' }}"
                            id="dashboard15">
                            {{-- Country --}}
                            @can('list_countries')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'countries' ? 'active' : '' }}"
                                        href="{{ route('admin.countries.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Country
                                        </div>
                                    </a>
                                </li>
                            @endcan

                            {{-- Company --}}
                            @can('list_companies')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'company' ? 'active' : '' }}"
                                        href="{{ route('admin.companies.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Company
                                        </div>
                                    </a>
                                </li>
                            @endcan

                            {{-- Course --}}
                            @can('list_work_categories')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'work-category' ? 'active' : '' }}"
                                        href="{{ route('admin.work_categories.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Work Category
                                        </div>
                                    </a>
                                </li>
                            @endcan

                            {{-- Demand --}}
                            @can('list_demands')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'demands' ? 'active' : '' }}"
                                        href="{{ route('admin.demands.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Demand
                                        </div>
                                    </a>
                                </li>
                            @endcan

                             {{-- View Application --}}
                             @can('list_applications')
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::segment(2) == 'demands' ? 'active' : '' }}"
                                     href="{{ route('admin.applications.index') }}">
                                     <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                         Applications
                                     </div>
                                 </a>
                             </li>
                         @endcan
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of Informations --}}



                {{-- Beginning of Introduction --}}
                @hasanyrole('superadmin')
                    <li class="nav-item">
                        <!-- Navbar vertical label -->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Introduction</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                        <!-- Dropdown item -->
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'about-us' || Request::segment(2) == 'cover-images' || Request::segment(2) == 'services' || Request::segment(2) == 'team' ? '' : 'collapsed' }}"
                            href="#dashboardIntro" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'about-us' || Request::segment(2) == 'cover-images' || Request::segment(2) == 'services' || Request::segment(2) == 'team' ? 'true' : 'false' }}"
                            aria-controls="dashboardIntro">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Introduction</span>
                            </div>
                        </a>
                        <!-- Collapse content -->
                        <ul class="nav collapse {{ Request::segment(2) == 'about-us' || Request::segment(2) == 'cover-images' || Request::segment(2) == 'services' || Request::segment(2) == 'team' ? 'show' : '' }}"
                            id="dashboardIntro">
                            {{-- About Us --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'about-us' ? 'active' : '' }}"
                                    href="{{ route('admin.about-us.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">About Us</span>
                                    </div>
                                </a>
                            </li>
                            {{-- Cover Image --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'cover-images' ? 'active' : '' }}"
                                    href="{{ route('admin.cover-images.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Cover Image</span>
                                    </div>
                                </a>
                            </li>
                            {{-- Services --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'services' ? 'active' : '' }}"
                                    href="{{ route('admin.services.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Services</span>
                                    </div>
                                </a>
                            </li>
                            {{-- Teams --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'team' ? 'active' : '' }}"
                                    href="{{ route('admin.teams.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Teams</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> <!-- Corrected closing tag -->
                    </li>
                @endhasanyrole
                {{-- End of Introduction --}}



                {{-- Beginning of Posts --}}
                @hasanyrole('superadmin')
                    <li class="nav-item">
                        <!-- Navbar vertical label -->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Posts</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                        <!-- Dropdown item -->
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'posts' ? '' : 'collapsed' }}"
                            href="#dashboard23" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'posts' ? 'true' : 'false' }}"
                            aria-controls="dashboard23">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Posts</span>
                            </div>
                        </a>
                        <!-- Collapse content -->
                        <ul class="nav collapse {{ Request::segment(2) == 'posts' ? 'show' : '' }}" id="dashboard23">
                            {{-- Categories --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'categories' ? 'active' : '' }}"
                                    href="{{ route('admin.categories.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Categories</span>
                                    </div>
                                </a>
                            </li>
                            {{-- Post (Add & List) --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(3) == 'create' || (Request::segment(2) == 'posts' && Request::segment(3) != 'categories') ? 'active' : '' }}"
                                    href="{{ route('admin.posts.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Post</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> <!-- Corrected closing tag -->
                    </li>
                @endhasanyrole
                {{-- End of Posts --}}





                {{-- Beginning of Gallery --}}

                @hasanyrole('superadmin|admin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Gallery</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#dashboard11" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><i
                                        class="fas fa-users"></i></span><span class="nav-link-text ps-1">Gallery
                                </span></div>
                        </a>
                        <ul class="nav collapse  {{ Request::segment(2) == 'photo-galleries' || Request::segment(2) == 'video-galleries' ? 'show' : '' }}"
                            id="dashboard11">
                            @can('list_photo_galleries')
                                <li class="nav-item"><a
                                        class="nav-link {{ Request::segment(2) == 'photo-galleries' ? 'active' : '' }}"
                                        href="{{ route('admin.photo-galleries.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Photo Gallery

                                        </div>
                                    </a>
                                </li>
                            @endcan

                            @can('list_video_galleries')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'video-galleries' ? 'active' : '' }}"
                                        href="{{ route('admin.video-galleries.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-angle-double-right"></i> Video Gallery
                                        </div>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                    </li>
                @endhasanyrole

                {{-- End of Gallery --}}






                {{-- Beginning of Student Reviews --}}
                @hasanyrole('superadmin|admin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Student Reviews</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#dashboard16" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard16">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><i
                                        class="fas fa-users"></i></span><span class="nav-link-text ps-1">Testimonials
                                </span></div>
                        </a>
                        <ul class="nav collapse  {{ Request::segment(2) == 'testimonials' ? 'show' : '' }}"
                            id="dashboard16">
                            @can('list_testimonials')
                                <li class="nav-item"><a
                                        class="nav-link {{ Request::segment(2) == 'testimonials' ? 'active' : '' }}"
                                        href="{{ route('admin.testimonials.index') }}">
                                        <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                            Testimonial

                                        </div>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of Student Reviews --}}

                {{-- Beginning of Blog Posts Category --}}
                @hasanyrole('superadmin|admin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Blogs</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#blog-post-category" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="blog-post-category">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <span class="nav-link-text ps-1">Blogs</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'faqs' ? 'show' : '' }}"
                            id="blog-post-category" id="dashboard19">
                            {{-- Add Blog Post Category --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'faqs' && Request::segment(3) == 'create' ? 'active' : '' }}"
                                    href="{{ route('admin.blog-posts-categories.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span class="nav-link-text ps-1">Blogs</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of Blog Posts Category --}}




                {{-- Beginning of FAQs --}}
                @hasanyrole('superadmin|admin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Frequently Asked Questions</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'faqs' ? 'active' : '' }}"
                            href="#faq" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="faq">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-question-circle"></i></span>
                                <span class="nav-link-text ps-1">FAQs</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'faqs' ? 'show' : '' }}" id="faq">
                            {{-- FAQs --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'faqs' ? 'active' : '' }}"
                                    href="{{ route('admin.faqs.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-list"></i>
                                        <span class="nav-link-text ps-1">FAQ</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of FAQs --}}

                {{-- Beginning of CEOMESSAGE --}}
                @hasanyrole('superadmin')
                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">CEO Messages</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'ceomessage' ? 'active' : '' }}"
                            href="#d_msg" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="d_msg">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-question-circle"></i></span>
                                <span class="nav-link-text ps-1">CEO Messages</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ Request::segment(2) == 'ceomessage' ? 'show' : '' }}"
                            id="d_msg" id="dashboard21">
                            {{-- CEO Messages --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::segment(2) == 'ceomessage' ? 'active' : '' }}"
                                    href="{{ route('admin.ceomessage.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-list"></i>
                                        <span class="nav-link-text ps-1">CEO Message</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>
                @endhasanyrole
                {{-- End of CEOMESSAGE --}}

                 {{-- Beginning of Our Clients --}}
@hasanyrole('superadmin|admin')
<li class="nav-item">
    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
        <div class="col-auto navbar-vertical-label">Our Clients</div>
        <div class="col ps-0">
            <hr class="mb-0 navbar-vertical-divider">
        </div>
    </div>
    <a class="nav-link dropdown-indicator {{ Request::segment(2) == 'clients' ? 'active' : '' }}"
       href="#clients" role="button" data-bs-toggle="collapse" aria-expanded="true"
       aria-controls="clients">
        <div class="d-flex align-items-center">
            <span class="nav-link-icon"><i class="fas fa-question-circle"></i></span>
            <span class="nav-link-text ps-1">Our Clients</span>
        </div>
    </a>
    <ul class="nav collapse {{ Request::segment(2) == 'clients' ? 'show' : '' }}" id="clients">
        {{-- Clients --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'clients' ? 'active' : '' }}"
               href="{{ route('admin.client.index') }}">
                <div class="d-flex align-items-center">
                    <i class="fa fa-list"></i>
                    <span class="nav-link-text ps-1">Clients</span>
                </div>
            </a>
        </li>
        {{-- Clients Messages --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'clients' ? 'active' : '' }}"
               href="{{ route('admin.client_messages.index') }}">
                <div class="d-flex align-items-center">
                    <i class="fa fa-list"></i>
                    <span class="nav-link-text ps-1">Clients Messages</span>
                </div>
            </a>
        </li>
    </ul>
</li>
@endhasanyrole
             {{-- End of Our Clients --}}


            </ul>
        </div>
    </div>


</nav>
