    <!--navbar-->
    @extends('layout.main')
    @push('cssjsexternal')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endpush
    <!--/navbar-->
    @section('content')
        <section class=" w-full md:flex md:w-auto mt-32">
            <div class="items-center max-w-screen-md mx-auto ">
                <h3 class="text-purple-700 text-5xl text-center font-pacifico">Flustpicture</h3>
            </div>
        </section>
        <!--pages.conten-->
        <section class="mt-20">
            @csrf
            <div class="max-w-screen-md mx-auto">
                <div class="flex flex-wrap items-center flex-container" id="exploredata" >
                    <!-- Display search results here -->
                    <!--postingan-->
                </div>
                <div class="flex flex-wrap items-center flex-container" id="search-results" >
                    <!-- Display search results here -->
                    <!--postingan-->
                </div>
            </div>
            <div class="mb-28"></div>
        </section>
        <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
        <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
    @endsection
    @push('footerjsexternal')
        <script src="/javascript/explore.js"></script>
    @endpush
