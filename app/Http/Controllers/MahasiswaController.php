<?php  
namespace App\Http\Controllers; 
 
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Mahasiswa_Matakuliah;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\DB;
use PDF;
 
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
        //     $mahasiswa = Mahasiswa::where('nama', 'like', '%' . request('search') . '%')->paginate();
        // }else{
        //     $mahasiswa = Mahasiswa::orderBy('nim', 'asc')->paginate(5);
        // }
        // return view('mahasiswa.index', compact('mahasiswa'));
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
            'kelas' => 'required',
            'Jurusan' => 'required',
            'Foto' => 'required'
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        // $imageName = time().'.'.$request->Foto->extension();       
        // $request->image->move(public_path('images'), $imageName);
        $mahasiswa->Foto = $request->file('Foto')->store('images', 'public');
        // $mahasiswa->Foto = $image_name;
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->kelas_id = $request->get('kelas');


        // $kelas = new Kelas;
        // $kelas->id = 
        //fungsi eloquent untuk menambahkan data dengan relasi belongsTo
        // $mahasiswa->kelas()->associate($kelas);
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
        // dd($request);
        //melakukan validasi data
         $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'Kelas' => 'required',
            'jurusan' => 'required',
            'Foto' => 'required'
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        if ($mahasiswa->Foto && file_exists(storage_path('app/public/' . $mahasiswa->Foto))) {
            Storage::delete('public/' . $mahasiswa->Foto);
        }
        $mahasiswa->Foto = $request->file('Foto')->store('images', 'public');
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
    public function nilai($id_mahasiswa)
    {
        // Join relasi ke mahasiswa dan mata kuliah
        $mhs = Mahasiswa_MataKuliah::with('matakuliah')->where("mahasiswa_id", $id_mahasiswa)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where("nim", $id_mahasiswa)->first();
        //dd($mhs[0]);
        // Menampilkan nilai
        return view('mahasiswa.nilai', compact('mhs'));
    }
    public function cetak_pdf($Nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        // $pdf = PDF::loadview('articles.articles_pdf', ['articles' => $article]);
        $pdf = PDF::loadview('mahasiswa.pdf', array('Mahasiswa' => $Mahasiswa));
        return $pdf->stream();
    }
};  