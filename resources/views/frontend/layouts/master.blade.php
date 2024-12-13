<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    

@php

@endphp



@include('frontend.includes.head')

<body>
    
@include('frontend.includes.topnav')

    @include('frontend.includes.navbar')

    @yield('content')

    @include('frontend.includes.footer')

    <style>
        .whatsapp-chat-container {
            position: fixed;
            bottom: 1%;
            right: 1%;
            z-index: 999;
            transition: transform 0.3s ease-in-out;
            transform: scale(1);
        }

        .whatsapp-chat {
            display: block;
        }

        .whatsapp-chat img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .whatsapp-chat img:hover {
            transform: scale(1.1);
        }
    </style>

    
    <!-- WhatsApp Chat Button -->
    <div class="whatsapp-chat-container" id="whatsappChatContainer">
        <div class="whatsapp-chat">
            <a href="https://api.whatsapp.com/send?phone=9779861331656" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png"
                    alt="WhatsApp Chat" width="50" height="50">
            </a>
        </div>
    </div>


    <script>
        window.addEventListener('scroll', function() {
            var scrollPosition = window.scrollY;

            if (scrollPosition > 100) {
                document.getElementById('whatsappChatContainer').style.display = 'block';
            } else {
                document.getElementById('whatsappChatContainer').style.display = 'none';
            }
        });
    </script>

</body>

</html>
