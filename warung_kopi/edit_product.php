<?php
  $page_title = 'Edit Produk';
  require_once('includes/load.php');
  // Memeriksa level izin pengguna
  page_require_level(2);
?>
<?php
$produk = find_by_id('products', (int)$_GET['id']);
$semua_kategori = find_all('categories');
$semua_foto = find_all('media');
if (!$produk) {
  $session->msg("d", "ID produk tidak ditemukan.");
  redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
  $field_wajib = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
  validate_fields($field_wajib);

  if (empty($errors)) {
    $nama_produk  = remove_junk($db->escape($_POST['product-title']));
    $kategori_id  = (int)$_POST['product-categorie'];
    $jumlah       = remove_junk($db->escape($_POST['product-quantity']));
    $harga_beli   = remove_junk($db->escape($_POST['buying-price']));
    $harga_jual   = remove_junk($db->escape($_POST['saleing-price']));

    $media_id = empty($_POST['product-photo']) ? '0' : remove_junk($db->escape($_POST['product-photo']));

    $query  = "UPDATE products SET";
    $query .= " name='{$nama_produk}', quantity='{$jumlah}',";
    $query .= " buy_price='{$harga_beli}', sale_price='{$harga_jual}', categorie_id='{$kategori_id}', media_id='{$media_id}'";
    $query .= " WHERE id='{$produk['id']}'";
    $hasil = $db->query($query);

    if ($hasil && $db->affected_rows() === 1) {
      $session->msg('s', "Produk berhasil diperbarui.");
      redirect('product.php', false);
    } else {
      $session->msg('d', 'Maaf, gagal memperbarui produk!');
      redirect('edit_product.php?id=' . $produk['id'], false);
    }

  } else {
    $session->msg("d", $errors);
    redirect('edit_product.php?id=' . $produk['id'], false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Edit Produk</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_product.php?id=<?php echo (int)$produk['id'] ?>">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($produk['name']); ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="product-categorie">
                  <option value="">Pilih Kategori</option>
                  <?php foreach ($semua_kategori as $kat): ?>
                    <option value="<?php echo (int)$kat['id']; ?>" <?php if ($produk['categorie_id'] === $kat['id']) echo "selected"; ?>>
                      <?php echo remove_junk($kat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value="">Tanpa Gambar</option>
                  <?php foreach ($semua_foto as $foto): ?>
                    <option value="<?php echo (int)$foto['id']; ?>" <?php if ($produk['media_id'] === $foto['id']) echo "selected"; ?>>
                      <?php echo $foto['file_name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="qty">Jumlah</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                  </span>
                  <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($produk['quantity']); ?>">
                </div>
              </div>
              <div class="col-md-4">
                <label for="qty">Harga Beli</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($produk['buy_price']); ?>">
                  <span class="input-group-addon">.00</span>
                </div>
              </div>
              <div class="col-md-4">
                <label for="qty">Harga Jual</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($produk['sale_price']); ?>">
                  <span class="input-group-addon">.00</span>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="product" class="btn btn-danger">Perbarui</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
