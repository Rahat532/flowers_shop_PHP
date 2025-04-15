<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
   header('location:login.php');
}

// Your existing PHP logic for wishlist and cart
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home |RCT Shop</title>
   
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
   
   <style>
     .hero-bg {
       background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg-1.jpg');
     }
     .product-card:hover .product-actions {
       opacity: 1;
       transform: translateY(0);
     }
   </style>
</head>
<body class="font-poppins bg-gray-50">
   
<?php @include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero-bg min-h-[70vh] bg-cover bg-center bg-no-repeat flex items-center justify-center text-white py-20 px-4">
   <div class="text-center max-w-4xl mx-auto">
      <h1 class="font-merienda text-4xl md:text-6xl font-bold mb-6 animate-fadeIn">New Collections</h1>
      <p class="text-lg md:text-xl mb-8 leading-relaxed max-w-2xl mx-auto">
         Discover our latest arrivals that blend style, comfort, and quality for your everyday needs.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
         <a href="shop.php" class="bg-primary hover:bg-pink-600 text-white font-medium py-3 px-8 rounded-full transition duration-300">
            Shop Now
         </a>
         <a href="about.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-medium py-3 px-8 rounded-full transition duration-300">
            Learn More
         </a>
      </div>
   </div>
</section>

<!-- Featured Products -->
<section class="py-16 px-4 max-w-7xl mx-auto">
   <div class="text-center mb-12">
      <h2 class="font-merienda text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Products</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">Handpicked selection of our newest arrivals</p>
   </div>

   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
         <div class="relative group">
         <img src="uploaded_img/<?php echo $fetch_products['image'] ? $fetch_products['image'] : 'flowers\beach florist.jpg'; ?>" alt="<?php echo $fetch_products['name']; ?>" class="w-full h-80 object-cover">

            
            <div class="product-actions absolute top-4 right-4 flex flex-col gap-2 opacity-0 transform translate-y-4 transition duration-300">
               <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="w-12 h-12 flex items-center justify-center bg-white rounded-full shadow-md text-gray-800 hover:bg-primary hover:text-white transition">
                  <i class="fas fa-eye"></i>
               </a>
               <button type="submit" name="add_to_wishlist" class="w-12 h-12 flex items-center justify-center bg-white rounded-full shadow-md text-gray-800 hover:bg-primary hover:text-white transition">
                  <i class="fas fa-heart"></i>
               </button>
            </div>
            
            <span class="absolute top-4 left-4 bg-primary text-white font-medium py-1 px-3 rounded-full">
               $<?php echo $fetch_products['price']; ?>
            </span>
         </div>
         
         <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-800"><?php echo $fetch_products['name']; ?></h3>
            
            <div class="flex items-center mb-4">
               <div class="flex text-amber-400">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <span class="text-gray-500 ml-2">(24 reviews)</span>
            </div>
            
            <input type="number" name="product_quantity" value="1" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-primary">
            
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            
            <button type="submit" name="add_to_cart" class="w-full bg-primary hover:bg-pink-600 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
               Add to Cart
            </button>
         </div>
      </form>
      <?php
            }
         } else {
            echo '<p class="text-gray-600 text-center col-span-full py-12">No products added yet!</p>';
         }
      ?>
   </div>

   <div class="text-center mt-12">
      <a href="shop.php" class="inline-block border-2 border-primary text-primary hover:bg-primary hover:text-white font-medium py-3 px-8 rounded-full transition duration-300">
         View All Products
      </a>
   </div>
</section>

<!-- Features/Benefits Section -->
<section class="py-16 bg-gray-100">
   <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
         <div class="bg-white p-8 rounded-xl shadow-sm text-center">
            <div class="w-16 h-16 bg-primary bg-opacity-10 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
               <i class="fas fa-truck text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Free Shipping</h3>
            <p class="text-gray-600">On all orders over $50</p>
         </div>
         
         <div class="bg-white p-8 rounded-xl shadow-sm text-center">
            <div class="w-16 h-16 bg-primary bg-opacity-10 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
               <i class="fas fa-undo text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Easy Returns</h3>
            <p class="text-gray-600">30-day return policy</p>
         </div>
         
         <div class="bg-white p-8 rounded-xl shadow-sm text-center">
            <div class="w-16 h-16 bg-primary bg-opacity-10 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
               <i class="fas fa-headset text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
            <p class="text-gray-600">Dedicated customer service</p>
         </div>
      </div>
   </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-4 bg-secondary text-white">
   <div class="max-w-4xl mx-auto text-center">
      <h2 class="font-merienda text-3xl md:text-4xl font-bold mb-6">Have any questions?</h2>
      <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
         Our team is here to help you with any questions about our products, shipping, or returns.
      </p>
      <a href="contact.php" class="inline-block bg-white text-gray-900 hover:bg-gray-200 font-medium py-3 px-8 rounded-full transition duration-300">
         Contact Us
      </a>
   </div>
</section>

<?php @include 'footer.php'; ?>

<!-- Script for animations -->
<script>
   
   document.addEventListener('DOMContentLoaded', () => {
      const animatedElements = document.querySelectorAll('.animate-fadeIn');
      animatedElements.forEach((el, index) => {
         setTimeout(() => {
            el.style.opacity = 1;
         }, index * 200);
      });
   });
</script>

</body>
</html>