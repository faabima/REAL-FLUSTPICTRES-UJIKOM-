@extends('Admin.layout.main')
@section('content')
    <!--navbar-->
    <div class="flex overflow-hidden bg-white pt-16">
        <!--sidebar-->
        <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
        <div id="main-content" class="h-full w-full bg-white relative overflow-y-auto lg:ml-64">
            <section class="mt-10">
                <form action="/ubahprofiladmin" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap justify-between flex-container">
                        <div class="flex flex-col items-center w-2/6 bg-white rounded-md shadow-md max-[480px]:w-full">
                            <img src="/admin/{{ old('foto_profil', Auth::User()->foto_profil) }}" alt=""
                                class="rounded-full w-36 h-36">
                            <input type="file" name="file" class="items-center w-48 h-10 mt-4 border rounded-md">
                            <button type="submit" class="w-48 py-2 mt-4 mb-4 text-white rounded-md bg-blue-600">Ubah
                                Photo</button>
                        </div>
                </form>
                <div class="w-3/5 max-[480px]:w-full">
                    <div class="bg-white rounded-md shadow-md">
                        <form action="/updateprofileadmin" method="POST">
                            @csrf
                            <div class="flex flex-col px-4 py-4 ">
                                <h5 class="text-3xl text-center font-hurricane">Profile Admin</h5>
                                <h5>Username</h5>
                                <input type="text" name="username" value="{{ $dataprofile->username }}"
                                    class="py-1 rounded-md">
                                <h5>Nama Lengkap</h5>
                                <input type="text" name="nama_lengkap" value="{{ $dataprofile->nama_lengkap }}"
                                    class="py-1 rounded-md">
                                <h5>Email</h5>
                                <input type="text" name="email" value="{{ $dataprofile->email }}"
                                    class="py-1 rounded-md">
                                <h5>No Telepon</h5>
                                <input type="number" name="no_telephone" value="{{ $dataprofile->no_telephone }}"
                                    class="py-1 rounded-md">
                                    @error('no_telephone')
                                    @if ($message == 'The no telephone has already been taken.')
                                        <p class="text-red-500">Nomor telepon sudah terdaftar. Silakan gunakan nomor telepon lain.</p>
                                    @else
                                        <p class="text-red-500">{{ $message }}</p>
                                    @endif
                                @enderror
                                    <h5>Jenis Kelamin</h5>
                                    <select name="jenis_kelamin" id="" class="py-1 rounded-md">
                                        @foreach (['Laki-laki', 'Perempuan'] as $option)
                                            <option value="{{ $option }}"
                                                {{ $option == $dataprofile->jenis_kelamin ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <h5>Alamat</h5>
                                    <input type="text" name="alamat" value="{{ $dataprofile->alamat }}"
                                        class="py-2 rounded-md">
                                    <h5>Bio</h5>
                                    <input type="text" name="bio" value="{{ $dataprofile->bio }}"
                                        class="py-2 rounded-md">
                                    <button type="submit"
                                        class="py-2 mt-4 text-white rounded-md bg-blue-600">Perbaharui</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="mb-28"></div>
        </section>
        <!--footer-->
    </div>
    </div>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
    </div>
@endsection
