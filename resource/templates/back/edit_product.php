<?php 



if(isset($_GET['id'])) {
    
    
  $query=query("SELECT * FROM products WHERE product_id = ". escape_string($_GET['id']) . " ");  
    
    confirm($query);
    
    while ($row = fetch_array($query)) {
        
    $product_title        = escape_string($row['product_title']);
    $product_category_id  = escape_string($row['product_category_id']);
    $product_price        = ($row['product_price']);
    $product_description  = escape_string($row['product_description']);
    $short_desc           = escape_string($row['short_desc']);
    $product_quantity     = escape_string($row['product_quantity']);
    $product_image        = escape_string($row['product_image']);
        
        
        
        
        
        
        
    }
    
    $product_image_path = display_image($product_image);
    
    
    
    
    
}














?>
<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product
<?php update_product(); ?>
</h1>
</div>


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value="<?php echo $product_title; ?>">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php
        
          echo $product_description;
          
          ?></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="product_price" class="form-control" size="60" value="<?php echo $product_price; ?>">
      </div>
    </div>
    
    
     <div class="form-group">
           <label for="product-title">Product short Description</label>
      <textarea name="short_desc" id="" cols="10" rows="3" class="form-control">
         
          <?php echo $short_desc; ?>
         
         </textarea>
    </div>






    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product-title">Product Categories</label>
          
        <select name="product_category_id" id="" class="form-control">
            <option value=""><?php echo  show_product_category_title($product_category_id); ?></option>
            
                  <?php   show_categories_add_product_page(); ?>
          
        </select>


</div>





    <!-- Product Brands-->


    <div class="form-group">
      <label for="product-title">Product Quantity</label>
        
         <input type="number" name="product_quantity" id="" class="form-control" value ="<?php  echo $product_quantity; ?>">
       
         
    </div>


<!-- Product Tags -->




    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
        
        <img width='300' src="../../resource/<?php echo   $product_image_path;  ?>">
      
    </div>



</aside><!--SIDEBAR-->


    
</form>



                



            </div>
            <!-- /.container-fluid -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

