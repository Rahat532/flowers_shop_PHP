<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'Message already sent!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'Message sent successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Tailwind CSS CDN -->
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

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-100 font-poppins">

<?php @include 'header.php'; ?>

<!-- Page Heading -->
<section class="text-center py-8 bg-white shadow">
   <h3 class="text-3xl font-bold text-secondary uppercase">Contact Us</h3>
   <p class="text-gray-500 mt-2">
      <a href="home.php" class="text-primary hover:underline">Home</a> / Contact
   </p>
</section>

<!-- Contact Form Section -->
<section class="py-12 px-4 flex justify-center">
   <form action="" method="POST" class="bg-white shadow-md border border-gray-200 max-w-2xl w-full rounded-xl p-8">
      <h3 class="text-2xl font-semibold text-secondary mb-6 uppercase text-center">Send Us a Message!</h3>
      
      <input type="text" name="name" placeholder="Enter your name"
         class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-lg" required>

      <input type="email" name="email" placeholder="Enter your email"
         class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-lg" required>

      <input type="number" name="number" placeholder="Enter your number"
         class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-lg" required>

      <textarea name="message" placeholder="Enter your message"
         class="w-full mb-6 px-5 py-3 h-40 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-lg resize-none" required></textarea>

      <input type="submit" name="send" value="Send Message"
         class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold hover:bg-pink-600 transition duration-300 cursor-pointer">
   </form>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
