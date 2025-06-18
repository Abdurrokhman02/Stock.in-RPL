<?php
  $page_title = 'Edit Kategori';
  require_once('includes/load.php');
  // Mengecek level user yang memiliki izin untuk melihat halaman ini
  page_require_level(1);
?>
<?php
  // Menampilkan semua data kategori.
  $kategori = find_by_id('categories',(int)$_GET['id']);
  if(!$kategori){
    $session->msg("d","ID kategori tidak ditemukan.");
    redirect('categorie.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $nama_kategori = remove_junk($db->escape($_POST['categorie-name']));
  if(empty($errors)){
        $sql = "UPDATE categories SET name='{$nama_kategori}'";
        $sql .= " WHERE id='{$kategori['id']}'";
        $result = $db->query($sql);
        if($result && $db->affected_rows() === 1) {
            $session->msg("s", "Berhasil memperbarui kategori.");
            redirect('categorie.php',false);
        } else {
            $session->msg("d", "Maaf! Gagal memperbarui data.");
            redirect('categorie.php',false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('categorie.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Edit Kategori: <?php echo remove_junk(ucfirst($kategori['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_categorie.php?id=<?php echo (int)$kategori['id']; ?>">
           <div class="form-group">
               <input type="text" class="form-control" name="categorie-name" value="<?php echo remove_junk(ucfirst($kategori['name'])); ?>">
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Perbarui Kategori</button>
         </form>
       </div>
     </div>
   </div>
</div>

<?php include_once('layouts/footer.php'); ?>
