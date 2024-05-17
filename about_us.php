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
    <link rel="stylesheet" href="src/style/pages.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/headerFooter.css">
    <title>About Us</title>
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
       
<section class="company_overview_container">
 <div class="overview_parts">
    <h2>Company Overview</h2>
    <br>
    <p>ProSensia is a forward-thinking technology company dedicated to revolutionizing the electronic device industry. Founded by Momin Khan, our company is driven by a passion for innovation and a commitment to enhancing the lives of consumers through cutting-edge technology solutions.</p>
 </div>
 <div class="overview_parts_imgge">
    <img src="assets/images/img1.png" alt="">

 </div>
</section>

<section class="mission_container">
    <div class="mission_overview_parts_imgge">
        <img src="assets/images/ourMission 1.png" alt="">
    
     </div>
    <div class="overview_parts">
        <h2 style="color: #FECE00;">Our Mission</h2>
        <br>
        <p style="color: white;">At ProSensia, our mission is to extend the lifespan of electronic devices and improve their functionality through innovative solutions and exceptional customer service. We believe in leveraging technology to address real-world challenges and empower individuals and businesses to thrive in the digital age.</p>
     </div>
    
</section>

<section class="company_overview_container">
    <div class="overview_parts">
        <h2 >Vision for the Future</h2>
        <br>
        <p >Our vision is to create a future where electronic devices are more reliable, sustainable, and user-friendly. By developing groundbreaking products and services, we aim to shape a world where technology enhances every aspect of daily life, from communication and productivity to entertainment and beyond.</p>
     </div>
     <div class="vison_overview_parts_imgge">
        <img src="assets/images/vision 1.png" alt="">
    
     </div>
</section>

<section class="team_conatiner">
   <div class="team_info_text">
    <h2>Our Team</h2> <br>
    <p>Our team consists of talented individuals with diverse backgrounds and expertise in technology, engineering,<br> design, and customer service. Together, we work tirelessly to develop  innovative solutions <br> that address the evolving needs of our customers and the industry.</p>
   </div>
    <div class="team_members_pic">
        <img src="assets/images/teamProfile.png" alt="">
    </div>
</section>

<?php include 'components/footer.php'; ?>


    </section>

    <script>
        let preloader=document.getElementById("preloader");
      window.addEventListener('load',function(){
        preloader.style.display="none";
      })
      </script>
    
</body>
</html>