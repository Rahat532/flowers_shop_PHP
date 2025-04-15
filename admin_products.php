<?php

@include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $unique_image_name = time() . '_' . basename($image); // Prevent overwrite
    $image_folder = 'uploaded_img/' . $unique_image_name;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists!';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, image) VALUES('$name', '$details', '$price', '$unique_image_name')") or die('query failed');

        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully!';
            }
        }
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');

    if ($fetch_delete_image = mysqli_fetch_assoc($select_delete_image)) {
        $image_path = 'uploaded_img/' . $fetch_delete_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

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

   <!-- Custom Admin CSS -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

<?php @include 'admin_header.php'; ?>

<section class="add-products p-6 bg-gray-50">
   <form action="" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
      <h3 class="text-2xl font-semibold mb-4 text-center">Add New Product</h3>
      <input type="text" class="box w-full mb-3 p-2 border rounded" required placeholder="Enter product name" name="name">
      <input type="number" min="0" class="box w-full mb-3 p-2 border rounded" required placeholder="Enter product price" name="price">
      <textarea name="details" class="box w-full mb-3 p-2 border rounded" required placeholder="Enter product details" cols="30" rows="5"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box w-full mb-4" name="image">
      <input type="submit" value="Add Product" name="add_product" class="btn w-full bg-primary text-white p-2 rounded hover:bg-pink-600">
   </form>
</section>

<section class="show-products p-6">
   <div class="box-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <div class="box bg-white p-4 shadow rounded text-center">
         <div class="price text-xl font-bold text-primary mb-2">$<?php echo $fetch_products['price']; ?>/-</div>
         <img class="image w-full h-48 object-cover mb-2" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name font-semibold text-lg mb-1"><?php echo $fetch_products['name']; ?></div>
         <div class="details text-sm text-gray-600 mb-3"><?php echo $fetch_products['details']; ?></div>
         <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn inline-block px-4 py-2 bg-accent text-white rounded hover:bg-green-600 mr-2">Update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700" onclick="return confirm('Delete this product?');">Delete</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty col-span-3 text-center text-gray-500">No products added yet!</p>';
      }
      ?>
   </div>
</section>

</body>
</html>













<script src="js/admin_script.js"></script>

</body>
</html>