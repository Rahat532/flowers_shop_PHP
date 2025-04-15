<?php

@include 'config.php';

if(isset($_POST['submit'])){
   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
   
   <!-- Tailwind CSS -->
   <script src="https://cdn.tailwindcss.com"></script>

   <style>
     .gradient-bg {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
     }

     .message {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #ff4d4d;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 9999;
     }
   </style>

</head>
<body class="gradient-bg min-h-screen flex justify-center items-center">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times ml-4 cursor-pointer" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- Keep everything before unchanged -->
<section class="form-container bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
   <form id="registerForm" action="" method="post" class="space-y-6" onsubmit="return validateForm()">
      <h3 class="text-3xl font-bold text-center text-gray-800">Register Now</h3>

      <input type="text" name="name" id="name" class="w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500" placeholder="Enter your username" required>

      <input type="email" name="email" id="email" class="w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500" placeholder="Enter your email" required>

      <input type="password" name="pass" id="pass" class="w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500" placeholder="Enter your password" required>

      <input type="password" name="cpass" id="cpass" class="w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500" placeholder="Confirm your password" required>

      <button type="submit" name="submit" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300">Register Now</button>

      <p class="text-center text-sm text-gray-600">Already have an account? <a href="login.php" class="text-indigo-600 hover:underline">Login Now</a></p>
   </form>
</section>

<!-- JavaScript Validation Script -->
<script>
function validateForm() {
   const name = document.getElementById('name').value.trim();
   const email = document.getElementById('email').value.trim();
   const pass = document.getElementById('pass').value.trim();
   const cpass = document.getElementById('cpass').value.trim();

   const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
   const namePattern = /^[A-Za-z\s]+$/; // Only letters and spaces

   if (name === '' || email === '' || pass === '' || cpass === '') {
      alert('Please fill in all the fields.');
      return false;
   }

   if (!namePattern.test(name)) {
      alert('Name must contain only letters and spaces.');
      return false;
   }

   if (!emailPattern.test(email)) {
      alert('Please enter a valid email address.');
      return false;
   }

   if (pass.length < 8) {
      alert('Password must be at least 8 characters long.');
      return false;
   }

   if (pass !== cpass) {
      alert('Passwords do not match.');
      return false;
   }

   return true;
}

</script>


</body>
</html>
