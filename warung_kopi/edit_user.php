<?php
  $page_title = 'Edit Pengguna';
  require_once('includes/load.php');
  // Periksa level pengguna yang memiliki izin untuk melihat halaman ini
  page_require_level(1);
?>
<?php
  $e_user = find_by_id('users',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_user){
    $session->msg("d","ID pengguna tidak ditemukan.");
    redirect('users.php');
  }
?>

<?php
// Update informasi dasar pengguna
if(isset($_POST['update'])) {
  $req_fields = array('name','username','level');
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$e_user['id'];
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));
    $level = (int)$db->escape($_POST['level']);
    $status = remove_junk($db->escape($_POST['status']));
    $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Akun berhasil diperbarui.");
      redirect('edit_user.php?id='.(int)$e_user['id'], false);
    } else {
      $session->msg('d','Maaf, gagal memperbarui akun!');
      redirect('edit_user.php?id='.(int)$e_user['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id='.(int)$e_user['id'],false);
  }
}
?>

<?php
// Update password pengguna
if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$e_user['id'];
    $password = remove_junk($db->escape($_POST['password']));
    $h_pass = sha1($password);
    $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Password pengguna berhasil diperbarui.");
      redirect('edit_user.php?id='.(int)$e_user['id'], false);
    } else {
      $session->msg('d','Maaf, gagal memperbarui password!');
      redirect('edit_user.php?id='.(int)$e_user['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id='.(int)$e_user['id'],false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Perbarui Akun <?php echo remove_junk(ucwords($e_user['name'])); ?>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
          <div class="form-group">
            <label for="name" class="control-label">Nama</label>
            <input type="text" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
          </div>
          <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
          </div>
          <div class="form-group">
            <label for="level">Peran Pengguna</label>
            <select class="form-control" name="level">
              <?php foreach ($groups as $group ):?>
                <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status">
              <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?> value="1">Aktif</option>
              <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Tidak Aktif</option>
            </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update" class="btn btn-info">Perbarui</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Form ganti password -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Ganti Password <?php echo remove_junk(ucwords($e_user['name'])); ?>
        </strong>
      </div>
      <div class="panel-body">
        <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
            <label for="password" class="control-label">Password Baru</label>
            <input type="password" class="form-control" name="password" placeholder="Ketik password baru">
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update-pass" class="btn btn-danger pull-right">Ganti</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
