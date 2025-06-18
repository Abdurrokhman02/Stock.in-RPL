<?php
$page_title = 'Laporan Penjualan';
require_once('includes/load.php');
// Cek level user yang memiliki izin untuk melihat halaman ini
page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">
        <!-- Bisa ditambahkan judul panel di sini jika diperlukan -->
      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Rentang Tanggal</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="Dari">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="Sampai">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Buat Laporan</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
