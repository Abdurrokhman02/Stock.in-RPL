<?php
  $page_title = 'Tambah Produk';
  require_once('includes/load.php');
  // Cek level user untuk mengakses halaman ini
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>

<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
   validate_fields($req_fields);
   
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
     $media_id = (!isset($_POST['product-photo']) || $_POST['product-photo'] === "") ? '0' : remove_junk($db->escape($_POST['product-photo']));

     // Cek apakah produk dengan nama yang sama sudah ada
     $check_query = "SELECT * FROM products WHERE name = '{$p_name}' LIMIT 1";
     $result = $db->query($check_query);

     if($db->num_rows($result) > 0){
       $session->msg("d", "Error: Produk dengan nama '{$p_name}' sudah ada.");
       redirect('add_product.php', false);
     } else {
       $query  = "INSERT INTO products (";
       $query .=" name, quantity, buy_price, sale_price, categorie_id, media_id, date";
       $query .=") VALUES (";
       $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', NOW()";
       $query .=")";
       if($db->query($query)){
         $session->msg('s',"Produk berhasil ditambahkan.");
         redirect('add_product.php', false);
       } else {
         $session->msg('d','Maaf, gagal menambahkan produk.');
         redirect('add_product.php', false);
       }
     }
   } else {
     $session->msg("d", $errors);
     redirect('add_product.php', false);
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
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Tambah Produk Baru</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_product.php" class="clearfix">
          <div class="form-group">
            <label for="product-title" class="control-label">Nama Produk</label>
            <input type="text" class="form-control" name="product-title">
          </div>
          <div class="form-group">
            <label for="product-categorie">Kategori</label>
            <select class="form-control" name="product-categorie">
              <option value="">Pilih Kategori</option>
              <?php foreach ($all_categories as $cat): ?>
                <option value="<?php echo (int)$cat['id'] ?>">
                  <?php echo $cat['name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="product-quantity">Jumlah</label>
            <input type="number" class="form-control" name="product-quantity">
          </div>
          <div class="form-group">
            <label for="buying-price">Harga Beli (Rp)</label>
            <input type="number" class="form-control" name="buying-price">
          </div>
          <div class="form-group">
            <label for="saleing-price">Harga Jual (Rp)</label>
            <input type="number" class="form-control" name="saleing-price">
          </div>
          <div class="form-group">
            <label for="product-photo">Foto Produk</label>
            <select class="form-control" name="product-photo">
              <option value="">Tanpa Gambar</option>
              <?php foreach ($all_photo as $photo): ?>
                <option value="<?php echo (int)$photo['id'] ?>">
                  <?php echo $photo['file_name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" name="add_product" class="btn btn-primary">Tambah Produk</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
