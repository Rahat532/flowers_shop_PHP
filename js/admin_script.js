let navbar = document.querySelector('.header .flex .navbar');
let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active'); 
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   userBox.classList.remove('active');
}

   const userBtn = document.querySelector('#user-btn');
   const accountBox = document.querySelector('.account-box');

   userBtn.addEventListener('click', () => {
      accountBox.classList.toggle('active');
   });

   // Optional: close the box when clicking outside
   document.addEventListener('click', (e) => {
      if (!accountBox.contains(e.target) && !userBtn.contains(e.target)) {
         accountBox.classList.remove('active');
      }
   });
