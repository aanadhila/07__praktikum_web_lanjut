@extends('mahasiswa.layout')

@section('content')

<div class="container mt-5">
 <div class="row justify-content-center align-items-center">
   <div class="card" style="width: 24rem;">
      <div class="card-header">Edit mahasiswa</div>
      <div class="card-body">
         @if ($errors->any())
         <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         <form method="post" action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" id="myForm">
         @csrf
         @method('PUT')
            <div class="form-group">
               <label for="Nim">Nim</label>
               <br>
               <input type="text" name="nim" class="form-control" id="Nim" value="{{ $mahasiswa->nim }}" aria describedby="Nim" >
            </div>
            <div class="form-group">
               <label for="Nama">Nama</label>
               <br>
               <input type="text" name="nama" class="form-control" id="Nama" value="{{ $mahasiswa->nama }}" aria describedby="Nama" >
            <!-- </div>
            <div class="form-group">
               <label for="Email">Email</label>
               <br>
               <input type="email" name="email" class="form-control" id="Email" value="{{ $mahasiswa->email }}" aria- describedby="email" >
            </div>
            <div class="form-group">
               <label for="Tanggal_lahir">Tanggal Lahir</label>
               <br>
               <input type="date" name="tanggal_lahir" class="form-control" id="Tanggal_lahir" value="{{ $mahasiswa->tanggal_lahir }}" aria- describedby="tanggal_lahir" >
            </div>
            <div class="form-group">
               <label for="Alamat">Alamat</label>
               <br>
               <input type="Alamat" name="alamat" class="form-control" id="Tanggal_lahir" value="{{ $mahasiswa->alamat }}" aria- describedby="alamat" >
            </div> -->
            <br>
            <div class="form-group">
            <label for="Kelas">Kelas</label>
            <select class="form-control" name="Kelas">
               @foreach ($kelas as $kls)
               <option value="{{ $kls->id }}" {{ $mahasiswa->kelas_id == $kls->id ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
               @endforeach
               </select>
            </div>
            <div class="form-group">
            <div class="form-group">
               <label for="Jurusan">Jurusan</label>
               <br>
               <input type="Jurusan" name="jurusan" class="form-control" id="Jurusan" value="{{ $mahasiswa->jurusan }}" aria describedby="Jurusan" >
            </div>
            
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>
         </div>
      </div>
    </div>
</div>
   @endsection