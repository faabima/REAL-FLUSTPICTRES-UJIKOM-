 var paginate = 1;
    var dataExplore = [];
    loadMoreData(paginate);
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() >= $(document).height()){
            paginate++;
            loadMoreData(paginate);
        }
    });

    //pengulangan data
    function loadMoreData(paginate) {
        var urlnya = window.location.href.split("?")[1];
        var parameter = new URLSearchParams(urlnya);
        var cariValue = parameter.get('cari')
        if(cariValue == 'null'){
            url = window.location.origin + '/getDataExplore' + '?page=' + paginate;
        } else {
            url = window.location.origin + '/getDataExplore?cari='+ cariValue + '&page=' + paginate;
        }
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function (e) {
                console.log(e);

                // Sort the data in descending order based on the created_at property
                e.data.data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                
                e.data.data.forEach((x) => {
                    // Format Tanggal
                    var tanggal = x.created_at;
                    var tanggalObj = new Date(tanggal);
                    var tanggalFormatted = ('0' + tanggalObj.getDate()).slice(-2);
                    var bulanFormatted = ('0' + (tanggalObj.getMonth() + 1)).slice(-2);
                    var tahunFormatted = tanggalObj.getFullYear();
                    var tanggalupload = tanggalFormatted + '-' + bulanFormatted + '-' + tahunFormatted;
                    var hasilPencarian = x.likefoto.filter((hasil) => hasil.users_id === e.idUser);
                    var userlike = (hasilPencarian.length <= 0) ? 0 : hasilPencarian[0].users_id;

                    let datanya = {
                        id: x.id,
                        judul_foto: x.judul_foto,
                        deksripsi_foto: x.deksripsi_foto,
                        foto: x.lokasi_file,
                        created_at: tanggalupload,
                        Nama_Album: x.album ? x.album.Nama_Album : ('-'),
                        username: x.users.username,
                        foto_profil: x.users.foto_profil,
                        jml_komen: x.komenfoto_count,
                        jml_like: x.likefoto_count,
                        idUserLike: userlike,
                        useractive: e.idUser,
                        users_id: x.users_id,
                    };
                    dataExplore.push(datanya);
                    console.log(userlike);
                    console.log(e.idUser);
                });
                getExplore();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle error
            }
        });
    }

    const getExplore =()=>{
        $('#exploredata').html('')
        dataExplore.map((x, i)=>{
            $('#exploredata').append(
                `
                            <div class="flex mt-2">
                                <div class="mt-2 flex flex-col px-2 py-4 bg-white shadow-md rounded-md">
                                    <div class="mb-2" style="position:relative">
                                        <div class="ml-2 flex justify-between space-x-2">
                                            <a href="/profil_public/${x.users_id}">
                                                <div class="flex flex-wrap items-center space-x-2">
                                                <img src="${x.foto_profil ? `/pic/${x.foto_profil}` : '/pic/users.png'}" alt="User Avatar" class="w-8 h-8 rounded-full">
                                                    <div>                                            
                                                        <p class="text-gray-800 font-semibold">${x.username}</p>
                                                        <p class="text-gray-500 text-sm">${x.created_at}</p>
                                                    </div>
                                                </div>
                                            </a>              
                                            <!-- Dropdown menu -->
                                            <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                                class="hover:bg-gray-50 rounded-full p-1 font-medium"
                                                type="button" onclick="toggleContent(${i})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="7" r="1" />
                                                    <circle cx="12" cy="17" r="1" />
                                                    <circle cx="12" cy="12" r="1" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="dropdownDots${i}" class="z-10 hidden  bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600" style="position:absolute; right:0">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                                    <li>
                                                        <button class="bg-red-500 text-black px-4 py-2 rounded-md mt-2"
                                                        onclick="showReportModal(${x.id})">Laporkan</button>
                                                    </li>
                                                </ul>
                                        </div>
                                    </div>
                                    <a href="/explore-detail/${x.id}">
                                        <div class="w-[363px] h-[192px] overflow-hidden rounded-md">
                                            <img src="/postingan/${x.foto}" alt=""
                                                class="w-full transition duration-500 ease-in-out hover:scale-105">
                                        </div>
                                    </a>
                                    <div class="flex flex-wrap items-center justify-between px-2 mt-2">
                                        <div>
                                            <div class="flex flex-col">
                                                <div class="font-bold">
                                                    ${x.judul_foto}
                                                </div>
                                                <div>
                                                    ${x.deksripsi_foto}
                                                </div>
                                                <div class="text-blue-500 text-sm">
                                                    ${x.Nama_Album}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                        <a href="/explore-detail/${x.id}">
                                            <span class="bi bi-chat-left-text"></span>
                                        </a>
                                            <small>${x.jml_komen}</small>
                                            <span class="bi ${x.idUserLike === x.useractive ? 'bi-heart-fill red-heart' : 'bi-heart' }"
                                                onclick="likes(this, ${x.id})"></span>
                                            <small id="exploredata-${x.id}-like-count">${x.jml_like}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                `
            )
        });
    }
    //toggle
    function toggleContent(index) {
        var dropdown = document.getElementById('dropdownDots' + index);
        var userCanReport = dataExplore[index].useractive !== dataExplore[index].users_id;

        if (userCanReport) {
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        } else {
            // Jika pengguna tidak dapat melaporkan foto sendiri, Anda dapat memberikan pesan atau mengabaikan aksi ini
            console.log('Tidak dapat melaporkan foto sendiri');
        }
    }

    //likefoto
    // function likes(txt, id){
    //     $.ajax({
    //         url: window.location.origin +'/likefoto',
    //         dataType: "JSON",
    //         type: "POST",
    //         data: {
    //             _token: $('input[name="_token"]').val(),
    //             idfoto: id
    //         },
    //         success:function(res){
    //             console.log(res)
    //             location.reload()
    //         },
    //         error:function(jqXHR, textStatus, errorThrown){
    //             alert('gagal')
                
    //         }
    //     })
    // }
    function likes(spanElement, id) {
        console.log('Clicked on photo ID:', id);
    
        // Determine whether it's a like or unlike action
        var isLiked = $(spanElement).hasClass('bi-heart-fill');
    
        // Make an AJAX request to the server
        $.ajax({
            url: window.location.origin + '/likefoto',
            dataType: "JSON",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                idfoto: id,
                isLiked: isLiked
            },
            success: function(res) {
                console.log('Server Response:', res);
                console.log('isLiked:', isLiked);
    
                // Toggle the heart icon class based on the response
                $(spanElement).toggleClass('bi-heart bi-heart-fill');
    
                // Update the like count on the page without reloading
                $('#exploredata-' + id + '-like-count').text(res.likes);
            },                        
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                
                // Log the response text to help identify the issue
                console.log('Server Response Text:', jqXHR.responseText);
    
                // Show an alert if there's an error
                alert('gagal');
            }
        });
    }
    
    $(document).ready(function() {
        // Define $x with some sample values
        var id = $x.id;
    
        // Assuming 'x.id' represents the post ID
        var spanElement = document.querySelector('.bi'); // replace with a more specific selector if needed
        var id = $x.id; // Assuming x.id represents the post ID
      
        setInterval(function() {
          likes(spanElement, id);
        }, 500);
    });    

//alasan laporkan
    function showReportModal(id) {
        // Show a modal to enter the reason for reporting
        var reason = prompt("Masukan alasan laporan:");

        if (reason !== null && reason !== "") {
            // Call the function to report with the provided reason
            laporkan(id, reason);
        } else {
            // Handle the case where the user canceled or entered an empty reason
            console.log('Laporan dibatalkan atau alasan kosong');
        }
    }
    
    //laporkan
    function laporkan(id, reason) {
        $.ajax({
            url: '/laporkan',
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                id: id,
                reason: reason
            },
            success: function (data) {
                // Handle the success response if needed
                console.log('Post reported successfully');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle the error response if needed
                console.error('Failed to report post');
            }
        });
    }