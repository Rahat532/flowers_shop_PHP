<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
    header('location:wishlist.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>

     <!-- Fonts & Icons -->
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
   <!-- Tailwind CSS -->
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
     tailwind.config = {
       theme: {
         extend: {
           colors: {
             primary: '#ec4899', // pink-500
             secondary: '#111827', // gray-900
             accent: '#10b981', // emerald-500
           },
           fontFamily: {
             poppins: ['Poppins', 'sans-serif'],
             merienda: ['Merienda', 'cursive'],
           },
         }
       }
     }
   </script>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="py-12 px-4 bg-gray-50 min-h-screen">
   <div class="text-center mb-10">
      <h1 class="text-3xl font-bold text-gray-800">Your Wishlist</h1>
      <p class="text-gray-500 mt-2"><a href="home.php" class="text-blue-600 hover:underline">Home</a> / Wishlist</p>
   </div>

   <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 max-w-7xl mx-auto">
   <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_wishlist) > 0){
            while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
   ?>
   <form action="wishlist.php" method="POST" class="bg-white rounded-lg shadow-md p-5 relative flex flex-col items-center">
      <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="absolute top-3 right-3 text-red-500 hover:text-red-700" onclick="return confirm('Delete this from wishlist?');">
         <i class="fas fa-times"></i>
      </a>
      <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="absolute top-3 left-3 text-blue-500 hover:text-blue-700">
         <i class="fas fa-eye"></i>
      </a>
      <img src="uploaded_img/<?php echo $fetch_wishlist['image']; ?>" alt="" class="h-40 object-contain mb-4 rounded">
      <h2 class="text-lg font-semibold text-center"><?php echo $fetch_wishlist['name']; ?></h2>
      <p class="text-pink-600 font-bold mt-2">$<?php echo $fetch_wishlist['price']; ?>/-</p>

      <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">

      <input type="submit" value="Add to Cart" name="add_to_cart" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded w-full text-center cursor-pointer">
   </form>
   <?php
            $grand_total += $fetch_wishlist['price'];
        }
    } else {
        echo '<p class="text-center text-gray-500 text-lg col-span-full">Your wishlist is empty</p>';
    }
    ?>
   </div>

   <?php if($grand_total > 0): ?>
   <div class="mt-12 text-center">
      <p class="text-xl text-gray-700 mb-4">Grand Total: <span class="font-bold text-pink-600">$<?php echo $grand_total; ?>/-</span></p>
      <a href="shop.php" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded mr-4">Continue Shopping</a>
      <a href="wishlist.php?delete_all" onclick="return confirm('Delete all from wishlist?');"
         class="inline-block bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-6 rounded">
         Delete All
      </a>
   </div>
   <?php endif; ?>
</section>

<?php @include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
