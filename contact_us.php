<?php
session_start();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&family=Kosugi&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="src/style/contact.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="src/style/headerFooter.css">
    <title>Contact Us</title>
</head>
<body>
    

    <div id="preloader">
        <h1>
         <span class="let1">P</span>
         <span class="let2">R</span>
         <span class="let3">O</span>
         <span class="let4">S</span>
         <span class="let5">E</span>
         <span class="let6">N</span>
         <span class="let7">S I</span>
         <span class="let8">A</span> 
        </h1>
      </div>


  
      <?php
include "components/navbar.php";
?>
    
    <section class="container">
        <section class="contact_container">
         <div class="contact_text">
            <h2>Contact Us</h2>
         </div>
         <div class="sendmail_container">
            <div class="mail_conatiner">
<div class="contact_mail_info">
    <h3>Got Any Questions?</h3>

    <h5><span>Email: </span>prosensia@gmail.com</h5>
    <h5><span>Number: </span>+923107717890</h5>
    <h5><span>Address:</span> paf-iast haripur</h5>
</div>
<div class="contact_mail_input">
    <input type="text" name="" placeholder="Name" id="">
<input type="text" name="" placeholder="Email" id="">
<textarea name="" id="" cols="30" rows="10" placeholder="Message"></textarea>
<div class="submit_button">
 <input id="contact_submit" type="submit" value="Submit">
</div>
</div>
         </div>
        </div>
        </section>
    </section>

   <?php include 'components/footer.php'; ?>

          <script>
            let preloader=document.getElementById("preloader");
          window.addEventListener('load',function(){
            preloader.style.display="none";
          })
          </script>

</body>
</html>