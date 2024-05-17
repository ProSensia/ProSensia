<nav class="thenavbar">
      <div class="logo">
        <div class="logo_container">
          <img src="assets/images/3 1.png" alt="">
      </div>
    </div>
      <ul class="nav_components nav_hidecontent">
          <li class="pages_nav"> <a class="nav_links" href="/prosensia"> Home</a></li>
          <li class="pages_nav"> <a class="nav_links" href="/prosensia/about"> AboutUs</a></li>
          <li class="pages_nav"> <a class="nav_links" href="/prosensia/contact"> ContactUs</a></li>
          <?php
// if(!isset( $_SESSION['username'])||!isset($_SESSION['loggedin'])){
//   echo '   <li class="pages_nav"> <a class="nav_links" href="login.php"> Sign In</a></li>';
// }
// else{
//  echo' <li class="pages_nav"> <a class="nav_links" href="dashboard.php"> Profile</a></li>';
// }
?>
       

      </ul>
      
      <div class="burger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <script >
      let burger = document.querySelector('.burger');
let navcontent = document.querySelector('.nav_components');

burger.addEventListener('click', () => {
    navcontent.classList.toggle('nav_hidecontent')
    navcontent.classList.toggle('the_nav_content')
})
    </script>
  </nav>