<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluspicture | log in</title>
    <link rel="short icon" href="/assets/logo.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="bg-white border-gray-200 shadow-md dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between max-w-screen-md p-4 mx-auto">
            <h3 class="text-3xl font-pacifico text-purple-700">Fluspicture</h3>
            <div class="flex gap-1">
                <a href="/login"><button class="px-5 py-1 text-white rounded-full bg-blue-700">Login</button></a>
                <a href="/register"><button class="px-5 py-1 rounded-full bg-bgcolor2">Register</button></a>
            </div>
        </div>
    </nav>
    <section class="mt-14">
        <div class="max-w-[364px] bg-white rounded-md shadow-md mx-auto px-6 py-4">
            <form action="/ceklogin" method="post">
                @csrf
                <div class="flex flex-col">
                    <div class="sm:mx-auto sm:w-full sm:max-w-sm transition duration-500 ease-in-out hover:scale-105">
                        <img class="mx-auto h-24 w-auto" src="/assets/logo.png" alt="Your Company">
                    </div>
                    <a href="/" class="mx-auto text-sky-600 text-3xl font-hurricane">Sign in with email
                        Account</a>
                    <div>
                        <h4 class="mt-3">Email</h4>
                        <input type="email" name="email" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Jhonde@gmail.com" required="#">
                        @error('email')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <h4 class="mt-3">Password</h4>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                        @error('password')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit"
                        class="py-2 px-32 mt-4 text-white rounded-full bg-blue-600 hover:bg-blue-700">Log in</button>
                    <div class="mt-3"></div>
                    <a href="/resetemail"
                        class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-normal py-2 px-4 rounded-full">
                        Forget Password
                    </a>
                    <div class="mb-4"></div>
                    <p class=" text-center text-sm font-light text-gray-500 dark:text-gray-400">
                        Belum Punya Akun Daftar? <a href="/register"
                            class=" text-blue-700 text-primary-600 hover:underline dark:text-primary-500">Register</a>
                    <div class="mb-4"></div>
                    {{-- @if (auth()->check() && auth()->user()->isBanned()) --}}
                        <p class="text-center text-sm font-light text-gray-500 dark:text-gray-400">
                            Akun Anda telah diblokir. Butuh bantuan? Silakan <a href="/pesanapply"
                                class="text-blue-700 text-primary-600 hover:underline dark:text-primary-500">hubungi
                                kami</a>.
                        </p>
                    {{-- @endif --}}
                </div>
            </form>
        </div>
    </section>
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
