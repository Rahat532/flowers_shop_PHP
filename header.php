

<header class="bg-gradient-to-r from-pink-500 to-white-500 shadow-md sticky top-0 w-full z-50 border-b border-gray-100">
   <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      
      <!-- Logo -->
      <a href="home.php" class="text-4xl font-Merienda font-bold tracking-tight text-gray-900 hover:text-pink-600 transition-colors duration-300">
         <span class="font-merienda text-4xl md:text-6xl font-bold mb-6">Flowers</span>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex items-center space-x-8">
         <a href="home.php" class="text-lg font-merienda text-gray-700 hover:text-pink-600 transition-colors duration-200 py-2 px-1">Home</a>

         <div class="relative group">
            <button class="text-lg font-merienda text-gray-700 hover:text-pink-600 transition-colors duration-200 py-2 px-1 flex items-center">
               Pages <i class="fas fa-chevron-down ml-1 text-xs mt-1"></i>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
               <a href="about.php" class="block px-4 py-2 font-merienda text-gray-700 hover:bg-pink-50 hover:text-pink-600">About</a>
               <a href="contact.php" class="block px-4 py-2 font-merienda text-gray-700 hover:bg-pink-50 hover:text-pink-600">Contact</a>
            </div>
         </div>

         <a href="shop.php" class="text-lg font-merienda text-gray-700 hover:text-pink-600 transition-colors duration-200 py-2 px-1">Shop</a>
         <a href="orders.php" class="text-lg font-merienda text-gray-700 hover:text-pink-600 transition-colors duration-200 py-2 px-1">Orders</a>

         <div class="relative group">
            <button class="text-lg font-merienda text-gray-700 hover:text-pink-600 transition-colors duration-200 py-2 px-1 flex items-center">
               Account <i class="fas fa-chevron-down ml-1 text-xs mt-1"></i>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
               <a href="login.php" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">Login</a>
               <a href="register.php" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">Register</a>
            </div>
         </div>
      </nav>

      <!-- Icons -->
      <div class="flex items-center gap-6">
         <a href="search_page.php" class="text-gray-600 hover:text-pink-600 transition-colors duration-200 text-xl relative">
            <i class="fas fa-search"></i>
         </a>

         <div id="user-btn" class="text-gray-600 hover:text-pink-600 transition-colors duration-200 text-xl cursor-pointer relative">
            <i class="fas fa-user"></i>
         </div>

         <a href="wishlist.php" class="text-gray-600 hover:text-pink-600 transition-colors duration-200 text-xl relative">
            <i class="fas fa-heart"></i>
            <?php if($wishlist_num_rows > 0): ?>
               <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                  <?= $wishlist_num_rows; ?>
               </span>
            <?php endif; ?>
         </a>

         <a href="cart.php" class="text-gray-600 hover:text-pink-600 transition-colors duration-200 text-xl relative">
            <i class="fas fa-shopping-cart"></i>
            <?php if($cart_num_rows > 0): ?>
               <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                  <?= $cart_num_rows; ?>
               </span>
            <?php endif; ?>
         </a>

         <!-- Mobile Menu Button -->
         <button id="menu-btn" class="md:hidden text-gray-600 hover:text-pink-600 transition-colors duration-200 text-xl">
            <i class="fas fa-bars"></i>
         </button>
      </div>
   </div>

   <!-- Account Dropdown Modal -->
   <div id="account-modal" class="fixed md:absolute right-4 md:right-8 top-16 md:top-full mt-2 bg-white border border-gray-200 shadow-xl rounded-xl w-80 md:w-64 p-6 z-50 hidden transition-all duration-300 transform translate-y-2">
      <div class="flex justify-between items-start mb-4">
         <div>
            <h2 class="text-xl font-bold text-gray-800">Account Info</h2>
            <p class="text-sm text-gray-500">Welcome back!</p>
         </div>
         <button id="close-modal" class="text-gray-400 hover:text-red-500 transition-colors">
            <i class="fas fa-times"></i>
         </button>
      </div>

      <div class="space-y-3 mb-6">
         <div class="flex items-center space-x-3">
            <div class="bg-pink-100 text-pink-600 rounded-full p-2">
               <i class="fas fa-user-circle text-xl"></i>
            </div>
            <div>
               <p class="font-medium text-gray-800"><?= $_SESSION['user_name']; ?></p>
               <p class="text-sm text-gray-500"><?= $_SESSION['user_email']; ?></p>
            </div>
         </div>
      </div>

      <a href="logout.php" class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200">
         <i class="fas fa-sign-out-alt"></i>
         <span>Logout</span>
      </a>
   </div>

   <!-- Mobile Menu -->
   <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200 shadow-lg">
      <div class="px-6 py-4 space-y-4">
         <a href="home.php" class="block text-lg font-medium text-gray-700 hover:text-pink-600 py-2">Home</a>
         
         <div class="space-y-2">
            <button class="flex items-center justify-between w-full text-lg font-medium text-gray-700 hover:text-pink-600 py-2" onclick="toggleMobileSubmenu('pages-menu')">
               Pages <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
            </button>
            <div id="pages-menu" class="hidden pl-4 space-y-2">
               <a href="about.php" class="block text-gray-600 hover:text-pink-600 py-1">About</a>
               <a href="contact.php" class="block text-gray-600 hover:text-pink-600 py-1">Contact</a>
            </div>
         </div>

         <a href="shop.php" class="block text-lg font-medium text-gray-700 hover:text-pink-600 py-2">Shop</a>
         <a href="orders.php" class="block text-lg font-medium text-gray-700 hover:text-pink-600 py-2">Orders</a>
         
         <div class="space-y-2">
            <button class="flex items-center justify-between w-full text-lg font-medium text-gray-700 hover:text-pink-600 py-2" onclick="toggleMobileSubmenu('account-menu')">
               Account <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
            </button>
            <div id="account-menu" class="hidden pl-4 space-y-2">
               <a href="login.php" class="block text-gray-600 hover:text-pink-600 py-1">Login</a>
               <a href="register.php" class="block text-gray-600 hover:text-pink-600 py-1">Register</a>
            </div>
         </div>
      </div>
   </div>
</header>

<script>
   // Toggle account modal
   const userBtn = document.getElementById('user-btn');
   const accountModal = document.getElementById('account-modal');
   const closeModal = document.getElementById('close-modal');
   
   userBtn.addEventListener('click', () => {
      accountModal.classList.toggle('hidden');
   });
   
   closeModal.addEventListener('click', () => {
      accountModal.classList.add('hidden');
   });
   
   // Close modal when clicking outside
   document.addEventListener('click', (e) => {
      if (!accountModal.contains(e.target) && e.target !== userBtn && !userBtn.contains(e.target)) {
         accountModal.classList.add('hidden');
      }
   });
   
   // Mobile menu toggle
   const menuBtn = document.getElementById('menu-btn');
   const mobileMenu = document.getElementById('mobile-menu');
   
   menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
   });
   
   // Toggle mobile submenus
   function toggleMobileSubmenu(id) {
      const submenu = document.getElementById(id);
      const chevron = submenu.previousElementSibling.querySelector('i');
      
      submenu.classList.toggle('hidden');
      chevron.classList.toggle('rotate-180');
   }
</script>

<style>
   .animate-fade-in {
      animation: fadeIn 0.3s ease-out;
   }
   
   @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
   }
</style>



