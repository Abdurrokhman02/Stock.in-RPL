<?php
  $page_title = 'Beranda Admin';
  require_once('includes/load.php');
  // Memeriksa level pengguna yang memiliki izin untuk mengakses halaman ini
  page_require_level(1);
?>

<?php
  $c_categorie     = count_by_id('categories');
  $c_product       = count_by_id('products');
  $c_sale          = count_by_id('sales');
  $c_user          = count_by_id('users');
  $products_sold   = find_higest_saleing_product('10');
  $recent_products = find_recent_product_added('5');
  $recent_sales    = find_recent_sale_added('5');
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <a href="users.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"><?php echo $c_user['total']; ?></h2>
          <p class="text-muted">Pengguna</p>
        </div>
      </div>
    </div>
  </a>

  <a href="categorie.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"><?php echo $c_categorie['total']; ?></h2>
          <p class="text-muted">Kategori</p>
        </div>
      </div>
    </div>
  </a>

  <a href="product.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"><?php echo $c_product['total']; ?></h2>
          <p class="text-muted">Produk</p>
        </div>
      </div>
    </div>
  </a>

  <a href="sales.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-usd"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"><?php echo $c_sale['total']; ?></h2>
          <p class="text-muted">Penjualan</p>
        </div>
      </div>
    </div>
  </a>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Produk Terlaris</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Total Terjual</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as $product_sold): ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Penjualan Terbaru</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Nama Produk</th>
              <th>Tanggal</th>
              <th>Total Penjualan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($recent_sales as $recent_sale): ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo remove_junk(first_character($recent_sale['name'])); ?></td>
                <td><?php echo date("d-m-Y", strtotime($recent_sale['date'])); ?></td>
                <td>Rp<?php echo number_format($recent_sale['price'], 0, ',', '.'); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bagian Produk Terbaru -->
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Produk Terbaru</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Tanggal Ditambahkan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_products as $recent): ?>
              <tr>
                <td><?php echo remove_junk(first_character($recent['name'])); ?></td>
                <td><?php echo date("d-m-Y", strtotime($recent['date'])); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
