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
   <title>About Us</title>

   <!-- Fonts & Icons -->
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
   <!-- Tailwind CSS -->
   <script src="https://cdn.tailwindcss.com"></script>
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

   
   <style>
     .hero-bg {
       background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/home-bg.png');
     }
   </style>

   <!-- custom admin css file link -->
   <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>
<body class="font-poppins bg-gray-100">

<?php @include 'header.php'; ?>

<section class="heading py-10 bg-gradient-to-r from-primary to-accent text-white text-center">
    <h3 class="text-4xl font-semibold">About Us</h3>
    <p class="text-lg mt-4">
        <a href="home.php" class="text-accent hover:text-white">Home</a> / About
    </p>
</section>

<section class="about py-20 px-5 lg:px-32 bg-white">
    <div class="flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-10">

        <div class="flex-1">
            <img src="images/about-img-1.jpg" alt="Why Choose Us" class="w-full rounded-lg shadow-lg">
        </div>

        <div class="flex-1 space-y-5">
            <h3 class="text-3xl font-semibold text-secondary">Why Choose Us?</h3>
            <p class="text-lg text-gray-700">
            We chose Flower because it offers the perfect blend of beauty, quality, and care. Your unique floral designs and heartfelt service make every moment unforgettable. Truly the best choice!
            </p>
            <a href="shop.php" class="btn px-6 py-2 bg-primary text-white rounded-full hover:bg-accent">Shop Now</a>
        </div>

    </div>

    <div class="flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-10 mt-20">

        <div class="flex-1 space-y-5">
            <h3 class="text-3xl font-semibold text-secondary">What We Provide?</h3>
            <p class="text-lg text-gray-700">
            At Flower, we provide fresh, handpicked blooms, elegant bouquets, same-day delivery, custom floral arrangements, and heartfelt gifts to make every occasion special, memorable, and full of love.
            </p>
            <a href="contact.php" class="btn px-6 py-2 bg-primary text-white rounded-full hover:bg-accent">Contact Us</a>
        </div>

        <div class="flex-1">
            <img src="images/about-img-2.jpg" alt="What We Provide" class="w-full rounded-lg shadow-lg">
        </div>

    </div>

    <div class="flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-10 mt-20">

        <div class="flex-1">
            <img src="images/about-img-3.jpg" alt="Who We Are" class="w-full rounded-lg shadow-lg">
        </div>

        <div class="flex-1 space-y-5">
            <h3 class="text-3xl font-semibold text-secondary">Who We Are?</h3>
            <p class="text-lg text-gray-700">
            We are Flower — a passionate team of floral artists dedicated to spreading joy through nature’s beauty. Our mission is to deliver love, emotions, and smiles with every bouquet.
            </p>
            <a href="#reviews" class="btn px-6 py-2 bg-primary text-white rounded-full hover:bg-accent">Client's Reviews</a>
        </div>

    </div>

</section>

<section class="reviews bg-gray-100 py-20" id="reviews">
    <h1 class="title text-4xl text-center font-semibold text-secondary">Client's Reviews</h1>

    <div class="box-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mt-12">
        <?php 
        $reviews = [
            ["img" => "pic-1.jpg", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "John Deo", "stars" => 4.5],
            ["img" => "pic-2.jpg", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "Jane Doe", "stars" => 4],
            ["img" => "pic-3.png", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "Mary Jane", "stars" => 5],
            ["img" => "pic-4.jpg", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "James Smith", "stars" => 3.5],
            ["img" => "pic-5.jpg", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "Robert Brown", "stars" => 4],
            ["img" => "pic-6.jpg", "review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque.", "name" => "Lisa Green", "stars" => 5]
        ];

        foreach ($reviews as $review) {
            echo "
            <div class='box bg-white p-6 rounded-lg shadow-lg text-center'>
                <img src='images/{$review['img']}' alt='Review Image' class='w-24 h-24 rounded-full mx-auto'>
                <p class='text-gray-700 mt-4'>{$review['review']}</p>
                <div class='stars mt-4'>";
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $review['stars']) {
                        echo "<i class='fas fa-star text-yellow-500'></i>";
                    } else {
                        echo "<i class='fas fa-star-half-alt text-yellow-500'></i>";
                    }
                }
                echo "</div>
                <h3 class='text-xl font-semibold mt-2'>{$review['name']}</h3>
            </div>";
        }
        ?>
    </div>
</section>
<?php @include 'footer.php'; ?>
</body>
</html>
