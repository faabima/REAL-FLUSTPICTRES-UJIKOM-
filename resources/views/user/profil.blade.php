<!--navbar-->
@extends('layout.main')
<!--/navbar-->
@section('content')
    <section class="mt-32">
        <div class="items-center max-w-screen-md mx-auto ">
            <h3 class="text-5xl text-center font-hurricane">Flustpicture</h3>
        </div>
    </section>
    <section class="mt-10">
        <form action="/ubahprofil" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap justify-between flex-container">
                <div class="flex flex-col items-center w-2/6 bg-white rounded-md shadow-md max-[480px]:w-full">
                    @php
                        $foto_profil = Auth::user()->foto_profil;
                        $avatar_default = 'users.png'; // Ganti dengan nama file avatar default Anda
                    @endphp

                    <img id="preview" src="{{ $foto_profil ? asset("pic/$foto_profil") : asset("pic/$avatar_default") }}"
                        alt="User Avatar" class="rounded-full w-36 h-36">

                    <input type="file" name="file" id="fileInput"
                        class="items-center w-48 h-10 mt-4 border rounded-md" onchange="previewImage(this)">

                    <script>
                        function previewImage(input) {
                            var preview = document.getElementById('preview');
                            var fileInput = document.getElementById('fileInput');

                            var files = fileInput.files;

                            if (files.length > 0) {
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                };

                                reader.readAsDataURL(files[0]);
                            } else {
                                // Jika tidak ada file yang dipilih, tampilkan foto profil atau avatar default
                                preview.src = "{{ $foto_profil ? asset("pic/$foto_profil") : asset("pic/$avatar_default") }}";
                            }
                        }
                    </script>
                    <!-- Tampilkan pesan jika file belum dipilih -->
                    @if (session('fileError'))
                        <div class=" text-red-500 ">
                            {{ session('fileError') }}
                        </div>
                    @endif
                    <!-- Tampilkan pesan berhasil di ubah -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <button type="submit" class="w-48 py-2 mt-4 mb-4 text-white rounded-md bg-blue-600">Ubah Photo</button>

        </form>
        <!-- hapus foto -->
        <form action="/hapusfotoprofil" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-48 py-2 mt-4 mb-4 text-white rounded-md bg-blue-600">Hapus Foto
                Profil</button>
        </form>
        </div>
        <div class="w-3/5 max-[480px]:w-full">
            <div class="bg-white rounded-md shadow-md">
                <!-- Data User -->
                <form action="/updateprofile" method="POST">
                    @csrf
                    <div class="flex flex-col px-4 py-4 ">
                        <h5 class="text-3xl text-center font-hurricane">Profile</h5>
                        <h5>Username</h5>
                        <input type="text" name="username" value="{{ $dataprofile->username }}" class="py-1 rounded-md">
                        @error('username')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <h5>Nama Lengkap</h5>
                        <input type="text" name="nama_lengkap" value="{{ $dataprofile->nama_lengkap }}"
                            class="py-1 rounded-md">
                        @error('nama_lengkap')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <h5>Email</h5>
                        <input type="text" name="email" value="{{ $dataprofile->email }}" class="py-1 rounded-md">
                        @error('email')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <h5>No Telepon</h5>
                        <input type="number" name="no_telephone" value="{{ $dataprofile->no_telephone }}"
                            class="py-1 rounded-md">
                        @error('no_telephone')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <h5>Jenis Kelamin</h5>
                        <select name="jenis_kelamin" id="" class="py-1 rounded-md">
                            @foreach (['Laki-laki', 'Perempuan'] as $option)
                                <option value="{{ $option }}"
                                    {{ $option == $dataprofile->jenis_kelamin ? 'selected' : '' }}>{{ $option }}
                                </option>
                            @endforeach
                        </select>
                        <h5>Alamat</h5>
                        <input type="text" name="alamat" value="{{ $dataprofile->alamat }}" class="py-2 rounded-md">
                        <h5>Bio</h5>
                        <input type="text" name="bio" value="{{ $dataprofile->bio }}" class="py-2 rounded-md">
                        <button type="submit" class="py-2 mt-4 text-white rounded-md bg-blue-600">Perbaharui</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="mb-28"></div>
    </section>
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
@endsection
