<?php
  $page_title = 'Semua Kategori';
  require_once('includes/load.php');
  // Memeriksa level pengguna yang memiliki izin untuk mengakses halaman ini
  page_require_level(1);

  $all_categories = find_all('categories');
?>

<?php
 if (isset($_POST['add_cat'])) {
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if (empty($errors)) {
      $sql  = "INSERT INTO categories (name)";
      $sql .= " VALUES ('{$cat_name}')";
      if ($db->query($sql)) {
        $session->msg("s", "Kategori baru berhasil ditambahkan");
        redirect('categorie.php', false);
      } else {
        $session->msg("d", "Maaf, gagal menambahkan kategori.");
        redirect('categorie.php', false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('categorie.php', false);
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
  <!-- Form Tambah Kategori -->
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Tambah Kategori Baru</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="categorie.php">
          <div class="form-group">
            <input type="text" class="form-control" name="categorie-name" placeholder="Nama Kategori">
          </div>
          <button type="submit" name="add_cat" class="btn btn-primary">Tambah Kategori</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Tabel Semua Kategori -->
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Daftar Semua Kategori</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Kategori</th>
              <th class="text-center" style="width: 100px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_categories as $cat): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_categorie.php?id=<?php echo (int)$cat['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_categorie.php?id=<?php echo (int)$cat['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
