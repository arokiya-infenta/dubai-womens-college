	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          
        </div>
      </div>
    </footer>
	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  
  <script src="<?=base_url()?>white-version/assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/bootstrap.min.js"></script>
	
	<!-- simplebar js -->
	<script src="<?=base_url()?>white-version/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?=base_url()?>white-version/assets/js/waves.js"></script>
	<!-- sidebar-menu js -->
	<script src="<?=base_url()?>white-version/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

  <!--Data Tables js-->
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

    <script>
 /*     $(".delete-tr-dis").click(function(){

var val = $(this).val();
alert(val);
$('#elte-dis'+val).remove();



}); */
     $(document).ready(function() {
      //Default data table

      var i =2;
      var j =2;
      $('#add-diss').click(function(e){
        //alert();
 e.preventDefault();
""
var vx = '<tr id="delte-dis'+i+'"><th scope="row">'+i+'</th><td> <input type="text" class="form-control" id="input-10"></td>'+
      '<td> <input type="file" class="form-control" id="input-10"></td>'+
      '<td><button class="btn btn-danger delete-tr-dis" value="'+i+'" id="add-diss" >X</button></td> </tr>';

$('#app-dis').append(vx); 

i++;


      });


      $(document).on('click','.delete-tr-dis', function(){
       
                var button_id = $(this).val();
              //  alert(button_id);
                $("#delte-dis"+button_id+"").remove();
            });




    $('#add-tres').click(function(e){
        
 e.preventDefault();
 //alert(j);
  var ts='<tr id="delte-tres'+j+'"><th scope="row">'+j+'</th><td> <input type="text" class="form-control" id="input-10"></td>'+
      '<td> <input type="text" class="form-control" id="input-10"></td>'+
      '<td> <input type="date" class="form-control" id="input-10"></td>'+
      '<td> <input type="text" class="form-control" id="input-10"></td>'+
      '<td> <input type="text" class="form-control" id="input-10"></td>'+
      '<td><button class="btn btn-danger delete-tres-dis" value="'+j+'" >X</button></td></tr>';




$('#app-tres').append(ts);  

j++;


      });


      $(document).on('click','.delete-tres-dis', function(){
       
                var button_id = $(this).val();
              //  alert(button_id);
                $("#delte-tres"+button_id+"").remove();
            });


     


       $('#default-datatable').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
       
      } );

    </script>
  
</body>
</html>
