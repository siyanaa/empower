<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    use App\Models\Favicon;
    $favicon = Favicon::first();
    ?>
    @include('backend.includes.head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
</head>

<body>

    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>

            @include('backend.includes.sidebar')

            <div class="content">
                @include('backend.includes.navbar')
                @yield('content')
                @include('backend.includes.footer')
            </div>
        </div>
    </main>

    @include('backend.includes.customsidebar')
    @include('backend.includes.scripts')

    <!-- Summernote JS -->
  
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });
    </script>
</body>

</html>
