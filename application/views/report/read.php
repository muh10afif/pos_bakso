<style>
  .input {
      height: 10px !important;
      border-radius: 10px;
      border-color: #f2a654;
  }
  .nav-tabs .nav-link:not(.active) {
      border-color: #f2a654 !important;
      color: grey;
  }
  .nav-tabs .nav-link.active {
      border-color: #f2a654 !important;
      background-color: #faa307;
      font-weight: bold;
      color: white;
  }

  .date td, .datepicker th {
      width: 2.5rem;
      height: 2.5rem;
      font-size: 0.85rem;
  }

  .date {
      margin-bottom: 3rem;
  }
</style>
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper pb-0">
      <div class="row">
          <div class="col-sm">
              <div class="card shadow">
                  <div class="card-header" style="background-color: #ffbf00;">
                      <h3 id="judul" class="font-weight-blod"><b><i class="fa fa-file-alt mr-3"></i>Report Transaksi</b></h3>
                  </div>
                  <form id="form-filter" class="form-horizontal" method="post" action="<?php echo base_url('Report/cetak') ?>">
                      <input type="hidden" id="aksi" name="jns">
                      <div class="card-body">
                          <div class="d-flex justify-content-center">
                              <div class="col-md-8">
                                  <div class="input-daterange input-group" id="date-range-2">
                                      <input type="text" class="form-control date" name="start_date" id="start" placeholder="Awal Periode" readonly/>
                                      <div class="input-group-append">
                                          <span class="input-group-text bg-primary b-0 text-white">s / d</span>
                                      </div>
                                      <input type="text" class="form-control date" name="end_date" id="end" placeholder="Akhir Periode" readonly/>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="card-footer ">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="d-flex justify-content-start">
                                    <?php if($this->session->userdata('id_role') > 1) { ?>
                                        <button type="submit" class="btn btn-sm btn-primary mr-2" name="excel" data="excel" data-toggle='tooltip' data-placement='top' title='Downnload Excel'><i class="fa fa-file-excel"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning" name="pdf" data="pdf" data-toggle='tooltip' data-placement='top' title='Downnload Pdf'><i class="fa fa-file-pdf"></i></button>
                                      <?php } ?>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="d-flex justify-content-end">
                                      <button type="button" class="btn btn-primary mr-2" id="btn-filter">Tampilkan</button>
                                      <button type="button" class="btn btn-warning" id="btn-reset">Reset</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="row mt-3">
          <div class="col-sm">
              <div class="card shadow">
                  <div class="card-body">
                      
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0;">

                        <a class="nav-item nav-link mr-2 active font-weight-bold shadow" style="border-radius: 7px;" id="nav-bahan-tab" data-toggle="tab" href="#nav-bahan" role="tab" aria-controls="nav-bahan" aria-selected="true"><h4 class="mt-1">Transaksi Selesai</h4></a>

                        <a class="nav-item nav-link mr-2 font-weight-bold shadow" style="border-radius: 7px;" id="nav-stok-tab" data-toggle="tab" href="#nav-stok" role="tab" aria-controls="nav-stok" aria-selected="true"><h4 class="mt-1">Transaksi Belum Terbayar</h4></a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-bahan" role="tabpanel" aria-labelledby="nav-bahan-tab">
                        <div class="row mt-3">
                            <div class="col-sm">
                                <div class="table-wrap mt-3">
                                    <table id="table" class="table w-100 display pb-30 table-bordered table-striped" width="100%">
                                        <thead class="text-center">
                                            <tr class="table-secondary">
                                                <th class="font-weight-bold" width="5%">No.</th>
                                                <th class="font-weight-bold">Tanggal Transaksi</th>
                                                <th class="font-weight-bold">Kode Transaksi</th>
                                                <th class="font-weight-bold">Total Harga</th>
                                                <th class="font-weight-bold" width="7%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-stok" role="tabpanel" aria-labelledby="nav-stok-tab">
                        <div class="row mt-3">
                            <div class="col-sm">
                                <div class="table-wrap mt-3">
                                    <table id="table_blm" class="table w-100 display pb-30 table-bordered table-striped" width="100%">
                                        <thead class="text-center">
                                            <tr class="table-secondary">
                                                <th class="font-weight-bold" width="5%">No.</th>
                                                <th class="font-weight-bold">Tanggal Transaksi</th>
                                                <th class="font-weight-bold">Kode Transaksi</th>
                                                <th class="font-weight-bold">Total Harga</th>
                                                <th class="font-weight-bold" width="7%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                  </div>
              </div>
          </div>
      </div>
    </div>
    <script>
      var table;
      var table_blm;
      $(document).ready(function() {
        table = $('#table').DataTable({ 
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Report/read')?>",
                "type": "POST",
                "data": function (data) {
                    data.start_date     = $('#start').val();
                    data.end_date       = $('#end').val();
                },
            },
            stateSave : true,
            "columnDefs": [
                { 
                    "targets": [0,4],
                    "orderable": false,
                },
                {
                    "targets": [0,4],
                    "className": "text-center",
                }
            ],
        });

        table_blm = $('#table_blm').DataTable({ 
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Report/read_blm')?>",
                "type": "POST",
                "data": function (data) {
                    data.start_date     = $('#start').val();
                    data.end_date       = $('#end').val();
                },
            },
            stateSave : true,
            "columnDefs": [
                { 
                    "targets": [0,4],
                    "orderable": false,
                },
                {
                    "targets": [0,4],
                    "className": "text-center",
                }
            ],
        });

        // $('#detail').DataTable();

        // setInterval( function () {
        //     table.ajax.reload( null, false );
        // }, 30000 );

        $('#btn-filter').click(function(){
          table.ajax.reload();
          table_blm.ajax.reload();
        });
        $('#btn-reset').click(function(){
          $('#start').val('');
          $('#end').val('');
          table.ajax.reload();
          table_blm.ajax.reload();
        });
        $('.date').datepicker({

          "format": "yyyy-mm-dd",
          "todayHighlight": true,
          "autoclose": true,
          "clearBtn": true

        });

      });
    </script>

    <div class="modal fade" id="detail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title display-4 font-weight-bold">Detail Transaksi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="card shadow">
              <div class="card-body">
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td width="10%"><b>Kode Transaksi</b></td>
                      <td id="mod_kode_transaksi"></td>
                    </tr>
                    <tr>
                      <td width="10%"><b>Tanggal</b></td>
                      <td id="mod_tgl_transaksi"></td>
                    </tr>
                    <tr>
                      <td width="10%"><b>Nomor Meja</b></td>
                      <td id="mod_nomor_meja"></td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <div class="table-responsive">
                  <table id="table" class="table table-striped table-hover">
                    <thead class="text-center">
                      <tr class="table-secondary font-weight-bold">
                        <th class="font-weight-bold">No.</th>
                        <th class="font-weight-bold">Nama Produk</th>
                        <th class="font-weight-bold">Harga</th>
                        <th class="font-weight-bold">Qty</th>
                        <th class="font-weight-bold">Diskon</th>
                        <th class="font-weight-bold">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody id="mod_detail_string">
                      
                    </tbody>
                  </table>
                </div>
                <br>
                <div>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left"><b>Potongan Harga</b></td>
                        <td width="5%">:</td>
                        <td class="text-right" id="mod_potongan_harga"></td>
                      </tr>
                      
                      
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left"><b>Diskon</b></td>
                        <td width="5%">:</td>
                        <td class="text-right" id="mod_diskon"></td>
                      </tr>

                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td width="5%" class="text-left"><b>Subtotal</b></td>
                        <td width="5%">:</td>
                        <td  width="15%" class="text-right" id="mod_subtotal"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left"><b>Total</b></td>
                        <td width="5%">:</td>
                        <td class="text-right" id="mod_total"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left"><b>Tunai</b></td>
                        <td width="5%">:</td>
                        <!-- <td><b>Rp. <?php echo $row->tunai ? number_format($row->tunai) : 0 ?></b></td> -->
                        <td class="text-right">
                        <div class="">
                            <div class="easy-get5" data-id="" harga="" id="mod_tunai">
                                <input type="text" style="font-size: 18px;"  class="form-control input text-right easy-put5" name="tunai" id="tunai" size="1" value="" autocomplete="off">
                            </div>
                        </div></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left"><b>Kembali</b></td>
                        <td width="5%">:</td>
                        <td class="text-right"><b id="kembali"></b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="mdi mdi-close-circle mr-2"></i><span style="font-size: 18px;">Batal</span></button>
            <button type="button" class="btn btn-warning kirim-email" data-id="" id="mod_kirim_email"><i class="mdi mdi-gmail mr-2"></i><span style="font-size: 18px;">Kirim Email</span></button>
            <button type="button" class="btn btn-primary cetak" data-id="" potongan_harga="" id="mod_cetak"><i class="mdi mdi-printer mr-2"></i><span style="font-size: 18px;">Cetak</span></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_email" role="dialog" aria-labelledby="exampleModalCenterTitle2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered w-75" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #faa307;">
                <h5 class="modal-title font-weight-bold text-white judul">Kirim E-mail</h5>
                <button type="button" class="close keluar-email" data-id=""  data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="mr-2 text-white">&times;</span>
                </button>
            </div>
            <form id="form-email">
            <div class="modal-body row">
                <div class="col-md-12 mt-3">
                    <input type="hidden" class="id_tr">
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-3 col-form-label text-right">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" style="font-size: 14px;" name="nm_email" id="nm_email" placeholder="Masukkan Email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-4 offset-md-8 text-right">
                    <button class="btn btn-success simpan_email" type="button" data-id="" id="mod_kirim">Kirim</button>
                </div>
            </div>
            </form>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->

    

    <script>
      // card cetak nota
      $('.cetak').on('click', function () {

        var id_tr       = $(this).data('id');
        var pot_harga   = $(this).attr('potongan_harga');

        console.log(id_tr);

        $.ajax({
            url         : "Transaksi/cetak_nota/"+id_tr+"/"+pot_harga,
            method      : "POST",
            data        : {id_tr:id_tr, pot_harga:pot_harga},
            dataType    : "JSON",
            success     : function (data) {

                
            },
            error       : function(xhr, status, error) {
                // var err = eval("(" + xhr.responseText + ")");
                // alert(err.Message);

                $('#potongan_harga').val(0);
            }

        })

        return false;

      })

      $('.kirim-email').on('click', function () {
          var id = $(this).data('id');

          $('#nm_email').val('');
          $('#modal_email').modal('show');
          $('#detail').modal('hide');
      })

      $('.keluar-email').on('click', function () {
        var id = $(this).data('id');

        $('#modal_email').modal('hide');
        $('#detail').modal('show');
      })

      // button transaksi
      $('.simpan_email').on('click', function () {

        var id_tr  = $(this).data('id');
        var email  = $('#nm_email').val();

        if (email == '') {

            swal({
                title               : "Peringatan",
                text                : 'Email Harap Diisi!',
                buttonsStyling      : false,
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            });  

            return false;

        } else {

            $.ajax({
                url         : "Transaksi/kirim_email",
                method      : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Harap Tunggu',
                        html    : 'Memproses Kirim Data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data        : {id_tr:id_tr, email:email},
                dataType    : "JSON",
                success     : function (data) {

                    if (data.status == 'OK') {

                        swal({
                            title               : "Berhasil",
                            text                : 'Data berhasil dikirim ke '+email,
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'success',
                            showConfirmButton   : false,
                            timer               : 1500
                        });

                        $('#detail').modal('show');
                        $('#modal_email').modal('hide');
                    } 
                    
                },
                error       : function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }

            })

            return false;

        }

      })

      $('#table').on('click', '.detailButton', function () {

        var id_tr       = $(this).data('id');

        $.ajax({
            url         : "Report/detail/",
            method      : "POST",
            data        : {id_tr:id_tr},
            dataType    : "JSON",
            success     : function (data) {
              $('#mod_kode_transaksi').html(data.kode_transaksi);
              $('#mod_tgl_transaksi').html(data.tgl_transaksi);
              $('#mod_nomor_meja').html(data.nomor_meja);
              $('#mod_detail_string').html(data.detail_string);
              $('#mod_potongan_harga').html(data.potongan_harga);
              $('#mod_diskon').html(data.diskon);
              $('#mod_subtotal').html(data.subtotal);
              $('#mod_total').html(data.total);
              $('#mod_tunai').attr('harga', data.harga);
              $('#mod_tunai').data('id', data.kode_transaksi_plain);
              $('#tunai').val(data.tunai);
              $('#kembali').html(data.kembali);
              $('#mod_kirim_email').data('id', data.kode_transaksi_plain);
              $('#mod_cetak').data('id', data.kode_transaksi_plain);
              $('#mod_cetak').attr('potongan_harga', data.potongan_harga_plain);
              $('#mod_kirim').data('id', data.kode_transaksi_plain);

            },
            error       : function(xhr, status, error) {
                console.log('Error Message');
            }

        })

      })

      $('#table_blm').on('click', '.detailButton', function () {

        var id_tr       = $(this).data('id');

        console.log(id_tr);

        $.ajax({
            url         : "Report/detail/",
            method      : "POST",
            data        : {id_tr:id_tr},
            dataType    : "JSON",
            success     : function (data) {
              $('#mod_kode_transaksi').html(data.kode_transaksi);
              $('#mod_tgl_transaksi').html(data.tgl_transaksi);
              $('#mod_nomor_meja').html(data.nomor_meja);
              $('#mod_detail_string').html(data.detail_string);
              $('#mod_potongan_harga').html(data.potongan_harga);
              $('#mod_diskon').html(data.diskon);
              $('#mod_subtotal').html(data.subtotal);
              $('#mod_total').html(data.total);
              $('#mod_tunai').attr('harga', data.harga);
              $('#mod_tunai').data('id', data.kode_transaksi_plain);
              $('#tunai').val(data.tunai);
              $('#kembali').html(data.kembali);
              $('#mod_kirim_email').data('id', data.kode_transaksi_plain);
              $('#mod_cetak').data('id', data.kode_transaksi_plain);
              $('#mod_cetak').attr('potongan_harga', data.potongan_harga_plain);
              $('#mod_kirim').data('id', data.kode_transaksi_plain);

            },
            error       : function(xhr, status, error) {
                console.log('Error Message');
            }

        })

      })

    </script>