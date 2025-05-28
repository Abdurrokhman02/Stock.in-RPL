<?php
  $page_title = 'Laporan Penjualan Harian';
  require_once('includes/load.php');
  // Cek level akses pengguna
  page_require_level(3);
?>

<?php
 $tahun  = date('Y');
 $bulan = date('m');
 $penjualan = dailySales($tahun, $bulan);
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg ?? ''); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Laporan Penjualan Harian</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">No</th>
              <th>Nama Produk</th>
              <th class="text-center" style="width: 15%;">Jumlah Terjual</th>
              <th class="text-center" style="width: 15%;">Total Penjualan</th>
              <th class="text-center" style="width: 15%;">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($penjualan)): ?>
              <?php foreach ($penjualan as $index => $jual): ?>
                <tr>
                  <td class="text-center"><?php echo $index + 1; ?></td>
                  <td><?php echo remove_junk($jual['name'] ?? 'Produk Tidak Diketahui'); ?></td>
                  <td class="text-center"><?php echo (int)($jual['total_qty'] ?? 0); ?></td>
                  <td class="text-center">Rp<?php echo number_format($jual['total_saleing_price'] ?? 0); ?></td>
                  <td class="text-center"><?php echo $jual['date'] ?? '-'; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Tidak ada data penjualan hari ini</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>