<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {

    public function __construct()
    {
        $this->id_user = $this->session->userdata('id_user');
    }

    var $table = 'trn_transaksi';
 
    function get_datatables()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->order_by('trn_transaksi.id', 'asc');
        // $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        // print_r($this->db->last_query());exit;
        return $query->result();
    }

    function get_datatables_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->order_by('trn_transaksi.id', 'asc');
        // $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->result();
    }

    function get_datatables_admin()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->order_by('trn_transaksi.id', 'asc');
        // $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->result();
    }

    function get_datatables_admin_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->order_by('trn_transaksi.id', 'asc');
        // $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->db->select('trn_transaksi.*, mst_user.username');
        $this->db->from('trn_transaksi');
        $this->db->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username');
        $this->db->from('trn_transaksi');
        $this->db->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered_admin()
    {
        $this->db->select('trn_transaksi.*, mst_user.username');
        $this->db->from('trn_transaksi');
        $this->db->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered_admin_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username');
        $this->db->from('trn_transaksi');
        $this->db->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        return $this->db->count_all_results();
    }

    public function count_all_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
        	$start = $this->input->post('start_date');
        	$end = $this->input->post('end_date');
        	$this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        return $this->db->count_all_results();
    }

    public function count_all_admin()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai !=', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        return $this->db->count_all_results();
    }

    public function count_all_admin_blm()
    {
        $this->db->select('trn_transaksi.*, mst_user.username')
        ->from('trn_transaksi')
        ->join('mst_user', 'mst_user.id = trn_transaksi.id_user', 'left')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('trn_transaksi.id_user', $this->session->userdata('id_user'))
        ->where('tunai', 0);
        if($this->input->post('start_date') != '' && $this->input->post('end_date') != '')
        {
            $start = $this->input->post('start_date');
            $end = $this->input->post('end_date');
            $this->db->where("trn_transaksi.created_at BETWEEN '".$start."' AND '".$end."'");
        }
        $this->db->where('mst_user.id', $this->id_user);
        return $this->db->count_all_results();
    }

    public function get($id = null)
    {
        $this->db->from($this->table)
        ->where('trn_transaksi.kode_transaksi <> ""');
        if($id)
        {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_detail($id)
    {
        $this->db->select('trn_detail_transaksi.*, trn_transaksi.kode_transaksi, trn_transaksi.total_harga, mst_product.nama_product')
        ->from('trn_detail_transaksi')
        ->join('trn_transaksi', 'trn_transaksi.id = trn_detail_transaksi.id_transaksi')
        ->join('mst_product', 'mst_product.id = trn_detail_transaksi.id_product')
        ->where('trn_transaksi.id_user', $this->id_user);
        $query = $this->db->get();
        return $query->result();

    }

    public function get_table()
    {
        $this->db->from($this->table)
        ->where('kode_transaksi <> ""')
        ->where('id_user', $this->id_user)
        ->order_by('id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_table_tanggal($date)
    {
        $this->db->from($this->table)
        ->where('kode_transaksi <> ""')
        ->where("created_at", $date)
        ->where('id_user', $this->id_user)
        ->order_by('id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_table_periode($start, $end)
    {
    	$this->db->from($this->table)
        ->where('kode_transaksi <> ""')
        ->where("created_at BETWEEN '".$start."' AND '".$end."'")
        ->where('id_user', $this->id_user)
    	->order_by('id', 'asc');
    	$query = $this->db->get();
    	return $query->result();
    }

    public function get_total()
    {
        $this->db->select('sum(total_harga) as total')
        ->from('trn_transaksi')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('id_user', $this->id_user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_total_tanggal($date)
    {
        $this->db->select('sum(total_harga) as total')
        ->from('trn_transaksi')
        ->where('created_at', $date)
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where('id_user', $this->id_user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_total_periode($start, $end)
    {
        $this->db->select('sum(total_harga) as total')
        ->from('trn_transaksi')
        ->where('trn_transaksi.kode_transaksi <> ""')
        ->where("created_at BETWEEN '".$start."' AND '".$end."'")
        ->where('id_user', $this->id_user);
        $query = $this->db->get();
        return $query->row();
    }

}

/* End of file M_report.php */
/* Location: ./application/models/M_report.php */