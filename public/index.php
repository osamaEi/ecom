<?php require_once("../resource/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            
            <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>
       
            

            <div class="col-md-9">

               <div class="row carousel-holder">

                    <div class="col-md-12">

                 
                          <?php include(TEMPLATE_FRONT . DS . "slider.php"); ?>
                  

                </div>
            
                </div>
         
                <div class="row">
             
                    
<?php      
                    $per_page=3;
                    
                   
                    
                      if(isset($_GET['page'])) {
                    
                    $page=$_GET['page'];
                   
                    
                }else{
                    $page="";
                    
                }
                
                if($page==""|| $page ==1) {
                    
                    $page_1=0;
                    
                } else {
                    
                    $page_1= ( $page * $per_page )- $per_page;
                    
                }
                    
                    
                    
    
    $products = query("SELECT * FROM products");
                    
    confirm($products);
    
   
                    
    $count= mysqli_num_rows($products);
                    
    $count =ceil($count /$per_page);
    
     
          if($count <1) {
                    
                    echo "<h1>No posts Available</h1>";
                    
                } else {
                        
              
            $query = query("SELECT * FROM products LIMIT $page_1,$per_page");
              
              confirm($query);
   
    
    
    
    
    
    
    
    while($row =fetch_array($query)) {
        

        
    ?>

             
    <div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id=<?php echo $row['product_id']; ?>"><img class="responsive"  src="../resource/uploads/<?php echo $row['product_image']; ?>" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;<?php echo $row['product_price']; ?></h4>
            <h4><a href="item.php?id=<?php echo $row['product_id']; ?>"><?php echo $row['product_title']; ?></a>
            </h4>
            <p><?php echo $row['product_description']; ?></p>
             <a class="btn btn-primary" target="_blank" href="../resource/cart.php?add=<?php echo $row['product_id']; ?>">Add to cart</a>
            
                  

        </div>

    </div>
</div>
  <?php  } } ?>
        
    
   
 
    
     

                </div>

            
  
           
            </div>

        </div>



    </div>
    <!-- /.container -->
<div class ="row">
<ul class="pagination">
    
    
    
      <?php
    if(empty($_GET['page'])) {
        
        $page = $_GET['page'] =1;
        
    }
    if($count>1 ) {
            
    if($page>1 ) {
        
        
        $prev =$page-1;
        
        
          echo "  <li class='paginate'>
      <a class='page-link' href='index.php?page={$prev}' >Previous</a>
    </li>";
        
        
    }
    
    
    
    
    
         
    for($i=1;$i<=$count;$i++){
        
       if ($i==$page) {
                  
 echo "<li class = 'active' background='blue'><a  href='index.php?page={$i}'>{$i}</a></li>";
                    
                    
                }else {
                    
                    
                     echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
                
               
                
    }
                
           
          if($page < $count) {
        
      (int)$next =(int)$page +1;
          echo "  <li class='paginate'>
      <a class='page-link' href='index.php?page={$next}' >NEXT</a>
    </li>";
        
        
    }   
    }
            
            ?>
                    
</ul>           
           
</div>
    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>


              