<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_employe');
		$this->load->model('m_lhkpn');
		$this->load->model('m_hukdis');
		$this->load->model('m_skk');
		$this->load->library('upload');
	}


	public function index()
	{
		$data['hukdis']=$this->m_hukdis->getHukdisAll();
		$data['lhkpn']=$this->m_lhkpn->getLhkpnProses();
		$data['detail_lhkpn']=$this->m_lhkpn->getLhkpnVerif();
		$data['skk']=$this->m_skk->getSkkProses();

		$this->load->view('admin/dashboard/index',$data);
	}
	

}
