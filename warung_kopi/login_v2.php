<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<div class="login-page">
    <div class="text-center">
       <h1>Selamat Datang</h1>
       <p>Silakan masuk untuk memulai sesi Anda</p>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth_v2.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Nama Pengguna</label>
              <input type="name" class="form-control" name="username" placeholder="Nama Pengguna">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info pull-right">Masuk</button>
        </div>
    </form>
</div>
<?php include_once('layouts/header.php'); ?>
