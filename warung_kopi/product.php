<?php
  $page_title = 'Semua Produk';
  require_once('includes/load.php');
  // Cek level user yang memiliki izin melihat halaman ini
  page_require_level(2);

  // Logika untuk Pencarian
  $search = isset($_GET['search']) ? $_GET['search'] : '';

  // Logika untuk Paginasi
  $limit = 10; // Jumlah produk per halaman
  $total_products_result = count_products($search);
  $total_products = isset($total_products_result['total']) ? (int)$total_products_result['total'] : 0;
  $total_pages = ceil($total_products / $limit);

  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  if ($current_page < 1) {
    $current_page = 1;
  } elseif ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
  }

  $offset = ($current_page - 1) * $limit;

  // Mengambil data produk dengan paginasi dan pencarian
  $products = join_product_table($limit, $offset, $search);
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-left" style="width: 60%;">
            <form method="get" action="product.php" class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari Nama Produk..." value="<?php echo htmlspecialchars($search); ?>" style="width: 300px;">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                        </span>
                    </div>
                </div>
            </form>
         </div>
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Tambah Baru</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Foto</th>
                <th> Nama Produk </th>
                <th class="text-center" style="width: 10%;"> Kategori </th>
                <th class="text-center" style="width: 10%;"> Stok </th>
                <th class="text-center" style="width: 10%;"> Harga Beli </th>
                <th class="text-center" style="width: 10%;"> Harga Jual </th>
                <th class="text-center" style="width: 10%;"> Produk Ditambahkan </th>
                <th class="text-center" style="width: 100px;"> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php 
                // Inisialisasi nomor urut berdasarkan halaman saat ini
                $i = $offset + 1; 
                foreach ($products as $product):
              ?>
              <tr>
                <td class="text-center"><?php echo $i++;?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Hapus" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
          <?php if ($total_pages > 1): ?>
          <div class="text-center">
              <ul class="pagination">
                  <?php if ($current_page > 1): ?>
                      <li><a href="product.php?page=<?php echo $current_page - 1; ?><?php if(!empty($search)) echo '&search='.$search; ?>">&laquo;</a></li>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                      <li class="<?php if ($i == $current_page) echo 'active'; ?>">
                          <a href="product.php?page=<?php echo $i; ?><?php if(!empty($search)) echo '&search='.$search; ?>"><?php echo $i; ?></a>
                      </li>
                  <?php endfor; ?>
                  
                  <?php if ($current_page < $total_pages): ?>
                      <li><a href="product.php?page=<?php echo $current_page + 1; ?><?php if(!empty($search)) echo '&search='.$search; ?>">&raquo;</a></li>
                  <?php endif; ?>
              </ul>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>