<!DOCTYPE html>
<html lang="en">
@include('backend.includes.head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>

@include('backend.includes.navbar')
            @include('backend.includes.sidebar')

            {{-- navbar --}}
            <div class="content">

               

                @include('sweetalert::alert')


                @yield('content')


                @include('backend.includes.footer')
            </div>

        </div>
    </main>

    {{-- @include('backend.includes.customsidebar') --}}
    @include('backend.includes.scripts')

    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote for the 'description' textarea
            $('#description').summernote();
    
            // Initialize Summernote for the 'content' textarea
            $('#content').summernote({
                callbacks: {
                    onSubmit: function(content) {
                        // Remove <p> tags from the content
                        return $(content).find('p').unwrap().end().html();
                    }
                }
            });
        });
    </script>

</body>

</html>
