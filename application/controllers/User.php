<?php
defined ('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    public function index()
    {
        $data['title'] = 'Halaman Utama Siswa';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/index',$data);
        $this->load->view('templates/footersiswa');
    }
    public function kelas()
    {
        $data['title'] = 'Lihat Kelas';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        $data['mapel'] = $this->user_model->get_mapel();

        $kelas = $this->session->userdata('id_kelas');
        $data['nama_kelas'] = $this->user_model->get_kelas_id($kelas);

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/kelas',$data);
        $this->load->view('templates/footersiswa');
    }
    public function masukkelas()
    {
        $data['title'] = 'Lihat Kelas';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        $data['mapel'] = $this->user_model->get_mapel();
        $data['nilai'] = $this->user_model->get_nilaisemua();

        $mapel=$this->input->post('mapel');
        $namakelas = $this->input->post('kelas');
        $data['kelas'] = $this->user_model->getallkelas($mapel,$namakelas);

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/kelas/lihatmapel',$data);
        $this->load->view('templates/footersiswa');
    }
    public function addsiswamasuk()
    {
        $data['title'] = 'Lihat Kelas';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        $data['siswa'] = $this->user_model->get_siswa();
        $data['mapel'] = $this->user_model->get_mapel();

        $kode = $this->input->post('kode1');
        $jenis = $this->input->post('jenis');
        $siswa = $this->input->post('siswa');
        $nilai = $this->input->post('nilai');
        $data1 = array(
            'id_kode_kelas'=>$kode,
            'id_tugas'=> $jenis,
            'id_siswa' => $siswa,
            'nilai' => $nilai
        );
        if(($jenis != null || $jenis ='') && ($siswa != null || $siswa = '') && ($kode != null || $kode=''))
        {
            $this->user_model->update_kelas($data1,$siswa,$kode,$jenis);
        }
        $mapel=$this->input->post('mapel');
        $namakelas = $this->input->post('kelas');
        $data['nilai'] = $this->user_model->get_nilaisemua();
        $data['kelas'] = $this->user_model->getallkelas($mapel,$namakelas);
        
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/kelas/lihatmapel',$data);
        $this->load->view('templates/footersiswa');
    }
    public function tugasindividu()
    {
        $data['title'] = 'Upload Individu';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        
        $id_siswa = $this->session->userdata('id');
        $data['kelas'] = $this->user_model->get_kode_id($id_siswa);
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/tugasindividu',$data);
        $this->load->view('templates/footersiswa');
    }
    public function tugassiswaindividu()
    {
        $data['title'] = 'Upload Individu';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        
        $data['kode'] = $this->input->post('kode');
        $data['mapel'] = $this->user_model->get_mapelkelas($data['kode']);
        $id_tugas = 1;
        $id_siswa = $this->session->userdata('id');
        $data['kelas'] = $this->user_model->get_kode_id($id_siswa);
        $data['download'] = $this->user_model->get_tugasdownload($data['kode'],$id_tugas);
        
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/tugas/tugassiswaindividu',$data);
        $this->load->view('templates/footersiswa');
    }
    public function download($nama)
    {
        $this->load->helper('download');
        $fileinfo = $this->user_model->download($nama);
        $file = 'dokumen/'.$fileinfo['nama_dokumen'];
        force_download($file, NULL);
    }
    public function cektugassiswaindividu()
    {
        $data['title'] = 'Upload Individu';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();
        $data['upload'] = $this->user_model->do_upload();
        
        $data['kode'] = $this->input->post('kode');
        $id_siswa = $this->session->userdata('id');
        $data['kelas'] = $this->user_model->get_kode_id($id_siswa);
        
        $kode = $this->input->post('kode');
        $date = date('y-m-d');
        $siswa = $this->input->post('idsiswa');
        $doc = $_FILES['doc']['name'];
        $test = str_replace(' ','_',$doc);
        $data1 = array(
            'kode_kelas' => $kode,
            'id_siswa' => $siswa,
            'nama_dokumen' => $test,
            'date' => $date 
        );
        if($this->user_model->cekuploadsiswa($kode,$siswa)==false)
        {
            $this->db->insert('tugas_siswa',$data1);
        }
        else
        {
            $this->db->where('kode_kelas',$kode);
            $this->db->where('id_siswa',$siswa);
            $this->db->update('tugas_siswa',$data1);
        }
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/tugas/tugassiswaindividu',$data);
        $this->load->view('templates/footersiswa');
    }
    public function lihatkelompok()
    {
        $data['title'] = 'Cek kelompok';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();

        $id_siswa = $this->session->userdata('id');
        $data['kelas'] = $this->user_model->get_kode_id($id_siswa);
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/kelompok',$data);
        $this->load->view('templates/footersiswa');
    }
    public function tablekelompok()
    {
        $data['title'] = 'Kelompok';
        $data['user'] = $this->db->get_where('nama_siswa', ['nama_siswa' => $this->session->userdata('nama')])->row_array();

        $id_siswa = $this->session->userdata('id');
        $data['kode'] = $this->input->post('kode');
        $data['kelas'] = $this->user_model->get_kode_id($id_siswa);
        $data['siswa'] = $this->user_model->get_bagikelompok();
        
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebarsiswa',$data);
        $this->load->view('templates/topbarsiswa',$data);
        $this->load->view('user/kelompok/tablekelompok',$data);
        $this->load->view('templates/footersiswa');
    }
}