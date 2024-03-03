<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="short icon" href="/assets/logo.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="bg-white border-gray-300 shadow-md px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="/" class="flex items-center">
                    <img src="/assets/logo.png"
                        class="mr-3 h-6 sm:h-9 w-full transition duration-300 ease-in-out hover:scale-105"
                        alt="Flustpicture Logo" />
                    <span
                        class="self-center text-xl font-pacifico whitespace-nowrap dark:text-white">Flustpicture</span>
                </a>
                <div class="flex gap-1">
                    <a href="/login"
                        class="inline-flex justify-center items-center py-3 px-4 text-base  font-semibold text-center text-gray-900 rounded-lg  hover:bg-blue-200 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-blue-700 dark:focus:ring-white">
                        LOG IN
                    </a>
                    <a href="/register"
                        class="inline-flex justify-center items-center py-3 px-4 text-base font-semibold text-center text-gray-900 rounded-lg  hover:bg-blue-200 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-blue-700 dark:focus:ring-white">
                        REGISTER
                    </a>
                </div>
    </header>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid py-8 px-4 mx-auto max-w-screen-xl lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="place-self-center mr-auto lg:col-span-7">
                <h1 class="mb-4 max-w-2xl text-4xl text-purple-800 font-pacifico leading-none md:text-5xl xl:text-6xl dark:text-white">
                    Selamat Datang di Website Galeri Foto</h1><br>
                <p class="mb-6 max-w-1xl font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">"Apa
                    yang saya suka tentang fotografi adalah mereka menangkap momen yang hilang selamanya, dan tidak
                    mungkin untuk memproduksinya kembali". @Karl Lagerfeld.</p>
            </div>
            <div class= "flex lg:mt-0 lg:col-span-5 lg:flex">
                <img src="/assets/logo.png" alt="mockup"
                    class="w-full transition duration-500 ease-in-out hover:scale-105">
            </div>
        </div>
    </section>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <h2
                class="mb-8 text-3xl font-hurricane tracking-tight leading-tight text-center text-gray-900 lg:mb-16 dark:text-white md:text-4xl">
                @Flustpicture</h2>
        </div>
    </section>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>
