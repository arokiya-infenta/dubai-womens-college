<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trust extends CI_Controller {


	public function index()
	{
    $this->load->view('template/trust/header');
    $this->load->view('template/trust/menubar');
    $this->load->view('template/trust/headerbar');
    $this->load->view('trust/dashbord');
    $this->load->view('template/trust/footer');
    }
    
    public function membersManage(){


        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/membersmanage.php');
        $this->load->view('template/trust/footer');




    }

    public function addMember(){

        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/addmembers');
        $this->load->view('template/trust/footer');


    }

    public function editMember(){

        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/editmember');
        $this->load->view('template/trust/footer');


    }

    public function transactionsManage(){



        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/transactionmanage');
        $this->load->view('template/trust/footer');


    }

    public function addTransactions(){

        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/transactionadd');
        $this->load->view('template/trust/footer');


    }
    public function editTransactions(){

        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/transactionedit');
        $this->load->view('template/trust/footer');


    }


    public function reports(){

        $this->load->view('template/trust/header');
        $this->load->view('template/trust/menubar');
        $this->load->view('template/trust/headerbar');
        $this->load->view('trust/reports');
        $this->load->view('template/trust/footer');


    }



}
