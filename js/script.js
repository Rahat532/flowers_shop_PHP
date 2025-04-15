let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () =>{
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
}

window.onscroll = () =>{
    userBox.classList.remove('active');
    navbar.classList.remove('active');
}
 document.getElementById('user-btn').onclick = () => {
      const box = document.getElementById('account-box');
      box.classList.toggle('hidden');
   };

   const userBtn = document.getElementById('user-btn');
   const modal = document.getElementById('account-modal');
   const closeModal = document.getElementById('close-modal');

   userBtn.addEventListener('click', () => {
      modal.classList.toggle('hidden');
   });

   closeModal.addEventListener('click', () => {
      modal.classList.add('hidden');
   });

   //  close if click outside
   document.addEventListener('click', (e) => {
      if (!modal.contains(e.target) && !userBtn.contains(e.target)) {
         modal.classList.add('hidden');
      }
   });

