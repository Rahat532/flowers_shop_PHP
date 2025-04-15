<?php

@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

if (isset($_POST['add_to_wishlist'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_wishlist) > 0) {
      $message[] = 'Already added to wishlist';
   } elseif (mysqli_num_rows($check_cart) > 0) {
      $message[] = 'Already added to cart';
   } else {
      mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
      $message[] = 'Product added to wishlist';
   }
}

if (isset($_POST['add_to_cart'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart) > 0) {
      $message[] = 'Already added to cart';
   } else {
      $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

      if (mysqli_num_rows($check_wishlist) > 0) {
         mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
      }

      mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Product added to cart';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">

   <!-- Tailwind CSS -->
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
     tailwind.config = {
       theme: {
         extend: {
           colors: {
             primary: '#ec4899',
             secondary: '#111827',
             accent: '#10b981',
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
<body class="font-poppins bg-gray-50 text-secondary">

<?php @include 'header.php'; ?>

<section class="py-10 bg-gradient-to-r from-primary to-accent text-white text-center">
   <h3 class="text-4xl font-semibold">Our Shop</h3>
   <p class="text-lg mt-2">
      <a href="home.php" class="underline hover:text-gray-200">Home</a> / Shop
   </p>
</section>

<section class="py-16 px-4 lg:px-20">
   <h1 class="text-3xl font-semibold text-center mb-10 text-primary">Latest Products</h1>

   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($product = mysqli_fetch_assoc($select_products)) {
      ?>
      <form action="" method="POST" class="bg-white rounded-xl shadow-md p-4 flex flex-col justify-between relative group hover:shadow-lg transition">
         <a href="view_page.php?pid=<?php echo $product['id']; ?>" class="absolute top-2 right-2 text-gray-400 hover:text-primary">
            <i class="fas fa-eye"></i>
         </a>
         <img src="uploaded_img/<?php echo $product['image']; ?>" alt="" class="h-40 mx-auto object-contain mb-4">
         <div class="text-lg font-semibold mb-2"><?php echo $product['name']; ?></div>
         <div class="text-xl text-primary font-bold mb-2">$<?php echo $product['price']; ?>/-</div>
         <input type="number" name="product_quantity" value="1" min="1" class="w-full border border-gray-300 rounded-md px-2 py-1 mb-3 text-center focus:outline-none focus:ring-2 focus:ring-primary">
         <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
         <input type="submit" value="Add to Wishlist" name="add_to_wishlist" class="bg-pink-500 text-white py-2 rounded-md hover:bg-pink-600 transition mb-2 cursor-pointer">
         <input type="submit" value="Add to Cart" name="add_to_cart" class="bg-emerald-500 text-white py-2 rounded-md hover:bg-emerald-600 transition cursor-pointer">
      </form>
      <?php
            }
         } else {
            echo '<p class="text-center col-span-4 text-gray-500">No products added yet!</p>';
         }
      ?>
   </div>
</section>

<?php @include 'footer.php'; ?>

</body>
</html>
