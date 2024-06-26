<?php
include 'koneksi.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST['update_cart'])) {
  $id_cart = $_POST['id_cart'];
  $cart_jumlah = $_POST['jumlah_events'];
  mysqli_query($con, "UPDATE `cart` SET jumlah_events = '$cart_jumlah' WHERE id_cart = '$id_cart'") or die('query gagal');
  $message[] = 'Quantity Updated!';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($con, "DELETE FROM `cart` WHERE id_cart = '$delete_id'") or die('query gagal');
  header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
  mysqli_query($con, "DELETE FROM `cart` WHERE id_user = '$user_id'") or die('query gagal');
  header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart | TorajaFest</title>

  <!-- CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;1,200&display=swap");

  * {
    font-family: "Poppins", sans-serif;
  }

  .headings {
    min-height: 40vh;
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    background: url(cart.jpg) no-repeat;
    background-size: cover;
    background-position: center;
    text-align: center;

  }

  .pags {

    min-width: 10vh;
    height: 30px;
    padding: 3px 3px 3px;
    background-color: #EEEEEE;

  }

  a {
    color: #19376d;
  }

  a:hover {
    color: black;
  }

  .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }

  .box {
    border: 1px solid #ced4da;
    border-radius: 5px;
    overflow: hidden;
    width: 300px;
    padding: 10px;
  }

  .event-details img {
    width: 100%;
    height: auto;
  }

  .name {
    font-weight: bold;
    margin-top: 10px;
  }

  .price {
    color: #007bff;
  }

  .quantity {
    margin-top: 10px;
  }

  .quantity label {
    display: block;
    margin-bottom: 5px;
  }

  .sub-total {
    margin-top: 10px;
  }

  .delete-btn {
    color: red;
    cursor: pointer;
    float: right;
  }
</style>

<body>
  <?php include('header.php') ?>
  <div class="headings">
    <h1 class="text-white fs-1 fw-bolder text-uppercase">Toraja In Art & Culture Festival Cart</h1>
    <div class="pags rounded" aria-label="breadcrumb">
      <ol class="breadcrumb ">
        <li class="breadcrumb-item "><a href="home.php" class="text-decoration-none fs-bold fs-5">Home</a></li>
        <li class="breadcrumb-item active text-decoration-none fs-bold fs-5" aria-current="page">Cart</li>
      </ol>
    </div>
  </div>

  <section class="shopping-cart">

    <h1 class="title">Events Added</h1>

    <div class="box-container">
      <?php
      $grand_total = 0;
      $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE id_user = '$user_id'") or die('query gagal');
      if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
      ?>
          <div class="box">
            <a href="cart.php?delete=<?php echo $fetch_cart['id_cart']; ?>" class="delete-btn" onclick="return confirm('Delete this from cart?');"><i class="bi bi-trash"></i></a>
            <div class="event-details">
              <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
              <div class="name"><?php echo $fetch_cart['nama']; ?></div>
              <div class="price">Rp <?php echo $fetch_cart['harga_events']; ?>/-</div>
              <form action="" method="post">
                <input type="hidden" name="id_cart" value="<?php echo $fetch_cart['id_cart']; ?>">
                <div class="quantity">
                  <label for="quantity">Quantity:</label>
                  <input type="number" min="1" max="100" name="jumlah_events" value="<?php echo $fetch_cart['jumlah_events']; ?>">
                </div>
                <input type="submit" name="update_cart" value="Update" class="option-btn">
              </form>
              <div class="sub-total"> Sub total : <span>Rp <?php echo $sub_total = ($fetch_cart['jumlah_events'] * $fetch_cart['harga_events']); ?>/-</span> </div>
            </div>
          </div>
      <?php
            $grand_total += $sub_total;
          }
        } else {
          echo '<p class="empty">Your cart is empty</p>';
        }
        ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from cart?');">Delete all</a>
    </div>

    <div class="cart-total">
      <p>Total Purchase: <span>Rp <?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
        <!-- <a href="shop-event.php" class="option-btn">continue shopping</a> -->
        <a href="checkout.php" class="btn btn-secondary text-decoration-none<?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to checkout</a>
      </div>
    </div>

  </section>

  <?php include('footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
