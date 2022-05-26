<?php  
namespace App\Http\Controllers; 
 
use App\Models\Mahasiswa; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
 
class MahasiswaController extends Controller 
{ 
   /** 
*	Display a listing of the resource. 
     * 
*	@return \Illuminate\Http\Response 
     */     
    public function index()
    {
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate' => $paginate]);

        //fungsi eloquent menampilkan data menggunakan pagination
        // if(request('search')){
        //     $mahasiswas = Mahasiswa::where('nama', 'like', '%' . request('search') . '%')->paginate();
        // }else{
        //     $mahasiswas = Mahasiswa::orderBy('nim', 'asc')->paginate(5);
        // }
        // return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    public function store(Request $request)
    {
        //melakukan validasi data
        $validatedData = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required'
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->No_Handphone = $request->get('No_Handphone');

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambahkan data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }
    
     public function destroy( $nim) 
     { 
 //fungsi eloquent untuk menghapus data         
         Mahasiswa::find($nim)->delete();         
         return redirect()->route('mahasiswa.index') 
            -> with('success', 'Mahasiswa Berhasil Dihapus'); 
     } 
     public function cari (Request $request)
    {

         $cari = $request -> get ('cari');
         $post = DB::table('mahasiswa')->where('nama','like','%'.$cari.'%')->paginate(5);
        return view('mahasiswa.index',['mahasiswa' => $post]);
         
    }
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan nim Mahasiswa
        // code sebelum di relasi --> $Mahasiswa = Mahasiswa::find($nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);

    }
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan nim Mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));

    }


    public function update(Request $request, $nim)
    {
        //melakukan validasi data
         $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'Kelas' => 'required',
            'jurusan' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->Jurusan = $request->get('jurusan');

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk update data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

};  