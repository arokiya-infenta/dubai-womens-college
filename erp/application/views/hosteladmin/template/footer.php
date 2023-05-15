   <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   &copy;Hostel Management System |<a href="https://iStudiotech.com/" target="_blank"  > Designed by : iStudiotech</a> 
                </div>

            </div>
        </div>
    </section>

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/bootstrap-datepicker.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript
<script src="<?php echo base_url();?>hostelassets/dist/js/raphael-min.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/morris.min.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/morris-data.js"></script>
-->
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/sb-admin-2.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/dataTable.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/timepicker.js"></script>

<script src="<?php echo base_url();?>hostelassets/dist/js/modernizr.custom.63321.js"></script>

<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.calendario.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/data.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/app.js"></script>

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
  
  <!--Datepicker-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>



<script type="text/javascript">
    $( document ).ready(function() {

        $('.datepicker').datepicker();

    });
</script>
<script type="text/javascript">
    $(function() {

        var transEndEventNames = {
                'WebkitTransition' : 'webkitTransitionEnd',
                'MozTransition' : 'transitionend',
                'OTransition' : 'oTransitionEnd',
                'msTransition' : 'MSTransitionEnd',
                'transition' : 'transitionend'
            },
            transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
            $wrapper = $( '#custom-inner' ),
            $calendar = $( '#calendar' ),
            cal = $calendar.calendario( {
                onDayClick : function( $el, $contentEl, dateProperties ) {

                    if( $contentEl.length > 0 ) {
                        showEvents( $contentEl, dateProperties );
                    }

                },
                caldata : codropsEvents,
                displayWeekAbbr : true
            } ),
            $month = $( '#custom-month' ).html( cal.getMonthName() ),
            $year = $( '#custom-year' ).html( cal.getYear() );

        $( '#custom-next' ).on( 'click', function() {
            cal.gotoNextMonth( updateMonthYear );
        } );
        $( '#custom-prev' ).on( 'click', function() {
            cal.gotoPreviousMonth( updateMonthYear );
        } );

        function updateMonthYear() {
            $month.html( cal.getMonthName() );
            $year.html( cal.getYear() );
        }

        // just an example..
        function showEvents( $contentEl, dateProperties ) {

            hideEvents();

            var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Events for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>' ),
                $close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

            $events.append( $contentEl.html() , $close ).insertAfter( $wrapper );

            setTimeout( function() {
                $events.css( 'top', '0%' );
            }, 25 );

        }
        function hideEvents() {

            var $events = $( '#custom-content-reveal' );
            if( $events.length > 0 ) {

                $events.css( 'top', '100%' );
                Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

            }

        }

    });
</script>
</body>

</html>
