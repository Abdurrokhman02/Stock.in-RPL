<?php
  $page_title = 'Penjualan Bulanan';
  require_once('includes/load.php');
  // Mengecek level user yang memiliki izin untuk melihat halaman ini
  page_require_level(3);
?>
<?php
  $year = date('Y');
  $sales = monthlySales($year);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Penjualan Bulanan</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Nama Produk</th>
              <th class="text-center" style="width: 15%;">Jumlah Terjual</th>
              <th class="text-center" style="width: 15%;">Total Harga Jual</th>
              <th class="text-center" style="width: 15%;">Bulan & Tahun</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              // PERBAIKAN 1: Buat variabel counter untuk penomoran baris
              $i = 1; 
              foreach ($sales as $sale): 
            ?>
            <tr>
              <?php // PERBAIKAN 2: Gunakan counter, bukan fungsi count_id() ?>
              <td class="text-center"><?php echo $i++; ?></td>
              
              <?php // PERBAIKAN 3: Ganti key dari 'name' menjadi 'product_name' ?>
              <td><?php echo remove_junk($sale['product_name']); ?></td>
              
              <?php // PERBAIKAN 4: Ganti key dari 'qty' menjadi 'total_qty' ?>
              <td class="text-center"><?php echo (int)$sale['total_qty']; ?></td>
              
              <?php // Key ini sudah benar (meskipun ada typo di fungsi aslinya) ?>
              <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
              
              <?php // PERBAIKAN 5: Ganti 'date' menjadi 'month_year' atau 'bulan' ?>
              <td class="text-center"><?php echo $sale['month_year']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>