<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @stack('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('public/assets/css/app.css')
</head>

<body>


    <div class="@if (!Request::is('register') && !Request::is('login')) flex @endif">
        @if (!Request::is('register') && !Request::is('login'))
            <div id="Main"
                class="flex min-h-screen w-full transform flex-col items-start justify-start border-r border-gray-600 bg-gray-900 transition duration-500 ease-in-out sm:w-[22rem] xl:translate-x-0">
                <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
                <div class="hidden items-center justify-start space-x-3 p-6 xl:flex">
                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1 17H0H1ZM7 17H6H7ZM17 27V28V27ZM27 17H28H27ZM17 0C12.4913 0 8.1673 1.79107 4.97918 4.97918L6.3934 6.3934C9.20644 3.58035 13.0218 2 17 2V0ZM4.97918 4.97918C1.79107 8.1673 0 12.4913 0 17H2C2 13.0218 3.58035 9.20644 6.3934 6.3934L4.97918 4.97918ZM0 17C0 21.5087 1.79107 25.8327 4.97918 29.0208L6.3934 27.6066C3.58035 24.7936 2 20.9782 2 17H0ZM4.97918 29.0208C8.1673 32.2089 12.4913 34 17 34V32C13.0218 32 9.20644 30.4196 6.3934 27.6066L4.97918 29.0208ZM17 34C21.5087 34 25.8327 32.2089 29.0208 29.0208L27.6066 27.6066C24.7936 30.4196 20.9782 32 17 32V34ZM29.0208 29.0208C32.2089 25.8327 34 21.5087 34 17H32C32 20.9782 30.4196 24.7936 27.6066 27.6066L29.0208 29.0208ZM34 17C34 12.4913 32.2089 8.1673 29.0208 4.97918L27.6066 6.3934C30.4196 9.20644 32 13.0218 32 17H34ZM29.0208 4.97918C25.8327 1.79107 21.5087 0 17 0V2C20.9782 2 24.7936 3.58035 27.6066 6.3934L29.0208 4.97918ZM17 6C14.0826 6 11.2847 7.15893 9.22183 9.22183L10.636 10.636C12.3239 8.94821 14.6131 8 17 8V6ZM9.22183 9.22183C7.15893 11.2847 6 14.0826 6 17H8C8 14.6131 8.94821 12.3239 10.636 10.636L9.22183 9.22183ZM6 17C6 19.9174 7.15893 22.7153 9.22183 24.7782L10.636 23.364C8.94821 21.6761 8 19.3869 8 17H6ZM9.22183 24.7782C11.2847 26.8411 14.0826 28 17 28V26C14.6131 26 12.3239 25.0518 10.636 23.364L9.22183 24.7782ZM17 28C19.9174 28 22.7153 26.8411 24.7782 24.7782L23.364 23.364C21.6761 25.0518 19.3869 26 17 26V28ZM24.7782 24.7782C26.8411 22.7153 28 19.9174 28 17H26C26 19.3869 25.0518 21.6761 23.364 23.364L24.7782 24.7782ZM28 17C28 14.0826 26.8411 11.2847 24.7782 9.22183L23.364 10.636C25.0518 12.3239 26 14.6131 26 17H28ZM24.7782 9.22183C22.7153 7.15893 19.9174 6 17 6V8C19.3869 8 21.6761 8.94821 23.364 10.636L24.7782 9.22183ZM10.3753 8.21913C6.86634 11.0263 4.86605 14.4281 4.50411 18.4095C4.14549 22.3543 5.40799 26.7295 8.13176 31.4961L9.86824 30.5039C7.25868 25.9371 6.18785 21.9791 6.49589 18.5905C6.80061 15.2386 8.46699 12.307 11.6247 9.78087L10.3753 8.21913ZM23.6247 25.7809C27.1294 22.9771 29.1332 19.6127 29.4958 15.6632C29.8549 11.7516 28.5904 7.41119 25.8682 2.64741L24.1318 3.63969C26.7429 8.20923 27.8117 12.1304 27.5042 15.4803C27.2001 18.7924 25.5372 21.6896 22.3753 24.2191L23.6247 25.7809Z"
                            fill="white" />
                    </svg>
                    <p class="text-2xl leading-6 text-white">OvonRueden</p>
                </div>
                <div class="flex h-full w-full flex-1 flex-col justify-between py-5">
                    <div>
                        <div
                            class="flex h-full w-full flex-1 flex-col items-center justify-start gap-4 space-y-3 border-b border-gray-600 pb-5 pl-4">
                            <a href="{{ route('feed.show') }}"
                                class="jusitfy-start flex w-full items-center space-x-6 rounded text-white duration-200 focus:text-indigo-400 focus:outline-none">
                                <svg class="fill-stroke" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9 4H5C4.44772 4 4 4.44772 4 5V9C4 9.55228 4.44772 10 5 10H9C9.55228 10 10 9.55228 10 9V5C10 4.44772 9.55228 4 9 4Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M19 4H15C14.4477 4 14 4.44772 14 5V9C14 9.55228 14.4477 10 15 10H19C19.5523 10 20 9.55228 20 9V5C20 4.44772 19.5523 4 19 4Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9 14H5C4.44772 14 4 14.4477 4 15V19C4 19.5523 4.44772 20 5 20H9C9.55228 20 10 19.5523 10 19V15C10 14.4477 9.55228 14 9 14Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M19 14H15C14.4477 14 14 14.4477 14 15V19C14 19.5523 14.4477 20 15 20H19C19.5523 20 20 19.5523 20 19V15C20 14.4477 19.5523 14 19 14Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <p class="text-base leading-4">Feed</p>
                            </a>
                            @if ($auth->admin)
                                <a href="{{ route('users.show') }}"
                                    class="jusitfy-start flex w-full items-center space-x-6 rounded text-white duration-200 focus:text-indigo-400 focus:outline-none">
                                    <svg class="fill-stroke" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M6 21V19C6 17.9391 6.42143 16.9217 7.17157 16.1716C7.92172 15.4214 8.93913 15 10 15H14C15.0609 15 16.0783 15.4214 16.8284 16.1716C17.5786 16.9217 18 17.9391 18 19V21"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <p class="text-base leading-4">Users</p>
                                </a>
                            @endif
                            <a href="{{ route('post.create') }}"
                                class="jusitfy-start flex w-full items-center space-x-6 rounded text-white duration-200 focus:text-indigo-400 focus:outline-none">
                                <svg class="ml-0.5 w-5 fill-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
                                </svg>
                                <p class="text-base leading-4">New Post</p>
                            </a>
                        </div>
                    </div>


                    <a class="sticky bottom-4" href="{{ route('profile.show', ['id' => $auth->id]) }}">
                        <div class="flex items-center space-x-2 pl-4">
                            <div>
                                <img class="max-w-10 aspect-square max-h-10 rounded-full object-cover"
                                    src="{{ $auth->avatar_src }}" alt="avatar" />
                            </div>
                            <div class="flex flex-col items-start justify-start">
                                <p class="cursor-pointer text-sm leading-5 text-white">{{ $auth->nick_name }}</p>
                                <p class="cursor-pointer text-xs leading-3 text-gray-300">{{ $auth->email }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <script>
                let icon1 = document.getElementById("icon1");
                let menu1 = document.getElementById("menu1");
                const showMenu1 = (flag) => {
                    if (flag) {
                        icon1.classList.toggle("rotate-180");
                        menu1.classList.toggle("hidden");
                    }
                };
                let icon2 = document.getElementById("icon2");

                const showMenu2 = (flag) => {
                    if (flag) {
                        icon2.classList.toggle("rotate-180");
                    }
                };
                let icon3 = document.getElementById("icon3");

                const showMenu3 = (flag) => {
                    if (flag) {
                        icon3.classList.toggle("rotate-180 ");
                        duration - 30
                    }
                };

                let Main = document.getElementById("Main");
                let open = document.getElementById("open");
                let close = document.getElementById("close");

                const showNav = (flag) => {
                    if (flag) {
                        Main.classList.toggle("-translate-x-full");
                        Main.classList.toggle("translate-x-0");
                        open.classList.toggle("hidden");
                        close.classList.toggle("hidden");
                    }
                };
            </script>
        @endif
        <div class="@if (!Request::is('login') && !Request::is('register')) w-full p-12 bg-gray-800 @endif">
            @yield('content')
        </div>
    </div>


    <script src="https://kit.fontawesome.com/1e21adaaa9.js" crossorigin="anonymous"></script>
    @stack('js')
    @vite('public/assets/js/app.js')
</body>

</html>
