<?php

namespace App\Http\Controllers;

use App\Models\foto;
use App\Models\User;
use App\Models\album;
use App\Models\laporan;
use App\Models\folowers;
use App\Models\likefoto;
use App\Models\datapesan;
use App\Models\komenfoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //proses register
    public function register(Request $request)
    {
        $messages = [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
        ];
        
        // Validasi
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'email' => 'required|unique:users,email',
        ], $messages);
        
        // Simpan
        $dataStore = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ];
        
        User::create($dataStore);
        return redirect('/login')->with('success', 'Data berhasil disimpan');        

    }
    //viewlogin
    public function viewlogin(Request $request)
    {
        // ... your existing code

        // Example: check if the user is banned
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and is banned
        $isBanned = $user && $user->status_user === 'NonAktif';

        // Pass the $isBanned variable to the view
        return view('login', compact('isBanned'));
    }
    //log in
    // public function ceklogin(Request $request)
    // {
    //     // Validate
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     // Find the user by email
    //     $user = User::where('email', $request->email)->first();

    //     // Check if the user exists
    //     if ($user) {
    //         // Check if the user is banned
    //         if ($user->status_user === 'NonAktif') {
    //             throw ValidationException::withMessages([
    //                 'email' => 'Akun Anda telah di-banned.',
    //             ]);
    //         }

    //         // Attempt to log in
    //         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //             $request->session()->regenerate();
    //             return redirect('/explore');
    //         }
    //     }

    //     // If user does not exist or login attempt fails
    //     throw ValidationException::withMessages([
    //         'email' => 'Email atau Password Anda Salah.',
    //     ]);
    // }
    public function ceklogin(Request $request)
    {
        // Validate
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists
        if ($user) {
            // Check if the user is banned
            if ($user->isBanned()) {
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda telah di-banned.',
                ]);
            }

            // Attempt to log in
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect('/explore');
            }
        }

        // If user does not exist or login attempt fails
        throw ValidationException::withMessages([
            'email' => 'Email atau Password Anda Salah.',
        ]);
    }
    //logout
    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
    //upload foto
    // public function upload_foto(Request $request)
    // {
    //     $namafile   = pathinfo($request->file, PATHINFO_FILENAME);
    //     $extensi    = $request->file->getClientOriginalExtension();
    //     $namafoto   = 'postingan' . time() . '.' . $extensi;
    //     $request->file->move('postingan', $namafoto);
    //     //simpan
    //     $datasimpan = [
    //         'users_id' => auth()->User()->id,
    //         'judul_foto' => $request->judul_foto,
    //         'deksripsi_foto' => $request->deksripsi_foto,
    //         'lokasi_file'   => $namafoto,
    //         'album_id' => $request->album,
           
    //     ];
    //     foto::create($datasimpan);
    //     return redirect('/explore');
    // }
        public function upload_foto(Request $request)
    {
        // Aturan validasi
        $rules = [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120|dimensions:max_width=800,max_height=400', // ukuran file maksimum dalam kilobyte (5 MB) dan dimensi
            'judul_foto' => 'required|string',
            'deksripsi_foto' => 'required|string',
            'album' => 'nullable|exists:album,id',
        ];

        // Pesan validasi
        $messages = [
            'file.required' => 'Harap pilih gambar.',
            'file.max' => 'Ukuran gambar harus kurang dari 5MB.',
            'file.dimensions' => 'Dimensi gambar tidak boleh lebih dari 800x400px.',
            'judul_foto.required' => 'Harap berikan judul untuk foto.',
            'deksripsi_foto.required' => 'Harap berikan deskripsi untuk foto.',
            'album.exists' => 'Album yang dipilih tidak ada.',
            'file.image' => 'Berkas yang diunggah harus berupa gambar.',
            'file.mimes' => 'Format gambar yang didukung adalah jpeg, png, jpg, dan gif.',
        ];

        // Melakukan validasi
        $validator = Validator::make($request->all(), $rules, $messages);

        // Memeriksa jika validasi gagal
        if ($validator->fails()) {
            return redirect('/upload')
                ->withErrors($validator)
                ->withInput();
        }

        // Melanjutkan dengan pengunggahan file dan penyimpanan data
        $file = $request->file('file');
        $namafile = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extensi = $file->getClientOriginalExtension();
        $namafoto = 'postingan' . time() . '.' . $extensi;

        // Memeriksa ukuran file sebelum melakukan unggah
        if ($file->getSize() > 5120 * 1024) { // mengonversi kilobyte ke byte
            return redirect('/upload')
                ->withErrors(['file' => 'Ukuran gambar melebihi batas maksimum (5MB).'])
                ->withInput();
        }

        // Memindahkan file ke lokasi yang diinginkan
        $file->move('postingan', $namafoto);

        // Menyimpan data ke database
        $datasimpan = [
            'users_id' => auth()->user()->id,
            'judul_foto' => $request->judul_foto,
            'deksripsi_foto' => $request->deksripsi_foto,
            'lokasi_file' => $namafoto,
            'album_id' => $request->album,
        ];

        foto::create($datasimpan);

        // Mengarahkan ke halaman explore setelah unggah berhasil
        return redirect('/explore');
    }

    




    //getDataExplore
    public function getdata(Request $request) {
        if($request->cari !== 'null'){
            $explore = foto::with(['likefoto', 'album', 'users'])
            ->withCount(['likefoto', 'komenfoto'])
            ->where(function ($query) use ($request) {
                $query->where('judul_foto', 'like', '%' . $request->cari . '%')
                    ->orWhereHas('album', function ($subquery) use ($request) {
                        $subquery->where('Nama_Album', 'like', '%' . $request->cari . '%');
                    })
                    ->orWhereHas('users', function ($subquery) use ($request) {
                        $subquery->where('username', 'like', '%' . $request->cari . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(4);        
        } else {
            $explore = foto::with(['likefoto', 'album', 'users'])->withCount(['likefoto', 'komenfoto'])->orderBy('created_at', 'desc')->paginate(4);
        }
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser' => auth()->user()->id
        ]);
    }
    
    //likefoto
    // public function likesfoto(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'idfoto' => 'required'
    //         ]);
    //         $existingLike = likefoto::where('foto_id', $request->idfoto)->where('users_id', auth()->user()->id)->first();
    //         if(!$existingLike){
    //             $dataSimpan = [
    //                 'foto_id'   => $request->idfoto,
    //                 'users_id'   => auth()->user()->id
    //             ];
    //             likefoto::create($dataSimpan);
    //         } else {
    //             likefoto::where('foto_id', $request->idfoto)->where('users_id', auth()->user()->id)->delete();
    //         }

    //         return response()->json('Data berhasil di simpan ', 200);
    //     } catch (\Throwable $th) {
    //         return response()->json('Something want wrong', 500,);
    //     }
    // }
    public function likesfoto(Request $request)
    {
        try {
            $request->validate([
                'idfoto' => 'required'
            ]);

            // Check if the user has already liked the photo
            $existingLike = likefoto::where('foto_id', $request->idfoto)
                                    ->where('users_id', auth()->user()->id)
                                    ->first();

            // If the user hasn't liked the photo, create a new like entry
            if (!$existingLike) {
                $dataSimpan = [
                    'foto_id' => $request->idfoto,
                    'users_id' => auth()->user()->id
                ];
                likefoto::create($dataSimpan);
            } else {
                // If the user has already liked the photo, delete the existing like entry (unlike)
                likefoto::where('foto_id', $request->idfoto)
                        ->where('users_id', auth()->user()->id)
                        ->delete();
            }

            // Retrieve the updated like count
            $likeCount = likefoto::where('foto_id', $request->idfoto)->count();

            // Return the updated like count
            return response()->json(['likes' => $likeCount], 200);
        } catch (\Throwable $th) {
            // Handle any exceptions that may occur during the process
            return response()->json('Something went wrong', 500);
        }
    }

    //explore
    public function explore()
    {
        return view('user.explore');
    }
    //tambah album
    public function tambahalbum(Request $request)
    {
        //simpan
        $tambahalbum = [
            'users_id' => auth()->User()->id,
            'Nama_Album' => $request->Nama_Album,
            'deskripsi' => $request->deskripsi,
        ];
        album::create($tambahalbum);
        return redirect('/upload');
    }
    //getDataPostingansemua
    // public function getdatapostingan(Request $request){
    //     $postinganuserid = auth()->user()->id;
    //     $explore = foto::with(['likefoto','album','users'])->withCount(['likefoto','komenfoto'])->orderBy('created_at','desc')->whereHas('users', function($query) use($postinganuserid){ $query->where('users_id', $postinganuserid);})->paginate(4);
    //     return response()->json([
    //         'data' => $explore,
    //         'statuscode' => 200,
    //         'idUser'    => auth()->user()->id
    //     ]);
    // }
    public function getdatapostingan(Request $request){
        $postinganuserid = auth()->user()->id;
    
        $explore = foto::with(['likefoto', 'album', 'users'])
            ->withCount(['likefoto', 'komenfoto'])
            ->orderBy('created_at', 'desc')
            ->whereHas('users', function($query) use ($postinganuserid) {
                $query->where('users_id', $postinganuserid)
                      ->where('role', 'user'); // Filter hanya pengguna dengan peran 'user'
            })
            ->whereHas('users', function($query) {
                $query->whereNotIn('role', ['admin']); // Hindari menampilkan pengguna dengan peran 'admin'
            })
            ->paginate(4);
    
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser' => auth()->user()->id
        ]);
    }
        
    //getDataAlbum
    // public function getdataalbum(Request $request) {
    //     $postinganuserid = auth()->user()->id;
    //     $albumFilter = $request->input('album');
        
    //     $query = foto::with(['likefoto', 'album', 'users'])
    //         ->withCount(['likefoto', 'komenfoto'])
    //         ->orderBy('created_at', 'desc') // Corrected orderBy clause
    //         ->whereHas('users', function ($query) use ($postinganuserid) {
    //             $query->where('users_id', $postinganuserid);
    //         });

    //     if ($request->cari && $request->cari !== 'null') {
    //         // Add filter for searching by album name
    //         $query->whereHas('album', function ($subquery) use ($request) {
    //             $subquery->where('Nama_Album', 'like', '%' . $request->cari . '%');
    //         });
    
    //         // Add filter for searching by photo title (Judul_Foto)
    //         $query->orWhere('judul_foto', 'like', '%' . $request->cari . '%');
    //     } else {
    //         $query->where('album_id', '!=', null);
    //     }
    
    //     $result = $query->paginate();
    
    //     return response()->json([
    //         'data' => $result,
    //         'statuscode' => 200,
    //         'idUser' => $postinganuserid
    //     ]);
    // }
    public function getdataalbum(Request $request) {
        $postinganuserid = auth()->user()->id;
        $albumFilter = $request->input('album');
        
        $query = foto::with(['likefoto', 'album', 'users'])
            ->withCount(['likefoto', 'komenfoto'])
            ->orderBy('created_at', 'desc') // Corrected orderBy clause
            ->where('users_id', $postinganuserid);
    
        if ($request->cari && $request->cari !== 'null') {
            // Add filter for searching by album name
            $query->whereHas('album', function ($subquery) use ($request) {
                $subquery->where('Nama_Album', 'like', '%' . $request->cari . '%');
            });
    
            // Add filter for searching by photo title (Judul_Foto)
            $query->orWhere(function ($subquery) use ($request, $postinganuserid) {
                $subquery->where('judul_foto', 'like', '%' . $request->cari . '%')
                         ->where('users_id', $postinganuserid);
            });
        } else {
            $query->where('album_id', '!=', null);
        }
    
        $result = $query->paginate();
    
        return response()->json([
            'data' => $result,
            'statuscode' => 200,
            'idUser' => $postinganuserid
        ]);
    }
     

// public function getdataalbum(Request $request) {
//     $postinganuserid = auth()->user()->id;
//     $albumFilter = $request->input('album');
//     if ($request->cari !== 'null') {
//         $query = foto::with(['likefoto', 'album', 'users'])
//                 ->withCount(['likefoto', 'komenfoto'])
//                 ->whereHas('users', function ($query) use ($postinganuserid) {
//                     $query->where('users_id', $postinganuserid);
//                 })
//                 ->whereHas('album', function ($subquery) use ($request) {
//                     $subquery->where('Nama_Album', 'like', '%' . $request->cari . '%');
//                 })
//                 ->paginate();
                
                
                
//     } else {
//             $query = foto::with(['likefoto', 'album', 'users'])
//             ->withCount(['likefoto', 'komenfoto'])
//             ->whereHas('users', function ($query) use ($postinganuserid) {
//                 $query->where('users_id', $postinganuserid);
//             })
//             ->where('album_id', '!=', null)
//             ->paginate();
//     }

//     return response()->json([
//         'data' => $query,
//         'statuscode' => 200,
//         'idUser' => $postinganuserid
//     ]);
// }

    // album
    public function album()
    {
        $user = auth()->user();

        // Retrieve albums associated with the user
        $data_album = $user->album;

        // Pengikut
        $userFollowers = DB::table('folowers')->where('id_following', $user->id)->count();

        // diikuti
        $dataFollowCount = DB::table('folowers')->where('users_id', $user->id)->count();

        return view('user.album', compact('data_album', 'userFollowers', 'dataFollowCount'));
    }
    //profil
    public function profil()
    {
        $data = [
            'dataprofile'   => User::where('id', auth()->user()->id)->first()
        ];
        return view('user.profil', $data);
    }
    //updatedataprofile
    public function updatedataprofile(Request $request)
    {
        // Pesan validasi kustom dalam bahasa Indonesia
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'email' => 'Format :attribute tidak valid.',
            'unique' => ':attribute sudah terdaftar.',
        ];

        // Validasi aturan
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'no_telephone' => 'required|unique:users,no_telephone,' . auth()->user()->id,
            'alamat' => 'required',
            'bio' => 'required',
        ], $messages);
        // Data untuk pembaruan
        $dataupdate = [
            'username' => $request->username,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telephone' => $request->no_telephone,
            'alamat' => $request->alamat,
            'bio' => $request->bio,
        ];

        // Proses pembaruan
        User::where('id', auth()->user()->id)->update($dataupdate);

        return redirect('/profile');
    }
    //fotoprofil
    public function fotoprofil(Request $request)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Sesuaikan dengan kebutuhan Anda
        ]);

            // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect('/profile')
                ->withErrors($validator)
                ->withInput()
                ->with('fileError', 'Silakan pilih file foto terlebih dahulu.');
        }

        // Simpan foto
        $namafile   = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $extensi    = $request->file('file')->getClientOriginalExtension();
        $namafoto   = 'profile' . time() . '.' . $extensi;
        $request->file('file')->move('pic', $namafoto);

        // Data untuk update
        $dataupdate = [
            'foto_profil' => $namafoto,
        ];

        // Proses update
        auth()->user()->update($dataupdate);

        // Set notifikasi berhasil
        return redirect('/profile')->with('success', 'Foto profil berhasil diubah.');
    }

    //upload
    public function upload()
    {
        $data_album = album::with('users')->where('users_id', auth()->user()->id)->get();
        return view('user.upload',compact('data_album'));

    }
    //about
    public function about()
    {
        return view('user.about');

    }
    //explore detail
    public function explore_detail($id)
    {
        return view('user.explore-detail',[
            'foto' => foto::whereId($id)->first(),
        ]);
    }
    //Exploredatadetail
    public function getdatadetail(Request $request, $id){
        $dataDetailFoto     = foto::with(['users','album'])->where('id', $id)->firstOrFail();
        $dataJumlahPengikut = DB::table('folowers')->selectRaw('count(id_following) as jmlfolow')->where('id_following', $dataDetailFoto->users->id)->first();
        $dataFollow         = folowers::where('id_following', $dataDetailFoto->users->id)->where('users_id', auth()->user()->id)->first();
        return response()->json([
            'dataDetailFoto'    => $dataDetailFoto,
            'dataJumlahFollow'  => $dataJumlahPengikut,
            'dataUser'          => auth()->user()->id,
            'dataFollow'        => $dataFollow,
        ], 200);
    }
    //datakomentar
    public function ambildatakomentar(Request $request, $id){
        $ambilkomentar = komenfoto::with('users')->where('foto_id', $id)->get();
        return response()->json([
            'data'  => $ambilkomentar,
        ], 200);
    }
    //kirimkomentar
    public function kirimkomentar(Request $request){
        try {
            $request->validate([
                'idfoto'   => 'required',
                'isi_komentar'  => 'required',
            ]);
            $dataStoreKomentar = [
                'users_id'  => auth()->user()->id,
                'foto_id'   => $request->idfoto,
                'isi_komentar'  => $request->isi_komentar,
            ];
            komenfoto::create($dataStoreKomentar);
            return response()->json([
                'data'      => 'Data berhasil di simpan',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json('Data komentar  gagal di simpann', 500);
        }
    }
    //explore edit password
    public function edit_password_username()
    {
        return view('user.changepassword');
    }
    // ChangePasswordController.php
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // tambahkan validated confirmed
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);
            
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                ->withInput();
        }
    
        $user->update([
            'password' => bcrypt($request->password),
        ]);
    
        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
        
    //explore profil public
    public function profil_public($id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user') // Filter hanya pengguna dengan peran 'user'
            ->first();

        if (!$user) {
            return abort(404); // Tampilkan halaman 404 jika pengguna tidak ditemukan atau peran tidak sesuai
        }

        $userFollowers = DB::table('folowers')
            ->where('id_following', $id)
            ->count();

        $dataFollowCount = DB::table('folowers')->where('users_id', $user->id)->count();

        return view('user.profil-public', [
            'username' => $user->username,
            'foto_profil' => $user->foto_profil,
            'bio' => $user->bio,
            'user_id' => $id,
            'folowers_id' => folowers::where('id_following', $id)->pluck('users_id')->toArray(),
            'followers_count' => $userFollowers,
            'following_count' => $dataFollowCount,
        ]);
    }

    //getDataPublic
    public function getdatapublic(Request $request,$id){
        $publicuserid = auth()->user()->id;
        $explore = foto::with(['likefoto','album','users',])->withCount(['likefoto','komenfoto',])->where('users_id', $id)->paginate(4);
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser'    => auth()->user()->id
        ]);
    }
    //follow
    public function ikuti(Request $request){
        try {
            $request->validate([
                'idfollow' => 'required',
            ]);
            $existingFollow = folowers::where('users_id', auth()->user()->id)->where('id_following', $request->idfollow)->first();
            if(!$existingFollow){
                $dataSimpan = [
                    'users_id'      => auth()->user()->id,
                    'id_following'  => $request->idfollow,
                ];
                folowers::create($dataSimpan);
            } else {
                folowers::where('users_id', auth()->user()->id)->where('id_following', $request->idfollow)->delete();
            }
            return response()->json('Data berhasil di eksekusi', 200);
        } catch (\Throwable $th) {
            return response()->json('Something went wrong', 500);
        }
    }
    //delete
    public function deletefoto(Request $request, $id)
    {
        try {
            // Find the foto record
            $foto = foto::findOrFail($id);

            // Delete associated komen and like records
            $foto->komenfoto()->delete();
            $foto->likefoto()->delete();

            // Delete the file associated with the foto
            $filePath = ('postingan/' . $foto->file_name); // Adjust the file path based on your actual structure

            // Check if the file exists
            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            // Delete the foto record
            $foto->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus foto dan data terkait.'], 500);
        }
    }

    //cari
    // public function cari(Request $request)
    // {
    //     if ($request->has('cari')) {
    //         $cari = $request->cari;

    //         // Search based on the title of the photo, album, and username
    //         $foto = Foto::where('judul_foto', 'LIKE', "%$cari%")
    //             ->orWhereHas('album', function ($query) use ($cari) {
    //             $query->where('Nama_Album', 'LIKE', "%$cari%");
    //             })
    //             ->orWhereHas('users', function ($query) use ($cari) {
    //                 $query->where('username', 'LIKE', "%$cari%");
    //             })
    //             ->get();
    //     } else {
    //         $foto = Foto::all();
    //     }

    //     return response()->json($foto);
    // }

    //laporkan 
    public function laporan(Request $request)
    {
            $idFoto = $request->input('id');
            $reason = $request->input('reason');
            $userId = Auth::id(); // Assuming you have authentication

            // Store the report in the database
        $report = new laporan;
            $report->foto_id = $idFoto;
            $report->users_id = $userId;
            $report->alasan = $reason;
            
            
        $report->save();

    return response()->json(['message' => 'Report submitted successfully']);
    }
    //hapusprofil
    public function hapusprofil()
    {
        // Ambil user yang sedang terautentikasi
        $user = Auth::user();

        // Hapus foto profil dari penyimpanan (jika ada)
        if ($user->foto_profil) {
            Storage::delete("/pic/{$user->foto_profil}");
        }

        // Set foto profil user menjadi null di database
        $user->update(['foto_profil' => null]);

        // Redirect atau lakukan tindakan lain yang sesuai
        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }
    //emailreset
    public function emailreset(){
        
        return view('Auth.forgetpassword');
    }
    // //editpostingannew
    // public function editpostinganew($id) {
    //     $foto = foto::with(['album', 'likefoto', 'komenfoto'])->find($id);

    //     if(!$foto || $foto->album->users_id !== auth()->user()->id){
    //         return redirect()->route('your.error.route');
    //     }

    //     $data_album = album::with('users')->where('users_id', auth()->user()->id)->get();

    //     return view('user.editfoto', compact('foto', 'data_album'));
    // }

    // editpostinganew
    public function editpostinganew($id) {
        $foto = foto::with(['album', 'likefoto', 'komenfoto'])->find($id);

        if(!$foto || ($foto->album && $foto->album->users_id !== auth()->user()->id)) {
            return redirect()->route('your.error.route');
        }

        $data_album = album::with('users')->where('users_id', auth()->user()->id)->get();

        return view('user.editfoto', compact('foto', 'data_album'));
    }

    //updatepostingan
    // public function updatepostingan(Request $request, $id)
    // {
    //     // Validate the form data
    //     $request->validate([
    //         'judul_foto' => 'required|string|max:255',
    //         'album' => 'required|exists:album,id',
    //         'deksripsi_foto' => 'nullable|string',
    //         'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the file upload
    //     ]);

    //     // Find the photo by ID
    //     $photo = foto ::findOrFail($id);
    //     // Update the photo details
    //     $photo->judul_foto = $request->judul_foto;
    //     $photo->album_id = $request->album;
    //     $photo->deksripsi_foto = $request->deksripsi_foto;

    //     // Handle file upload if a new file is provided
    //     $namafile = pathinfo($request->file, PATHINFO_FILENAME);
    //     $extensi = $request->file->getClientOriginalExtension();
    //     $namafoto = 'postingan' . time() . '.' . $extensi;

    //     // Ensure that the 'postingan' directory exists within the 'public' folder
    //     $directoryPath = ('postingan');
    //     // Move the file to the 'postingan' directory
    //     $request->file->move($directoryPath, $namafoto);
    //     // Update the database with the new file path
    //     $photo->lokasi_file = $namafoto;

    //     // Save the changes
    //     $photo->save();

    //     // Redirect back or to a success page
    //     return redirect('/album')->with('success', 'Photo updated successfully');
    // }
    // public function updatepostingan(Request $request, $id)
    // {
    //     // Validate the form data
    //     $request->validate([
    //         'judul_foto' => 'required|string|max:255',
    //         'album' => 'required|exists:album,id',
    //         'deksripsi_foto' => 'nullable|string',
    //         'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the file upload
    //     ]);

    //     // Find the photo by ID
    //     $photo = foto::findOrFail($id);

    //     // Update the photo details
    //     $photo->judul_foto = $request->judul_foto;
    //     $photo->album_id = $request->album;
    //     $photo->deksripsi_foto = $request->deksripsi_foto;

    //     // Handle file upload if a new file is provided
    //     if ($request->hasFile('file')) {
    //         // Delete the old file if it exists
    //         if (Storage::disk('public')->exists('postingan/' . $photo->lokasi_file)) {
    //             Storage::disk('public')->delete('postingan/' . $photo->lokasi_file);
    //         }

    //         // Process the new file
    //         $extensi = $request->file('file')->getClientOriginalExtension();
    //         $namafoto = 'postingan' . time() . '.' . $extensi;
    //         // Move the file to the 'postingan' directory
    //         $request->file('file')->storeAs('postingan', $namafoto, 'public');
    //         // Update the database with the new file path
    //         $photo->lokasi_file = $namafoto;
    //     }

    //     // Save the changes
    //     $photo->save();

    //     // Redirect back or to a success page
    //     return redirect('/album')->with('success', 'Photo updated successfully');
    // }
    public function updatepostingan(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'judul_foto' => 'required|string|max:255',
            'album' => 'nullable|exists:album,id', // Making the album field optional
            'deksripsi_foto' => 'nullable|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the file upload
        ]);
    
        // Find the photo by ID
        $photo = foto::findOrFail($id);
    
        // Update the photo details
        $photo->judul_foto = $request->judul_foto;
        $photo->deksripsi_foto = $request->deksripsi_foto;
    
        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            try {
                // Get the old file path from the database
                $oldFilePath = 'postingan/' . $photo->lokasi_file;
        
                // Check if the old file exists before attempting to delete
                if (Storage::disk('postingan')->exists($oldFilePath)) {
                    // Attempt to delete the old file
                    $deleteSuccess = file::disk('postingan')->delete($oldFilePath);
        
                    if (!$deleteSuccess) {
                        throw new \Exception('Failed to delete the old file.');
                    }
                }
        
                // Process the new file
                $extensi = $request->file('file')->getClientOriginalExtension();
                $namafoto = 'postingan' . time() . '.' . $extensi;
        
                // Move the file to the 'postingan' directory
                $request->file('file')->storeAs('postingan', $namafoto, 'public');
        
                // Update the database with the new file path
                $photo->lokasi_file = $namafoto;
                $photo->save();
        
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal mengunggah foto baru: ' . $e->getMessage()], 500);
            }
        }        
            
        // Update the album_id if provided, or set it to null if not provided
        $photo->album_id = $request->has('album') ? $request->album : null;
    
        // Save the changes
        $photo->save();
    
        // Redirect back or to a success page
        return redirect('/album')->with('success', 'Photo updated successfully');
    }
    


    //ajukanbanding
    public function pesanapplyuser(){

        return view('pesan');
    }
    //kirimpesa
    public function pemulihanakun(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
        ]);

        // Simpan data ke dalam database
        datapesan::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'pesan' => $validatedData['pesan'],
        ]);

        // Redirect ke halaman lain atau tampilkan pesan sukses
        return redirect('/login')->with('success', 'Data berhasil disimpan.');
    }
}
