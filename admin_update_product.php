<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

   mysqli_query($conn, "UPDATE `products` SET name = '$name', details = '$details', price = '$price' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
   
   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image file size is too large!';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('uploaded_img/'.$old_image);
         $message[] = 'image updated successfully!';
      }
   }

   $message[] = 'product updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body class="bg-gray-50 text-gray-800 font-poppins">

<?php @include 'admin_header.php'; ?>

<section class="update-product py-10 px-4 max-w-4xl mx-auto">
   <h1 class="text-3xl font-bold mb-6 text-center text-primary">Update Product</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){
   ?>

   <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-lg rounded-2xl p-8 space-y-6">
      <div class="flex justify-center">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="w-40 h-40 object-cover rounded" alt="Product Image">
      </div>
      <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
      <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">

      <div>
         <label class="block text-sm font-medium mb-1">Product Name</label>
         <input type="text" class="w-full border rounded px-3 py-2" value="<?php echo $fetch_products['name']; ?>" required name="name">
      </div>

      <div>
         <label class="block text-sm font-medium mb-1">Product Price</label>
         <input type="number" min="0" class="w-full border rounded px-3 py-2" value="<?php echo $fetch_products['price']; ?>" required name="price">
      </div>

      <div>
         <label class="block text-sm font-medium mb-1">Product Details</label>
         <textarea name="details" class="w-full border rounded px-3 py-2" required rows="5"><?php echo $fetch_products['details']; ?></textarea>
      </div>

      <div>
         <label class="block text-sm font-medium mb-1">Change Image (optional)</label>
         <input type="file" accept="image/jpg, image/jpeg, image/png" class="w-full border rounded px-3 py-2" name="image">
      </div>

      <div class="flex items-center justify-between">
         <input type="submit" value="Update Product" name="update_product" class="bg-primary text-white px-6 py-2 rounded hover:bg-pink-600 transition-all">
         <a href="admin_products.php" class="text-secondary hover:underline">← Go Back</a>
      </div>
   </form>

   <?php
         }
      }else{
         echo '<p class="text-center text-lg text-red-500">No product selected for update!</p>';
      }
   ?>
</section>

<script src="js/admin_script.js"></script>

</body>
</html>
