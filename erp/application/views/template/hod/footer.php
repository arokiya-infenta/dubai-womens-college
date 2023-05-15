	
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
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
  <!--Select Plugins Js-->
    <script src="<?php echo base_url('').'white-version/assets/plugins/select2/js/select2.min.js'; ?>"></script>
  <!--Multi Select Js-->
    <script src="<?php echo base_url().'white-version/assets/plugins/jquery-multi-select/jquery.multi-select.js'; ?>"></script>
    <script src="<?php echo base_url().'white-version/assets/plugins/jquery-multi-select/jquery.quicksearch.js'; ?>"></script>
    
    
    <script>
        $(document).ready(function() {
            $('.single-select').select2();
      
            $('.multiple-select').select2();

        //multiselect start

            $('#my_multi_select1').multiSelect();
            $('#my_multi_select2').multiSelect({
                selectableOptgroup: true
            });

            $('#my_multi_select3').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function (ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });

         $('.custom-header').multiSelect({
              selectableHeader: "<div class='custom-header'>Selectable items</div>",
              selectionHeader: "<div class='custom-header'>Selection items</div>",
              selectableFooter: "<div class='custom-header'>Selectable footer</div>",
              selectionFooter: "<div class='custom-header'>Selection footer</div>"
            });



          });

    </script>

    <script>
 $(document).ready(function() {



$('#example1').DataTable();
       $('#default-datatable').DataTable();

       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 8, "desc" ]],
        
      } ); 
      
      var shotlisted = $('#shortlisted').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 0, "asc" ]],
        "paging":   false,
        
      } );
      
      var zoom = $('#examplezoomview').DataTable( {
        lengthChange: false,
		paginate: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 5, "desc" ]],
        
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );
	 
$('#example_fees_master').DataTable( {	 
} );

var base_url = "<?php echo base_url(); ?>";
var myTable = $('#attendance-datatable').DataTable({"iDisplayLength": 50, order: [[1, 'asc']], "search": {regex: true, smart: false}}).column(1).search('$', true, true).draw();

var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
	/*var month1 = $('#month').val();
	var month2 = month1.split('-');
	var month3 = month2[1];
	var month = monthNames[month3 -1];*/
	var date = $('#date').val();
	
 var subject_name_a = $('#subject_name').val();	
 var subject_code_a = $('#subject_code').val();	
 var batch_a = $('#batch').val();	
 var dept_a = $('#department').val();	
		$('#attendance-report'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+subject_name_a+'_ '+date+'',
				//exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5, 6]
                //  }
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
				   
				   doc.styles.tableHeader.fontSize = 8;    
				   doc.defaultStyle.alignment = 'center';
				   doc.styles.tableHeader.alignment = 'center';
				   //doc.styles.tableHeader.alignment = 'center';
				   //doc.content[1].table.headerRows = 0; //Only the first page will show the header
				   //doc.content[1].margin = [ 20, 0, 20, 0 ] //left, top, right, bottom	
                   //doc.content[1].table.widths = 
                   //Array(doc.content[1].table.body[0].length + 1).join('*').split('');
				   //doc.content[1].table.widths = [90,90,90,90,90,90,90,90];
				   var rowCount = doc.content[1].table.body.length;
                     for (i = 1; i < rowCount; i++) {
                       doc.content[1].table.body[i][1].alignment = 'left';
                       doc.content[1].table.body[i][2].alignment = 'left';
				       doc.content[1].table.body[i][2].uppercase = true;
                     };
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 12; };
                        objLayout['paddingRight'] = function(i) { return 12; };
                        objLayout['paddingTop'] = function(i) { return 12; };
                        objLayout['paddingBottom'] = function(i) { return 12; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					
					doc.content.splice(1, 1, {
                        margin: [ 0, 10, 0, 0 ],
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [  {text: 'DEPARTMENT: \t'+dept_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n BATCH:  \t\t\t\t'+batch_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n SUBJECT CODE:  '+subject_code_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n SUBJECT NAME: '+subject_name_a+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
                    doc.content.splice(3, 0, {

                        table: {
                            widths: [300, '*', '*'],
                            body: [
                                [
                                    {text: '', background: '#fff'}
                                    , {text: 'ATTENDANCE', bold: true, fontSize: 10,fillColor:'#00394d',color:'white'}
                                    , {text: 'OD', bold: true, fontSize: 10,fillColor:'#00394d',color:'white'}]
                            ]
                        },

                        margin: [0, 0, 0, 0],
                        alignment: 'center'
                    });
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });
		

                },
				/*exportOptions: {

                 format: {
                   header: function ( data, columnIdx ) {
                   return data.toUpperCase();
                   },
				   body: function ( data, row, column, node ) {
                   return column === 1 ?
                   data.toUpperCase() :
                   data;
                   }
                 },

                 modifier: {
                   pageMargins: [0, 0, 0, 0], // try #3 setting margins
                   margin: [0, 0, 0, 0], // try #4 setting margins
                   alignment: 'center'
                   },
                }*/
			}],
			  'columnDefs': [ {
                'targets': [3,4,5,6,7,8,9,10,11,12,13,14], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }]
		} );
		
	
 var from_date_c = $('#from_date1').val();	
 var to_date_c = $('#to_date1').val();	
 var subject_name_c = $('#subject_name').val();	
 var subject_code_c = $('#subject_code').val();	
 var batch_c = $('#batch').val();	
 var dept_c = $('#department').val();	
		$('#attendance-consolidated'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: ''+subject_name_c+'_ ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+subject_name_c+'_ '+currentDate+'',
				orientation:'landscape'
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+subject_name_c+'_ '+currentDate+'',
				//exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5, 6]
                //  }
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
				   
				   doc.styles.tableHeader.fontSize = 8;    
				   doc.defaultStyle.alignment = 'center';
				   doc.styles.tableHeader.alignment = 'center';
				   doc.content[1].table.widths = [ '5%', '14%', '30%', '10%', '10%', '10%', '10%', '12%'];
				   var rowCount = doc.content[1].table.body.length;
                     for (i = 1; i < rowCount; i++) {
                       doc.content[1].table.body[i][1].alignment = 'center';
                       doc.content[1].table.body[i][2].alignment = 'left';
				       doc.content[1].table.body[i][2].uppercase = true;
                     };
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .19; };
                        objLayout['vLineWidth'] = function(i) { return .19; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .17; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					
					doc.content.splice( 1, 1, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: 'SUBJECT WISE ATTENDANCE DETAILS',
						margin: [0, 0, 0, 0],
                    } );
					
                    doc.content.splice(2, 0, {
                        margin: [ 0, 10, 0, 0 ],
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [ {text: 'FROM DATE ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t TO DATE ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t\t DEPARTMENT ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t BATCH ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t SUBJECT CODE ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t\t SUBJECT NAME: \t'+subject_name_c+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
					
					 doc.content.splice(3, 0, {
                        margin: [ 0, 0, 0, 0 ],//left, top, right, bottom
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [ {text: ''+from_date_c+' ', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t '+to_date_c+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t  '+dept_c+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t\t\t  '+batch_c+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t\t  '+subject_code_c+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });

                },
				exportOptions: {

                 format: {
                   header: function ( data, columnIdx ) {
                   return data.toUpperCase();
                   },
				   body: function ( data, row, column, node ) {
                   return column === 3 ?
                   data.toUpperCase() :
                   data;
                   }
                 },

                 modifier: {
                   pageMargins: [0, 0, 0, 0], // try #3 setting margins
                   margin: [0, 0, 0, 0], // try #4 setting margins
                   alignment: 'center'
                   },
                }
			}]
		} );	
    </script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
    </script>
	<script>
	$(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});
    </script>
	<script>
	$(function () {
  $("#leave_dates").datepicker({ 
        multidate: true
  }).datepicker();
});
    </script>
	 
	
</body>
</html>
