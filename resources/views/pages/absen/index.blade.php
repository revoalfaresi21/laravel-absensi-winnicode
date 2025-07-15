<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>

  <body>
    <div class="container my-5">
        <div class="card mb-4">
            <div class="card-body" text-center>
                <h4 class="text-center">{{ env('APP_NAME') }}</h4>
                <table class="table table-borderless">
                  <tr>
                      <td width="150">Nama Kegiatan</td>
                      <td width="20">:</td>
                      <td>{{$presence->nama_kegiatan}}</td>
                  </tr>
                  <tr>
                      <td>Tanggal Kegiatan</td>
                      <td>:</td>
                      <td>{{ date('d F Y', strtotime($presence->tgl_kegiatan)) }}</td>
                  </tr>
                  <tr>
                      <td>Waktu Mulai</td>
                      <td>:</td>
                      <td>{{ date('H:i', strtotime($presence->tgl_kegiatan)) }}</td>
                  </tr>
                </table>
            </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Form Absensi</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('absen.save') }}" method="post">
                  @csrf
                  <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id='nama' name="nama">
                    @error('nama')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Daftar Kehadiran</h5>
              </div>
            <div class="card-body">

          </div>
          </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
  </body>
</html>