<?php require_once("config.php"); ?>
<?php 


if(isset($_GET['add'])) {
    

    $query = query("SELECT * FROM products WHERE product_id=" .escape_string($_GET['add']). " ");
    
    confirm($query);
    
    
    while($row = fetch_array($query)) {
        
        if($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]) {
            
           $rq= $_SESSION['product_'. $_GET['add']] +=1;
            
             redirect("../public/checkout.php");
            
            
        } else {
            
            set_message("WE ONLY HAVE " . $row['product_quantity'] . " " . "Avaliable");
             redirect("../public/checkout.php");
        }
        
        
    }
}

if (isset($_GET['remove'])) {
    
    $_SESSION['product_'.$_GET['remove']]--;
    
    if($_SESSION['product_'.$_GET['remove']] < 1) {
           unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
   
        
         redirect("../public/checkout.php");
        
    }else {
        
         redirect("../public/checkout.php");
    }
    
    
}
if (isset($_GET['delete'])) {
    
    $_SESSION['product_'.$_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
     redirect("../public/checkout.php");
}

function cart() { 
    
   $total = 0;
   $totalss = 0;
   $sub = 0;
    
    foreach($_SESSION as $name => $value) {
        
        if($value>0) {
        
        if(substr($name,0,8) == "product_") {
             
            (int)$length = strlen((int)$name - 8);
            
            (int)$id = substr($name , 8 , $length);
            
    $query = query("SELECT * FROM products WHERE product_id = " .escape_string($id). " ");
    confirm($query);
            
            
            
            
    
    while($row=fetch_array($query)) { 
        
        $sub = $row['product_price']*$value;
        
       $product_image = display_image($row['product_image']);
        
        $product =<<<DELIMETER
            
            <tr>
                <td>{$row['product_title']} <br>
            
            <img width='100' src='../resource/{$product_image}'>
            </td>
                <td>{$row['product_price']}</td>
                <td>$value</td>
                <td>{$row['product_quantity']}</td>
                <td>$sub</td>
                <td><a  class='btn btn-success' href="../resource/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a>
               <a class='btn btn-warning'href="../resource/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
               <a class='btn btn-danger' href="../resource/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a></td>
              
              
            </tr>
            
            
            
            DELIMETER;
        
          echo $product;
        
    }
          $_SESSION['item_total']= $total +=$sub; 
          $_SESSION['item_quantity']  = $totalss +=$value; 
            
        }
    }
        
        
    }
    
}


function process_transaction() { 
    

    
    if(isset($_GET['tx'])) {
    
    
    $amount = $_GET['tx'];
    $currency= $_GET['cc'];
    $transaction = $_GET['amt'];
    $status= $_GET['st'];
    
    
    $send_order= query("INSERT INTO orders 
    
    (order_amount,order_transaction,order_status,order_currency) VALUES('{$amount}', 
    
    '{$currency}','{$transaction}','{$status}')");
    
      confirm($send_order);
        
        
        $last_id = last_id();
   
        
  
 
    
    
    
  

    
    
    
   $total = 0;
$item_quantity=0;
$sub=0;
    
    foreach($_SESSION as $name => $value) {
        
        if($value>0) {
        
        if(substr($name,0,8) == "product_") {
             
            (int)$length = strlen((int)$name - 8);
            
            (int)$id = substr($name , 8 , $length);
            
    $query = query("SELECT * FROM products WHERE product_id = " .escape_string($id). " ");
    confirm($query);
    
    while($row=fetch_array($query)) { 
        
        $product_price=$row['product_price'];
        $product_title=$row['product_title'];
        $sub = $row['product_price']*$value;
        $item_quantity +=$value; 
        
        
        
        
          $insert_report= query("INSERT INTO reports(product_id,order_id,product_price,product_title,product_quantity) VALUES('{$id}','{$last_id}','{$product_price}','{$product_title}','{$value}')");
        
        confirm($insert_report);
        
        
        
        
        
        
        
        
        
        
    }
      $total +=$sub; 
   echo $item_quantity; 
            
        }
    }
        
        
    }
        
    } 
    
    session_destroy();
    
 
    
    
    
    
}



?>
