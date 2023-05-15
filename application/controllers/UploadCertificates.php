<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadCertificates extends CI_Controller {


	public function __construct()
    {
    parent::__construct();
    error_reporting(0);
    ini_set('display_errors', 0);  
	$this->load->library('upload');
    $this->upload->initialize($this->do_upload());
    }

    public function UpdateMyCertificatesPg(){




     ///==================sslc =======================//
     $sslc_name = $this->input->post('stu_pr_sslc');
     $sslc_file =$this->upload->do_upload('pr_sslc');
     $upload_sslc = $this->upload->data();
     
 
         if($sslc_file){
 
         
 
             $sslc_cer =$upload_sslc['file_name'];
         }else{
             if($sslc_name == null){
                         $sslc_cer = null;
             }else{
 
                 $sslc_cer = $sslc_name;
 
             }
         }


     ///==================Plus one=======================//
     $plusone_1_name = $this->input->post('stu_pr_plus_one');
     $plusone_1_file =$this->upload->do_upload('pr_plus_one');
     $upload_plusone_1_file = $this->upload->data();
     
 
         if($plusone_1_file){
 
         
 
             $pr_plusone_1 =$upload_plusone_1_file['file_name'];
         }else{
             if($plusone_1_name == null){
                         $pr_plusone_1 = null;
             }else{
 
                 $pr_plusone_1 = $plusone_1_name;
 
             }
         }



     ///==================Plus 2=======================//
     $plus_two_1_name = $this->input->post('stu_pr_plus_two');
     $plus_two_1_file =$this->upload->do_upload('pr_plus_two');
     $upload_plus_two_1_file = $this->upload->data();
     
 
         if($plus_two_1_file){
 
         
 
             $pr_plus_two_1 =$upload_plus_two_1_file['file_name'];
         }else{
             if($plus_two_1_name == null){
                         $pr_plus_two_1 = null;
             }else{
 
                 $pr_plus_two_1 = $plus_two_1_name;
 
             }
         }














        ///==================Semester one=======================//
        $semester_1_name = $this->input->post('stu_pr_semester_1');
        $semester_1_file =$this->upload->do_upload('pr_semester_1');
        $upload_semester_1_file = $this->upload->data();
        
    
            if($semester_1_file){
    
            
    
                $pr_semester_1 =$upload_semester_1_file['file_name'];
            }else{
                if($semester_1_name == null){
                            $pr_semester_1 = null;
                }else{
    
                    $pr_semester_1 = $semester_1_name;
    
                }
            }
    
        ///==================Semester two=======================//
        $semester_2_name = $this->input->post('stu_pr_semester_2');
        $semester_2_file =$this->upload->do_upload('pr_semester_2');
        $upload_semester_2_file = $this->upload->data();
        
    
            if($semester_2_file){
    
            
    
                $pr_semester_2 =$upload_semester_2_file['file_name'];
            }else{
                if($semester_2_name == null){
                            $pr_semester_2 = null;
                }else{
    
                    $pr_semester_2 = $semester_2_name;
    
                }
            }
        ///==================Semester three=======================//
        $semester_3_name = $this->input->post('stu_pr_semester_3');
        $semester_3_file =$this->upload->do_upload('pr_semester_3');
        $upload_semester_3_file = $this->upload->data();
        
    
            if($semester_3_file){
    
            
    
                $pr_semester_3 =$upload_semester_3_file['file_name'];
            }else{
                if($semester_3_name == null){
                            $pr_semester_3 = null;
                }else{
    
                    $pr_semester_3 = $semester_3_name;
    
                }
            }
    
        ///==================Semester Four=======================//
        $semester_4_name = $this->input->post('stu_pr_semester_4');
        $semester_4_file =$this->upload->do_upload('pr_semester_4');
        $upload_semester_4_file = $this->upload->data();
        
    
            if($semester_4_file){
    
            
    
                $pr_semester_4 =$upload_semester_4_file['file_name'];
            }else{
                if($semester_4_name == null){
                            $pr_semester_4 = null;
                }else{
    
                    $pr_semester_4 = $semester_4_name;
    
                }
            }
    
    
    
    ///==================Semester Five=======================//
    $semester_5_name = $this->input->post('stud_pr_semester_5');
    $semester_5_file =$this->upload->do_upload('pr_semester_5');
    $upload_semester_5_file = $this->upload->data();
    
    
        if($semester_5_file){
    
        
    
            $pr_semester_5 =$upload_semester_5_file['file_name'];
        }else{
            if($semester_5_name == null){
                        $pr_semester_5 = null;
            }else{
    
                $pr_semester_5 = $semester_5_name;
    
            }
        }
    
    
    ///==================Semester SIX=======================//
    $semester_6_name = $this->input->post('stud_pr_semester_6');
    $semester_6_file =$this->upload->do_upload('pr_semester_6');
    $upload_semester_6_file = $this->upload->data();
    
    
        if($semester_6_file){
    
        
    
            $pr_semester_6 =$upload_semester_6_file['file_name'];
        }else{
            if($semester_6_name == null){
                        $pr_semester_6 = null;
            }else{
    
                $pr_semester_6 = $semester_6_name;
    
            }
        }
    
    
    ///==================Semester Seven=======================//
    $semester_7_name = $this->input->post('stud_pr_semester_7');
    $semester_7_file =$this->upload->do_upload('pr_semester_7');
    $upload_semester_7_file = $this->upload->data();
    
    
        if($semester_7_file){
    
        
    
            $pr_semester_7 =$upload_semester_7_file['file_name'];
        }else{
            if($semester_7_name == null){
                        $pr_semester_7 = null;
            }else{
    
                $pr_semester_7 = $semester_7_name;
    
            }
        }
    
    
    ///==================Semester Eight=======================//
    $semester_8_name = $this->input->post('stud_pr_semester_8');
    $semester_8_file =$this->upload->do_upload('pr_semester_8');
    $upload_semester_8_file = $this->upload->data();
    
    
        if($semester_8_file){
    
        
    
            $pr_semester_8 =$upload_semester_8_file['file_name'];
        }else{
    
          

            if($semester_8_name == null){
                        $pr_semester_8 = null;
            }else{
    
                $pr_semester_8 = $semester_8_name;
    
            }
        }
    
    
    ////=======================dessiabledr=====================//
    
    $abled_cert_name = $this->input->post('abled_cert_name');
    $abled_cer = $this->upload->do_upload('abled_certificate');
    $dataabled = $this->upload->data();
    
    
    if($abled_cer){
    
    
    
    $abled_certificate =$dataabled['file_name'];
    }else{
    if($abled_cert_name == null){
                $abled_certificate = null;
    }else{
    
        $abled_certificate = $abled_cert_name;
    
    }
    }
    
    
    ///==================Provisional=======================//
    $semester_9_name = $this->input->post('stud_pr_provisional_pg_cer');
    $semester_9_file =$this->upload->do_upload('pr_provisional_pg_cer');
    $upload_semester_9_file = $this->upload->data();
    
    
        if($semester_9_file){
    
        
    
            $pr_semester_9 =$upload_semester_9_file['file_name'];
        }else{
            if($semester_9_name == null){
                        $pr_semester_9 = null;
            }else{
    
                $pr_semester_9 = $semester_9_name;
    
            }
        }
    
    
            ///==================UG=======================//
    $semester_10_name = $this->input->post('stud_pr_ug_cer');
    $semester_10_file =$this->upload->do_upload('pr_ug_cer');
    $upload_semester_10_file = $this->upload->data();
    
    
        if($semester_10_file){
    
        
    
            $pr_semester_10 =$upload_semester_10_file['file_name'];
        }else{
            if($semester_10_name == null){
                        $pr_semester_10 = null;
            }else{
    
                $pr_semester_10 = $semester_10_name;
    
            }
        }
    
    
            ///==================Comunity =======================//
            $semester_11_name = $this->input->post('stud_pr_community_cer');
            $semester_11_file =$this->upload->do_upload('pr_community_cer');
            $upload_semester_11_file = $this->upload->data();
            
        
                if($semester_11_file){
        
                
        
                    $pr_semester_11 =$upload_semester_11_file['file_name'];
                }else{
                    if($semester_11_name == null){
                                $pr_semester_11 = null;
                    }else{
        
                        $pr_semester_11 = $semester_11_name;
        
                    }
                }
        
            ///==================Cummulative=======================//
            $semester_12_name = $this->input->post('stud_pr_cummulative_cer');
            $semester_12_file =$this->upload->do_upload('pr_cummulative_cer');
            $upload_semester_12_file = $this->upload->data();
            
        
                if($semester_12_file){
        
                
        
                    $pr_semester_12 =$upload_semester_12_file['file_name'];
                }else{
                    if($semester_12_name == null){
                                $pr_semester_12 = null;
                    }else{
        
                        $pr_semester_12 = $semester_12_name;
        
                    }
                }	
    
    ///==================Transfer=======================//
    $semester_13_name = $this->input->post('stud_pr_transfer_cer');
    $semester_13_file =$this->upload->do_upload('pr_transfer_cer');
    $upload_semester_13_file = $this->upload->data();
    
    
        if($semester_13_file){
    
        
    
            $pr_semester_13 =$upload_semester_13_file['file_name'];
        }else{
            if($semester_13_name == null){
                        $pr_semester_13 = null;
            }else{
    
                $pr_semester_13 = $semester_13_name;
    
            }
        }
        
        
    
    
    
    ///==================Transfer=======================//
    $semester_14_name = $this->input->post('stud_pr_conduct_cer');
  
    $semester_14_file =$this->upload->do_upload('pr_conduct_cer');
    
    $upload_semester_14_file = $this->upload->data();
  
    
    
        if($semester_14_file){
    
        
    
            $pr_semester_14 =$upload_semester_14_file['file_name'];
        }else{



            $error = array('error' => $this->upload->display_errors());
            if($semester_14_name == null){
                        $pr_semester_14 = null;
            }else{
    
                $pr_semester_14 = $semester_14_name;
    
            }
        }	
        
        
    
    //--------------------------------basic------------------//
      ///==================Transfer=======================//
 
////=======================dessiabledr=====================//

$abled_cert_name = $this->input->post('abled_cert_name');
$abled_cer = $this->upload->do_upload('abled_certificate');
$dataabled = $this->upload->data();


if($abled_cer){



	$abled_certificate =$dataabled['file_name'];
}else{
	if($abled_cert_name == null){
				$abled_certificate = null;
	}else{

		$abled_certificate = $abled_cert_name;

	}
}

    
    
    $update_details = array(
        
        'pr_sslc'=>$sslc_cer,
        'pr_plus_one'=>$pr_plusone_1,
        'pr_plus_two'=>$pr_plus_two_1,
        'pr_semester_1'=>$pr_semester_1,
        'pr_semester_2'=>$pr_semester_2,
        'pr_semester_3'=>$pr_semester_3,
        'pr_semester_4'=>$pr_semester_4,
        'pr_semester_5'=>$pr_semester_5,
        'pr_semester_6'=>$pr_semester_6,
        'pr_semester_7'=>$pr_semester_7,
        'pr_semester_8'=>$pr_semester_8,
        'pr_provisional_pg_cer'=>$pr_semester_9,
        'pr_ug_cer'=>$pr_semester_10,
        'pr_community_cer'=>$pr_semester_11,
        'pr_cummulative_cer'=>$pr_semester_12,
        'pr_transfer_cer'=>$pr_semester_13,
        'pr_conduct_cer'=>$pr_semester_14,
        'pr_abled_certificate'=>$abled_certificate,
    );
    
 


    if($this->session->userdata('user')['user_m_course'] == 3){

  $this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_dip',$update_details);
   
    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Files Updated Successfully .
    </div>');
    }else{
  $this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_pg',$update_details);
   
    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Files Updated Successfully .
    </div>');

    }

  
    
    
        redirect('Home/dashBoard');




       
    }
    
    public function UpdateMyCertificatesUg(){



        $payed=$this->uri->segment(3);
        $apply = $this->input->post('appli');
        
        
        
            $image_P = $this->input->post('ppimage');
            $stu_certificate = $this->input->post('stu_certificate');
        
        
            $this->upload->initialize($this->do_upload());
            $hh =$this->upload->do_upload('profile-img');
            $dataInfo = $this->upload->data();
            
        
                if($hh){
        
                
        
                    $filename =$dataInfo['file_name'];
                }else{
                    if($image_P == null){
                                $filename = null;
                    }else{
        
                        $filename = $image_P;
        
                    }
                }
                //$this->upload->initialize($this->do_upload());
        
                ///==================sslc=======================//
                $image_sslc = $this->input->post('stu_sslccert');
                $sslccert =$this->upload->do_upload('sslccert');
                $datasslccert = $this->upload->data();
                
            
                    if($sslccert){
            
                    
            
                        $sslc =$datasslccert['file_name'];
                    }else{
                        if($image_sslc == null){
                                    $sslc = null;
                        }else{
            
                            $sslc = $image_sslc;
            
                        }
                    }
            
        ////=======================HSC FIRST=====================//
                    $image_hs1 = $this->input->post('stu_hs_fir_certi');
                    $hsc1 =$this->upload->do_upload('hs_fir_certi');
                    $datahsc1 = $this->upload->data();
                
            
                    if($hsc1){
            
                    
            
                        $certhsc1 =$datahsc1['file_name'];
                    }else{
                        if($image_hs1 == null){
                                    $certhsc1 = null;
                        }else{
            
                            $certhsc1 = $image_hs1;
            
                        }
                    }
        
        
        ////=======================HSC Second=====================//
        
        $image_hs2 = $this->input->post('stu_hs_sec_certi');
        $hsc2 =$this->upload->do_upload('hs_sec_certi');
        $datahsc2 = $this->upload->data();
        
        
        if($hsc2){
        
        
        
            $certhsc2 =$datahsc2['file_name'];
        }else{
            if($image_hs2 == null){
                        $certhsc2 = null;
            }else{
        
                $certhsc2 = $image_hs2;
        
            }
        }
        
        ////=======================transfer_cer=====================//
        
        $image_trans = $this->input->post('stud_transfer');
        $trans_cer = $this->upload->do_upload('transfercert');
        $datatrans = $this->upload->data();
        
        
        if($trans_cer){
        
        
        
            $trans =$datatrans['file_name'];
        }else{
            if($image_trans == null){
                        $trans = null;
            }else{
        
                $trans = $image_trans;
        
            }
        }
        
        ////=======================dessiabledr=====================//
        
        $abled_cert_name = $this->input->post('abled_cert_name');
        $abled_cer = $this->upload->do_upload('abled_certificate');
        $dataabled = $this->upload->data();
        
        
        if($abled_cer){
        
        
        
            $abled_certificate =$dataabled['file_name'];
        }else{
            if($abled_cert_name == null){
                        $abled_certificate = null;
            }else{
        
                $abled_certificate = $abled_cert_name;
        
            }
        }
        
        
        
        
        ////=======================Comunity=====================//
                    $image_cc = $this->input->post('stud_commcert');
                    $ccc =$this->upload->do_upload('commcert');
                    $dataInfod = $this->upload->data();
                
            
                    if($ccc){
            
                    
            
                        $ccname =$dataInfod['file_name'];
                    }else{
                        if($image_cc == null){
                                    $ccname = null;
                        }else{
            
                            $ccname = $image_cc;
            
                        }
                    }
        
        
                    ////======================= Professional =====================//
                    $image_cert_cc = $this->input->post('stu_prof_cert_name');
                    $ccc_prof =$this->upload->do_upload('stu_prof_cert');
                    $dataInfo_prof= $this->upload->data();
                
            
                    if($ccc_prof){
            
                    
            
                        $ccname_prof =$dataInfo_prof['file_name'];
                    }else{
                        if($image_cert_cc == null){
                                    $ccname_prof = null;
                        }else{
            
                            $ccname_prof = $image_cert_cc;
            
                        }
                    }
        
        
        
                    ////======================= Conduct Certificate =====================//
                    $image_conduct_name = $this->input->post('stu_conduct_cert_name');
                    $cc_conduct =$this->upload->do_upload('stu_conduct_cert');
                    $dataInfo_cond = $this->upload->data();
                
            
                    if($cc_conduct){
            
                    
            
                        $cc_cunduct_name =$dataInfo_cond['file_name'];
                    }else{
                        if($image_conduct_name == null){
                                    $cc_cunduct_name = null;
                        }else{
            
                            $cc_cunduct_name = $image_conduct_name;
            
                        }
                    }
        
        
        
        
                    ////=======================Eligibility Certificate =====================//
                    $image_elig_name = $this->input->post('stu_elig_certi_name');
                    $ccc_elig =$this->upload->do_upload('stu_elig_certi');
                    $dataInfoelig = $this->upload->data();
                
            
                    if($ccc_elig){
            
                    
            
                        $ccname_elig =$dataInfoelig['file_name'];
                    }else{
                        if($image_elig_name == null){
                                    $ccname_elig = null;
                        }else{
            
                            $ccname_elig = $image_elig_name;
            
                        }
                    }	
                    ////=======================Migration Certificate =====================//
        
        
                    $image_mig_name = $this->input->post('stu_migrate_cert_name');
                    $mig =$this->upload->do_upload('stu_migrate_cert');
                    $dataInfomig = $this->upload->data();
                
            
                    if($mig){
            
                    
            
                        $migccname =$dataInfomig['file_name'];
        
                    }else{
                        if($image_mig_name == null){
                                    $image_mig_name = null;
                        }else{
            
                            $migccname = $image_mig_name;
            
                        }
                    }

    
    
    $update_details = array(
        
        'pr_sslc_mark'=>$sslc,
		'pr_hse_certificate'=>$certhsc1,
		'pr_hse2_certificate'=>$certhsc2,
		'pr_transfer_cert'=>$trans,
		'pr_comunity_cert'=>$ccname,
		'pr_provisional_mark_sheet'=>$ccname_prof,
		'pr_conduct_certificate'=>$cc_cunduct_name,
		'pr_eligibility_certificate'=>$ccname_elig,
		'pr_migration_certificate'=>$migccname,
    );
    
 


    if($this->session->userdata('user')['user_m_course'] == 3){

  $this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview',$update_details);
   
    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Files Updated Successfully .
    </div>');
    }else{
  $this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview',$update_details);
   
    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Files Updated Successfully .
    </div>');

    }

  
    
    
        redirect('Home/dashBoard');




       
    }
    
    public function do_upload(){


        $config = array();
        $config['upload_path'] = 'admin/uploads/';
        $config['allowed_types'] = '*';
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;


        $this->load->library('upload', $config);
    
        // Initialize the Upload library with curront $config
    
        return $config;
        
        }


}