<?php
  $page_title = 'Edit Akun';
  require_once('includes/load.php');
  page_require_level(3);
?>

<?php
// Proses unggah foto pengguna
if (isset($_POST['submit'])) {
  $photo = new Media();
  $user_id = (int)$_POST['user_id'];
  $photo->upload($_FILES['file_upload']);
  if ($photo->process_user($user_id)) {
    $session->msg('s','Foto berhasil diunggah.');
    redirect('edit_account.php');
  } else {
    $session->msg('d', join($photo->errors));
    redirect('edit_account.php');
  }
}
?>

<?php
// Proses update data pengguna
if (isset($_POST['update'])) {
  $req_fields = array('name','username');
  validate_fields($req_fields);

  if (empty($errors)) {
    $id = (int)$_SESSION['user_id'];
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));

    $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = $db->query($sql);

    if ($result && $db->affected_rows() === 1) {
      $session->msg('s',"Akun berhasil diperbarui.");
      redirect('edit_account.php', false);
    } else {
      $session->msg('d','Maaf, gagal memperbarui akun!');
      redirect('edit_account.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_account.php', false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-camera"></span>
        <span>Ganti Foto Saya</span>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4">
            <img class="img-circle img-size-2" src="uploads/users/<?php echo $user['image'];?>" alt="Foto Pengguna">
          </div>
          <div class="col-md-8">
            <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                <button type="submit" name="submit" class="btn btn-warning">Ganti</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit Akun Saya</span>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
          <div class="form-group">
            <label for="name" class="control-label">Nama</label>
            <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
          </div>
          <div class="form-group">
            <label for="username" class="control-label">Nama Pengguna</label>
            <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
          </div>
          <div class="form-group clearfix">
            <a href="change_password.php" title="Ganti Kata Sandi" class="btn btn-danger pull-right">Ganti Kata Sandi</a>
            <button type="submit" name="update" class="btn btn-info">Perbarui</button>
