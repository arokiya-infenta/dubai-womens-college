<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=base_url()?>digitalBanner/css/style.css">
</head>
<body>
    

<div class="mssw">
<?php  if(sizeof($announcements)==0 && sizeof($notification) == 0){

    $disp ='style="display: none;"';
}else{
    $disp="";

} ?>

    <div class="left-section" <?=$disp?>>
        <div class="text-content">
            <div class="logo">
                <img src="<?=base_url()?>digitalBanner/images/mssw_logo.png" width="100" alt="">
            </div>
            <div class="header-text">
                <h1>MADRAS SCHOOL OF SOCIAL WORK</h1>
                <p>(An autonoumous institution affiliated to the university of Madras)</p>
                <p>Accredited by NAAC with "A" Grade</p>
            </div>
        </div>
        <div class="text-scroll-content">
            <h2>Announcements & Events</h2>
            <div class="scroll-box" >
                <div class="slide-txt">
                   
                <?php foreach ($announcements as $key => $value) { ?>
                               <p><?=$value->content?></p>
              <?php  } ?> 
              
              <?php foreach ($notification as $key => $value) { ?>
                               <p></p>

                               <p><b>Title : <?=$value->title?> Start Date : <?=$value->start_date?>  End Date :<?=$value->end_date?> Start time :<?=$value->start_time?> End Time :<?=$value->end_time?></b><br>
                               
                               <?=$value->discription?></p>


              <?php  } ?>

             
             
                </div>
                
            </div>
        </div>
    </div>

    <div class="right-section">

    <?php   $vid = $this->db->select('*')->from("digital_board_video")->where('status',1)->get();
    
    $num = $vid->num_rows();

    if($num > 0){
    
    ?>
        <div class="video">
            <video src="<?=base_url()?>digitalBanner/<?=$videos[0]->v_video_name?>"  controls autoplay></video>
        </div>

        <?php } ?>
        <h2>Photo & Video Gallery</h2>
       
        <div class="slideshow-container">


        <?php foreach ($gallery as $key => $value) { ?>


            <div class="mySlides fade">
              <img src="<?=base_url()?>digitalBanner/<?=$value->image_name?>" style="width:100%; height: 100%;" >
            </div>
                              
              <?php  } ?> 


          
            
           
            
            <div style="text-align:center" class="dot-content">

            <?php foreach ($gallery as $key => $value) { ?>


                <span class="dot"></span> 
                  
  <?php  } ?> 
              
                
              </div>


            </div>
            <br>
            
           
            
		<br>

		
    </div>
</div>













<script src="<?=base_url()?>digitalBanner/js/main.js"></script>
<script>
	/* setInterval(function() {
					window.location.replace('<?=base_url()."DigitalBanner"?>');
                }); */

</script>


</body>
</html>