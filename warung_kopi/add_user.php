<?php
  $page_title = 'Tambah Pengguna';
  require_once('includes/load.php');
  // Memeriksa level pengguna yang memiliki izin untuk mengakses halaman ini
  page_require_level(1);
  $groups = find_all('user_groups');
?>

<?php
  if(isset($_POST['add_user'])){

    $req_fields = array('full-name','username','password','level' );
    validate_fields($req_fields);

    if(empty($errors)){
      $name        = remove_junk($db->escape($_POST['full-name']));
      $username    = remove_junk($db->escape($_POST['username']));
      $password    = remove_junk($db->escape($_POST['password']));
      $user_level  = (int)$db->escape($_POST['level']);
      $password    = sha1($password);

      $query  = "INSERT INTO users (";
      $query .= "name, username, password, user_level, status";
      $query .= ") VALUES (";
      $query .= "'{$name}', '{$username}', '{$password}', '{$user_level}', '1'";
      $query .= ")";

      if($db->query($query)){
        // berhasil
        $session->msg('s',"Akun pengguna berhasil dibuat!");
        redirect('add_user.php', false);
      } else {
        // gagal
        $session->msg('d','Maaf, gagal membuat akun!');
        redirect('add_user.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_user.php', false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Tambah Pengguna Baru</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="add_user.php">
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" name="full-name" placeholder="Nama Lengkap">
          </div>
          <div class="form-group">
            <label for="username">Nama Pengguna</label>
            <input type="text" class="form-control" name="username" placeholder="Nama Pengguna">
          </div>
          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
          </div>
          <div class="form-group">
            <label for="level">Peran Pengguna</label>
            <select class="form-control" name="level">
              <?php foreach ($groups as $group ):?>
                <option value="<?php echo $group['group_level'];?>">
                  <?php echo ucwords($group['group_name']);?>
                </option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="add_user" class="btn btn-primary">Tambah Pengguna</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
