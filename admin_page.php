<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

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
           fontSize: {
             'base': '1.125rem',
             'lg': '1.25rem',
             'xl': '1.5rem',
             '2xl': '1.875rem',
             '3xl': '2.25rem',
             '4xl': '3rem',
             '5xl': '4rem',
           }
         }
       }
     }
   </script>

   <link rel="stylesheet" href="css/admin_style.css">
</head>

<body class="bg-gray-100 font-poppins">

<?php @include 'admin_header.php'; ?>

<section class="dashboard px-6 py-16 min-h-screen">
   <h1 class="text-5xl font-extrabold text-secondary mb-16 text-center uppercase tracking-wider">Admin Dashboard</h1>

   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- Cards -->
      <?php
         function renderCard($title, $value, $color) {
            echo "
            <div class='bg-white rounded-2xl shadow-xl p-8 text-center hover:shadow-2xl transition transform hover:-translate-y-1 duration-300'>
               <h3 class='text-4xl font-bold text-[$color] mb-3'>".(is_numeric($value) ? "$".$value."/-" : $value)."</h3>
               <p class='text-lg text-gray-600 font-semibold'>$title</p>
            </div>
            ";
         }

         // Pendings
         $total_pendings = 0;
         $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
         while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
            $total_pendings += $fetch_pendings['total_price'];
         }
         renderCard("Total Pendings", $total_pendings, "#ec4899");

         // Completes
         $total_completes = 0;
         $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
         while($fetch_completes = mysqli_fetch_assoc($select_completes)){
            $total_completes += $fetch_completes['total_price'];
         }
         renderCard("Completed Payments", $total_completes, "#10b981");

         // Orders
         $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
         $number_of_orders = mysqli_num_rows($select_orders);
         renderCard("Orders Placed", $number_of_orders, "#111827");

         // Products
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         $number_of_products = mysqli_num_rows($select_products);
         renderCard("Products Added", $number_of_products, "#111827");

         // Users
         $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
         $number_of_users = mysqli_num_rows($select_users);
         renderCard("Normal Users", $number_of_users, "#111827");

         // Admins
         $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
         $number_of_admin = mysqli_num_rows($select_admin);
         renderCard("Admin Users", $number_of_admin, "#111827");

         // Accounts
         $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         $number_of_account = mysqli_num_rows($select_account);
         renderCard("Total Accounts", $number_of_account, "#111827");

         // Messages
         $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
         $number_of_messages = mysqli_num_rows($select_messages);
         renderCard("New Messages", $number_of_messages, "#111827");
      ?>
   </div>
</section>

<!-- Footer -->
<footer class="bg-secondary text-white py-8 mt-16">
   <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
      <p class="text-base">&copy; <?php echo date("Y"); ?> Admin Panel. All rights reserved.</p>
      <div class="flex space-x-6 mt-4 md:mt-0 text-base">
         <a href="#" class="hover:text-primary transition">Privacy Policy</a>
         <a href="#" class="hover:text-primary transition">Terms</a>
         <a href="#" class="hover:text-primary transition">Support</a>
      </div>
   </div>
</footer>

</body>
</html>
