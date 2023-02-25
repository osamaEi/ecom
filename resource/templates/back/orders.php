

                


        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Orders

</h1>
    
    <h4 text=center class="bg-danger"><?php display_message(); ?></h4>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>id</th>
           <th>Amount</th>
           <th>Transaction</th>
           <th>currency</th>
           <th>status</th>
           <th>Delete</th>
     
      </tr>
    </thead>
    <tbody>
   
        <?php display_order(); ?>
        
    
    </tbody>
</table>
</div>











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

</body>

</html>
