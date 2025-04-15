<?php

@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

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

<body class="font-poppins bg-gray-100 text-secondary">

<?php @include 'header.php'; ?>

<section class="py-10 bg-gradient-to-r from-primary to-accent text-white text-center">
    <h3 class="text-4xl font-Merienda">Your Orders</h3>
    <p class="text-lg mt-2">
        <a href="home.php" class="text-white underline hover:text-gray-200">Home</a> / Order
    </p>
</section>

<section class="py-16 px-4 lg:px-32">
    <h1 class="text-3xl font-Merienda text-center mb-10">Placed Orders</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
        ?>
        <div class="bg-white rounded-xl shadow-lg p-6 space-y-3">
            <p><span class="font-semibold">Placed On:</span> <?php echo $fetch_orders['placed_on']; ?></p>
            <p><span class="font-semibold">Name:</span> <?php echo $fetch_orders['name']; ?></p>
            <p><span class="font-semibold">Number:</span> <?php echo $fetch_orders['number']; ?></p>
            <p><span class="font-semibold">Email:</span> <?php echo $fetch_orders['email']; ?></p>
            <p><span class="font-semibold">Address:</span> <?php echo $fetch_orders['address']; ?></p>
            <p><span class="font-semibold">Payment Method:</span> <?php echo $fetch_orders['method']; ?></p>
            <p><span class="font-semibold">Your Orders:</span> <?php echo $fetch_orders['total_products']; ?></p>
            <p><span class="font-semibold">Total Price:</span> $<?php echo $fetch_orders['total_price']; ?>/-</p>
            <p>
                <span class="font-semibold">Payment Status:</span> 
                <span class="<?php echo $fetch_orders['payment_status'] == 'pending' ? 'text-red-500' : 'text-green-600'; ?>">
                    <?php echo $fetch_orders['payment_status']; ?>
                </span>
            </p>
        </div>
        <?php
            }
        } else {
            echo '<p class="col-span-3 text-center text-lg text-gray-600">No orders placed yet!</p>';
        }
        ?>
    </div>
</section>

<?php @include 'footer.php'; ?>

</body>
</html>
