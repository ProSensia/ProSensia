<?php
include "./partials/headers.php";
session_start();



?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ProSensia | Home</title>
    <link rel="stylesheet" href="./src/style/style.css" />
    <link rel="stylesheet" href="./src/style/home.css" />
    <link rel="stylesheet" href="./src/style/headerFooter.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&family=Kosugi&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/pages.css">
   
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



    <div class="heroHome">
      <div class="heroHomeTop">
        <div class="heroHomeTopImg">
          <img src="./src/images/heroHomeImg.png" alt="HeroImg" />
        </div>
        <div class="heroHomeTopContent">
          <div>
            <img
              src="./src/images/yellowLine.png"
              alt=""
              class="heroHomeTopContentImg1"
            />
            <img
              src="./src/images/yellowLine.png"
              alt=""
              class="heroHomeTopContentImg2"
            />
            <img
              src="./src/images/yellowLine.png"
              alt=""
              class="heroHomeTopContentImg3"
            />
            <h1>
              Empowering <br />
              Devices, <br />
              Extending Life
            </h1>
            <h4>Transforming Tech for Tomorrow</h4>
          </div>
        </div>
      </div>

     
        <div class="heroHomeBottomDiv">
          <div class="heroHomeBottomRow1">
            <div class="rowCol1">
              <div class="col1Div1">
                <i class="fa fa-cog" style="color: #fece00"></i>
              </div>

              <div class="col1Div2">
                <h3>We are</h3>
                <h2>Pioneering Progress</h2>
                <p>Innovating Tomorrow's Technology</p>
              </div>
            </div>

            <div class="rowCol2">
              <div class="col2Div1">
                <i class="fa fa-globe" style="color: #fece00"></i>
              </div>

              <div class="col2Div2">
                <h3>We are</h3>
                <h2>Empowering Excellence</h2>
                <p>Driving Innovation, Inspiring Change</p>
              </div>
            </div>

            <div class="rowCol3">
              <div class="col3Div1">
                <i class="fa fa-line-chart" style="color: #fece00"></i>
              </div>

              <div class="col3Div2">
                <h3>We are</h3>
                <h2>Igniting Growth</h2>
                <p>Fostering Innovation, Engineering Solutions</p>
              </div>
            </div>
          </div>
          <div class="heroHomeBottomRow2">
            <div class="rowCol1">
              <div class="col1Div1">
                <i class="fa fa-desktop" style="color: #fece00"></i>
              </div>

              <div class="col1Div2">
                <h3>We are</h3>
                <h2>Championing Change</h2>
                <p>Revolutionizing Tech, Empowering Lives</p>
              </div>
            </div>
            <div class="rowCol2">
              <div class="col2Div1">
                <i class="fa fa-mobile" style="color: #fece00"></i>
              </div>

              <div class="col2Div2">
                <h3>We are</h3>
                <h2>Fostering Futures</h2>
                <p>Transforming Tech, Enriching Lives</p>
              </div>
            </div>
            <div class="rowCol3">
              <div class="col3Div1">
                <i class="fa fa-rocket" style="color: #fece00"></i>
              </div>

              <div class="col3Div2">
                <h3>We are</h3>
                <h2>Elevating Expectations</h2>
                <p>Redefining Possibilities, Shaping Tomorrow</p>
              </div>
            </div>
          </div>
        </div>
     

    </div>
 
    <div class="homeSection2">
      <div class="homeSection2Left">
        <img src="./src/images/BreezeBustersStartup.png" alt="BreezeBusters" />
      </div>
      <div class="homeSection2Center">
        <img src="./src/images/yellowLine.png" alt="YellowLine" />
      </div>
      <div class="homeSection2Right">
        <h1>Our Startup</h1>
        <p>
          Our flagship startup, BreezeBusters, is the pioneering venture of
          ProSensia. BreezeBusters specializes in AC predictive maintenance,
          focusing on enhancing the lifespan and efficiency of air conditioning
          systems. Through innovative technology and proactive strategies,
          BreezeBusters aims to revolutionize the way AC systems are managed and
          maintained.
        </p>
      </div>
    </div>

    <div class="homeSection3">
      <div class="homeSection3Right">
        <h1>What We Think?</h1>
        <p>
          At ProSensia, we're shaping a tech-driven future with BreezeBusters
          leading the way. Our startups offer innovative solutions for diverse
          challenges, aiming to create impactful change. Through innovation,
          we're building a brighter tomorrow, one startup at a time.
        </p>
      </div>

      <div class="homeSection3Left">
        <img src="./src/images/brainFont.png" alt="Brain" />
      </div>
    </div>





    <?php include 'components/footer.php'; ?>
  </body>
  <script>
    let preloader=document.getElementById("preloader");
  window.addEventListener('load',function(){
    preloader.style.display="none";
  })
  </script>
</html>
