@extends('Admin.layout.main')
@section('content')
    <!--navbar-->
    <div class="flex overflow-hidden bg-white pt-16">
        <!--sidebar-->
        <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
        <div id="main-content" class="h-full w-full bg-white relative overflow-y-auto lg:ml-64">
            <br>
            <section class="max-w-[500px] mx-auto ">
                <div class="max-[480px]:w-full">
                    <div class="bg-white rounded-md shadow-md ">
                        <form action="/change-passwordadmin" method="POST">
                            @csrf
                            <div class="flex flex-col px-4 py-4 ">
                                <h5 class="text-3xl text-center font-hurricane">Change Your Password Admin</h5>
                                <h5>Password lama</h5>
                                @error('password')
                                    <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                                @enderror
                                <input type="password" class="rounded-md" name="current_password" required = "">
                                <h5>Password Baru</h5>
                                <input type="password" class="rounded-md" name="password" required = "">
                                @error('password')
                                    <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                                @enderror
                                <h5>Confirm Password</h5>
                                <input type="password" class="rounded-md" name="password_confirmation" required = "">
                                @error('password')
                                    <small class="text-red-600 mt-2 text-sm">{{ $message }}</small>
                                @enderror
                                <button type="submit"
                                    class="py-2 mt-4 text-white rounded-md bg-blue-600">Perbaharui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
