<!--navbar-->
@extends('layout.main')
<!--/navbar-->
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <section class="mt-32">
        <div class="items-center max-w-screen-md mx-auto ">
            <h3 class="text-5xl text-center font-hurricane">Flustpictures</h3>
        </div>
    </section>
    <section class="max-w-[500px] mx-auto ">
        <div class="max-[480px]:w-full">
            <div class="bg-white rounded-md shadow-md ">
                <form action="/change-password" method="POST">
                    @csrf
                    <div class="flex flex-col px-4 py-4">
                        <h5 class="text-3xl text-center font-hurricane">Ubah Kata Sandi Anda</h5>

                        <!-- Password lama -->
                        <h5>Password lama</h5>
                        @error('current_password')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror
                        <input type="password" class="rounded-md" name="current_password" required>
                        @error('password')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror

                        <!-- Password baru -->
                        <h5>Password Baru</h5>
                        <input type="password" class="rounded-md" name="password" required>
                        @error('password')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror

                        <!-- Konfirmasi Password baru -->
                        <h5>Konfirmasi Password Baru</h5>
                        <input type="password" class="rounded-md" name="password_confirmation" required>
                        @error('password_confirmation')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror
                        @error('password')
                            <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                        @enderror
                        
                        <!-- Notifikasi sukses -->
                        @if (session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        <button type="submit" class="py-2 mt-4 text-white rounded-md bg-blue-600">Perbaharui</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
@endsection
