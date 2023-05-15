<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


public function registerUser($email,$mobile,$data){


//echo $this->userExists($email,$mobile);




 //echo $n;

 if((int)$this->userExists($email,$mobile) == 0){

        $this->db->insert('stu_user',$data);
        
        return 'inserted';  
}else{

        return 'email exists';

}  



}

public function userExists($email,$mobile){

$where = '(u_email_id="'.$email.'" or u_mobile = "'.$mobile.'")';
$q = $this->db->select('*')->from('stu_user')->where($where)->get();

return $q->num_rows();

}


public function selectLogin($email,$pass){
    $where = '(u_email_id="'.$email.'" or u_mobile = "'.$email.'")';

    $q = $this->db->select('*')->from('stu_user')->where($where)->where('u_pass',$pass)->where('login_status_ ',1)->get();

    return $r = $q->result();

}





}
?>