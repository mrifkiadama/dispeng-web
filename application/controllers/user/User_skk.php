<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_skk extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url();
			redirect($url);
		};
		$this->load->model('m_employe');
		$this->load->model('m_skk');
		$this->load->library('upload');
	}
	public function index()
	{

		$data['skk'] = $this->m_skk->getSkkAll();
		$data['skk'] = $this->m_skk->getSkkVerif();
		$data['detail_skk'] = $this->m_skk->getSkkVerif();
		// $data['detail_lhkpn']=$this->m_lhkpn->getLhkpnVerif();
		$this->load->view('user/skk/data_skk', $data);
	}

	public function form()
	{
		$this->load->view('user/skk/form');
	}

	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->m_employe->search_blog($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = $row->nip;


				echo json_encode($arr_result);
			}
		}
	}

	public function simpan_form()
	{
		$nip = $this->input->post('nip');
		$tanggal_lapor = $this->input->post('tanggal_surat_skk');
		$name = $nip . '-Surat_Permintaan_SKK' . '-' . date('dmY');
		$config['upload_path'] = './assets/dokument/SKK'; //path folder
		$config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size']     = 2000; // 3MB
		$config['file_name'] = $name;
		$this->upload->initialize($config);
		if (!empty($_FILES['file_pdf_skk']['name'])) {
			if ($this->upload->do_upload('file_pdf_skk')) {
				$file = $this->upload->data();
				$pdf = $file['file_name'];
				$data = array(
					'nip' => $nip,
					'file' => $pdf,
					'status_proses' => 0,
					'tanggal_pengajuan' => $tanggal_lapor
				);

				// var_dump($data);
				// die();
				$this->m_skk->simpan_skk('tbl_skk', $data);
				echo $this->session->set_flashdata('success', ' berhasil ditambahkan permintaan SKK');
				redirect('user/dashboard');
			} else {
				// echo '<script>alert("");</script>';
				echo '<script>setTimeout(function(){ alert("File Yang Dimasukan Harus PDF"); }, 3000);';
				redirect('user/user_skk');
			}
		} else {
			echo '<script>alert("FILE KOSONG");</script>';

			// redirect('user/user_lhkpn1');
		}
	}

	public function download($file)
	{
		$this->load->helper('download');
		$name = $this->uri->segment(4);
		$data = file_get_contents('./assets/dokument/LHKPN/' . $name);
		force_download($name, $data);
		redirect('user/user_lhkpn');
	}
}
