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
                        <!--pesan-->
                        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                            <h3 class="text-xl leading-none font-bold text-gray-900 mb-5">Pesan</h3>
                            <div class="block w-full overflow-x-auto">
                                <div class="p-6 overflow-scroll px-0">
                                    <table class="mt-4 w-full min-w-max table-auto text-left">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                                        Username
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                                        Email
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                                        Pesan
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                                        Tanggal
                                                    </p>
                                                </th>
                                                <th
                                                    class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                                    <p
                                                        class="antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                                        Actions
                                                    </p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($messages as $message)
                                                <tr>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <p
                                                            class="antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                            {{ $message->username }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <p
                                                            class="antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                            {{ $message->email }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <p
                                                            class="antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                            {{ $message->pesan }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <p
                                                            class="antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                                            {{ $message->created_at->format('d M Y') }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4 border-b border-blue-gray-50">
                                                        <form action="{{ route('hapuspesan') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $pesan->id }}">
                                                            <button type="submit"
                                                                class="w-24 py-2 text-white bg-blue-700 rounded-md">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                        <br>
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
