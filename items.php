<?php
ob_start();
session_start();

  include 'files/ini.php';


  
                $stmt = $con->prepare("SELECT 
                items.*,
                categories.categories_name AS Category,
                users.user_name
            FROM 
                items
            INNER JOIN 
                categories ON categories.categories_id = items.items_cat
            INNER JOIN 
                users ON users.user_id = items.items_owner
            WHERE 
                items_status != 2
            ORDER BY 
                items_id DESC;
            
                ");


$stmt->execute();


$allItems = $stmt->fetchall();

if (! empty($allItems)) {


?>

<style>
    .imagg{
        background: #e3ebef;
        justify-content: center;
    height: 300px;
    display: flex;
    align-content: center;
    align-items: center;
    
}

</style>
    <div class="articles" id="articles" >
      <div class="container">

      <?php  foreach ($allItems as $item) { ?>

      <div class="box">
            <div class="imagg">
            <img src="upload/items/<?php echo $item['items_image'];?>"style="background:#e3ebef;" alt="" />
            </div>
          <div class="content">
            <h3><?php echo $item['items_name'];?></h3>
            <p><?php echo $item['items_desc'];?></p>
            <p><?php echo $item['user_name'];?></p>
            <a href="details.php?itemid=<?php echo $item['items_id'];?>" >مشاهدة الان</a>
          </div>
        </div>

        <?php   }?>






      </div>
    </div>
    <div class="spikes"></div>
    <!-- End Articles -->



      <?php

    }
        include 'files/footer.php';
        ob_end_flush();
        ?>
