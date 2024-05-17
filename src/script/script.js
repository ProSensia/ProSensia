

let preloader=document.getElementById("preloader");
window.addEventListener('load',function(){
preloader.style.display="none";
})



function switchPageLogin() {
  window.location.href = 'login.php';
}
function switchPageSignup() {
  window.location.href = 'signup.php';
}
