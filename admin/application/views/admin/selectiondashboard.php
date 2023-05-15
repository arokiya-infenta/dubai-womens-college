<style>
 .panel-title {
  position: relative;
}
  
.panel-title::after {
  content: "\f107";
  color: #333;
  top: -2px;
  right: 0px;
  position: absolute;
  font-family: "FontAwesome"
}

.panel-title[aria-expanded="true"]::after {
  content: "\f106";
}
</style>

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
  <!-- Horizontal - start --> 
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">  
   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Selection List <?=$this->session->userdata("user")["user_aca_year"]?></h4></div>
  
</div>
</div>
</div>
</a>
	
  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">	
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">Selection List SF Courses <?php   
						
 $syear = $this->session->userdata("user")["user_aca_year"]."-07-01";
						 $eyear = $this->session->userdata("user")["user_aca_year"] + 1 ."-07-01";
						 
						
						
						?> </div>
            <div class="card-body">

            <?php $cou = $this->db->select('*')->from('college_course')->where('mc_id',2)->where('cs_id !=',3)->where('cs_id !=',4)->get(); 
            
            
            $res = $cou->result();

            $mtsf =0;
            foreach($res as $res){
            

             // $where = '(cs_id !="'.$res->applied_course_id.'")';

              $s = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_course_id",$res->cs_id)
							->where("created >",$syear)
							->where("created <",$eyear)
							->get();

              
              $r =$s->num_rows();// $this->db->where($where);

              $mtsf += $r;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/1/<?=$res->cs_id?>" ><?=$res->cs_name?></a> <b class="ls-view"><?=$r?></b></p>



             <?php 
            }
             ?>
			 
			 <?php

                $tot_sf = 0;

                $sf =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",3)->where("sl_course_id",1)
								->where("created >",$syear)
							->where("created <",$eyear)
								->get();
                $mswsf_1 =$sf->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/3/1" >Community Development</a><b class="ls-view"><?=$mswsf_1?></b></p>
              <?php
                $sf2 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",3)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_2 =$sf2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/3/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswsf_2?></b></p>

              <?php
                $sf3 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",3)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_3 =$sf3->num_rows();// $this->db->where($where);

                $tot_sf = $mtsf + $mswsf_1 + $mswsf_2 +$mswsf_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/3/3" >Human Resource Management</a><b class="ls-view"><?=$mswsf_3?></b></p>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total Selection SF Courses :<b class="ls-view"> <?= $tot_sf?></b></p>
      </div>
          </div>
        </div>
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Selection List MSW Aided Courses</div>
            <div class="card-body">
            <?php
            $tot_aid = 0;
            $aid = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",2)->where("sl_course_id",1)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $mswaid_1 =$aid->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/2/1" >Community Development</a><b class="ls-view"><?=$mswaid_1?></b></p>
              <?php
                $aid2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",2)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_2 =$aid2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/2/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswaid_2?></b></p>

              <?php
                $aid3 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",2)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_3 =$aid3->num_rows();// $this->db->where($where);

                $tot_aid = $mswaid_1 + $mswaid_2 + $mswaid_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/2/3" >Human Resource Management</a><b class="ls-view"><?=$mswaid_3?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Selection MSW Aided  Courses :<b class="ls-view"> <?= $tot_aid?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		 <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-warning text-white">Selection List UG Courses</div>
            <div class="card-body">
            <?php
            $tot_ug = 0;
            $ug = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",5)->where("sl_course_id",1)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $ug_1 =$ug->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/5/1" >B.S.W (SF)</a><b class="ls-view"><?=$ug_1?></b></p>
              <?php
                $ug2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",5)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $ug_2 =$ug2->num_rows();// $this->db->where($where);

                $tot_ug = $ug_1 + $ug_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/5/2" >B.Sc Psychology (SF)</a><b class="ls-view"><?=$ug_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Selection UG  Courses :<b class="ls-view"> <?= $tot_ug?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		<div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Selection List PG-Diploma Courses</div>
            <div class="card-body">
            <?php
            $tot_pg_dip = 0;
            $pgdip = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",4)->where("sl_course_id",10)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $pgdip_1 =$pgdip->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/4/10" >Personnel Management & Industrial Relations (SF)</a><b class="ls-view"><?=$pgdip_1?></b></p>
              <?php
                $pgdip2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",1)->where("sl_main_id",4)->where("sl_course_id",11)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $pgdip_2 =$pgdip2->num_rows();// $this->db->where($where);

                $tot_pg_dip = $pgdip_1 + $pgdip_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentSelectionList/4/11" >Human Resource Management (SF)</a><b class="ls-view"><?=$pgdip_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Selection PG-Diploma  Courses :<b class="ls-view"> <?= $tot_pg_dip?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
      
      </div>
	  
	      </div>	
        </div>
	 </div> 

	 
<!-- Waiting List Starts-->
<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
  <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">	 
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Waiting List <?=$this->session->userdata("user")["user_aca_year"]?></h4></div>
  
</div>
</div>
</div>
</a>		  
  <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
   <div class="panel-body">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">Waiting List SF Courses</div>
            <div class="card-body">

            <?php $cou = $this->db->select('*')->from('college_course')->where('mc_id',2)->where('cs_id !=',3)->where('cs_id !=',4)
							
						->get(); 
            
            
            $res = $cou->result();

            $mtsf =0;
            foreach($res as $res){
            

             // $where = '(cs_id !="'.$res->applied_course_id.'")';

             $s = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_course_id",$res->cs_id)
						 ->where("created >",$syear)
						 ->where("created <",$eyear)->get();

              
              $r =$s->num_rows();// $this->db->where($where);

              $mtsf += $r;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/1/<?=$res->cs_id?>" ><?=$res->cs_name?></a> <b class="ls-view"><?=$r?></b></p>



             <?php 
            }
             ?>
			 
			 <?php

                $tot_sf = 0;

                $sf = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",3)->where("sl_course_id",1)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_1 =$sf->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/3/1" >Community Development</a><b class="ls-view"><?=$mswsf_1?></b></p>
              <?php
                $sf2 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",3)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_2 =$sf2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/3/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswsf_2?></b></p>

              <?php
                $sf3 =$this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",3)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_3 =$sf3->num_rows();// $this->db->where($where);

                $tot_sf = $mtsf + $mswsf_1 + $mswsf_2 +$mswsf_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/3/3" >Human Resource Management</a><b class="ls-view"><?=$mswsf_3?></b></p>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total Waiting SF Courses :<b class="ls-view"> <?= $tot_sf?></b></p>
      </div>
          </div>
        </div>
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Waiting List  MSW Aided Courses</div>
            <div class="card-body">
            <?php
            $tot_aid = 0;
                $aid = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",2)->where("sl_course_id",1)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_1 =$aid->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/2/1" >Community Development</a><b class="ls-view"><?=$mswaid_1?></b></p>
              <?php
                $aid2 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",2)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_2 =$aid2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/2/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswaid_2?></b></p>

              <?php
                $aid3 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",2)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_3 =$aid3->num_rows();// $this->db->where($where);

                $tot_aid = $mswaid_1 + $mswaid_2 + $mswaid_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/2/3" >Human Resource Management</a><b class="ls-view"><?=$mswaid_3?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Waiting MSW Aided  Courses :<b class="ls-view"> <?= $tot_aid?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		 <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-warning text-white">Waiting List UG Courses</div>
            <div class="card-body">
            <?php
            $tot_ug = 0;
            $ug = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",5)->where("sl_course_id",1)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $ug_1 =$ug->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/5/1" >B.S.W (SF)</a><b class="ls-view"><?=$ug_1?></b></p>
              <?php
                $ug2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",5)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $ug_2 =$ug2->num_rows();// $this->db->where($where);

                $tot_ug = $ug_1 + $ug_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/5/2" >B.Sc Psychology (SF)</a><b class="ls-view"><?=$ug_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Waiting UG  Courses :<b class="ls-view"> <?= $tot_ug?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		<div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Waiting List PG-Diploma Courses</div>
            <div class="card-body">
            <?php
            $tot_pg_dip = 0;
            $pgdip = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",4)->where("sl_course_id",10)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $pgdip_1 =$pgdip->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/4/10" >Personnel Management & Industrial Relations (SF)</a><b class="ls-view"><?=$pgdip_1?></b></p>
              <?php
                $pgdip2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",2)->where("sl_main_id",4)->where("sl_course_id",11)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $pgdip_2 =$pgdip2->num_rows();// $this->db->where($where);

                $tot_pg_dip = $pgdip_1 + $pgdip_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentWaitingList/4/11" >Human Resource Management (SF)</a><b class="ls-view"><?=$pgdip_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Waiting PG-Diploma  Courses :<b class="ls-view"> <?= $tot_pg_dip?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
      
      </div>
	  </div>
         </div>
          </div>
							  
	<!-- Not Eligible Starts --> 
<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
  <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="false" aria-controls="collapseOne">	
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Not Eligible List <?=$this->session->userdata("user")["user_aca_year"]?></h4></div>
  
</div>
</div>
</div>
</a>		  
  <div id="collapseOne2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">Not Eligible List SF Courses</div>
            <div class="card-body">

            <?php $cou = $this->db->select('*')->from('college_course')->where('mc_id',2)->where('cs_id !=',3)->where('cs_id !=',4)
						
						->get(); 
            
            
            $res = $cou->result();

            $mtsf =0;
            foreach($res as $res){
            

             // $where = '(cs_id !="'.$res->applied_course_id.'")';

              $s = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_course_id",$res->cs_id)
							->where("created >",$syear)
							->where("created <",$eyear)->get();

              
              $r =$s->num_rows();// $this->db->where($where);

              $mtsf += $r;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/1/<?=$res->cs_id?>" ><?=$res->cs_name?></a> <b class="ls-view"><?=$r?></b></p>



             <?php 
            }
             ?>
			 
			 <?php

                $tot_sf = 0;

                $sf =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",3)->where("sl_course_id",1)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_1 =$sf->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/3/1" >Community Development</a><b class="ls-view"><?=$mswsf_1?></b></p>
              <?php
                $sf2 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",3)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_2 =$sf2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/3/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswsf_2?></b></p>

              <?php
                $sf3 = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",3)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswsf_3 =$sf3->num_rows();// $this->db->where($where);

                $tot_sf = $mtsf + $mswsf_1 + $mswsf_2 +$mswsf_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/3/3" >Human Resource Management</a><b class="ls-view"><?=$mswsf_3?></b></p>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total Not Eligible SF Courses :<b class="ls-view"> <?= $tot_sf?></b></p>
      </div>
          </div>
        </div>
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Not Eligible List MSW Aided Courses</div>
            <div class="card-body">
            <?php
            $tot_aid = 0;
            $aid = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",2)->where("sl_course_id",1)
						->where("created >",$syear)
						->where("created <",$eyear)
						->get();

                $mswaid_1 =$aid->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/2/1" >Community Development</a><b class="ls-view"><?=$mswaid_1?></b></p>
              <?php
                $aid2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",2)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)
								->get();
                $mswaid_2 =$aid2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/2/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswaid_2?></b></p>

              <?php
                $aid3 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",2)->where("sl_course_id",3)
								->where("created >",$syear)
								->where("created <",$eyear)->get();
                $mswaid_3 =$aid3->num_rows();// $this->db->where($where);

                $tot_aid = $mswaid_1 + $mswaid_2 + $mswaid_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/2/3" >Human Resource Management</a><b class="ls-view"><?=$mswaid_3?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Not Eligible MSW Aided  Courses :<b class="ls-view"> <?= $tot_aid?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		 <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-warning text-white">Not Eligible List UG Courses</div>
            <div class="card-body">
            <?php
            $tot_ug = 0;
            $ug = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",5)->where("sl_course_id",1)
						->where("created >",$syear)
						->where("created <",$eyear)->get();

                $ug_1 =$ug->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/5/1" >B.S.W (SF)</a><b class="ls-view"><?=$ug_1?></b></p>
              <?php
                $ug2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",5)->where("sl_course_id",2)
								->where("created >",$syear)
								->where("created <",$eyear)->get();
                $ug_2 =$ug2->num_rows();// $this->db->where($where);

                $tot_ug = $ug_1 + $ug_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/5/2" >B.Sc Psychology (SF)</a><b class="ls-view"><?=$ug_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Not Eligible UG  Courses :<b class="ls-view"> <?= $tot_ug?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
		
		<div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Not Eligible List PG-Diploma Courses</div>
            <div class="card-body">
            <?php
            $tot_pg_dip = 0;
            $pgdip = $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",4)->where("sl_course_id",10)
						->where("created >",$syear)
						->where("created <",$eyear)->get();

                $pgdip_1 =$pgdip->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/4/10" >Personnel Management & Industrial Relations (SF)</a><b class="ls-view"><?=$pgdip_1?></b></p>
              <?php
                $pgdip2 =  $this->db->select('*')->from('shotlisted_candidate')->where("reservation_status",3)->where("sl_main_id",4)->where("sl_course_id",11)	->where("created >",$syear)
								->where("created <",$eyear)->get();
                $pgdip_2 =$pgdip2->num_rows();// $this->db->where($where);

                $tot_pg_dip = $pgdip_1 + $pgdip_2;


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentNotEligibleList/4/11" >Human Resource Management (SF)</a><b class="ls-view"><?=$pgdip_2?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total Not Eligible PG-Diploma  Courses :<b class="ls-view"> <?= $tot_pg_dip?></b></p>
            </div>
          </div>
          </div>
          </div>
        </div>
      
      </div>
	  </div>
       </div>
        </div>

     
       <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    
   .ls-view {
    float: right;
    color: black;
}
    </style>
