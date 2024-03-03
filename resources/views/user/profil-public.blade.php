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
            <h3 class="text-5xl text-center font-hurricane">Flustpicture</h3>
        </div>
    </section>
    <section>
        <div class="flex flex-col items-center max-w-screen-md px-2 mx-auto mt-4">         
                <div>
                    <img src="<?php echo $foto_profil ? '/pic/' . $foto_profil : '/pic/users.png'; ?>" alt="" class="w-24 h-24 rounded-full">
                </div>
            <h3 class="text-xl font-semibold">
                {{ $username }}
            </h3>
            <small class="text-xs ">{{ $bio }}</small>
            <div class="flex flex-row mt-3">
                <small class="mr-4 text-abuabu">Pengikut {{ $followers_count }}</small>
                </a>
                <small class="text-abuabu">Dikuti {{ $following_count }} </small>
                </a>
            </div>
            @if ($user_id != auth()->user()->id)
                {{-- <div id="tombolfollow"> --}}
                <div>
                    @if (in_array(auth()->user()->id, $folowers_id))
                        <button class="px-4 mt-4 text-white bg-blue-600 rounded-full" onclick = "ikuti(this, {{ $user_id }})">
                            UNFOLLOW</button>
                    @else
                        <button class="px-4 mt-4 text-white bg-blue-600 rounded-full"
                            onclick = "ikuti(this,{{ $user_id }})">FOLLOW</button>
                    @endif
                </div>
        </div>
        @endif
        </div>
    </section>
    <section class="mt-10">
        <input type="hidden" value="{{ $user_id }}" id="input-user_id">
        <div class="max-w-screen-md mx-auto">
            <div class="flex flex-wrap items-center flex-container" id="publicfoto">
                <!--postinganpublic-->
            </div>
        </div>
        <div class="mb-28"></div>
    </section>
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
@endsection
@push('footerjsexternal')
    <script src="/javascript/profilpublic.js"></script>
@endpush
