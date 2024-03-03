<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluspicture | Apply</title>
    <link rel="shortcut icon" href="/assets/logo.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-800">
    <section class="mt-14">
        <div class="max-w-[364px] bg-white rounded-md shadow-md mx-auto px-6 py-4">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <a href="/login"
                    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                    Kembali
                </a>
                <br>
                <img class="mx-auto w-36 h-36 " src="/assets/logo.png" alt="Your Company">
                <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    Ajukan Banding Akun
                </h2>
            </div>
            <br>
            <form action="/ajukanbanding" method="POST">
                @csrf
                <div class="mb-4">
                    <h4 class="mt-3">Username</h4>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Jhonde" required="#">
                    @error('username')
                        <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <h4 class="mt-3">Email</h4>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Jhon@gmail.com" required="#">
                    @error('email')
                        <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                        <label for="comment" class="sr-only">Your comment</label>
                        <textarea id="comment" name="pesan" rows="4"
                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                            placeholder="Tuliskan pesan ..." required></textarea>
                    </div>
                    <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                        <button type="submit"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                            Ajukan Banding
                        </button>
                    </div>
                </div>
                <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">
                    Laporkan, Postingan yang berbau sara, negatif, pornogatif, laporan anda akan di tinjau
                    <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Flustpictures</a>.
                </p>
            </form>
        </div>
    </section>
</body>

</html>
