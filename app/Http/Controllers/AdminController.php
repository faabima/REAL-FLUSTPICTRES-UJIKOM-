<?php

namespace App\Http\Controllers;

use App\Models\foto;
use App\Models\User;
use App\Models\laporan;
use App\Models\likefoto;
use App\Models\datapesan;
use App\Models\komenfoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //loginadmin
    public function ceklogin_admin(Request $request)
    {
         // Validate
        $request->validate([
            'email' => ['required', 'email'],
            'password'  => ['required'],
        ]);

        // Proses log in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        } else {
            // dd($request);
            throw ValidationException::withMessages([
                'email' => 'Email atau Password Anda Salah',  
            ]);
        }
    }
    //logout
    public function logoutadmin(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/loginadmin');
    }
    //dashboaradmin
    public function dashboard_admin()
    {
        // Assuming you have a 'role' column in your users table
        $role = 'user'; // Change this to the role you want to filter
    
        // Fetch users based on the role
        $user = User::where('role', $role)->get();
        $dataparsing = [
            'User' => User::where('role', 'user')->count(),
            'Admin' => User::where('role', 'admin')->count(),
            'laporan' => laporan::all()->count(),
        ];
        $datalaporan = DB::table('laporan')
            ->join('users', 'laporan.users_id', '=', 'users.id')
            ->join('foto', 'laporan.foto_id', '=', 'foto.id')
            ->select('users.username', 'users.email', 'users.foto_profil', 'foto.lokasi_file', 'laporan.*')
            ->get();

        return view('admin.dasbor', $dataparsing, compact('user'));
    }
    //tambahadmin
    public function tambah_admin(Request $request)
    {
        $tambahadmin = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ];
        User::create($tambahadmin);
        return redirect('/tambahadmin');
    }
    //viewprofileadmin
    public function profile_admin(){
        $data = [
            'dataprofile'   => User::where('id', auth()->user()->id)->first()
        ];
        return view('admin.profileadmin', $data);
    }
    //updatedataprofileAdmin
    public function updatedataprofileadmin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telephone' => 'required|string|max:15|unique:users,no_telephone,' . auth()->user()->id,
            'alamat' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
        ]);
    
        // Process update if validation passes
        $dataupdate = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telephone' => $request->no_telephone,
            'alamat' => $request->alamat,
            'bio' => $request->bio,
        ];
    
        // Update user data
        User::where('id', auth()->user()->id)->update($dataupdate);
    
        return redirect('/profiladmin');
    }
    
    //fotoprofilAdmin
    public function fotoprofiladmin(Request $request)
    {
        $namafile   = pathinfo($request->file, PATHINFO_FILENAME);
        $extensi    = $request->file->getClientOriginalExtension();
        $namafoto   = 'profile' . time() . '.' . $extensi;
        $request->file->move('admin', $namafoto);
        //data
        $dataupdate = [
            'foto_profil'  =>$namafoto,
        ];
        //proses update
        User::where('id', auth()->user()->id)->update($dataupdate);
        
        return redirect('/profiladmin');
    }
    //viewpasswordupdate
    public function passwordupdate(){
        
        return view('admin.updatepassword');
    }
    // ChangePasswordController.php
    public function updateadmin(Request $request)
    {
       $request->validate([
           'current_password' => 'required',
           'password' => 'required|min:8',
       ]);

       $user = Auth::user();
    //dd($request->current_password);
       if (!Hash::check($request->current_password, $user->password)) {
           return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => bcrypt($request->password),
         ]);

       return redirect()->back()->with('success', 'Password berhasil diubah ');
    }
    //datauser
    public function datauseradmin(Request $request) {
        // Assuming you have a 'role' column in your users table
        $role = 'user'; // Change this to the role you want to filter
    
        // Fetch users based on the role
        $user = User::where('role', $role)->get();
    
        return view('admin.datauser', compact('user'));
    }
    //laporan
    public function laporan(Request $request){

        $datalaporan = DB::table('laporan')
            ->join('users', 'laporan.users_id', '=', 'users.id')
            ->join('foto', 'laporan.foto_id', '=', 'foto.id')
            ->select('users.username', 'users.email', 'users.foto_profil', 'foto.lokasi_file', 'laporan.*')
            ->get();
    
        return view('admin.laporan', ['datalaporan' => $datalaporan]);
    }
    //Take Down.postingan
    public function deletePhoto($id)
    {
        try {
            // Temukan data laporan yang terkait dengan foto
            $laporan = laporan::where('foto_id', $id)->first();

            // Periksa apakah data laporan ditemukan
            if (!$laporan) {
                return redirect()->back()->with('error', 'Data laporan tidak ditemukan.');
            }

            // Hapus data foto dari penyimpanan (jika diperlukan)
            Storage::delete('/postingan/' . $laporan->foto->lokasi_file);

            // Hapus data laporan berserta relasinya
            $laporan->delete();

            // Hapus data like terkait
            likefoto::where('foto_id', $id)->delete();

            // Hapus data komen terkait
            komenfoto::where('foto_id', $id)->delete();

            // Hapus data foto dari database
            foto::destroy($id);

            return redirect()->back()->with('success', 'Foto berhasil dihapus bersama dengan data laporan, like, dan komen.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus foto dan data terkait: ' . $e->getMessage());
        }
    }
    //Tolak postingan
    public function hapusLaporan($id)
    {
        // Temukan laporan berdasarkan ID
        $laporan = laporan::find($id);

        // Periksa apakah laporan ditemukan
        if ($laporan) {
            // Hapus laporan
            $laporan->delete();

            // Berikan respons sukses dan kembali ke halaman sebelumnya
            return redirect()->back()->with('success', 'Data laporan berhasil dihapus');
        } else {
            // Jika laporan tidak ditemukan, berikan respons tidak ditemukan
            return response()->json(['message' => 'Data laporan tidak ditemukan'], 404);
        }
    }
    //Non Aktifkan user
    public function nonAktifkanUser(Request $request)
    {
        $userId = $request->input('user_id');

        // Fetch the user by ID
        $user = User::findOrFail($userId);

        // Toggle the user status
        $user->status_user = ($user->status_user === 'Aktif') ? 'NonAktif' : 'Aktif';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
    //viewdatapesan
    public function kotakmasuk()
    {
        // Ambil semua data pesan yang masuk dari database
        $messages = datapesan::all();
        $pesan = datapesan::first(); 

        // Kirim data pesan ke tampilan 'kotakmasuk'
        return view('admin.kotakmasuk', compact('messages','pesan'));
    }
    //hapuspesan
    public function hapuspesan(Request $request)
    {
        // Validate the request if necessary
        // ...

        // Get the ID from the request or any other way you want to determine which records to delete
        $pesanId = $request->input('id');

        // Delete data from the "data pesan" table based on ID
        datapesan::where('id', $pesanId)->delete();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Data pesan berhasil dihapus.');
    }
}


    


