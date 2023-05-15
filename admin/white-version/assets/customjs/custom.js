$(document).ready(function(){

$('#default-datatable').DataTable();


var table = $('#example').DataTable( {
 lengthChange: false,
 buttons: [ 'excel', 'pdf' ]
} );

table.buttons().container()
 .appendTo( '#example_wrapper .col-md-6:eq(0)' );


	//alert();
	$('#add-building').click(function(){
		var build_name = $('#build_name').val();
		   $.ajax({
            type: 'POST',
            url: '<?=base_url()?>Admin/addBuilding', 
            data: { build_name:build_name},
        })
        .done(function(data){
			if(data == "exists"){
			error_noti();
			}else{
			info_noti();
			}
			 setTimeout(function() {
				location.reload();
			}, 5000);
        })
        .fail(function() {
            alert( "Posting failed." );
        });
	});



	$('#add-floor').click(function(){
		var building_id = $('#building_id').val();
		var floor_name = $('#floor_name').val();
		   $.ajax({
            type: 'POST',
            url: '<?=base_url()?>Admin/addFloor', 
            data: { building_id:building_id,floor_name:floor_name},
        })
        .done(function(data){
			if(data == "success"){

			info_noti();
			}
		 	 setTimeout(function() {
				location.reload();
			}, 5000); 
        })
        .fail(function() {
            alert( "Posting failed." );
        });
	});
});
$('.edit-building').click(function(){
	
			var id  = 	$(this).val();
			var name = $('#build_name'+id).val();
		$.ajax({
            type: 'POST',
            url: '<?=base_url()?>Admin/editBuilding', 
            data: { id:id,name:name},
        }).done(function(data){
 			if(data == "success"){
			edit_building();
			}
			 setTimeout(function() {
				location.reload();
			}, 5000);
        })
        .fail(function() {
                    alert( "Posting failed." );
         }); 
	
});

$('.delete-building').click(function(){
	
	var id  = 	$(this).val();
	
	$.ajax({
            type: 'POST',
            url: '<?=base_url()?>Admin/deleteBuilding', 
            data: { id:id},
        }).done(function(data){
 			if(data == "success"){
			delete_building();
			}
			 setTimeout(function() {
				location.reload();
			}, 5000);
        })
        .fail(function() {
                    alert( "Posting failed." );
         }); 
	
	
});




$('.deletem-bill').click(function(){

var id = $(this).val();

//alert();
$.ajax({
	type: 'POST',
	url: '<?=base_url()?>Admin/deleteMSBill', 
	data: { id:id},
}).done(function(data){
	 if(data == "success"){
		delete_billing();
	}
	 setTimeout(function() {
		location.reload();
	}, 5000);
})
.fail(function() {
			alert( "Posting failed." );
 });  
 

});




$('.notification-delete').click(function(){


	var valu = $(this).val();
	
	
	//alert(valu);
	
	 $.ajax({
		type: 'POST',
		url: 'Admin/deleteNotification', 
		data: { valu:valu},
	}).done(function(data){
	
	//alert(data);
	
	})
	
	
	});
	


	function delete_building(){
		
		
		Lobibox.notify('error', {
		    pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
		    position: 'top right',
		    icon: 'fa fa-times-circle',
		    msg: 'Building deleted successfully.'
		    });

	}

	function edit_building(){
			Lobibox.notify('info', {
		    pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
		    position: 'top right',
		    icon: 'fa fa-info-circle',
		    msg: 'Update Building Successfully.'
		    });
		  }

  function info_noti(){
			Lobibox.notify('info', {
		    pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
		    position: 'top right',
		    icon: 'fa fa-info-circle',
		    msg: 'Building Successfully inserted.'
		    });
		  }
 
	  function error_noti(){
			Lobibox.notify('error', {
		    pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
		    position: 'top right',
		    icon: 'fa fa-times-circle',
		    msg: 'Building name Exists.'
		    });
		  }	

function delete_billing(){
			Lobibox.notify('error', {
		    pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
		    position: 'top right',
		    icon: 'fa fa-times-circle',
		    msg: 'Bill Deleted Successfully.'
		    });
		  }	
