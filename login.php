<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $message[] = 'No user found!';
      }

   }else{
      $message[] = 'Incorrect email or password!';
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

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
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-poppins min-h-screen flex items-center justify-center px-4">

   <?php
   if(isset($message)){
      foreach($message as $msg){
         echo '
         <div class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-100 text-red-700 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-4">
            <span>'.$msg.'</span>
            <i class="fas fa-times cursor-pointer" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <section class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-secondary mb-6 uppercase">Login Now</h2>

      <form action="" method="post" class="space-y-6">
         <div>
            <label for="email" class="block mb-1 text-gray-700 font-medium">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
         </div>

         <div>
            <label for="pass" class="block mb-1 text-gray-700 font-medium">Password</label>
            <input type="password" name="pass" id="pass" required placeholder="Enter your password"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
         </div>

         <button type="submit" name="submit"
            class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-pink-600 transition">Login Now</button>
      </form>

      <p class="mt-6 text-center text-gray-600 text-sm">Don't have an account? 
         <a href="register.php" class="text-primary font-medium hover:underline">Register now</a>
      </p>
   </section>

</body>
</html>
