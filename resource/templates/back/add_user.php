        
  <div class="col-lg-12">


      <h1>Add User</h1>




 <h4 class="btn-success"><?php display_message(); ?> </h4>
<?php insert_user(); ?>
<div class="col-sm-4 col-sm-offset-5">
         
            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="form-group"><label for="">
                    username<input type="username" name="username" class="form-control"></label>
                </div>
                  <div class="form-group"><label for="">
                    Email<input type="email" name="email" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="password" name="password" class="form-control"></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
            </form>
        </div>  
      
</div>