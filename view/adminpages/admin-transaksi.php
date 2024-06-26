<?php
include 'koneksi.php';

session_start();
$user_id = $_SESSION['admin_id'];

if (!isset($user_id)) {
  header('location:login.php');
}


if (isset($_POST['update_transaksi'])) {
  $transaksi_update_id = $_POST['id_transaksi'];
  $update_pembayaran = $_POST['update_payment'];
  mysqli_query($con, "UPDATE `transaksi` SET status_pembayaran = '$update_pembayaran' WHERE id_transaksi = '$transaksi_update_id'") or die('query gagal');
  $message[] = 'Payment status has been updated!';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($con, "DELETE FROM `transaksi` WHERE id_transaksi = '$delete_id'") or die('query gagal');
  header('location:admin-transaksi.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi Users</title>
  <!-- CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    /* CSS untuk memperbaiki tampilan responsif kotak transaksi */
    .box {
      border: 1px solid #dee2e6;
      border-radius: .25rem;
      padding: 15px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <?php include('admin-header.php') ?>

  <h1 class="text-center m-5">TRANSAKSI</h1>
  <section class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php
        $select_transaksi = mysqli_query($con, "SELECT * FROM `transaksi`") or die('query gagal');
        if (mysqli_num_rows($select_transaksi) > 0) {
          while ($fetch_transaksi = mysqli_fetch_assoc($select_transaksi)) {
        ?>
            <div class="col-12">
              <div class="box">
                <!-- Kode HTML untuk menampilkan informasi transaksi -->
                <p> User id: <span><?php echo $fetch_transaksi['id_user']; ?></span> </p>
                <p> Date: <span><?php echo $fetch_transaksi['tgl_transaksi']; ?></span> </p>
                <p> Name : <span><?php echo $fetch_transaksi['nama']; ?></span> </p>
                <p> Number : <span><?php echo $fetch_transaksi['no_tlpn']; ?></span> </p>
                <p> Email : <span><?php echo $fetch_transaksi['email']; ?></span> </p>
                <p> Address : <span><?php echo $fetch_transaksi['alamat']; ?></span> </p>
                <p> Total products : <span><?php echo $fetch_transaksi['total_events']; ?></span> </p>
                <p> Total price : <span>Rp <?php echo $fetch_transaksi['total_harga']; ?>/-</span> </p>
                <p> Payment method : <span><?php echo $fetch_transaksi['metode_pembayaran']; ?></span> </p>
                <!-- Form untuk mengubah status pembayaran -->
                <form action="" method="post">
                  <input type="hidden" name="id_transaksi" value="<?php echo $fetch_transaksi['id_transaksi']; ?>">
                  <select name="update_payment">
                    <option value="" selected disabled><?php echo $fetch_transaksi['status_pembayaran']; ?></option>
                    <option value="Pending">Pending</option>
                    <option value="Update">Update</option>
                  </select>
                  <input type="submit" value="Update" name="update_transaksi" class="option-btn">
                  <!-- Perbaiki tautan untuk menghapus transaksi -->
                  <a href="admin-transaksi.php?delete=<?php echo $fetch_transaksi['id_transaksi']; ?>" onclick="return confirm('Delete this transaction?');" class="delete-btn">Delete</a>
                </form>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty text-center">No Transactions Yet!</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
