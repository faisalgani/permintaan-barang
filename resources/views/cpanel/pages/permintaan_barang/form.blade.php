<!-- Required meta tags -->
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">@push('pluginCSS')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.css')}}">
    <!-- Leaflet -->
    <link rel="stylesheet" href="{{asset('assets/plugins/leaflet/leaflet.css')}}"> 
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.4/dist/esri-leaflet-geocoder.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/daterangepicker/daterangepicker.css')}}">
@endpush


<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

<script src="{{asset('assets/template/adminLTE/plugins/jquery-ui/jquery-ui.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/jquery-ui/jquery-ui.css')}}">

@push('pluginJS')
    <!-- Summernote -->
    <script src="{{asset('assets/template/adminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/template/adminLTE/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/inputmask/jquery.inputmask.min.js')}}"></script> 
    <script src="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/template/adminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Leaflet -->
    <script src="{{asset('assets/plugins/leaflet/leaflet.js')}}"></script>
    <!-- <script src="{{asset('assets/plugins/leaflet3/leaflet.bundle.js')}}"></script> -->
    <script src="{{asset('assets/plugins/esri-leaflet-v3.0.1/esri-leaflet.js')}}"></script>
    <script type="text/javascript" src="https://unpkg.com/esri-leaflet-geocoder@2.2.4"></script>

@endpush
<style type="text/css">
  .ui-autocomplete{
    z-index: 100000;
    position:absolute;
    top:0;
    left:0;
    cursor:default
  }
</style>
@extends('cpanel.index')
@section('content')
        <?php 
            // $process = "create";
            // $tmpData = array(
            //     'id' => "",
            //     'nik_pemesan' => "",
            //     'nama_pemesan' => "",
            //     'id_satuan' => "",
            //     'id_lokasi' => ""
            // );
            // $tmpProduk = $data['produk'];
            // if(count($data) > 0){
            //     $result = $data[0];
            //     $tmpData = array(
            //         'id' => $result->id,
            //         'nama_barang' =>  $result->nama_barang,
            //         'stok' =>  $result->stok,
            //         'stock' =>  $result->stock,
            //         'id_satuan' =>  $result->id_satuan,
            //         'id_lokasi' =>  $result->id_lokasi
            //     );
            //     $process = "update";
            // }
            // $tmpData = json_encode($tmpData);
        ?>
        
    <section class="content">
    <div class="container-fluid">
        
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Informasi Pemesan</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="inputName">NIK Pemesan</label>
                    <input type="text" id="nik_pemesan" name="nik_pemesan" class="form-control">
                    <input type="hidden" id="id_customer" name="id_customer" class="form-control">
                    <input type="hidden" id="id_departemen" name="id_departemen" class="form-control">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="inputName">Nama Pemesan</label>
                    <input type="text" id="nama_pemesan" name="nama_pemesan" class="form-control" readonly = "true" >
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label for="inputName">Departemen Pemesan</label>
                    <input type="text" id="nama_departemen" name="nama_departemen" class="form-control" readonly = "true">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="inputName">Tanggal Pemesanan</label>
                    <input type="date" id="tgl_pemesanan" class="form-control">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Informasi Produk</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary" onclick="add_row()"> 
                        <i class="fas fa-plus"></i>Tambah Baris
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 220px;">
                <table class="table table-head-fixed text-nowrap" id="table-pemesanan-produk">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Barang</th>
                      <th>Lokasi</th>
                      <th>Tersedia</th>
                      <th>Kuantiti</th>
                      <th>Satuan</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>  
      <div class="row">
        <div class="col-12">
            <a href="/admin/permintaan_barang" class="btn btn-secondary">Batal</a>
          <input type="submit" value="Simpan" id="btnSave" onclick="save_all();" class="btn btn-success float-right">
        </div>
      </div>
    </section>
        
@endsection('content')


<script>
    var route = "{{ url('/api/v1/customer/store_id/') }}";
    $(document).ready(function(){
        $( "#nik_pemesan" ).autocomplete({
            source: route,
            select: function (event, ui) {
                console.log(ui);
                $('[name="nik_pemesan"]').val(ui.item.nik); 
                $('[name="id_customer"]').val(ui.item.id_customer); 
                $('[name="id_departemen"]').val(ui.item.id_departemen); 
                $('[name="nama_pemesan"]').val(ui.item.nama_customer);
                $('[name="nama_departemen"]').val(ui.item.nama_departemen); 
            },
            minLength:3
        }).bind('focus', function(){ $(this).autocomplete("search")} );
        $(function() {
            $('#nik_pemesan').keyup(function() {
                this.value = this.value.toUpperCase();
            });
        });
    });

    function save_all(){
        var route_save = "{{ url('/api/v1/permintaan_barang/create/') }}";
        var x='';
        let result = [];
        let tmp_data = [];
        $("table tbody tr").each(function() {
            var allValues = {}; 
            $(this).find("input").each(function( index ) {
                const fieldName = $(this).attr("name");
                allValues[fieldName] = $(this).val();
            });
            result.push(allValues);
        })

     
        for (var i = 0; i < result.length; i++) {
            var y='';
			var z='@@##$$@@';
			y = result[i].id_barang;
			y += z + result[i].qty;
			y += z + result[i].keterangan;

			if (i === (result.length-1)){
				x += y ;
			}else{
				x += y + '##[[]]##';
			};
        }

        $.ajax({
            url : route_save,
            type: "POST",
            data:{
                "id_customer" : $('#id_customer').val(),
                "tgl_transaksi" : $('#tgl_pemesanan').val(),
                "data_array" : x
            },
            dataType: "JSON",
            success: function(data){
                alert("Transaksi Berhasil di Simpan");
                window.location.href = "{{URL::to('admin/permintaan_barang')}}";

            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
            }
        });
        console.log(x);
    }
    

    function add_row(){
        var route_barang = "";
        var table = document.getElementById("table-pemesanan-produk");
        var RowCount = table.tBodies[0].rows.length+1;
        var nilai = $("#nama_kota").val();
        var row1 = "<tr> <td>"+RowCount+"</td>";
        var row2 = "<td><input type=text id=nama_barang"+RowCount+" class=form-control> <input type=hidden id=id_barang"+RowCount+" name=id_barang class=form-control> </td>";
        var row3 = "<td><input type=text id=lokasi"+RowCount+" class=form-control readonly=true> </td>";
        var row4 = "<td><input type=text id=stok"+RowCount+" class=form-control readonly=true></td>";
        var row5 = "<td><input type=text id=qty"+RowCount+" name=qty class=form-control></td>";
        var row6 = "<td><input type=text id=satuan"+RowCount+" class=form-control readonly=true></td>";
        var row7 = "<td><input type=text id=keterangan"+RowCount+" name=keterangan class=form-control></td>";
        var row8 = "<td><input type='button' id=status-btn"+RowCount+" value='Status' class='btn btn-success'></td>"
        var row9 = "<td><input type='button' id='del-btn' value='Hapus' class='btn btn-danger' onclick='deleteRow(this)'></td>"
        var autocomplateBarang =  
        $(document).ready(function(){
            $('#nama_barang'+RowCount).autocomplete({
                source: "{{ url('/api/v1/barang/store_name/') }}",
                    select: function (event, ui) {
                        console.log(ui);
                        $('#id_barang'+RowCount).val(ui.item.id_barang);
                        $('#nama_barang'+RowCount).val(ui.item.nama_barang);
                        $('#lokasi'+RowCount).val(ui.item.lokasi);
                        $('#stok'+RowCount).val(ui.item.stok);
                        $('#satuan'+RowCount).val(ui.item.satuan);
                        if(ui.item.stok <= 5){
                            $('#status-btn'+RowCount).prop('value', 'Hampir Habis');
                            $('#status-btn'+RowCount).removeClass("btn btn-success").addClass("btn btn-warning");
                        }else{
                            $('#status-btn'+RowCount).prop('value', 'Tersedia');
                        }
                    },
                    minLength:3
                }).bind('focus', function(){ $(this).autocomplete("search")} );
            $(function() {
                $('#nama_barang'+RowCount).keyup(function() {
                    this.value = this.value.toUpperCase();
                });
            }); 
        });
        var baris_baru = row1+row2+row3+row4+row5+row6+row7+row8+row9+autocomplateBarang;
        $("#table-pemesanan-produk").append(baris_baru);
    }

    function deleteRow(row){
        var i=row.parentNode.parentNode.rowIndex;
        document.getElementById('table-pemesanan-produk').deleteRow(i);
    }

    function addAutoBarang(i){
        alert(i);
        var route_barang = "{{ url('/api/v1/barang/store_name/') }}";
        $( "#nama_barang"+i ).autocomplete({
            source: route_barang,
            select: function (event, ui) {
                console.log(ui);
              
            },
            minLength:3
        }).bind('focus', function(){ $(this).autocomplete("search")} );
        $(function() {
            $('#nama_barang'+i).keyup(function() {
                this.value = this.value.toUpperCase();
            });
        });
    }
</script>
