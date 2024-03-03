<!--navbar-->
@extends('layout.main')
@push('cssjsexternal')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
<!--/navbar-->
@section('content')
    <section class="mt-32">
        @csrf
        <div class="items-center max-w-screen-md mx-auto ">
            <h3 class="text-5xl text-center font-hurricane">Album</h3>
        </div>
    </section>
    <section>
        <div class="flex flex-col items-center max-w-screen-md px-2 mx-auto mt-4">
            <div>
                @php
                    $foto_profil = Auth::user()->foto_profil;
                    $avatar_default = 'users.png'; // Ganti dengan nama file avatar default Anda
                @endphp
                <img src="{{ $foto_profil ? asset("/pic/$foto_profil") : asset("/pic/$avatar_default") }}" alt="User Avatar"
                    class="rounded-full w-20 h-20">
            </div>
            <h3 class="text-xl font-semibold">
                {{ old('username', Auth::User()->username) }}
            </h3>
            <div class="mb-4"></div>
            <div class="flex justify-between gap-2">
                <a href="/profile" type="button" class="items-center bg-blue-600 text-white px-4 py-1 rounded-full">
                    <h3 class="text-1xl font-semibold">
                        Edit Profil
                    </h3>
                </a>
            </div>
            <div class="mb-4"></div>
            <small class="text-center text-xs ">{{ old('bio', Auth::User()->bio) }}</small>
            <div class="flex flex-row mt-3">
                <small class="mr-4 text-abuabu">Pengikut {{ $userFollowers }}</small>
                <small class="text-abuabu">Diikuti {{ $dataFollowCount }}</small>
            </div>
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <!--Album-->
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="album-tab" data-tabs-target="#album"
                            type="button" role="tab" aria-controls="album" aria-selected="false">Album</button>
                    </li>
                    <!--DaftarAlbum-->
                    {{-- <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="daftar-tab" data-tabs-target="#daftar"
                            type="button" role="tab" aria-controls="daftar" aria-selected="false">Daftar Album</button>
                    </li> --}}
                    <!--Postingan-->    
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="postingan-tab" data-tabs-target="#postingan" type="button" role="tab"
                            aria-controls="postingan" aria-selected="false">Postingan Semua</button>
                    </li>
                </ul>
            </div>
        </div>
        <!--album-->
        <section class="mt-2">
            <div class="hidden" id="album" role="tabpanel" aria-roledescription="album-tab">
                <div class="max-w-screen-md mx-auto">
                    <!-- select Album -->
                    <div class="max-w-md mx-auto">
                        <label for="underline_select" class="sr-only">Underline select</label>
                        {{-- <select id="underline_select" name="album"
                            class="block w-full py-2.5 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option selected>Select Your Album</option>
                            @foreach ($data_album as $album)
                                <option value="{{ $album->Nama_Album }}">{{ $album->Nama_Album }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="flex flex-wrap items-center flex-container" id="albumfoto">
                        <!-- Display posts here -->
                    </div>
                </div>
            </div>
        </section>
        <!--DaftarAlbum-->
        {{-- <section class="mt-2">
            <div class="hidden" id="daftar" role="tabpanel" aria-roledescription="daftar-tab">
                <div class="max-w-screen-md mx-auto">
                    <!-- select Album -->
                    <div class="max-w-md mx-auto">
                        <label for="underline_select" class="sr-only">Underline select</label>
                        <select id="underline_select" name="album"
                            class="block w-full py-2.5 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option selected>Select Your Album</option>
                            @foreach ($data_album as $album)
                                <option value="{{ $album->Nama_Album }}">{{ $album->Nama_Album }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-wrap items-center flex-container" id="albumfoto">
                    
                    </div>
                </div>
            </div>
        </section> --}}
        <!--Postingan-->
        <section class="mt-0">
            <div class="hidden" id="postingan" role="tabpanel" aria-roledescription="postingan-tab">
                <div class="max-w-screen-md mx-auto">
                    @csrf
                    <div class="flex flex-wrap items-center flex-container " id="postingandata">
                        <!--end-->
                    </div>
                </div>
            </div>
            <div class="mb-28"></div>
        </section>
        </div>
        </div>
    </section>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
@endsection
@push('footerjsexternal')
    <script src="/javascript/postingan.js"></script>
    <script src="/javascript/album.js"></script>
@endpush
