<?php
ob_start();
session_start();

  include 'files/ini.php';
?>
    <div class="landing">
      <div class="deco-white-circle-2">
          <img src="imgs/logobc.png" alt="alternative">
      </div>
      <div class="deco-white-circle-1">
          <img src="imgs/logobc2.png" alt="alternative">
      </div>
      <div class="container">
        <div class="text" id="a">
          <h1>تذكر دائمًا</h1>
                <h2>عندما تقرر التبرع بالأغراض القديمة، فإنك لا تمنح فقط شيئًا ماديًا، بل تمنح أيضًا فرصة للتجديد والتحسين لحياة الآخرين. الأشياء التي قد تبدو بلا قيمة بالنسبة لك، قد تكون كنزًا لشخص آخر في حاجة.</h2>
        </div>
        <div class="image" id="b">
          <img src="imgs/landing-image.png" alt="" />
        </div>
      </div>

    </div>
    <!-- End Landing -->
    <!-- Start Articles -->
    <div class="articles" id="articles" >
      <div class="container">

      <a href="items.php"> 
        <div class="box">
          <img src="imgs/visit.png"  style="background:#e3ebef;"alt="" />
          <div class="content">
            <h3><i class="fa-solid fa-person-circle-exclamation"></i> زائر</h3>
            <p> يمكنك تصفح الموقع كزائر </p>
          </div>
        </div>
      </a>


      <a href="login.php">
        <div class="box">
          <img src="imgs/give.png"style="background:#e3ebef;" alt="" />
          <div class="content">
            <h3><i class="fa-solid fa-hand-holding-medical"></i> متبرع </h3>
            <p>يمكنك  تقديم تبرعك الان بعد انشاء حساب</p>
          </div>
        </div>
      </a>


      <a href="login.php">
         <div class="box">
          <img src="./imgs/take.png" style="background:#e3ebef;" alt="" />
          <div class="content">
            <h3><i class="fa-solid fa-handshake-angle"></i>  محتاج</h3>
            <p> يمكنك تقديم طلب على شيء من المعروضات</p>
          </div>
        </div>
      </a>
      

      </div>
    </div>

    <!-- Start Articles -->
    <div class="spikes"></div>

    <div class="articles" style="background:#e3ebef; margin-top:0;" id="articles" >
    
      <div class="container">

      <a href="table1.php"> 
        <div class="box">
          <img src="imgs/house.png"  style="background:#e3ebef;"alt="" />
          <div class="content">
            <h3><i class="fa fa-couch" aria-hidden="true"></i> الأثاث</h3>
            <p>  كنب , كراسي , غرفة نوم , مفروشات</p>
          </div>
        </div>
      </a>


      <a href="notification.php">
        <div class="box">
          <img src="imgs/three.png"style="background:#e3ebef;" alt="" />
          <div class="content">
            <h3><i class="fa fa-tv" aria-hidden="true"></i> المنزليات </h3>
            <p>الكترونيات , ثلاجات , ادوات مطبخ , غسالة ملابس , ميكروويف</p>
          </div>
        </div>
      </a>


      <a href="fac.php">
         <div class="box">
          <img src="./imgs/clothes.png" style="background:#e3ebef;" alt="" />
          <div class="content">
            <h3><i class="fa fa-shirt" aria-hidden="true"></i>  الملابس</h3>
            <p> ملابس اطفال , ملابس رجال , ملابس نساء , ملابس صيفية وشتوية</p>
          </div>
        </div>
      </a>
      

      </div>
    </div>
    <div class="spikes"></div>
    <!-- End Articles -->

        <!-- Start Video -->
        <div class="video">

          <video autoplay muted loop>
            <source src="imgs/awesome-video.mp4" type="video/mp4" />
          </video>
          <div class="text">
            <h2 style="line-height:1.5;font-weight: normal;font-size:22px;">
            التبرع يُعزز روح المشاركة والتعاون في المجتمع. يمكن أن يلهم ذلك الآخرين للقيام بالخير أيضًا، فقد يكون تأثيرك الإيجابي سببًا في تشجيع غيرك على العطاء. عملية التبرع تمثل أيضًا فرصة للتخلص من الأشياء التي لا تحتاج إليها، مما يُمكّنك من ترتيب وتنظيف المكان وتحسين جودة حياتك الشخصية من خلال الاستغناء عن الأشياء الزائدة.
            </h2>
          </div>
        </div>
        <!-- End Video -->


      <?php
        include 'files/footer.php';
        ob_end_flush();
        ?>
