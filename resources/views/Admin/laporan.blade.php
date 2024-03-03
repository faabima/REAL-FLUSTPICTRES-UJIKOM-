@extends('Admin.layout.main')
@section('content')
    <!--navbar-->
    <div class="flex overflow-hidden bg-white pt-16">
        <!--sidebar-->
        <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
        <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
            <main>
                <div class="pt-6 px-4">
                    <!--datauser-->
                    <div class="grid grid-cols-1 2xl:grid-cols-2 xl:gap-4 my-4">
                        <!--laporan-->
                        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                            <h3 class="text-xl leading-none font-bold text-gray-900 mb-5">Laporan User</h3>
                            <div class="block w-full overflow-x-auto">
                                <div class="p-6 overflow-scroll px-0">
                                    <table class="mt-4 w-full min-w-max table-auto text-left">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        Foto <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9">
                                                            </path>
                                                        </svg>
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        User <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9">
                                                            </path>
                                                        </svg>
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        Alasan <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9">
                                                            </path>
                                                        </svg>
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        Status <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9">
                                                            </path>
                                                        </svg>
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        Tanggal <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9">
                                                            </path>
                                                        </svg>
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                        Actions</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datalaporan as $laporan)
                                                <tr>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <div class="flex items-center gap-3">
                                                            <div class="flex flex-col">
                                                                <img src="/postingan/{{ $laporan->lokasi_file }}"
                                                                    alt=""
                                                                    class="inline-block relative object-cover object-center !rounded-full w-28 h-24 ">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <div class="flex items-center gap-4">
                                                            <img src="/pic/{{ $laporan->foto_profil }}" alt="User Avatar"
                                                                class="w-8 h-8 rounded-full">
                                                            <div class="flex flex-col">
                                                                <p
                                                                    class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                                    {{ $laporan->username }}</p>
                                                                <p
                                                                    class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal opacity-70">
                                                                    {{ $laporan->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <div class="flex flex-col">
                                                            <p
                                                                class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                                {{ $laporan->alasan }}</p>
                                                            {{-- <p
                                                            class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal opacity-70">
                                                            Organization</p> --}}
                                                        </div>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <div class="w-max">
                                                            <p
                                                                class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                                {{ $laporan->status }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <p
                                                            class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                            {{ \Carbon\Carbon::parse($laporan->created_at)->format('D-M-Y') }}
                                                        </p>

                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <form
                                                            action="{{ route('delete_photo', ['id' => $laporan->foto_id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('DELETE')
                                                            <!-- ... -->
                                                            <button type="submit"
                                                                class= "w-24 py-2 text-white  bg-blue-700 rounded-md"
                                                                type="button">
                                                                Take Down
                                                            </button>
                                                        </form>
                                                        <br>
                                                        <form action="{{ route('hapuslaporan', ['id' => $laporan->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class= "w-24 py-2 text-white  bg-blue-700 rounded-md"
                                                                type="button">
                                                                Tolak
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <div class="bg-white md:flex md:items-center md:justify-between shadow rounded-lg p-4 md:p-6 xl:p-8 my-6 mx-4">
                <footer class="relative pt-8 pb-6 mt-16">
                    <div class="container mx-auto px-4">
                        <div class="flex flex-wrap items-center md:justify-between justify-center">
                            <div class="w-full md:w-6/12 px-4 mx-auto text-center">
                                <div class="text-sm text-gray-500  py-1">
                                    Made with <a href="https://www.creative-tim.com/product/soft-ui-dashboard-tailwind"
                                        class="text-gray-900 hover:text-gray-800" target="_blank">Software
                                        UI</a> by <a href="https://www.creative-tim.com"
                                        class="text-gray-900 hover:text-gray-800" target="_blank">
                                        fabimafadzillah Tim</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!--footer-->
        </div>
    </div>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
    </div>
@endsection
