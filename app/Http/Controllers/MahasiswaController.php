<?php  
namespace App\Http\Controllers; 
 
use App\Models\Mahasiswa; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
 
class MahasiswaController extends Controller 
{ 
   /** 
*	Display a listing of the resource. 
     * 
*	@return \Illuminate\Http\Response 
     */     
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        return view('mahasiswa.index', compact('mahasiswa'));
        with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
         return view('mahasiswa.create');
    }
        public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'Tanggal_lahir' => 'required',
            'Alamat' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        //fungsi eloquent untuk menambah data
        Mahasiswa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    
    public function show($Nim) 
    { 
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa 
        $Mahasiswa = Mahasiswa::find($Nim);         
        return view('mahasiswa.detail', compact('Mahasiswa'));     
    }   
    public function edit($Nim)    
    { 
 //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit 
        $Mahasiswa = Mahasiswa::find($Nim);         
        return view('mahasiswa.edit', compact('Mahasiswa'));     
    }    
    public function update(Request $request, $Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        $Mahasiswa->nim = $request->input('nim');
        $Mahasiswa->nama = $request->input('nama');
        $Mahasiswa->kelas = $request->input('email');
        $Mahasiswa->kelas = $request->input('tanggal_lahir');
        $Mahasiswa->kelas = $request->input('alamat');
        $Mahasiswa->kelas = $request->input('kelas');
        $Mahasiswa->jurusan = $request->input('jurusan');
        $Mahasiswa->update();

        return redirect()->route('mahasiswa.index') 
            ->with('success', 'Mahasiswa Berhasil Diupdate'); 
    } 
    
     public function destroy( $Nim) 
     { 
 //fungsi eloquent untuk menghapus data         
         Mahasiswa::find($Nim)->delete();         
         return redirect()->route('mahasiswa.index') 
            -> with('success', 'Mahasiswa Berhasil Dihapus'); 
     } 
     public function cari (Request $request)
    {

         $cari = $request -> get ('cari');
         $post = DB::table('mahasiswa')->where('nama','like','%'.$cari.'%')->paginate(5);
        return view('mahasiswa.index',['mahasiswa' => $post]);

         
    }
};  