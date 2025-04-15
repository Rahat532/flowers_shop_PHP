<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    
    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist';
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist';
    }

}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

   <!-- custom admin css file link  -->
   <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>
<body>
   
<?php @include 'header.php'; ?>



<section class="quick-view py-10 px-4 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold text-center text-primary mb-10">Product Details</h1>

    <?php  
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_products)){
    ?>
    <form action="" method="POST" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="w-full h-64 object-contain rounded border border-gray-200">

        <div class="space-y-4">
            <div class="text-2xl font-bold text-gray-800"><?php echo $fetch_products['name']; ?></div>
            <div class="text-xl text-pink-600 font-semibold">$<?php echo $fetch_products['price']; ?>/-</div>
            <div class="text-gray-600"><?php echo $fetch_products['details']; ?></div>

            <div class="flex flex-col sm:flex-row items-center gap-4 mt-4">
                <input type="number" name="product_quantity" value="1" min="1" class="border border-gray-300 rounded px-4 py-2 w-full sm:w-32 text-center">
            </div>

            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <input type="submit" value="Add to Wishlist" name="add_to_wishlist" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded cursor-pointer w-full sm:w-auto">
                <input type="submit" value="Add to Cart" name="add_to_cart" class="bg-emerald-500 hover:bg-emerald-600 text-black px-6 py-2 rounded cursor-pointer w-full sm:w-auto">
            </div>
        </div>
    </form>
    <?php
                }
            } else {
                echo '<p class="text-center text-gray-500 text-lg">No product details available!</p>';
            }
        }
    ?>

    <div class="text-center mt-10">
        <a href="home.php" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded shadow">Go to Home Page</a>
    </div>

</section>







<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>