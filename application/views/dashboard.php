<div class="container" style="margin-top: 25px;">
  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="card stretch-card mb-5 shadow">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <div class="hexagon">
              <div class="hex-mid hexagon-primary">
                <i class="mdi mdi-package"></i>
              </div>
            </div>
          </div>
          <h3 class="text-primary font-weight-bold">Produk</h3>
          <h3 class="text-primary font-weight-bold"><?php echo $produk ?></h3>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="card stretch-card mb-5 shadow">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <div class="hexagon">
              <div class="hex-mid hexagon-success">
                <i class="mdi mdi-google-circles-extended"></i>
              </div>
            </div>
          </div>
          <h3 class="text-success font-weight-bold">Kategori</h3>
          <h3 class="text-success font-weight-bold"><?php echo $kategori ?></h3>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="card stretch-card mb-5 shadow">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <div class="hexagon">
              <div class="hex-mid hexagon-warning">
                <i class="mdi mdi-cash"></i>
              </div>
            </div>
          </div>
          <h3 class="text-warning font-weight-bold">Pendapatan</h3>
          <h3 class="text-warning font-weight-bold">Rp. <?php echo number_format($pendapatan->total) ?></h3>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="card stretch-card mb-5 shadow">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <div class="hexagon">
              <div class="hex-mid hexagon-info">
                <i class="mdi mdi-margin"></i>
              </div>
            </div>
          </div>
          <?php  
          $profit   = 0;
          $hpp      = 0;
          $subtotal = 0;
          foreach($dt_profit as $row) {
            $hpp      += ($row->hpp*$row->jumlah);
            $subtotal += $row->subtotal;
          }
          $profit = $subtotal - $hpp;
          ?>
          <h3 class="text-info font-weight-bold">Profit</h3>
          <h3 class="text-info font-weight-bold">Rp. <?php echo number_format($profit) ?></h3>
        </div>
      </div>
    </div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<!-- 
<form id="form_upload_ttd_bar" autocomplete="off" method="post">
    <input type="hidden" name="id_rekon" id="id_rekon">
    <input type="hidden" name="nm_foto" id="nm_foto" value="kosong">
    <div class="modal-body">
        <div class="row" style="margin-top: 15px">
            <label class="col-12">Foto TTD Bar</label>
            <div class="col-md-12 align-items-center">
                <input type="text" name="id_karyawan" value="3210">
                <input type="file" id="foto" name="filegambar">
            </div>
        </div>    
    </div>
    <div class="modal-footer">
        
        <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
        <button class="btn btn-success" type="submit" id="simpan">Simpan</button>
    </div>
</form>

<script>
  $(document).ready(function () {

    // proses tambah tdd bar
    $('#form_upload_ttd_bar').on('submit', function () {

      $.ajax({
          url         : "http://localhost/cafe_api/C_absen/simpan_gambar_mobile/",
          type        : "post",
          data        : new FormData(this),
          processData : false,
          contentType : false,
          cache       : false,
          async       : false,
          dataType    : "JSON",
          success     : function (data) {

              console.log(data.pesan);

              location.reload();
              
          }
      })

      return false;

      })

  })
</script> -->