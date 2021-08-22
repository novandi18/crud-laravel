<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href={{ asset("css/bootstrap.min.css") }}>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>CRUD Laravel | {{ $title }}</title>
    <link rel="shortcut icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
</head>

<body>
    @include('partials.navbar')

    <div class="container">
        @yield('container')
    </div>

    <div class="btn-group position-fixed mb-4" style="z-index: 1; bottom: 0; right: 2em;" id="chat">
        <button class="btn btn-primary rounded-circle py-2 text-white" id="dropdownHide" type="button"
            data-bs-toggle="dropdown">
            <i class="bi bi-chat-square-dots-fill"></i>
        </button>
        <ul class="dropdown-menu p-0 shadow border-0 dropdown-menu-end mb-2 overflow-hidden" style="width: 20em;">
            <ul class="list-group">
                <div class="bg-primary rounded-top pt-2 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary rounded-0" style="margin-top: -0.5em; display: none"
                            id="chatBack">
                            <div class="bi bi-arrow-left"></div>
                        </button>

                        <h6 class="text-white" style="margin-left: 1em" id="titleChat">Chat</h6>
                        <h6 style="margin-left: .4em;">
                            <span class="badge bg-transparent border border-white text-white" id="countTitle"></span>
                        </h6>
                    </div>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary rounded-0" style="margin-top: -0.5em;" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Refresh" id="refreshChat" onclick="refresh()">
                            <div class="bi bi-arrow-clockwise"></div>
                        </button>
                        <button class="btn btn-primary rounded-0" style="margin-top: -0.5em; display: none"
                            id="chatList" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">
                            <div class="bi bi-chat-square-dots-fill"></div>
                        </button>
                        <button class="btn btn-primary rounded-0" style="margin-top: -0.5em" id="chatContact"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kontak Admin">
                            <div class="bi bi-people-fill"></div>
                        </button>
                        <button class="btn btn-primary rounded-0" style="margin-top: -0.5em" id="chatHide"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sembunyikan">
                            <div class="bi bi-chevron-down"></div>
                        </button>
                    </div>
                </div>

                {{-- Tidak ada chat --}}
                <div style="overflow-y: auto; overflow-x: hidden; height: 20em; display: none" id="noChat">
                    <div class="d-flex h-100 justify-content-center align-items-center flex-column px-5 text-secondary">
                        <i class="bi bi-chat-square-dots" style="font-size: 4em"></i>
                        <span class="text-center">Mari mulai chat sekarang ke sesama admin!</span>
                        <a href="#" class="btn btn-primary mt-3" id="btnChatStart">Mulai Sekarang</a>
                    </div>
                </div>

                {{-- List Admin --}}
                <div style="overflow-y: auto; overflow-x: hidden; height: 20em; display: none" id="listAdmin">
                </div>

                {{-- List Chat --}}
                <div style="overflow-y: auto; overflow-x: hidden; height: 20em; display: none;" id="listChat">
                </div>

                {{-- Personal Chat --}}
                <div style="height: 20em; display: none;" id="personalChat">
                    <li class="list-group-item d-flex align-items-center rounded-0 border-0 flex-column"
                        style="overflow-y: auto; overflow-x: hidden; height: 17.5em" id="messages">

                    </li>

                    <form id="message_form">
                        <li class="list-group-item border-0 p-0 d-flex justify-content-between" style="height: 2.5em">
                            <input type="hidden" id="username" name="username" value="{{ Auth::user()->username }}">
                            <input type="hidden" id="name" name="name" value="{{ Auth::user()->name }}">
                            <input type="hidden" id="to_name" name="to_name" value="">
                            <input type="hidden" id="receiver" name="receiver">
                            <input type="text" name="message" id="input" placeholder="Masukkan pesan"
                                class="border px-3 w-100 rounded-0 border-0" style="outline: none; background: #F9FAFB">
                            <button class="btn btn-primary rounded-0" type="submit" id="message_send"><i
                                    class="bi bi-arrow-right"></i></button>
                        </li>
                    </form>
                </div>
            </ul>
        </ul>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
    <script src="../../js/app.js"></script>

</body>

</html>