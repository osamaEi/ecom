<?php 

$upload_directory="uploads";
//helper function

function last_id() {
    
    global $connection;
    
    return mysqli_insert_id($connection);
    
    
    
    
}



function set_message($msg) {
    
    if(!empty($msg)) {
        
        $_SESSION['message']=$msg;
        
        
    } else {
        
        $msg="";
    }
    
    
}

function display_message() {
    
    if(isset($_SESSION['message'])) {
        
        echo $_SESSION['message'];
        
     
        
    }
       unset($_SESSION['message']);
    
}





function redirect($location) {
    
    header ("location: $location");
    
}



function query($sql){
    
    
    global $connection;
    
    return mysqli_query($connection,$sql);
    
    
}



function confirm($result) {
    
     global $connection;
    
    if(!$result) {
        
        die("QUERY FAILED" . mysqli_error($connection));
    }
    
    
    
    
    
}

function escape_string($string) {
    
    global $connection;
    
    return mysqli_real_escape_string($connection, $string);
    
    
}

function fetch_array($result) {
    
  return  mysqli_fetch_array($result);
    
    
}
/*******************FRONT END FUNCTIONS *****************************/




function get_categories() {
    
          
                    $query = "SELECT * FROM categories";
                    
                   $send_query=query($query);
                    
                    confirm($send_query);
    
                    while($row =fetch_array($send_query)) {
                          
                $category_link=<<<DELIMETER
                    
                    
                    <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
                    
                    
                    
                    
                    
                    
                   DELIMETER;
                            echo $category_link;
                    }
    

    
    
}  

function login_user(){
    
    if(isset($_POST['submit'])) {
        
        $username= escape_string($_POST['username']);
        $password= escape_string($_POST['password']);
        
        
        $query=query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        
        confirm($query);
        
        if(mysqli_num_rows($query) == 0) {
            
            set_message("Your Password or Username are wrong");
            redirect("login.php");
            
        }
        
        else {
            $_SESSION['username']=$username;
            redirect("admin");
        }
        
    }
    
    
}



function send_message() {
    
    
    if(isset($_POST['submit'])) {
        
        $to = "osamaeidbm1993@gmail.com";
        $from_name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        
        
        $headers= "FROM : {$from_name} {$email}";
        
      $result= mail($to,$phone,$message,$headers);
        
        if(!$result) {
            
            echo "ERROR";
            
        }else {
            
            echo "TRUE";
        }
        
        
        
        
        
    }
    
    
    
    
    
    
}


/*******************BACK END FUNCTIONS *****************************/


function display_order() {
    
    $query = query("SELECT * FROM orders");
    confirm($query);
    
    while($row = fetch_array($query)){
        
        
        
        $orders =<<<DELIMETER
            
            
            <tr>
            
            <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="../../resource/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            
            
            
            
            
            </tr>
            
            
            
            
            
            
            
            
            DELIMETER;
        
        echo $orders;
        
        
    }
    
  
    
}

function display_report() {
    
    $query = query("SELECT * FROM reports");
    confirm($query);
    
    while($row = fetch_array($query)){
        
        
        
        $orders =<<<DELIMETER
            
            
            <tr>
            
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resource/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            
            
            
            
            
            </tr>
            
            
            
            
            
            
            
            
            DELIMETER;
        
        echo $orders;
        
        
    }
    
  
    
}



function get_products_in_admin(){
    
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)) {
        
        $category = show_product_category_title($row['product_category_id']);
        
        
        $product_image =display_image($row['product_image']);
        
        $product = <<<DELIMETER

             
             
      <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
             <a href="index.php?edit_product&id={$row['product_id']}"><img width=100 borderRadius: 6px" src="../../resource/{$product_image}" alt=""></a>
            </td>
            <td>$category</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
                <td><a class="btn btn-danger" href="../../resource/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
      
             
             
             
             


DELIMETER;
        
        
         echo $product;
    }
    
    
    
    
    
}

/*************************ADD PRODUCT IN ADMIN****************/

function add_product() {
    
    
if(isset($_POST['publish'])) {
    
    $product_title        = escape_string($_POST['product_title']);
    $product_category_id  = escape_string($_POST['product_category_id']);
    $product_price        = escape_string($_POST['product_price']);
    $product_description  = escape_string($_POST['product_description']);
    $short_desc           = escape_string($_POST['short_desc']);
    $product_quantity     = escape_string($_POST['product_quantity']);
    $product_image        = escape_string($_FILES['file']['name']);
    $image_temp_location  = $_FILES['file']['tmp_name'];
    
    
    $moved =move_uploaded_file( $image_temp_location, UPLOAD_DIRECTORY. DS . $product_image);
    
    if($moved) {
 
   $query=query("INSERT INTO products(product_title,product_category_id,product_price,product_description,short_desc,product_quantity,product_image) VALUES('{$product_title}','{$product_category_id}','{$product_price}','{$product_description}','{$short_desc}','{$product_quantity}','{$product_image}')"); 
    
    $last_id =last_id($connection);
    
    confirm($query);
    
    set_message("NEW PRODUCT WITH Id  {$last_id}  JUST ADD");
    
    redirect("index.php?products");
    
    
}    else {
        
        echo "Not uploaded because of error ";
   
        echo $image_temp_location;
    }
    
    
    
    
}






}


function show_categories_add_product_page() {
    
          
                    $query = "SELECT * FROM categories";
                    
                   $send_query=query($query);
                    
                    confirm($send_query);
    
                    while($row =fetch_array($send_query)) {
                          
                $category_options=<<<DELIMETER
        
                    
                    
                   <option value="{$row['cat_id']}">{$row['cat_title']}</option>
                    
                    
                    
DELIMETER; 
                        
                        
                         
                        echo $category_options;
                        
                        
                    }
    
    

    
    
}  

function show_product_category_title($product_category_id) {
    
    
    $cat_query=query("SELECT * FROM categories Where cat_id = '{$product_category_id}' ");
    
    confirm($cat_query);
    
    while($row=fetch_array($cat_query)) {
        
        return $row['cat_title'];
        
    }
}


function display_image($picture) {
    
    global $upload_directory;
    
    return $upload_directory .DS. $picture;
    
    
}

/**********************************Update coding**************/

function update_product() {
    
    
if(isset($_POST['update'])) {
    
    $product_title        = escape_string($_POST['product_title']);
    $product_category_id  = escape_string($_POST['product_category_id']);
    $product_price        = escape_string($_POST['product_price']);
    $product_description  = escape_string($_POST['product_description']);
    $short_desc           = escape_string($_POST['short_desc']);
    $product_quantity     = escape_string($_POST['product_quantity']);
    $product_image        = $_FILES['file']['name'];
    $image_temp_location  = $_FILES['file']['tmp_name'];
    
    
    if(empty($product_image)) {
        
        $get_pic = query("SELECT product_image FROM products WHERE product_id =".$_GET['id'] . " ");
        confirm($get_pic);
        
        while($pic = fetch_array($get_pic)) {
            
            $product_image = $pic['product_image'];
            
        }
        
    }
    
    
    
    
    $moved =move_uploaded_file( $image_temp_location, UPLOAD_DIRECTORY. DS . $product_image);
    
    
 
   $query  ="UPDATE products SET ";
   $query .="product_title       = '{$product_title}'        , ";        
   $query .="product_category_id = '{$product_category_id}'  , ";        
   $query .="product_price       = '{$product_price}'        , ";        
   $query .="product_description = '{$product_description}'  , ";        
   $query .="short_desc          = '{$short_desc}'           , ";        
   $query .="product_quantity    = '{$product_quantity}'     , ";        
   $query .="product_image       = '{$product_image}'          "; 
   $query .="WHERE product_id = ".($_GET['id']);        
    
        
        query($query);
    
    
    confirm($query);
    
    set_message("Product has been updated");
    
    redirect("index.php?products");
    




}


}


function show_categories_in_admin() {
    
    $query = query("SELECT * FROM categories");
    confirm($query);
    
    while($row = fetch_array($query)) {
    
        $cat_id=$row['cat_id'];
        $cat_title=$row['cat_title'];
        
        
        $category= <<<DELIMETER
            
         <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
           <td><a class="btn btn-danger" href="../../resource/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
            
DELIMETER;
    
        echo $category;
    }
    
    
    
    
}


function creat_categories()  {
    
    if(isset($_POST['submit'])) {
        
        $cat_title = escape_string($_POST['cat_title']);
        if(empty($cat_title) && $cat_title =" " ) {
            
            echo "<h4 class='bg-danger'>Cannot be empty</h4>";
            
        } else {
        
        $query=query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
        
                     confirm($query);
 
        }
  
            

        

        
                     
    }
    
    
    
}

function display_users() {
    
    $query =query("SELECT * FROM users");
    
    confirm($query);
    
    while($row = fetch_array($query)) {
        
        $users =<<<OSOS
            
     <tr>

                                        <td>{$row['id']}</td>
                                  
                                        
                                        <td>{$row['username']}</td>
                                        
                                        
                                        <td>{$row['email']}</td>
              <td><a class="btn btn-danger" href="../../resource/templates/back/delete_user.php?id={$row['id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
                                  
                                    </tr>
OSOS;
        
        echo $users;
        
    }
    
    
} 


function insert_user() {
    
    if(isset($_POST['submit'])) {
        
        $username = escape_string($_POST['username']);
        $email    = escape_string($_POST['email']);
        $password = escape_string($_POST['password']);
        
        
    $query =query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
    
        confirm($query);
        set_message("new user added");
        redirect("../../public/admin/index.php?add_user");
        
    
    
}


}




/********************Sildes Function*************************/

function add_slides() {
    
    if(isset($_POST['add_slide'])) {
        
        $slide_title = escape_string($_POST['slide_title']);
        $slide_image = escape_string($_FILES['file']['name']);
        $slide_image_loc = $_FILES['file']['tmp_name'];
        
        if(empty($slide_title) || empty($slide_image))
 {
            
            
            echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
        
   } else {
            
            
            move_uploaded_file( $slide_image_loc, UPLOAD_DIRECTORY .DS .$slide_image);
            
            $query= query("INSERT INTO slides(slide_title,slide_image) VALUES('{$slide_title}','{$slide_image}')");
            
            confirm($query);
            
        }
        
        
        
        
    }
    
    
    
    
    
}

function get_current_slide() {
    
    
    
}





function get_active() {
    
    
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);
    
    while($row= fetch_array($query)) {
        
        
        
        $slides_active = <<<DELIMETER
            
            
            
<div class="item active">
<img  style="height:270px" class="slide-image" src="../resource/uploads/{$row['slide_image']}" alt="">
      </div>
            
            
            
            
DELIMETER;
        
        
        echo $slides_active;
        
        
    }
    
    
}

function get_slides() {
    
    $query = query("SELECT * FROM slides");
    confirm($query);
    
    while($row= fetch_array($query)) {
        
        
        
        $slides = <<<DELIMETER
            
            
            
            <div class="item">
  <img  style="height:270px" class="slide-image" src="../resource/uploads/{$row['slide_image']}" alt="">
      </div>
            
            
            
            
DELIMETER;
        
        
        echo $slides;
        
        
    }
    
    
    
    
}

function get_slide_thumbnails() {
    
    
    
    
    
}

























































?>