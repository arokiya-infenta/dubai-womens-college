
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>Madras School of Social Work</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="#" type="image/x-icon" />
    <link rel="apple-touch-icon" href="#" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://admission.mssw.in//landing/css/bootstrap.min.css" />
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="https://admission.mssw.in//landing/css/pogo-slider.min.css" />
    <!-- Site CSS -->
    <link rel="stylesheet" href="https://admission.mssw.in//landing/css/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="https://admission.mssw.in//landing/css/responsive.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://admission.mssw.in//landing/css/custom.css" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">
      <!-- LOADER -->
      <div id="preloader">
        <div class="loader">
            <img src="https://admission.mssw.in//landing/images/loader.gif" alt="#" />
        </div>
    </div>
    <!-- end loader -->
    <!-- END LOADER -->
    <header class="top-header">
        <nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="https://admission.mssw.in//landing/images/logo.png" alt="image"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                     <!--   <li><a class="nav-link active" href="https://admission.mssw.in//landing/">Home</a></li>
                        <li><a class="nav-link" href="#">About</a></li>
                        <li><a class="nav-link" href="#">Courses</a></li>
                        <li><a class="nav-link" href="#">Reaserch</a></li> -->
						
                        						<li><a class="nav-link" href="https://admission.mssw.in//Home/login">login</a></li>
                       <!-- <li><a class="nav-link" href="https://admission.mssw.in//Home/Register">Register</a></li>-->
                        					  <!-- 	<li><a class="nav-link" href="contact.html">Contact us</a></li> -->
                    </ul>
                </div>
               <!-- <div class="search-box">
                    <input type="text" class="search-txt" placeholder="Search">
                    <a class="search-btn">
                        <img src="https://admission.mssw.in//landing/images/search_icon.png" alt="#" />
                    </a>
                </div>-->
            </div>
        </nav>
    </header>
<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                  
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b; padding: 150px 0px;">
    <div class="container">
           <div class="">

           <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
            <th>Register Number</th>
                <th>Name</th>
               
                <th>Exam</th>
                <th>Date</th>
                <th>Question Attended</th>
                <th>Total Mark</th>
              
            </tr>
        </thead>
        <tbody>

        <?php foreach($student as $str){ ?>
            <tr>
                <td><?php echo "21".sprintf("%'04d", $str->student_id) ?></td>
                <td><?=strtoupper($str->pr_applicant_name)?></td>
                <td><?php if($str->exam_category == "MSCCF"){
                        echo "MSCCP";


                }else{


                    echo $str->exam_category;

                } ?></td>
                <td><?=date('d-m-Y',strtotime($str->start_date))?></td>
                <td><?=$str->question_attended?></td>
                <td><?=$str->total_mark?></td>
              
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <th>Register Number</th>
              <th>Name</th>
                <th>Exam</th>
                <th>Date</th>
                <th>Question Attended</th>
                <th>Total Mark</th>
        </tfoot>
    </table>
</div><!-- /.container -->
        
        
        </div>            

           </div>			  
       </div>
    </div>
<!-- end section -->
<style>

</style>
<!--<footer class="footer-box">
    <div class="container">
    
       <div class="row">
       
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog">
                <div class="full margin-bottom_30">
                   <img src="https://admission.mssw.in//landing/images/footer_logo.png" alt="#" />
                 </div>
                 <div class="full white_fonts">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip </p>
                 </div>
             </div>
          </div>
          
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
               <div class="footer_blog footer_menu white_fonts">
                        <h3>Quick links</h3>
                        <ul> 
                          <li><a href="#">> Join Us</a></li>
                          <li><a href="#">> Maintenance</a></li>
                          <li><a href="#">> Language Packs</a></li>
                          <li><a href="#">> LearnPress</a></li>
                          <li><a href="#">> Release Status</a></li>
                        </ul>
                     </div>
             </div>
             
             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog full white_fonts">
                         <h3>Newsletter</h3>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                         <div class="newsletter_form">
                            <form action="index.html">
                               <input type="email" placeholder="Your Email" name="#" required />
                               <button>Submit</button>
                            </form>
                         </div>
                     </div>
                </div>	 
          
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog full white_fonts">
                         <h3>Contact us</h3>
                         <ul class="full">
                           <li><img src="https://admission.mssw.in//landing/images/i5.png"><span>London 145<br>United Kingdom</span></li>
                           <li><img src="https://admission.mssw.in//landing/images/i6.png"><span>demo@gmail.com</span></li>
                           <li><img src="https://admission.mssw.in//landing/images/i7.png"><span>+12586954775</span></li>
                         </ul>
                     </div>
                </div>	 
          
       </div>
    
    </div>
</footer>
 End Footer -->

<div class="footer_bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="crp">© Copyrights 2021 powered by <a href="https://www.istudiotech.in/" class="ist">iStudio Technologies</a></p>
            </div>
        </div>
    </div>
</div>

<a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>
<style>
.errorClass { border:  1px solid red; }
</style>
<!-- ALL JS FILES -->
<!--<script src="https://admission.mssw.in//landing/js/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.8.3/jquery-ui.js"></script>
<!--<script type="text/javascript" src="https://admission.mssw.in/landing/js/fullscreen/release/jquery.fullscreen-0.3.2.min.js"></script>-->

<script src="https://admission.mssw.in//landing/js/popper.min.js"></script>
<script src="https://admission.mssw.in//landing/js/bootstrap.min.js"></script>
<!-- ALL PLUGINS -->
<script src="https://admission.mssw.in//landing/js/jquery.magnific-popup.min.js"></script>
<script src="https://admission.mssw.in//landing/js/jquery.pogo-slider.min.js"></script>
<script src="https://admission.mssw.in//landing/js/slider-index.js"></script>
<!--<script src="https://admission.mssw.in//landing/js/smoothscroll.js"></script>-->
<script src="https://admission.mssw.in//landing/js/form-validator.min.js"></script>
<script src="https://admission.mssw.in//landing/js/contact-form-script.js"></script>
<script src="https://admission.mssw.in//landing/js/isotope.min.js"></script>
<script src="https://admission.mssw.in//landing/js/images-loded.min.js"></script>
<script src="https://admission.mssw.in//landing/js/custom.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>



<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );


</script>

</body>

</html>