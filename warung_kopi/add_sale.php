<?php
  $page_title = 'Tambah Penjualan';
  require_once('includes/load.php');
  // Cek level pengguna yang memiliki izin untuk mengakses halaman ini
  page_require_level(3);
  // Mengambil semua produk untuk ditampilkan dalam daftar
  $products_for_listing = join_product_table();
?>

<?php
  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);

    if(empty($errors)){
      $p_id      = $db->escape((int)$_POST['s_id']);
      $s_qty     = $db->escape((int)$_POST['quantity']);
      $s_total   = $db->escape($_POST['total']);
      $date      = $db->escape($_POST['date']);
      $s_date    = make_date();

      $sql  = "INSERT INTO sales (";
      $sql .= " product_id, qty, price, date";
      $sql .= ") VALUES (";
      $sql .= "'{$p_id}', '{$s_qty}', '{$s_total}', '{$s_date}'";
      $sql .= ")";

      if($db->query($sql)){
        update_product_qty($s_qty, $p_id);
        $session->msg('s', "Penjualan berhasil ditambahkan.");
        redirect('add_sale.php', false);
      } else {
        $session->msg('d', 'Maaf, gagal menambahkan penjualan!');
        redirect('add_sale.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_sale.php', false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Cari</button>
          </span>
          <input type="text" id="sug_input" class="form-control" name="title" placeholder="Cari nama produk...">
        </div>
        <div id="result" class="list-group"></div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Form Tambah Penjualan</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
          <table class="table table-bordered">
            <thead>
              <th>Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </thead>
            <tbody id="product_info"> </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th-list"></span>
          <span>Daftar Data Barang</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Nama Produk</th>
              <th class="text-center" style="width: 15%;">Stok Tersedia</th>
              <th class="text-center" style="width: 15%;">Harga Jual</th>
              <th class="text-center" style="width: 15%;">Kategori</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products_for_listing as $index => $product): ?>
            <tr>
              <td class="text-center"><?php echo $index + 1; ?></td>
              <td><?php echo remove_junk($product['name']); ?></td>
              <td class="text-center"><?php echo remove_junk($product['quantity']); ?></td>
              <td class="text-center"><?php echo remove_junk($product['sale_price']); ?></td>
              <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>