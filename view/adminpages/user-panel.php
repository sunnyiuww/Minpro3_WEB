<?php
include 'koneksi.php';
session_start();
$user_id = $_SESSION['admin_id'];
if (!isset($user_id)) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Panel</title>
  <!-- CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    /* CSS tambahan untuk penyesuaian */
    .box {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <?php include('admin-header.php') ?>

  <h1 class="text-center">USER PANEL</h1>

  <section class="container">
    <div class="row">
      <?php
      $select_users = mysqli_query($con, "SELECT * FROM `user`") or die('query gagal');
      while ($fetch_users = mysqli_fetch_assoc($select_users)) {
      ?>
        <div class="col-md-4">
          <div class="box">
            <p> USER ID : <span><?php echo $fetch_users['id_user']; ?></span> </p>
            <p> Name : <span><?php echo $fetch_users['nama']; ?></span> </p>
            <p> Password : <span><?php echo $fetch_users['password']; ?></span> </p>
            <p> Gender : <span><?php echo $fetch_users['jenis_kelamin']; ?></span> </p>
            <p> Phone Number : <span><?php echo $fetch_users['no_tlpn']; ?></span> </p>
            <p> Email : <span><?php echo $fetch_users['email']; ?></span> </p>
            <p> Type User : <span style="color:<?php if ($fetch_users['user_type'] == 'admin') { echo 'color:blue;'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
            <a href="admin-user.php?delete=<?php echo $fetch_users['id_user']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete</a>
          </div>
        </div>
      <?php
      };
      ?>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
