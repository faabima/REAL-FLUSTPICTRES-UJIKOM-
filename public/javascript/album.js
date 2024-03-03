var paginate = 1;
var dataExplore1 = [];
loadMoreData1(paginate);
$(window).scroll(function(){
    if($(window).scrollTop() + $(window).height() >= $(document).height()){
        paginate++;
        loadMoreData1(paginate);
    }
})

function loadMoreData1(paginate){
    var urlnya = window.location.href.split("?")[1];
        var parameter = new URLSearchParams(urlnya);
        var cariValue = parameter.get('cari')
        if(cariValue == 'null'){
            url = window.location.origin +'/getDataAlbum'+ '?page='+paginate;
        } else {
            url = window.location.origin + '/getDataAlbum?cari='+ cariValue + '&page=' + paginate;
        }
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function(e){
            console.log(e)
            e.data.data.map((x)=>{
                var tanggal = x.created_at;
                var tanggalObj = new Date(tanggal);
                var tanggalFormatted = ('0' + tanggalObj.getDate()).slice(-2);
                var bulanFormatted = ('0' + (tanggalObj.getMonth() + 1)).slice(-2);
                var tahunFormatted = tanggalObj.getFullYear();
                var tanggalupload = tanggalFormatted + '-' + bulanFormatted + '-' + tahunFormatted;
                var hasilPencarian = x.likefoto.filter(function(hasil){
                    return hasil.users_id === e.idUser
                })
                if(hasilPencarian.length <= 0){
                    userlike = 0;
                } else {
                    userlike = hasilPencarian[0].users_id;
                }
                let datanya = {
                    id: x.id,
                    judul_foto: x.judul_foto,
                    deksripsi_foto: x.deksripsi_foto,
                    foto: x.lokasi_file,
                    created_at: tanggalupload,
                    Nama_Album : x.album.Nama_Album,
                    username: x.users.username,
                    foto_profil: x.users.foto_profil,
                    jml_komen: x.komenfoto_count,
                    jml_like: x.likefoto_count,
                    idUserLike: userlike,
                    useractive: e.idUser,
                    users_id: x.users_id,
                }
                dataExplore1.push(datanya)
                console.log(userlike)
                console.log(e.idUser)
            })
            getExplore1()
        },
        error: function(jqXHR, textStatus, errorThrown){

        }

    })
}
//test
// function loadMoreData1(paginate) {
//     // Get the query parameters from the current URL
//     var urlParams = new URLSearchParams(window.location.search);
//     var cariValue = urlParams.get('cari');

//     // Build the URL for the AJAX request based on the search parameter
//     var url = window.location.origin + '/getDataAlbum';

//     // Append search parameter and page number if applicable
//     if (cariValue !== null) {
//         url += '?cari=' + cariValue;
//     }
//     url += '&page=' + paginate;

//     // Make an AJAX request to the server
//     $.ajax({
//         url: url,
//         type: "GET",
//         dataType: "JSON",
//         success: function (response) {
//             // Process the data received from the server
//             response.data.data.forEach(function (x) {
//                 // Extract and format relevant data (date formatting in this case)
//                 var tanggalObj = new Date(x.created_at);
//                 var tanggalFormatted = tanggalObj.toLocaleDateString('en-GB');

//                 // Additional processing based on your logic
//                 var hasilPencarian = x.likefoto.find(function (hasil) {
//                     return hasil.users_id === response.idUser;
//                 });
//                 var userlike = hasilPencarian ? hasilPencarian.users_id : 0;

//                 // Create an object with the processed data
//                 var datanya = {
//                     id: x.id,
//                     judul_foto: x.judul_foto,
//                     deksripsi_foto: x.deksripsi_foto,
//                     foto: x.lokasi_file,
//                     created_at: tanggalFormatted,
//                     Nama_Album: x.album.Nama_Album,
//                     username: x.users.username,
//                     foto_profil: x.users.foto_profil,
//                     jml_komen: x.komenfoto_count,
//                     jml_like: x.likefoto_count,
//                     idUserLike: userlike,
//                     useractive: response.idUser,
//                     users_id: x.users_id,
//                 };

//                 // Push the processed data to an array (dataExplore1)
//                 dataExplore1.push(datanya);

//                 // Additional logging for debugging
//                 console.log(userlike);
//                 console.log(response.idUser);
//             });

//             // Call a function to handle the processed data (getExplore1)
//             getExplore1();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             // Handle errors during the AJAX request
//             console.error('AJAX Request Error:', textStatus, errorThrown);
//         }
//     });
// }

//pengulangan data
const getExplore1 =()=>{
    $('#albumfoto').html('')
    dataExplore1.map((x, i)=>{
        $('#albumfoto').append(
            `
                    <div class="flex mt-2">
                        <div class="mt-2 flex flex-col px-2 py-4 bg-white shadow-md rounded-md">
                            <div class="mb-2" style="position:relative">
                                <div class="ml-2 flex justify-between space-x-2">
                                    <a href="/album">
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
                                            type="button" onclick="toggleContent1(${i})">
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
                                                    <a href="/editfotopostingan/${x.id}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" data-id="${x.id}" class="block btn-delete-foto px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        Hapus
                                                    </button>
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
                    </div>
                    
            `
        )
    })
}


//toggle
function toggleContent1(index) {
    var dropdown = document.getElementById('dropdownDots' + index);
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}
//likefoto
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

// //delete foto
$(document).on('click', '.btn-delete-foto', function() {
    console.log('Tombol Hapus Diklik');
    var id = $(this).data('id');
    
    // Show loading spinner or change appearance immediately
    $('#elemen-foto-' + id).addClass('deleting');

    if (confirm('Apakah Anda yakin ingin menghapus postingan ini?')) {
        deletefoto(id);
    }

    function deletefoto(id) {
        $.ajax({
            url: '/deletefoto/' + id,
            dataType: "JSON",
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), 
                id: id
            },
            success: function(res) {
                if (res.success) {
                    // Hapus elemen postingan dari tampilan
                    $('#elemen-foto-' + id).remove();
                    // Refresh the page
                    location.reload();
                } else {
                    alert('Gagal menghapus postingan');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Gagal menghapus postingan');
            },
            complete: function() {
                // Remove loading spinner or revert appearance
                $('#elemen-foto-' + id).removeClass('deleting');
            }
        });
    }
});

// Add the editPhoto function
// function editPhoto(photoId) {
//     // Retrieve the photo details using the photoId
//     var photoToEdit = dataExplore1.find((photo) => photo.id === photoId);
//     // Open a modal for editing
//     openEditModal(photoToEdit);
// }
// // Function to open the edit modal
//     function openEditModal(photo) {
//         // Implement your modal logic here, for example, using a library like Bootstrap Modal
//         // For simplicity, let's log the details to the console
//         console.log("Opening modal for editing photo:", photo);
//         // Assuming you have an edit button in your modal, add a click event listener
//         $('#editButton').on('click', function () {
//             // Get the edited values from the modal fields
//             var editedTitle = $('#editModalTitle').text();
//             var editedDescription = $('#editModalDescription').val();
    
//             // Perform validation if needed
    
//             // Create an object with the edited data
//             var editedData = {
//                 id: photo.id,
//                 judul_foto: editedTitle,
//                 deksripsi_foto: editedDescription
//                 // Add other fields as needed
//             };
    
//             // Use Ajax to send the edited data to the server
//             $.ajax({
//                 type: 'PUT',  // Use 'PUT' method for updating data
//                 url: '/api/photos/' + photo.id,  // Replace with your actual API endpoint
//                 data: editedData,
//                 success: function (response) {
//                     console.log("Photo updated successfully:", response);
    
//                     // Close the modal after successful update
//                     $('#editModal').modal('hide');
    
//                     // You can also update the UI with the edited data if needed
//                     // For example, update the photo details on the page
//                     $('#photoTitle_' + photo.id).text(editedTitle);
//                     $('#photoDescription_' + photo.id).text(editedDescription);
//                 },
//                 error: function (error) {
//                     console.error("Error updating photo:", error);
//                     // Handle errors if necessary
//                 }
//             });
//         });
    
//         // Show the modal
//         $('#editModal').modal('show');
//         $('#editModalTitle').text(photo.judul_foto);
//         $('#editModalDescription').val(photo.deksripsi_foto);
//         // ... fill other modal fields ...
        
//     }
// Function to update the photo details
// function updatePhoto(photoId, updatedData) {
//     // Implement the logic to update the photo details
//     // Make an AJAX request to update the data on the server
//     // You can use a PUT or PATCH request to update the data
//     $.ajax({
//         url: '/updatePhoto/' + photoId,
//         type: 'PUT',
//         data: updatedData,
//         success: function(response) {
//             console.log('Photo updated successfully', response);
//             // You may want to refresh the page or update the UI accordingly
//         },
//         error: function(error) {
//             console.error('Error updating photo', error);
//         }
//     });
// }












