<!--navbar-->
@extends('layout.main')
<!--/navbar-->
@section('content')
    <section class="mt-32">
        <div class="items-center max-w-screen-md mx-auto">
            <h3 class="text-5xl text-center font-hurricane">Edit Foto Anda</h3>
        </div>
    </section>
    <form action="{{ url('/update/' . $foto->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use the PUT method for updates -->
        <section class="mt-10">
            <div class="max-w-screen-md mx-auto">
                <div class="flex flex-wrap px-2 flex-container">
                    <div class="w-3/5 max-[480px]:w-full">
                        <div class="flex justify-center px-3">
                            <div class="flex items-center justify-center w-full">
                                <label for="foto"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        @if ($foto->lokasi_file)
                                            <!-- Check if the photo has an image -->
                                            <img id="selected-image" src="{{ url('postingan/' . $foto->lokasi_file) }}"
                                                alt="Selected Image">
                                        @else
                                            <!-- Display a default image or a placeholder if no image is available -->
                                            <p>No image available</p>
                                        @endif
                                    </div>
                                    <input id="foto" type="file" class="hidden" name="file"
                                        onchange="displayImage(this)" />
                                </label>
                                <script>
                                    // Existing displayImage function for previewing the selected image
                                    function displayImage(input) {
                                        var file = input.files[0];
                                        if (file) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                document.getElementById('selected-image').src = e.target.result;
                                                document.getElementById('selected-image').classList.remove('hidden');
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 max-[480px]:w-full px-2">
                        <div class="flex flex-col flex-wrap ">
                            <h3 class="mb-2">Judul</h3>
                            <input type="text" name="judul_foto" value="{{ $foto->judul_foto }}"
                                class="mb-2 py-2 rounded-md border-slate-500 bg-gray-100">
                            <h3 label="album" class="mb-2">Album</h3>
                            <div class="flex flex-row justify-between gap-2">
                                <select name="album" id=""
                                    class="bg-gray-100 border border-slate-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">-- Pilih Album --</option>
                                    @foreach ($data_album as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $foto->album_id ? 'selected' : '' }}> {{ $item->Nama_Album }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="mb-2"></div>
                                <!-- Modal toggle -->
                                <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                                    class="w-full py-2 text-white  bg-blue-700 rounded-md" type="button">
                                    +Album
                                </button>
                                <!-- Main modal -->
                            </div class="ms-2">
                            <h3 class="mt-2">Deskripsi</h3>
                            <div class="mb-3"></div>
                            <textarea name="deksripsi_foto" id="" cols="30" rows="10"
                                class="w-full h-36 border-slate-500 rounded-xl bg-gray-100">{{ $foto->deksripsi_foto }}</textarea>
                            <div class=" mb-3"></div>
                            <div class="flex flex-row justify-between">
                                <button type="submit" class="w-full py-2 text-white  bg-blue-700 rounded-md">Update
                                    Photo</button>
                            </div>
                            <!-- Add any other form fields for the photo details -->
                            <br>
                            <div class="mb-28">
                                <div class="p-4 border-blue-600 bg-gray-300 rounded-md">
                                    <p class="text-center text-blue-500">
                                        Note: Upload dengan kesadaran akan pengaruh foto!
                                    </p>
                                </div>
                                <br>
                                <p class="flex flex-col justify-between text-center text-gray-500">
                                    @Flustpicture 2024
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!-- Your existing album form -->
    <form action="/tambah_album" method="post">
        @csrf
        <!-- Your existing album form content -->
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
@endsection
