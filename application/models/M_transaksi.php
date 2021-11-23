<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model {

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->id_user = $this->session->userdata('id_user');
    }

	public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function ubah_data($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function cari_data_order($tabel, $where, $order)
    {
        $this->db->from($tabel);
        foreach ($where as $key => $value) {
            $this->db->where($key, $value);
        }
        foreach ($order as $key => $value) {
            $this->db->order_by($key, $value);
        }
        

        return $this->db->get();
    }

    public function cari_data_tr($id_tr)
    {
        $this->db->select('*, a.id as id_d_tr, b.id as id_product');
        $this->db->from("trn_detail_transaksi as a");
        $this->db->join('mst_product as b', 'b.id = a.id_product', 'inner');
        $this->db->join('mst_discount as d', 'd.id_product = b.id', 'left');
        $this->db->where('a.id_transaksi', $id_tr);
        $this->db->order_by('a.id', 'asc');

        return $this->db->get();
    }
    
    public function get_total_pesanan($id_tr)
    {
        $this->db->select_sum('subtotal');
        $this->db->from('trn_detail_transaksi');
        $this->db->where('id_transaksi', $id_tr);
        
        
        return $this->db->get();
    }

    public function get_diskon($id_tr)
    {
        $this->db->select('sum(d.discount * t.jumlah) as tot_diskon');
		$this->db->from('trn_detail_transaksi as t');
		$this->db->join('mst_discount as d', 'd.id_product = t.id_product', 'inner');
        $this->db->where('t.id_transaksi', $id_tr);
        
        return $this->db->get();
    }

    public function get_diskon_2($id_tr)
    {
        $this->db->select_sum('t.total_discount');
		$this->db->from('trn_detail_transaksi as t');
        $this->db->where('t.id_transaksi', $id_tr);
        
        return $this->db->get();
    }

    public function jml_diskon($id_product)
    {
        $this->db->select_sum('discount');
        $this->db->from('mst_discount');
        $this->db->where('id_product', $id_product);
        
        return $this->db->get();
    }

    // 11-07-2020
    public function get_tot_subtotal($id_tr)
    {
        $this->db->select_sum('subtotal');
        $this->db->from('trn_detail_transaksi');
        $this->db->where('id_transaksi', $id_tr);
        
        return $this->db->get();
        
    }

    public function cari_data_kd_tr($tabel, $where)
    {
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($where);
        $this->db->where('kode_transaksi !=', '');
        $this->db->order_by('id', 'desc');

        return $this->db->get();
        
    }

    // 12-07-2020
    public function get_diskon_sbl($id_tr, $id_product)
    {
        $this->db->select_sum('total_discount');
        $this->db->from('trn_detail_transaksi');
        $this->db->where('id_transaksi', $id_tr);
        $this->db->where('id_product', $id_product);
        
        return $this->db->get();
    }

    public function cari_detail_tr($id_transaksi)
    {
        $this->db->select('*');
        $this->db->from('trn_detail_transaksi as t');
        $this->db->join('mst_product as p', 'p.id = t.id_product', 'inner');
        $this->db->where('t.id_transaksi', $id_transaksi);
        
        return $this->db->get();
    }

    // 15-07-2020
    public function get_diskon_tr($id_tr)
    {
        $this->db->select_sum('total_discount');
        $this->db->from('trn_detail_transaksi');
        $this->db->where('id_transaksi', $id_tr);

        return $this->db->get();
    }

    public function get_kategori($id_tr)
    {
        $this->db->select('k.kategori, k.id as id_kategori');
        $this->db->from('trn_detail_transaksi as t');
        $this->db->join('mst_product as p', 'p.id = t.id_product', 'inner');
        $this->db->join('mst_kategori as k', 'k.id = p.id_kategori', 'inner');
        $this->db->where('t.id_transaksi', $id_tr);
        $this->db->group_by('k.id');
        
        return $this->db->get();
    }

    public function get_product_kat($id_kat, $id_tr)
    {
        $this->db->select('p.nama_product, p.harga, t.*');
        $this->db->from('trn_detail_transaksi as t');
        $this->db->join('mst_product as p', 'p.id = t.id_product', 'inner');
        $this->db->join('mst_kategori as k', 'k.id = p.id_kategori', 'inner');
        $this->db->where('t.id_transaksi', $id_tr);
        $this->db->where('k.id', $id_kat);
        
        return $this->db->get();
    }

    // 20-07-2020
    public function get_data_kdtr_kosong()
    {
        return $this->db->get_where('trn_transaksi', ['kode_transaksi' => '']);
    }

    public function get_total_hari_ini()
    {
        $this->db->select('sum(total_harga) as total')
        ->from('trn_transaksi')
        ->where('created_at', date('Y-m-d'))
        ->where('id_user', $this->id_user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_profit()
    {
        // $query = $this->db->query('SELECT mst_product.hpp, trn_detail_transaksi.subtotal, trn_detail_transaksi.jumlah FROM trn_detail_transaksi INNER JOIN mst_product ON trn_detail_transaksi.id_product = mst_product.id WHERE trn_detail_transaksi.created_at ="'.date('Y-m-d').'"')->result();

        $this->db->select('mst_product.hpp, trn_detail_transaksi.subtotal, trn_detail_transaksi.jumlah');
        $this->db->from('trn_detail_transaksi');
        $this->db->join('mst_product', 'trn_detail_transaksi.id_product = mst_product.id', 'inner');
        $this->db->where('trn_detail_transaksi.created_at', date('Y-m-d', now('Asia/Jakarta')));
        $this->db->where('mst_product.id_user', $this->id_user);
        
        return $this->db->get();
        
    }
}

/* End of file M_transaksi.php */
/* Location: ./application/models/M_transaksi.php */