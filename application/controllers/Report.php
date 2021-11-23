<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
		$data 	= [
			'title'		=> 'Report',
            'report'    => $this->report->get()->result(),
			'isi'		=> 'report/read'
		];

		$this->load->view('template/wrapper', $data);
	}

	public function read()
	{
        if($this->session->userdata('id_role') > 1)
        {
    		$list 	= $this->report->get_datatables();
    		$data 	= [];
    		$no		= 1;
    		foreach($list as $report)
    		{
    			$row = [];
    			$row[] = $no++.'.';
                $row[] = date('d-m-Y', strtotime($report->created_at));
                $row[] = $report->kode_transaksi ? $report->kode_transaksi : 'Tidak Ada';
                $row[] = 'Rp. '.number_format($report->total_harga);
                $row[] = '<button type="button" class="btn btn-info btn-xs detailButton" data-toggle="modal" data-target="#detail" data-id="'.$report->id.'"><i class="mdi mdi-information-outline"></i></button>';
                $data[] = $row;
    		}
    		$output = [
                        "recordsTotal" 		=> $this->report->count_all(),
                        "recordsFiltered" 	=> $this->report->count_filtered(),
                        "data" 				=> $data,
    		          ];
            echo json_encode($output);
        }
        else
        {
            $list   = $this->report->get_datatables_admin();
            $data   = [];
            $no     = 1;
            foreach($list as $report)
            {
                $row = [];
                $row[] = $no++.'.';
                $row[] = date('d-m-Y', strtotime($report->created_at));
                $row[] = $report->kode_transaksi ? $report->kode_transaksi : 'Tidak Ada';
                $row[] = 'Rp. '.number_format($report->total_harga);
                $row[] = '<button type="button" class="btn btn-info btn-xs detailButton" data-toggle="modal" data-target="#detail" data-id="'.$report->id.'"><i class="mdi mdi-information-outline"></i></button>';
                $data[] = $row;
            }
            $output = [
                        "recordsTotal"      => $this->report->count_all_admin(),
                        "recordsFiltered"   => $this->report->count_filtered_admin(),
                        "data"              => $data,
                      ];
            echo json_encode($output);
        }
	}

	public function read_blm()
	{
        if($this->session->userdata('id_role') > 1)
        {
    		$list 	= $this->report->get_datatables_blm();
    		$data 	= [];
    		$no		= 1;
    		foreach($list as $report)
    		{
    			$row = [];
    			$row[] = $no++.'.';
                $row[] = date('d-m-Y', strtotime($report->created_at));
                $row[] = $report->kode_transaksi ? $report->kode_transaksi : 'Tidak Ada';
                $row[] = 'Rp. '.number_format($report->total_harga);
                $row[] = '<button type="button" class="btn btn-info btn-xs detailButton" data-toggle="modal" data-target="#detail" data-id="'.$report->id.'"><i class="mdi mdi-information-outline"></i></button>';
                $data[] = $row;
    		}
    		$output = [
                        "recordsTotal" 		=> $this->report->count_all_blm(),
                        "recordsFiltered" 	=> $this->report->count_filtered_blm(),
                        "data" 				=> $data,
    		          ];
            echo json_encode($output);
        }
        else
        {
            $list   = $this->report->get_datatables_admin_blm();
            $data   = [];
            $no     = 1;
            foreach($list as $report)
            {
                $row = [];
                $row[] = $no++.'.';
                $row[] = date('d-m-Y', strtotime($report->created_at));
                $row[] = $report->kode_transaksi ? $report->kode_transaksi : 'Tidak Ada';
                $row[] = 'Rp. '.number_format($report->total_harga);
                $row[] = '<button type="button" class="btn btn-info btn-xs detailButton" data-toggle="modal" data-target="#detail" data-id="'.$report->id.'"><i class="mdi mdi-information-outline"></i></button>';
                $data[] = $row;
            }
            $output = [
                        "recordsTotal"      => $this->report->count_all_admin_blm(),
                        "recordsFiltered"   => $this->report->count_filtered_admin_blm(),
                        "data"              => $data,
                      ];
            echo json_encode($output);
        }
	}

    public function detail()
    {
        $id_tr = $this->input->post('id_tr');

        $tr_data = $this->report->get($id_tr)->row();

        $this->db->select('trn_detail_transaksi.*, trn_transaksi.total_harga, mst_product.nama_product, mst_product.harga')
        ->from('trn_detail_transaksi')
        ->join('trn_transaksi', 'trn_transaksi.id = trn_detail_transaksi.id_transaksi', 'inner')
        ->join('mst_product', 'mst_product.id = trn_detail_transaksi.id_product', 'left')
        ->where('trn_detail_transaksi.id_transaksi', $id_tr);
        $query = $this->db->get();
        $detil = $query->result();
        $i = 1;
        $diskon = 0;
        $tt_sb = 0;

        $detailString = '';

        foreach ($detil as $row2) {
            
            $diskon += $row2->total_discount;

            $tt_sb += (($row2->harga - $tr_data->potongan_harga) * $row2->jumlah);
            
            $detailString .="<tr>";
            $detailString .="<td align='center'>". $i++ ."</td>";
            $detailString .="<td>". $row2->nama_product ."</td>";
            $detailString .="<td>Rp. ". number_format($row2->harga - $tr_data->potongan_harga) ."</td>";
            $detailString .="<td align='center'>". $row2->jumlah ."</td>";
              if(strlen($row2->total_discount > 2)) {
                $detailString .="<td>Rp. ". number_format($row2->total_discount) ."</td>";
              } elseif(strlen($row2->total_discount < 3) && $row2->total_discount > 0) { 
                $harga_diskon = ($row2);
                $detailString .="<td>". $row2->total_discount ." %</td>";
              } elseif($row2->total_discount == 0) { 
                $detailString .="<td>Tidak Ada</td>";
              }
            $detailString .="<td>Rp. ". number_format($row2->subtotal) ."</td>";
            $detailString .="</tr>";

        }

        $potongan = ($tr_data->potongan_harga != null) ? number_format($tr_data->potongan_harga) : 0;
        $tunai = $tr_data->tunai ? number_format($tr_data->tunai,0,'.','.') : 0 ;
        $kembali = $tr_data->tunai ? number_format($tr_data->tunai - ($tt_sb - $diskon)) : number_format(($tr_data->tunai - $tr_data->total_harga));

        $harga = $tt_sb - $diskon;

        $output = [
                    "kode_transaksi_plain" => $id_tr,
                    "kode_transaksi"    => "<b>: ". $tr_data->kode_transaksi ."</b>",
                    "tgl_transaksi"     => "<b>: ". date('d-m-Y', strtotime($tr_data->created_at)) ."</b>",
                    "nomor_meja"        => "<b>: ". $tr_data->nomer_meja ."</b>",
                    "detail_string"     => $detailString,
                    "potongan_harga"    => "<b>Rp. ". $potongan ."</b>",
                    "potongan_harga_plain"    => $potongan,
                    "diskon"            => "<b>Rp. ". number_format($diskon) ."</b>",
                    "subtotal"          => "<b>Rp. ". number_format($tt_sb) ."</b>",
                    "total"             => "<b>Rp. ". number_format($tt_sb - $diskon) ."</b>",
                    "harga"             => $harga,
                    "tunai"             => $tunai,
                    "kembali"           => "<span>Rp. ". $kembali ."</span>",
                  ];
        echo json_encode($output);
    }

	public function cetak()
    {
    	if($this->input->post('pdf') !== null)
    	{
    		if(!empty($this->input->post('start_date')) && !empty($this->input->post('end_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('start_date'))).'/'.date('Y-m-d', strtotime($this->input->post('end_date')));
    			redirect('Report/cetak_pdf/'.$x);
    		}
    		elseif(!empty($this->input->post('start_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('start_date')));
    			redirect('Report/cetak_pdf/'.$x);
    		}
    		elseif(!empty($this->input->post('end_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('end_date')));
    			redirect('Report/cetak_pdf/'.$x);
    		}
    		else
    		{
    			redirect('Report/cetak_pdf');
    		}
    	}
    	else
    	{
    		if(!empty($this->input->post('start_date')) && !empty($this->input->post('end_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('start_date'))).'/'.date('Y-m-d', strtotime($this->input->post('end_date')));
    			redirect('Report/cetak_excel/'.$x);
    		}
    		elseif(!empty($this->input->post('start_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('start_date')));
    			redirect('Report/cetak_excel/'.$x);
    		}
    		elseif(!empty($this->input->post('end_date')))
    		{
    			$x = date('Y-m-d', strtotime($this->input->post('end_date')));
    			redirect('Report/cetak_excel/'.$x);
    		}
    		else
    		{
    			redirect('Report/cetak_excel');
    		}
    	}
    }

    public function cetak_pdf($x = null)
    {
    	if($x != null)
    	{
    		if($this->uri->segment(3) && empty($this->uri->segment(4)))
    		{
    			$tanggal 	= $this->uri->segment(3);
    			$ket 		= 'Laporan Rekapan Transaksi Tanggal '.date('d-m-Y', strtotime($tanggal));
				$laporan 	= $this->report->get_table_tanggal($tanggal);
	            $total 		= $this->report->get_total_tanggal($tanggal);
    		}
    		else
    		{
				$start 		= $this->uri->segment(3);
				$end 		= $this->uri->segment(4);
				$ket 		= 'Laporan Rekapan Transaksi Periode '.date('d-m-Y', strtotime($start)).' s/d '.date('d-m-Y', strtotime($end));
				$laporan 	= $this->report->get_table_periode($start, $end);
	            $total 		= $this->report->get_total_periode($start, $end);
	        }
		}
		else
		{
			$ket 		= 'Laporan Rekapan Transaksi Keseluruhan';
			$laporan 	= $this->report->get_table();
			$total 		= $this->report->get_total();
		}

		$data['ket'] 		= $ket;
        $data['laporan']	= $laporan;
        $data['total'] 		= floatval($total->total);
        ob_start();
	    $this->load->view('format/print_report', $data);
	    $html = ob_get_contents();
        // var_dump($html);die();
	        ob_end_clean();
	        require_once('./assets/html2pdf/html2pdf.class.php');
	    $pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(30, 0, 20, 0));
	    $pdf->WriteHTML($html);
	    $pdf->Output('Laporan Rekapan Transaksi.pdf', 'I');
        // $this->load->library('pdf');
        // $this->pdf->setPaper('A4', 'potrait');
        // $this->pdf->filename = $data['ket'].".pdf";
        // $this->pdf->load_view('format/print_report', $data);
    }

    public function cetak_excel($x =  null)
    {
    	if($x != null)
    	{
    		if($this->uri->segment(3) && empty($this->uri->segment(4)))
    		{
    			$tanggal 	= $this->uri->segment(3);
    			$ket 		= 'Laporan Rekapan Transaksi Tanggal '.date('d-m-Y', strtotime($tanggal));
				$laporan 	= $this->report->get_table_tanggal($tanggal);
	            $total 		= $this->report->get_total_tanggal($tanggal);
    		}
    		else
    		{
				$start 		= $this->uri->segment(3);
				$end 		= $this->uri->segment(4);
				$ket 		= 'Laporan Rekapan Transaksi Periode '.date('d-m-Y', strtotime($start)).' s/d '.date('d-m-Y', strtotime($end));
				$laporan 	= $this->report->get_table_periode($start, $end);
	            $total 		= $this->report->get_total_periode($start, $end);
	        }
		}
		else
		{
			$ket 		= 'Laporan Rekapan Transaksi Keseluruhan';
			$laporan 	= $this->report->get_table();
			$total 		= $this->report->get_total();
		}

		$data['ket'] 		= $ket;
        $data['laporan']	= $laporan;
        $data['total'] 		= floatval($total->total);
        ob_start();
	    $this->load->view('format/print_report_excel', $data);
    }

}

/* End of file Report.php */
/* Location: ./application/controllers/Report.php */