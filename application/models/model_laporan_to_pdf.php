<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laporan_to_pdf extends CI_Model {

	/****************************************************************************************/	
	// BEGIN SALDO KAS PETUGAS
	/****************************************************************************************/


	public function export_saldo_kas_petugas($cabang='',$tanggal)
	{
		$sql = " SELECT 
						mfi_gl_account_cash.account_cash_code,
						mfi_fa.fa_name,
						fn_get_saldoawal_kaspetugas(mfi_gl_account_cash.account_cash_code,?,0) as saldoawal,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'D') as mutasi_debet,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'C') as mutasi_credit
				from 	
						mfi_gl_account_cash 
				left outer join mfi_fa on (mfi_gl_account_cash.fa_code=mfi_fa.fa_code)
				where 
						mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) and mfi_gl_account_cash.account_cash_type = '0'
				order by mfi_gl_account_cash.account_cash_code ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_cabang($cabang='')
	{
		$sql = "select branch_name from mfi_branch";
		if($cabang!=""){
			$sql .= " where branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
		}
		$query = $this->db->query($sql,array($cabang));
		$row = $query->row_array();
		if(isset($row['branch_name'])){
			return $row['branch_name'];
		}else{
			return '';
		}
	}

	/****************************************************************************************/	
	// END SALDO KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PETUGAS
	/****************************************************************************************/
	public function export_transaksi_kas_petugas($tanggal,$tanggal2,$account_cash_code)
	{
		$sql = "SELECT 
							fn_get_saldoawal_kaspetugas(a.account_cash_code,?,0) as saldoawal,
							a.trx_gl_cash_type,
							a.trx_date,
							b.display_text trx_type,
							a.description,
							a.flag_debet_credit,
							(case when a.flag_debet_credit='D' then a.amount else 0 end) as trx_debet,
							(case when a.flag_debet_credit='C' then a.amount else 0 end) as trx_credit
				from 
							mfi_trx_gl_cash as a
				left outer join 
							mfi_list_code_detail b on (a.trx_gl_cash_type=CAST(b.code_value as integer) 
							and b.code_group='trx_gl_cash_type')
				where 
							a.trx_date between ? and ?
							and a.account_cash_code = ?
				order by 	a.trx_date,a.trx_gl_cash_type ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal2,$account_cash_code));	
		// print_r($this->db);
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END TRANSAKSI KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN LABA RUGI
	/****************************************************************************************/


	public function export_lap_lr($cabang='')
	{
		$sql = "SELECT
				mfi_gl_report.report_code,
				mfi_gl_report.report_name,
				mfi_gl_report_item.item_code,
				mfi_gl_report_item.item_name,
				mfi_gl_report_item.posisi,
				mfi_gl_report_item.item_type,
				mfi_gl_report.report_type
				FROM
				mfi_gl_report
				INNER JOIN mfi_gl_report_item ON mfi_gl_report_item.report_code = mfi_gl_report.report_code
				where 
				mfi_gl_report.report_type=?
				order by mfi_gl_account_cash.account_cash_code ";

		$query = $this->db->query($sql,array($cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	public function getReportItem()
	{
		$sql = "SELECT * FROM v_report_finansial WHERE report_code = '20'";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	/*public function getReportItem()
	{
		$sql = "SELECT
				mfi_gl_report.report_code,
				mfi_gl_report.report_name,
				mfi_gl_report_item.item_code,
				mfi_gl_report_item.item_name,
				mfi_gl_report_item.posisi,
				mfi_gl_report_item.item_type,
				mfi_gl_report.report_type
				FROM
				mfi_gl_report
				INNER JOIN mfi_gl_report_item ON mfi_gl_report_item.report_code = mfi_gl_report.report_code
				WHERE mfi_gl_report.report_type=1
				ORDER BY mfi_gl_report_item.item_code ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}*/

	/****************************************************************************************/	
	// END LAPORAN LABA RUGI
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN NERACA_GL
	/****************************************************************************************/
	public function export_neraca_gl($branch_code='',$periode_bulan='',$periode_tahun='',$periode_hari='')
	{
		$param = array();
		$last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
		$report_code='10';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

			if($branch_code=="00000"){
				$param[] = $last_date;
				$param[] = 'all';
				$param[] = $last_date;
				$param[] = 'all';
				$param[] = $report_code;
			}else{
				$param[] = $last_date;
				$param[] = $branch_code;
				$param[] = $last_date;
				$param[] = $branch_code;
				$param[] = $report_code;
			}
		$query = $this->db->query($sql,$param);
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];	
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$exp = explode('#',$rows[$i]['formula']);
				
				if(count($exp) > 1){
					$rows[$i]['formula'] = $exp[0];
					$report_code = $exp[1];
					$rumus = $exp[2];
				}else{
					$formula = $rows[$i]['formula'];
				}

				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$last_date,$branch_code,$report_code);
				}

					// $formula=$rows[$i]['formula'];
				$amount=array();
				foreach($arr_amount as $key=>$value):
					// $formula=str_replace('$'.$key, $value.'::numeric', $formula);
					$amount[]=$value;
				endforeach;

				//RUMUS FORMULA
				if($rumus == "dikurang"){
					$formula = $amount[0] - $amount[1];
					$formula.= "::numeric";
				}else{
					$formula = $amount[0] + $amount[1];
					$formula.= "::numeric";
				}
				//END RUMUS

				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	
		}
		return $row;
	}
	/****************************************************************************************/	
	// END NERACA_GL
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST JATUH TEMPO
	/****************************************************************************************/
	public function export_list_jatuh_tempo($tanggal,$tanggal2,$cabang,$petugas,$produk,$akad='',$pengajuan_melalui='')
	{
		$sql = "SELECT
							mfi_account_financing_droping.droping_date,
							mfi_account_financing.account_financing_no,
							mfi_cif.nama,
							mfi_cm.cm_name,
							mfi_cm.cm_code,
							(SELECT COUNT(cif_no) FROM mfi_account_financing WHERE mfi_account_financing.cif_no = mfi_cif.cif_no GROUP BY mfi_account_financing.cif_no) AS ke,
							mfi_kecamatan_desa.desa,
							mfi_account_financing.pokok,
							mfi_account_financing.margin,
							mfi_account_financing.jangka_waktu,
							mfi_account_financing.periode_jangka_waktu,
							mfi_account_financing.tanggal_jtempo,
							mfi_account_financing.branch_code,
							mfi_account_financing.saldo_pokok,
							mfi_account_financing.angsuran_pokok,
							mfi_product_financing.product_name
				FROM
							mfi_account_financing
				LEFT JOIN 	mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				LEFT JOIN 	mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
				LEFT JOIN 	mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				LEFT JOIN 	mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				LEFT JOIN   mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN   mfi_account_financing_reg ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no

				WHERE 
						 	mfi_account_financing_droping.droping_date between ? and ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($cabang=="00000" || $cabang=="")
				{
					$sql .= " ";
				}
				elseif($cabang!="00000")
				{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $cabang;
				}

                if($petugas!="000000")
                {
                    $sql .= " AND mfi_account_financing.fa_code = ? ";
                    $param[] = $petugas;
                }

                if($produk!="0000")
                {
                	if($produk=='semua'){
						$sql .= " AND mfi_product_financing.product_financing_gl_code='52'";
					}else{
						$sql .= " AND mfi_account_financing.product_code=?";
						$param[] = $produk;
					}
                    /*$sql .= " AND mfi_account_financing.product_code = ? ";
                    $param[] = $produk;*/
                }

				if($akad!="-")
				{
					$sql .= " AND mfi_account_financing.akad_code = ? ";
					$param[] = $akad;
				}

				if($pengajuan_melalui!="-")
				{
					if($pengajuan_melalui=="koptel"){
						$sql .= " AND mfi_account_financing_reg.pengajuan_melalui = ? ";
						$param[] = $pengajuan_melalui;
					}else{
						$sql .= " AND mfi_account_financing_reg.kopegtel_code = ? ";
						$param[] = $pengajuan_melalui;
					}
				}
				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST JATUH TEMPO
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function list_pelunasan_pembiayaan_kelompok($cabang,$tanggal1_,$tanggal2_,$rembug)
	{
		$sql = "SELECT
				mfi_account_financing_lunas.tanggal_lunas,
				mfi_account_financing.account_financing_no,
				mfi_cif.nama,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.tanggal_jtempo,
				mfi_cm.cm_name,
				mfi_cm.cm_code,
				mfi_account_financing.branch_code,
				mfi_account_financing_lunas.saldo_pokok,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing_lunas.saldo_margin,
				mfi_account_financing_lunas.potongan_margin
				FROM
				mfi_account_financing_lunas
				LEFT JOIN  mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				LEFT JOIN  mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN  mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				WHERE mfi_account_financing_lunas.tanggal_lunas between ? and ? ";							

				$param[] = $tanggal1_;	
				$param[] = $tanggal2_;

				
				if($cabang!="00000")
				{
				$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $cabang;
				}

				if($rembug!="00000")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
				}

				$query = $this->db->query($sql,$param);
				// echo "<pre>";
				// print_r($this->db);
				// die();
				return $query->result_array();
	}

	public function list_pelunasan_pembiayaan_individu($tanggal1_,$tanggal2_,$cabang,$petugas,$produk)
	{
		$sql = "SELECT
				mfi_account_financing_lunas.tanggal_lunas,
				mfi_account_financing.account_financing_no,
				mfi_cif.nama,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.tanggal_jtempo,
				mfi_cm.cm_name,
				mfi_cm.cm_code,
				mfi_account_financing.branch_code,
				mfi_account_financing_lunas.saldo_pokok,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing_lunas.saldo_margin,
				mfi_account_financing_lunas.potongan_margin
				FROM
				mfi_account_financing_lunas
				LEFT JOIN  mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				LEFT JOIN  mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN  mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				WHERE mfi_account_financing_lunas.tanggal_lunas between ? and ? ";							

				$param[] = $tanggal1_;	
				$param[] = $tanggal2_;

				if($cabang!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[]=$cabang;
				}

                if($petugas!="000000")
                {
                    $sql .= " AND mfi_account_financing.fa_code = ? ";
                    $param[] = $petugas;
                }

                if($produk!="0000")
                {
                    $sql .= " AND mfi_account_financing.product_code = ? ";
                    $param[] = $produk;
                }

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/

	public function export_lap_droping_pembiayaan_kelompok($cabang='',$rembug='',$from_date,$thru_date,$cif_type)
	{
		$sql = "SELECT
							mfi_cif.nama,
							mfi_account_financing_droping.droping_date,
							mfi_account_financing_droping.droping_by,
							mfi_account_financing_droping.account_financing_no,
							mfi_account_financing.pokok,
							mfi_cm.cm_name,
							mfi_fa.fa_name,
							mfi_account_financing.pokok,
							mfi_account_financing.margin,
							mfi_account_financing.jangka_waktu,
							mfi_account_financing.periode_jangka_waktu,
							mfi_account_financing.tanggal_jtempo,
							mfi_account_financing.biaya_administrasi,
							mfi_account_financing.biaya_jasa_layanan,
							mfi_account_financing.simpanan_wajib_pinjam,
							(mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin+mfi_account_financing.angsuran_catab) as besar_angsuran,
							mfi_fa.fa_name,
							mfi_product_financing.product_name
				FROM
							mfi_cif
				LEFT JOIN 	mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_cif.cif_no
				LEFT JOIN 	mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				LEFT JOIN 	mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN 	mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				WHERE 		
							mfi_account_financing_droping.droping_date between ? AND ?
							AND mfi_account_financing.status_rekening !='0' 
							AND mfi_cif.cif_type = ?
							
				";

				$param[] = $from_date;
				$param[] = $thru_date;
				$param[] = $cif_type;

				if($cabang=="00000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="00000")
				{
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $cabang;
				}

				if($rembug!="")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
				}

                if($petugas!="000000")
                {
                    $sql .= " AND mfi_account_financing.fa_code = ? ";
                    $param[] = $petugas;
                }

                if($produk!="0000")
                {
                    $sql .= " AND mfi_account_financing.product_code = ? ";
                    $param[] = $produk;
                }

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 

	public function export_lap_droping_pembiayaan_individu($from_date,$thru_date,$cif_type,$cabang,$petugas,$produk,$resort='',$akad='',$pengajuan_melalui='')
	{
		// $sql = "SELECT
		// 		mfi_cif.nama,
		// 		mfi_account_financing_droping.cif_no,
		// 		mfi_account_financing_droping.droping_date,
		// 		mfi_account_financing_droping.droping_by,
		// 		mfi_account_financing_droping.account_financing_no,
		// 		mfi_account_financing_droping.status_transfer,
		// 		mfi_account_financing_droping.tanggal_transfer,
		// 		mfi_account_financing.pokok,
		// 		mfi_account_financing.margin,
		// 		mfi_account_financing.jangka_waktu,
		// 		mfi_account_financing.periode_jangka_waktu,
		// 		mfi_account_financing.tanggal_jtempo,
		// 		mfi_account_financing.tanggal_akad,
		// 		mfi_account_financing.biaya_administrasi,
		// 		mfi_account_financing.biaya_jasa_layanan,
		// 		mfi_account_financing.biaya_notaris,
		// 		mfi_account_financing.simpanan_wajib_pinjam,
		// 		mfi_account_financing.angsuran_pokok,
		// 		mfi_account_financing.angsuran_margin,
		// 		mfi_account_financing.angsuran_catab,
		// 		mfi_account_financing.biaya_asuransi_jiwa,
		// 		mfi_account_financing_reg.premi_asuransi_tambahan,
		// 		(mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin) as besar_angsuran,
		// 		mfi_product_financing.nick_name AS product_name
		// 		FROM
		// 		mfi_account_financing_droping 
		// 		LEFT JOIN mfi_cif on mfi_account_financing_droping.cif_no = mfi_cif.cif_no
		// 		LEFT JOIN mfi_account_financing ON mfi_account_financing_droping.account_financing_no = mfi_account_financing.account_financing_no
		// 		INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
		// 		INNER JOIN mfi_akad ON mfi_akad.akad_code=mfi_product_financing.akad_code
		// 		LEFT JOIN mfi_account_financing_reg ON mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
		// 		WHERE 		
		// 		mfi_account_financing_droping.droping_date between ? AND ?
		// 		AND mfi_account_financing.status_rekening !='0' 
		// 		AND mfi_cif.cif_type = ?
		// 		";

		$sql = "

			SELECT 

				b.nama
				, c.cif_no
				, c.droping_date
				, c.droping_by
				, c.account_financing_no
				, c.status_transfer
				, c.tanggal_transfer
				, a.pokok
				, a.margin
				, a.jangka_waktu
				, a.periode_jangka_waktu
				, a.tanggal_jtempo
				, a.tanggal_akad
				, a.biaya_administrasi
				, a.biaya_jasa_layanan
				, a.biaya_notaris
				, a.simpanan_wajib_pinjam
				, a.angsuran_pokok
				, a.angsuran_margin
				, a.angsuran_catab
				, a.biaya_asuransi_jiwa
				, f.premi_asuransi_tambahan
				, (a.angsuran_pokok+a.angsuran_margin) as besar_angsuran
				, d.nick_name AS product_name 

			FROM mfi_account_financing a
			JOIN mfi_cif b ON b.cif_no=a.cif_no
			JOIN mfi_account_financing_droping c ON c.account_financing_no=a.account_financing_no
			JOIN mfi_product_financing d ON d.product_code=a.product_code
			LEFT JOIN mfi_akad e ON e.akad_code=a.akad_code
			LEFT JOIN mfi_account_financing_reg f ON f.registration_no=a.registration_no AND f.cif_no=a.cif_no
			WHERE a.tanggal_akad BETWEEN ? AND ?

		";

				$param[] = $from_date;
				$param[] = $thru_date;
				// $param[] = $cif_type;
				if($cabang!="00000"){
					$sql.=" AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $cabang;
				}

                // if($petugas!="000000")
                // {
                //     $sql .= " AND mfi_account_financing.fa_code = ? ";
                //     $param[] = $petugas;
                // }

                if($produk!="0000")
                {
                	if($produk=='semua'){
						$sql .= " AND d.product_financing_gl_code='52'";
					}else{
						$sql .= " AND a.product_code = ?";
						$param[] = $produk;
					}
                    /*$sql .= " AND a.product_code = ? ";
                    $param[] = $produk;*/
                }

				if($resort!="00000")
				{
					$sql .= " AND a.resort_code = ? ";
					$param[] = $resort;
				}

				if($akad!="-")
				{
					$sql .= " AND e.akad_code = ? ";
					$param[] = $akad;
				}

				if($pengajuan_melalui!="-")
				{
					if($pengajuan_melalui=="koptel"){
						$sql .= " AND f.pengajuan_melalui = ? ";
						$param[] = $pengajuan_melalui;
					}else{
						$sql .= " AND f.kopegtel_code = ? ";
						$param[] = $pengajuan_melalui;
					}
				}
				
				$sql .= " ORDER BY a.tanggal_akad ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN LIST ANGGOTA
	/****************************************************************************************/

	public function export_excel_list_anggota()
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.desa,
				mfi_cif.created_timestamp,
				mfi_cif.jenis_kelamin,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.ibu_kandung,
				mfi_cif_kelompok.cif_kelompok_id,
				mfi_cif_kelompok.cif_id,
				mfi_cif_kelompok.setoran_lwk,
				mfi_cif_kelompok.setoran_mingguan,
				mfi_cif_kelompok.pendapatan,
				mfi_cif_kelompok.literasi_latin,
				mfi_cif_kelompok.literasi_arab,
				mfi_cif_kelompok.p_nama,
				mfi_cif_kelompok.p_tmplahir,
				mfi_cif_kelompok.p_usia,
				mfi_cif_kelompok.p_tglahir,
				mfi_cif_kelompok.p_pendidikan,
				mfi_cif_kelompok.p_pekerjaan,
				mfi_cif_kelompok.p_ketpekerjaan,
				mfi_cif_kelompok.p_pendapatan,
				mfi_cif_kelompok.p_periodependapatan,
				mfi_cif_kelompok.p_literasi_latin,
				mfi_cif_kelompok.p_literasi_arab,
				mfi_cif_kelompok.p_jmltanggungan,
				mfi_cif_kelompok.p_jmlkeluarga,
				mfi_cif_kelompok.rmhstatus,
				mfi_cif_kelompok.rmhukuran,
				mfi_cif_kelompok.rmhatap,
				mfi_cif_kelompok.rmhlantai,
				mfi_cif_kelompok.rmhdinding,
				mfi_cif_kelompok.rmhjamban,
				mfi_cif_kelompok.rmhair,
				mfi_cif_kelompok.lahansawah,
				mfi_cif_kelompok.lahankebun,
				mfi_cif_kelompok.lahanpekarangan,
				mfi_cif_kelompok.ternakkerbau,
				mfi_cif_kelompok.ternakdomba,
				mfi_cif_kelompok.ternakunggas,
				mfi_cif_kelompok.elektape,
				mfi_cif_kelompok.elektv,
				mfi_cif_kelompok.elekplayer,
				mfi_cif_kelompok.elekkulkas,
				mfi_cif_kelompok.kendsepeda,
				mfi_cif_kelompok.kendmotor,
				mfi_cif_kelompok.ushrumahtangga,
				mfi_cif_kelompok.ushkomoditi,
				mfi_cif_kelompok.ushlokasi,
				mfi_cif_kelompok.ushomset,
				mfi_cif_kelompok.byaberas,
				mfi_cif_kelompok.byadapur,
				mfi_cif_kelompok.byalistrik,
				mfi_cif_kelompok.byatelpon,
				mfi_cif_kelompok.byasekolah,
				mfi_cif_kelompok.byalain,
				mfi_cm.cm_name
				FROM
				mfi_cif
				INNER JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				ORDER BY mfi_cif_kelompok.cif_kelompok_id ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function export_list_anggota($branch_id,$cm_code)
	{
		$sql = "SELECT
				mfi_cif.cm_code,
				mfi_cm.branch_id,
				mfi_cm.cm_name
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				WHERE mfi_cm.branch_id = ?
				";

			$param[] = $branch_id;

			if($cm_code!="")
			{
			$sql .= " AND mfi_cm.cm_code = ? ";
			$param[] = $cm_code;
			}

			$sql .= " GROUP BY mfi_cif.cm_code,mfi_cm.branch_id,mfi_cm.cm_name";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	public function export_list_anggota2($cm)
	{
		$param = array();
		$query2 	  = "SELECT
						mfi_cif.panggilan,
						mfi_cif.cif_no,
						mfi_cif.nama,
						mfi_cif.kelompok,
						mfi_cif.jenis_kelamin,
						mfi_cif.ibu_kandung,
						mfi_cif.tmp_lahir,
						mfi_cif.tgl_lahir,
						mfi_cif.usia,
						mfi_cif.alamat,
						mfi_cif.rt_rw,
						mfi_cif.desa,
						mfi_cif.kecamatan,
						mfi_cif.kabupaten,
						mfi_cif.kodepos,
						mfi_cif.no_ktp,
						mfi_cif.no_npwp,
						mfi_cif.telpon_rumah,
						mfi_cif.telpon_seluler,
						mfi_cif.pendidikan,
						mfi_cif.status_perkawinan,
						mfi_cif.pekerjaan,
						mfi_cif.ket_pekerjaan,
						mfi_cif.pendapatan_perbulan,
						mfi_cif.tgl_gabung,
						mfi_cif_kelompok.cif_kelompok_id,
						mfi_cif_kelompok.cif_id,
						mfi_cif_kelompok.setoran_lwk,
						mfi_cif_kelompok.setoran_mingguan,
						mfi_cif_kelompok.pendapatan,
						mfi_cif_kelompok.literasi_latin,
						mfi_cif_kelompok.literasi_arab,
						mfi_cif_kelompok.p_nama,
						mfi_cif_kelompok.p_tmplahir,
						mfi_cif_kelompok.p_usia,
						mfi_cif_kelompok.p_tglahir,
						mfi_cif_kelompok.p_pendidikan,
						mfi_cif_kelompok.p_pekerjaan,
						mfi_cif_kelompok.p_ketpekerjaan,
						mfi_cif_kelompok.p_pendapatan,
						mfi_cif_kelompok.p_periodependapatan,
						mfi_cif_kelompok.p_literasi_latin,
						mfi_cif_kelompok.p_literasi_arab,
						mfi_cif_kelompok.p_jmltanggungan,
						mfi_cif_kelompok.p_jmlkeluarga,
						mfi_cif_kelompok.rmhstatus,
						mfi_cif_kelompok.rmhukuran,
						mfi_cif_kelompok.rmhatap,
						mfi_cif_kelompok.rmhlantai,
						mfi_cif_kelompok.rmhdinding,
						mfi_cif_kelompok.rmhjamban,
						mfi_cif_kelompok.rmhair,
						mfi_cif_kelompok.lahansawah,
						mfi_cif_kelompok.lahankebun,
						mfi_cif_kelompok.lahanpekarangan,
						mfi_cif_kelompok.ternakkerbau,
						mfi_cif_kelompok.ternakdomba,
						mfi_cif_kelompok.ternakunggas,
						mfi_cif_kelompok.elektape,
						mfi_cif_kelompok.elektv,
						mfi_cif_kelompok.elekplayer,
						mfi_cif_kelompok.elekkulkas,
						mfi_cif_kelompok.kendsepeda,
						mfi_cif_kelompok.kendmotor,
						mfi_cif_kelompok.ushrumahtangga,
						mfi_cif_kelompok.ushkomoditi,
						mfi_cif_kelompok.ushlokasi,
						mfi_cif_kelompok.ushomset,
						mfi_cif_kelompok.byaberas,
						mfi_cif_kelompok.byadapur,
						mfi_cif_kelompok.byalistrik,
						mfi_cif_kelompok.byatelpon,
						mfi_cif_kelompok.byasekolah,
						mfi_cif_kelompok.byalain,
						mfi_cm.cm_name,
						mfi_cif.cm_code
						FROM mfi_cif LEFT JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
						WHERE mfi_cif.cif_type = 0
						";

				if($cm!="")
				{
				$query2 .= " AND mfi_cm.cm_code = ? ";
				$param[] = $cm;
				}

		$data2 = $this->db->query($query2,$param);
		return $data2->result_array();
	}

	public function export_list_individu($tglawal,$tglakhir,$branch_code)
	{
		$sql = "SELECT * FROM mfi_cif WHERE cif_type = '1'";
		if($tglawal!="" && $tglakhir!=""){
			$sql .= " AND tgl_gabung BETWEEN ? AND ? ";
			$param[] = $tglawal;
			$param[] = $tglakhir;
		}

		if($branch_code!="00000"){
			$sql.=" AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$data = $this->db->query($sql,$param);
		return $data->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN LIST ANGGOTA
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN OUTSTANDING
	/****************************************************************************************/

	public function export_lap_list_outstanding_pembiayaan_individu($akad='',$produk_pembiayaan='',$pengajuan_melalui='',$peruntukan='')
	{
		$param = array();
		$sql = "select * from v_lap_outstanding_pembiayaan where account_financing_no != '' and cif_type = 1";
		
		if($produk_pembiayaan!="0000")
        {
            // $sql .= " AND product_code = ? ";
            // $param[] = $produk_pembiayaan;

            if($produk_pembiayaan=='semua'){
				$sql .= " AND product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
			}else{
				$sql .= " AND product_code = ?";
				$param[] = $produk_pembiayaan;
			}
        }

        if($akad!="-")
        {
            $sql .= " AND akad_code = ? ";
            $param[] = $akad;
        }

		if($pengajuan_melalui!="-")
		{
			if($pengajuan_melalui=="koptel"){
				$sql .= " AND pengajuan_melalui = ? ";
				$param[] = $pengajuan_melalui;
			}else{
				$sql .= " AND kopegtel_code = ? ";
				$param[] = $pengajuan_melalui;
			}
		}

        if($peruntukan!="-")
        {
            $sql .= " AND peruntukan = ? ";
            $param[] = $peruntukan;
        }

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/*
	LIST TAGIHAN
	*/

	public function export_list_tagihan($from_date='',$thru_date='',$akad='',$product_code='',$status_telkom=null,$code_divisi=null)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				  mfi_account_financing.account_financing_no,
				  mfi_account_financing.tanggal_akad,
				  mfi_account_financing.tanggal_jtempo,
				  mfi_account_financing.counter_angsuran,
				  (mfi_account_financing.jangka_waktu-mfi_account_financing.counter_angsuran) as sisa_angsuran,
				  (mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin) as besar_angsuran,
				  mfi_cif.nama,
				  mfi_cif.cif_no,
				  mfi_cm.cm_name,
				  mfi_product_financing.product_name,
				  mfi_product_financing.product_code
				FROM
				  mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_pegawai ON mfi_pegawai.nik = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				WHERE (mfi_account_financing.status_rekening = '1')
				AND account_financing_no NOT IN (SELECT account_financing_no FROM mfi_account_financing_lunas)
				";
		
		if($from_date!='' && $thru_date){
			$sql .= " AND mfi_account_financing.jtempo_angsuran_next BETWEEN '$from_date' AND '$thru_date'";
		}

		if($akad!='-'){
			$sql .= " AND mfi_account_financing.akad_code='$akad'";
		}

		if($product_code!='0000'){
			if($product_code=='semua'){
				$sql .= " AND mfi_product_financing.product_financing_gl_code='52'";
			}else{
				$sql .= " AND mfi_account_financing.product_code='$product_code'";
			}
		}

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='$branch_code')";
		}

		if($status_telkom!='-'){
			$sql .= " AND mfi_pegawai.status_telkom='".str_replace("%20"," ",$status_telkom)."' ";
		}

		if($code_divisi!=''){
			$sql .= " AND mfi_pegawai.code_divisi='".str_replace("%20"," ",$code_divisi)."' ";
		}

		$sql .= "ORDER BY mfi_account_financing.account_financing_no ASC";
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function export_lap_list_outstanding_pembiayaan_kelompok($cabang='',$rembug=false,$tanggal='')
	{
		$sql = "select * from v_lap_outstanding_pembiayaan where cif_type = 0";
		$param = array();

		if($cabang!="00000")
		{
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $cabang;
		}

		if($rembug!=false)
		{
			$sql .= " AND mfi_cm.cm_code = ? ";
			$param[] = $rembug;
		}
		// $sql.=" LIMIT 100";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/
	public function export_list_registrasi_pembiayaan($produk,$tanggal1_,$tanggal2_,$cabang,$akad='',$pengajuan_melalui='')
	{
		$sql = "SELECT
							mfi_account_financing.branch_code,
							mfi_account_financing.tanggal_pengajuan,
							mfi_account_financing.created_date,
							mfi_account_financing.tanggal_registrasi,
							mfi_account_financing.account_financing_no,
							mfi_cif.nama,
							mfi_cm.cm_code,
							mfi_cm.cm_name,
							mfi_kecamatan_desa.desa,
							mfi_account_financing.pokok,
							mfi_account_financing.margin,
							mfi_account_financing.angsuran_pokok,
							mfi_account_financing.angsuran_margin,
							mfi_account_financing.angsuran_catab,
							mfi_account_financing.jangka_waktu,
							mfi_account_financing.periode_jangka_waktu,
							mfi_account_financing.status_rekening,
							(SELECT
								mfi_list_code_detail.display_text AS sektor_ekonomi
							FROM
								mfi_list_code_detail
							WHERE
								mfi_list_code_detail.code_group= 'pekerjaan'
							AND mfi_account_financing.sektor_ekonomi = CAST(mfi_list_code_detail.code_value as integer)
							), 
							(SELECT
								mfi_list_code_detail.display_text AS peruntukan
							FROM
								mfi_list_code_detail
							WHERE
								mfi_list_code_detail.code_group= 'peruntukan'
							AND mfi_account_financing.peruntukan = CAST(mfi_list_code_detail.display_sort as integer)
							),
							mfi_product_financing.product_name||' - '||mfi_akad.akad_name AS product_name
				FROM
							mfi_account_financing
				INNER JOIN 	mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN 	mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				LEFT JOIN 	mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_product_financing ON mfi_account_financing.product_code=mfi_product_financing.product_code
				INNER JOIN mfi_akad ON mfi_akad.akad_code=mfi_product_financing.akad_code
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				WHERE mfi_account_financing.account_financing_id IS NOT NULL
				";
				
				if($akad!="-"){
					$sql .= " AND mfi_akad.akad_code = ?";
					$param[] = $akad;
				}
				
				if($pengajuan_melalui!="-")
				{
					if($pengajuan_melalui=="koptel"){
						$sql .= " AND mfi_account_financing_reg.pengajuan_melalui = ? ";
						$param[] = $pengajuan_melalui;
					}else{
						$sql .= " AND mfi_account_financing_reg.kopegtel_code = ? ";
						$param[] = $pengajuan_melalui;
					}
				}

				// if($produk!="2"){
				// 	$sql .= " AND mfi_cif.cif_type = ?";
				// 	$param[] = $produk;
				// }

				if($produk!="0000"){
					if($produk=='semua'){
						$sql .= " AND mfi_product_financing.product_financing_gl_code='52'";
					}else{
						$sql .= " AND mfi_account_financing.product_code=?";
						$param[] = $produk;
					}
					// $sql .= " AND mfi_account_financing.product_code = ?";
					// $param[] = $produk;
				}
				if($tanggal1_!="" && $tanggal2_!=""){
						
					$sql .= " AND mfi_account_financing.tanggal_pengajuan BETWEEN ? AND ?";
					$param[] = $tanggal1_;
					$param[] = $tanggal2_;
				}
				if($cabang!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[]=$cabang;
				}

				$sql .= " ORDER BY mfi_account_financing.tanggal_pengajuan ASC";
				$query = $this->db->query($sql,$param);
				// echo "<pre>";
				// print_r($this->db);
				// die();

				return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/


	// PAR
	public function get_laporan_par($date,$branch_code)
	{
		$flag_all_branch=$this->session->userdata('flag_all_branch');

		/*$sql = "SELECT a.cif_no,
				b.nama,
				a.branch_code,
				a.jangka_waktu,
				a.periode_jangka_waktu,
				? as tanggal_sekarang,
				d.droping_date,
				a.saldo_pokok, 
				(? - a.jtempo_angsuran_last) as hari_nunggak,
				fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) as freq_tunggakan,
				fn_get_par(? - a.jtempo_angsuran_last) as par_desc,
				fn_get_cpp_par(? - a.jtempo_angsuran_last) par,
				a.counter_angsuran,
				a.jtempo_angsuran_last,
				a.jtempo_angsuran_next,
				a.pokok,
				a.margin,
				a.angsuran_pokok,
				c.cm_name,
				(fn_get_cpp_par(? - a.jtempo_angsuran_last)/100 * a.saldo_pokok) as cadangan_piutang,
				(fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.pokok) as tunggakan_pokok 
				from mfi_account_financing a
				left join mfi_cif b on b.cif_no=a.cif_no
				left join mfi_cm c on c.cm_code = b.cm_code
				left join mfi_account_financing_droping d on d.account_financing_no=a.account_financing_no
				where (? - a.jtempo_angsuran_last) >0
				order by par_desc asc
				";*/
		$sql = "
			SELECT 
				a.cif_no,
				a.account_financing_no,
				b.nama,
				a.pokok,
				a.margin,
				c.droping_date,
				a.angsuran_pokok,
				a.angsuran_margin,
				a.saldo_pokok,
				a.saldo_margin,
				(? - a.jtempo_angsuran_last) as hari_nunggak,
				fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) as freq_tunggakan,
				(fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_pokok) as tunggakan_pokok,
				(fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_margin) as tunggakan_margin,
				fn_get_par(? - a.jtempo_angsuran_last) as par_desc,
				fn_get_cpp_par(? - a.jtempo_angsuran_last) par,
				(fn_get_cpp_par(? - a.jtempo_angsuran_last)/100 * a.saldo_pokok) as cadangan_piutang

			from mfi_account_financing a

			left join mfi_cif b on b.cif_no=a.cif_no
			left join mfi_account_financing_droping c on c.account_financing_no=a.account_financing_no

			where (? - a.jtempo_angsuran_last) >0
		";
		if($flag_all_branch=="0" || $branch_code!="00000"){
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
		}
		$sql .= "
			order by par_desc asc
		";
		$query = $this->db->query($sql,array($date,$date,$date,$date,$date,$date,$date,$date,$branch_code));

		return $query->result_array();
	}



	/****************************************************************************************/	
	// BEGIN REKAP JATUH TEMPO
	/****************************************************************************************/
		//cabang
		public function export_rekap_jatuh_tempo_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif.cif_no) AS jumlah_anggota,
							Sum(mfi_account_financing.angsuran_pokok) AS pokok
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code
					WHERE
							mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//by cabang
		public function export_rekap_jatuh_tempo_cabang($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							c.branch_name
							,count(a.cif_no) as jumlah_anggota
							,sum(a.angsuran_pokok) as pokok
							,sum(a.angsuran_margin) as margin
							,sum((a.angsuran_pokok+a.angsuran_margin)) as total
					FROM
							mfi_account_financing a
					INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
					INNER JOIN mfi_branch c ON c.branch_code=a.branch_code 

					where 	a.jtempo_angsuran_next between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//rembug
		public function export_rekap_jatuh_tempo_rembug($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as jumlah_anggota
							,sum(mfi_account_financing.angsuran_pokok) as pokok 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no

					where 	mfi_account_financing.jtempo_angsuran_next between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//petugas
		public function export_rekap_jatuh_tempo_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
								d.fa_code
								,d.fa_name
								,count(a.cif_no) as jumlah_anggota
								,sum(a.angsuran_pokok) as pokok
								,sum(a.angsuran_margin) as margin
								,sum((a.angsuran_pokoK+a.angsuran_margin)) as total
							FROM
								mfi_account_financing a
							INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
							INNER JOIN mfi_account_financing_reg c ON c.registration_no=a.registration_no
							LEFT JOIN mfi_fa d ON d.fa_code=c.fa_code
					WHERE
								a.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//peruntukan
		public function export_rekap_jatuh_tempo_peruntukan($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							c.display_text
							,count(a.cif_no) as jumlah_anggota
							,sum(a.angsuran_pokok) as pokok
							,sum(a.angsuran_margin) as margin
							,sum(a.angsuran_pokok+a.angsuran_margin) as total
					FROM
							mfi_account_financing a
					INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
					LEFT JOIN mfi_list_code_detail c ON CAST(c.code_value AS integer)=a.peruntukan 
					INNER JOIN mfi_branch d ON d.branch_code=a.branch_code 
					where 	c.code_group='peruntukan' AND a.jtempo_angsuran_next between ? and ?  ";

					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//resort
		public function export_rekap_jatuh_tempo_resort($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							c.resort_name
							,count(a.cif_no) as jumlah_anggota
							,sum(a.angsuran_pokok) as pokok
							,sum(a.angsuran_margin) as margin
							,sum(a.angsuran_pokok+a.angsuran_margin) as total
					FROM
							mfi_account_financing a
					INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
					INNER JOIN mfi_resort c ON c.resort_code=a.resort_code 
					INNER JOIN mfi_branch d ON d.branch_code=a.branch_code 
								
					where 	a.jtempo_angsuran_next between ? and ?  ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
	/****************************************************************************************/	
	// END REKAP JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
		//cabang
		public function export_rekap_pengajuan_pembiayaan_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif.cif_no) AS num,
							SUM(mfi_account_financing_reg.amount) AS amount
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code
					WHERE
							mfi_account_financing.tanggal_pengajuan BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

		//by cabang
		public function export_rekap_pengajuan_pembiayaan_cabang($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as num
							,sum(mfi_account_financing_reg.amount) as amount 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no
					join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no

					where 	mfi_account_financing.tanggal_pengajuan between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//rembug
		public function export_rekap_pengajuan_pembiayaan_rembug($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as num
							,sum(mfi_account_financing_reg.amount) as amount 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no
					join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no

					where 	mfi_account_financing.tanggal_pengajuan between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//petugas
		public function export_rekap_pengajuan_pembiayaan_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							c.fa_name
							,sum(b.amount) amount 
							,count(b.cif_no) AS num 
							FROM mfi_account_financing_reg b
							INNER JOIN mfi_cif d ON b.cif_no=d.cif_no
							INNER JOIN mfi_fa c ON c.fa_code=b.fa_code
					WHERE
								b.tanggal_pengajuan BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
						$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
						$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//peruntukan
		public function export_rekap_pengajuan_pembiayaan_peruntukan($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
						 c.display_text
						,sum(a.amount) amount
						,count(a.cif_no) AS num
					FROM mfi_account_financing_reg a
					INNER JOIN mfi_cif b ON b.cif_no=a.cif_no 
					INNER JOIN mfi_list_code_detail c ON a.peruntukan=CAST(c.code_value AS INTEGER)
					INNER JOIN mfi_product_financing d ON a.product_code=d.product_code
					WHERE c.code_group='peruntukan'
					AND a.tanggal_pengajuan BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
						$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
						$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
						$param[] = $branch_code;
					}

					$sql .=" GROUP BY 1 ";


					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//resort
		public function export_rekap_pengajuan_pembiayaan_resort($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 						
							c.resort_name
							,sum(b.amount) amount 
							,count(b.cif_no) AS num 
					FROM mfi_account_financing_reg b
					INNER JOIN mfi_cif d ON b.cif_no=d.cif_no
					INNER JOIN mfi_resort c ON c.resort_code=b.resort_code
					WHERE b.tanggal_pengajuan BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
						$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
						$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
						$param[] = $branch_code;
					}

					$sql .=" GROUP BY 1 ";


					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
		//cabang
		public function export_rekap_pencairan_pembiayaan_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif.cif_no) AS num,
							SUM(mfi_account_financing.pokok) AS pokok,
							SUM(mfi_account_financing.margin) AS margin
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code
					WHERE
							mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

		//by cabang
		public function export_rekap_pencairan_pembiayaan_cabang($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif.cif_no) AS num,
							SUM(mfi_account_financing.pokok) AS pokok,
							SUM(mfi_account_financing.margin) AS margin,
							SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code

					where 	mfi_account_financing_droping.droping_date between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//rembug
		public function export_rekap_pencairan_pembiayaan_rembug($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as num
							,sum(mfi_account_financing.pokok) as amount 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no
					join mfi_account_financing_droping on mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no

					where 	mfi_account_financing_droping.droping_date between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//petugas
		public function export_rekap_pencairan_pembiayaan_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_fa.fa_name,
							mfi_fa.fa_code,
							Count(mfi_cif.cif_no) AS num,
							SUM(mfi_account_financing.pokok) AS pokok,
							SUM(mfi_account_financing.margin) AS margin,
							SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
							LEFT JOIN mfi_fa ON mfi_fa.fa_code=mfi_account_financing.fa_code
					WHERE
								mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//peruntukan
		public function export_rekap_pencairan_pembiayaan_peruntukan($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
								mfi_list_code_detail.display_text,
								mfi_list_code_detail.code_value,
								Count(mfi_cif.cif_no) AS num,
								Sum(mfi_account_financing.pokok) AS pokok,
								Sum(mfi_account_financing.margin) AS margin,
								Sum((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
					FROM
								mfi_cif
								JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
								JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
								LEFT JOIN mfi_list_code_detail ON CAST(mfi_account_financing.peruntukan AS character varying) = mfi_list_code_detail.code_value
					WHERE
								mfi_list_code_detail.code_group='peruntukan'
								AND mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//resort
		public function export_rekap_pencairan_pembiayaan_resort($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_resort.resort_name,
							mfi_resort.resort_code,
							Count(mfi_cif.cif_no) AS num,
							SUM(mfi_account_financing.pokok) AS pokok,
							SUM(mfi_account_financing.margin) AS margin,
							SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
							JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing.resort_code
					WHERE
								mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="00000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="00000")
					{
					$sql .= " AND mfi_resort.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/

	public function export_rekap_saldo_anggota($branch_code)
	{
		$sql = "select 
				mfi_branch.branch_code,
				mfi_branch.branch_name,
				(select count(*) from mfi_cif, mfi_cm where mfi_cm.cm_code = mfi_cif.cm_code and mfi_cif.status = 1) as jumlah_anggota,
				(select sum(mfi_account_default_balance.setoran_lwk) from mfi_account_default_balance,mfi_cif where mfi_account_default_balance.cif_no = mfi_cif.cif_no and mfi_cif.status <> 2 and mfi_cif.branch_code = mfi_branch.branch_code) as setoran_lwk,
				(select sum(mfi_account_default_balance.simpanan_pokok) from mfi_account_default_balance,mfi_cif where mfi_account_default_balance.cif_no = mfi_cif.cif_no and mfi_cif.status <> 2 and mfi_cif.branch_code = mfi_branch.branch_code) as simpanan_pokok,
				(select sum(mfi_account_default_balance.tabungan_wajib) from mfi_account_default_balance,mfi_cif where mfi_account_default_balance.cif_no = mfi_cif.cif_no and mfi_cif.status <> 2 and mfi_cif.branch_code = mfi_branch.branch_code) as tabungan_minggon,
				(select sum(mfi_account_default_balance.tabungan_sukarela) from mfi_account_default_balance,mfi_cif where mfi_account_default_balance.cif_no = mfi_cif.cif_no and mfi_cif.status <> 2 and mfi_cif.branch_code = mfi_branch.branch_code) as tabungan_sukarela,
				(select sum(mfi_account_default_balance.tabungan_kelompok) from mfi_account_default_balance,mfi_cif where mfi_account_default_balance.cif_no = mfi_cif.cif_no and mfi_cif.status <> 2 and mfi_cif.branch_code = mfi_branch.branch_code) as tabungan_kelompok
				from mfi_branch
		";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .= " WHERE mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}


		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_saldo_anggota_rembug($branch_code)
	{
		$sql = "SELECT
				mfi_cm.cm_name,
				(select count(*) from mfi_cif where mfi_cm.cm_code = mfi_cif.cm_code and mfi_cif.status = 1) as jumlah_anggota,
				sum(mfi_account_default_balance.setoran_lwk) as setoran_lwk,
				sum(mfi_account_default_balance.simpanan_pokok) as simpanan_pokok,
				sum(mfi_account_default_balance.tabungan_wajib) as tabungan_minggon,
				sum(mfi_account_default_balance.tabungan_sukarela) as tabungan_sukarela,
				sum(mfi_account_default_balance.tabungan_kelompok) as tabungan_kelompok
				from mfi_cm, mfi_cif, mfi_account_default_balance
				where mfi_cm.cm_code = mfi_cif.cm_code and 
				mfi_cif.cif_no = mfi_account_default_balance.cif_no and 
				mfi_cif.status = 1
		";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		$sql .=" GROUP BY cm_name,jumlah_anggota ORDER BY cm_name ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_saldo_anggota_petugas($branch_code)
	{
		$sql = "select 
				mfi_fa.fa_name,
				(select count(*) from mfi_cif where mfi_cm.cm_code = mfi_cif.cm_code and mfi_cif.status = 1) as jumlah_anggota,
				sum(mfi_account_default_balance.setoran_lwk) as setoran_lwk,
				sum(mfi_account_default_balance.simpanan_pokok) as simpanan_pokok,
				sum(mfi_account_default_balance.tabungan_wajib) as tabungan_minggon,
				sum(mfi_account_default_balance.tabungan_sukarela) as tabungan_sukarela,
				sum(mfi_account_default_balance.tabungan_kelompok) as tabungan_kelompok
				from mfi_fa, mfi_cm, mfi_cif, mfi_account_default_balance
				where mfi_fa.fa_code = mfi_cm.fa_code and 
				mfi_cm.cm_code = mfi_cif.cm_code and 
				mfi_cif.cif_no = mfi_account_default_balance.cif_no and 
				mfi_cif.status = 1
		";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		$sql .=" GROUP BY 1,2 ORDER BY mfi_fa.fa_name ASC";

		$query = $this->db->query($sql,$param);

		echo "<pre>";
		print_r($this->db);
		die();

		return $query->result_array();
	}

	//cabang
	public function export_rekap_outstanding_pembiayaan_semua_cabang($branch_code)
	{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 mfi_branch.branch_code
					,mfi_branch.branch_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					from mfi_branch
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_branch.branch_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
	}

		//by cabang
		public function export_rekap_outstanding_pembiayaan_cabang($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 mfi_branch.branch_code
					,mfi_branch.branch_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					,(select sum(mfi_account_financing.saldo_catab) from mfi_account_financing,mfi_cif,mfi_cm where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as catab
					from mfi_branch
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_branch.branch_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}
		//rembug
		public function export_rekap_outstanding_pembiayaan_rembug($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_cm.cm_code
					,mfi_cm.cm_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					,(select sum(mfi_account_financing.saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as catab
					from mfi_cm
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_cif.cm_code = mfi_cm.cm_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_cm.cm_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		//produk
		public function export_rekap_outstanding_pembiayaan_produk($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$pokok = "(select sum(mfi_account_financing.saldo_pokok)
					  from mfi_account_financing,mfi_cif
					  where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1)";
			$margin_select1 = "(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1)";

			$margin_select2 = "(SELECT SUM(X.margin) FROM (
									(SELECT $pokok/2 AS margin FROM mfi_account_financing WHERE product_code='99' AND created_by='sys' LIMIT 1)
									UNION ALL
									(select sum(mfi_account_financing.saldo_margin) as margin from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1)
								) AS X)";

			$margin = "(CASE WHEN mfi_product_financing.product_code ='99' 
						THEN $margin_select2
						ELSE $margin_select1 END)";

			$sql = "SELECT 
					 mfi_product_financing.product_code
					,mfi_product_financing.product_name
					,(select count(*)
					  from mfi_account_financing,mfi_cif
					  where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code =  mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
				if($branch_code!="00000")
				{
					$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
			$sql .= "
					) as num
					,( $pokok
					";
				if($branch_code!="00000"){
					$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
			$sql .= "
					) as pokok
					,( $margin
					";
				if($branch_code!="00000"){
					$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
			$sql .= "
					) as margin
					,(select sum(mfi_account_financing.saldo_catab)
					  from mfi_account_financing,mfi_cif
					  where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
				if($branch_code!="00000"){
					$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
			$sql .= "
					) as catab
					FROM mfi_product_financing
					WHERE (select count(*)
					       from mfi_account_financing,mfi_cif
					       where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code =  mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
				if($branch_code!="00000"){
					$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
			$sql .= ") > 0";
			$sql.=" GROUP BY 1,2 ORDER BY mfi_product_financing.product_name asc";

			$query = $this->db->query($sql,$param);
			// echo '<pre>';
			// print_r($this->db);
			// die();
			return $query->result_array();
		}
		
		public function export_rekap_outstanding_pembiayaan_produk_sblm_ump($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_product_financing.product_code
					,mfi_product_financing.product_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code =  mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					,(select sum(mfi_account_financing.saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as catab
					from mfi_product_financing
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code =  mfi_product_financing.product_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_product_financing.product_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		//petugas
		public function export_rekap_outstanding_pembiayaan_petugas($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_fa.fa_code
					,mfi_fa.fa_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.fa_code =  mfi_fa.fa_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.fa_code = mfi_fa.fa_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.fa_code = mfi_fa.fa_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					,(select sum(mfi_account_financing.saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.fa_code = mfi_fa.fa_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as catab
					from mfi_fa
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.fa_code =  mfi_fa.fa_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_fa.fa_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		//resort
		public function export_rekap_outstanding_pembiayaan_resort($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_resort.resort_code
					,mfi_resort.resort_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.resort_code =  mfi_resort.resort_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.resort_code = mfi_resort.resort_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.resort_code = mfi_resort.resort_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					,(select sum(mfi_account_financing.saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.resort_code = mfi_resort.resort_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) as catab
					from mfi_resort
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.resort_code =  mfi_resort.resort_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="00000"){
				$sql .= " and mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_resort.resort_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		public function jqgrid_list_outstanding_pembiayaan_kelompok($sidx='',$sord='',$limit_rows='',$start='',$cabang='',$rembug='',$tanggal='',$petugas='',$produk='')
		{

			$order = '';
			$limit = '';

			if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
			if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";


			$sql = "select * from v_lap_outstanding_pembiayaan where account_financing_no != '' and cif_type = 0";
			$param = array();

			if($cabang!="00000")
			{
				$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $cabang;
			}

			if($rembug!="")
			{
				$sql .= " AND cm_code = ? ";
				$param[] = $rembug;
			}

            if($petugas!="000000")
            {
                $sql .= " AND fa_code = ? ";
                $param[] = $petugas;
            }

            if($produk!="0000")
            {
                $sql .= " AND product_code = ? ";
                $param[] = $produk;
            }

			$sql .= "$order $limit";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		} 	

		public function jqgrid_list_outstanding_pembiayaan_individu($sidx='',$sord='',$limit_rows='',$start='',$akad='',$produk_pembiayaan='',$pengajuan_melalui='',$peruntukan='')
		{

			$order = '';
			$limit = '';

			if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
			if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";


			$sql = "select * from v_lap_outstanding_pembiayaan where account_financing_no != '' and cif_type = 1";
			$param = array();

            if($produk_pembiayaan!="0000")
            {
                // $sql .= " AND product_code = ? ";
                // $param[] = $produk_pembiayaan;
                if($produk_pembiayaan=='semua'){
					$sql .= " AND product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
				}else{
					$sql .= " AND product_code = ?";
					$param[] = $produk_pembiayaan;
				}
            }

            if($akad!="-")
            {
                $sql .= " AND akad_code = ? ";
                $param[] = $akad;
            }

			if($pengajuan_melalui!="-")
			{
				if($pengajuan_melalui=="koptel"){
					$sql .= " AND pengajuan_melalui = ? ";
					$param[] = $pengajuan_melalui;
				}else{
					$sql .= " AND kopegtel_code = ? ";
					$param[] = $pengajuan_melalui;
				}
			}

            if($peruntukan!="-")
            {
                $sql .= " AND peruntukan = ? ";
                $param[] = $peruntukan;
            }

			$sql .= "$order $limit";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		} 	

		//peruntukan
		public function export_rekap_outstanding_pembiayaan_peruntukan($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
						a.display_text,
						a.code_value,
						a.display_sort,
						coalesce((select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.peruntukan::integer = a.display_sort::integer";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=	"		and status_rekening=1),0) as num,
						coalesce((select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.peruntukan::integer = a.display_sort::integer";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as pokok,
						coalesce((select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.peruntukan::integer = a.display_sort::integer";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as margin,
						coalesce((select sum(saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.peruntukan::integer = a.display_sort::integer";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as catab
					from 
						mfi_list_code_detail a
					where 
						a.code_group='peruntukan' ORDER BY a.code_value ";

			$query = $this->db->query($sql,$param);
			// echo '<pre>';
			// print_r($this->db);
			// die();
			return $query->result_array();
		}

		//peruntukan
		public function export_rekap_outstanding_pembiayaan_product($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
						a.product_name,
						a.product_code,
						coalesce((select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = a.product_code";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=	"		and status_rekening=1),0) as num,
						coalesce((select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = a.product_code";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as pokok,
						coalesce((select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = a.product_code";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as margin,
						coalesce((select sum(saldo_catab) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no=mfi_cif.cif_no and mfi_account_financing.product_code = a.product_code";
			if($branch_code!="00000"){
				$sql.=	"and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)"; 
				$param[] = $branch_code;
			}
			$sql.=  "		and status_rekening=1),0) as catab
					from 
						mfi_product_financing a
					ORDER BY a.product_name ";

			$query = $this->db->query($sql,$param);
			// echo '<pre>';
			// print_r($this->db);
			// die();
			return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
	public function export_list_pengajuan_pembiayaan_kelompok($cabang,$tanggal,$tanggal2,$rembug,$cif_type,$petugas,$produk)
	{
		$sql = "SELECT
							mfi_account_financing_reg.registration_no,
							mfi_account_financing_reg.rencana_droping,
							mfi_account_financing_reg.status,
							mfi_account_financing_reg.tanggal_pengajuan,
							mfi_cif.nama,
							mfi_cm.cm_name,
							(SELECT
								mfi_list_code_detail.display_text AS peruntukan
							FROM
								mfi_list_code_detail
							WHERE
								mfi_list_code_detail.code_group= 'peruntukan'
							AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.code_value as integer)
							),
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							mfi_account_financing_reg.amount,
							mfi_account_financing.pokok AS jumlah_dicairkan,
							mfi_account_financing.tanggal_akad AS tanggal_dicairkan
				FROM
					mfi_account_financing_reg
				LEFT JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				LEFT JOIN mfi_branch ON mfi_cm.branch_id = mfi_branch.branch_id
				LEFT JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no
				 AND mfi_account_financing_reg.tanggal_pengajuan = mfi_account_financing.tanggal_pengajuan

				WHERE 
					mfi_account_financing_reg.tanggal_pengajuan between ? AND ? AND mfi_cif.cif_type = ?";


				$param[] = $tanggal;	
				$param[] = $tanggal2;
				$param[] = $cif_type;

				if($cabang!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $cabang;
				}

				if($rembug!="00000" && $rembug!="")
				{
					$sql .= " AND mfi_cm.cm_code = ? ";
					$param[] = $rembug;
				}

				if($petugas!="000000")
				{
					$sql .= " AND mfi_account_financing_reg.fa_code = ? ";
					$param[] = $petugas;
				}

				if($produk!="0000")
				{
					if($produk=='semua'){
						$sql .= " AND mfi_product_financing.product_financing_gl_code='52'";
					}else{
						$sql .= " AND mfi_account_financing_reg.product_code=?";
						$param[] = $produk;
					}
					/*$sql .= " AND mfi_account_financing_reg.product_code = ? ";
					$param[] = $produk;*/
				}

				$sql .= " ORDER BY mfi_account_financing_reg.tanggal_pengajuan DESC, mfi_account_financing_reg.status ";

				$query = $this->db->query($sql,$param);
				// echo "<pre>";
				// print_r($this->db);
				// die();
				return $query->result_array();
	}

	public function export_list_pengajuan_pembiayaan_individu($tanggal,$tanggal2,$cif_type,$cabang,$petugas,$produk,$resort='',$status='',$akad='',$pengajuan_melalui='')
	{
		$param = array();
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.jangka_waktu,
				mfi_cif.cif_no,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name||' - '||mfi_akad.akad_name AS product_name,
				mfi_fa.fa_name,
				mfi_akad.akad_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code) 
					end) as melalui,
				(select nama_kopegtel from mfi_kopegtel where kopegtel_code = mfi_account_financing_reg.pelunasan_ke_kopeg_mana  limit 1) as pelunasan_ke_kopegtel,
				mfi_account_financing_reg.saldo_kewajiban
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				INNER JOIN mfi_akad ON mfi_product_financing.akad_code=mfi_akad.akad_code
				WHERE mfi_account_financing_reg.tanggal_pengajuan between ? AND ? AND mfi_cif.cif_type = ?
			   ";

				$param[] = $tanggal;		
				$param[] = $tanggal2;
				$param[] = $cif_type;

				if($cabang!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $cabang;
				}

				if($petugas!="000000")
				{
					$sql .= " AND mfi_account_financing.fa_code = ? ";
					$param[] = $petugas;
				}

				if($produk!="0000")
				{
					$sql .= " AND mfi_account_financing_reg.product_code = ? ";
					$param[] = $produk;
				}

				if($resort!="00000")
				{
					$sql .= " AND mfi_account_financing_reg.resort_code = ? ";
					$param[] = $resort;
				}

				if($status!="-")
				{
					$sql .= " AND mfi_account_financing_reg.status = ? ";
					$param[] = $status;
				}

				if($akad!="-")
				{
					$sql .= " AND mfi_akad.akad_code = ? ";
					$param[] = $akad;
				}

				if($pengajuan_melalui!="-")
				{
					if($pengajuan_melalui=="koptel"){
						$sql .= " AND mfi_account_financing_reg.pengajuan_melalui = ? ";
						$param[] = $pengajuan_melalui;
					}else{
						$sql .= " AND mfi_account_financing_reg.kopegtel_code = ? ";
						$param[] = $pengajuan_melalui;
					}
				}

				$sql .= " ORDER BY mfi_account_financing_reg.tanggal_pengajuan DESC, mfi_account_financing_reg.status ";
				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN BLOKIR TABUNGAN
	/****************************************************************************************/

	public function export_list_blokir_tabungan($from_date='',$thru_date='',$branch_code='')
	{
		$sql = "SELECT
				mfi_account_saving.account_saving_no as no_rek,
				mfi_cif.nama as nama,
				mfi_account_saving_blokir.created_date as tgl_blokir,
				mfi_account_saving_blokir.amount as jumlah,
				mfi_account_saving.created_date as tgl_buka,
				mfi_account_saving_blokir.description as keterangan
				FROM
				mfi_account_saving_blokir,mfi_account_saving,mfi_cif
				WHERE mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				AND mfi_account_saving.cif_no = mfi_cif.cif_no
				AND mfi_account_saving_blokir.created_date BETWEEN ? AND ?
				AND mfi_account_saving_blokir.tipe_mutasi = '2'
				";
				$param[]=$from_date;
				$param[]=$thru_date;
				if($branch_code!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[]=$branch_code;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN PEMBUKAAN DEPOSITO 
	/****************************************************************************************/

	public function export_list_pembukaan_deposito($from_date,$thru_date,$cabang)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				WHERE mfi_account_deposit.tanggal_buka BETWEEN ? AND ?
				AND mfi_account_deposit.status_rekening != '2'
				";
				$param[]=$from_date;
				$param[]=$thru_date;
				if($cabang!="00000"){
					$sql.=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[]=$cabang;
				}
				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN PEMBUKAAN DEPOSITO 
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING DEPOSITO
	/****************************************************************************************/

	public function export_lap_droping_deposito($cabang='',$rembug='',$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_cif.nama,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit_break.trx_date,
				mfi_account_deposit.nilai_bagihasil_last,
				mfi_account_deposit.nominal
				FROM
				mfi_account_deposit
				LEFT JOIN mfi_account_deposit_break ON mfi_account_deposit.account_deposit_no = mfi_account_deposit_break.account_deposit_no
				LEFT JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				WHERE 		
				mfi_account_deposit_break.trx_date between ? and ?
				AND mfi_account_deposit.status_rekening !='0'
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang=="00000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="00000")
				{
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $cabang;
				}

				// if($rembug!="")
				// {
				// $sql .= " AND mfi_cm.cm_code = ? ";
				// $param[] = $rembug;
				// }

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN DROPING DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN OUTSTANDING
	/****************************************************************************************/

	// public function export_rekap_outstanding_deposito($cabang='',$rembug='',$tanggal,$produk)
	public function export_rekap_outstanding_deposito($cabang='',$tanggal,$produk)
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_cif.nama,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over,
				mfi_account_deposit.nominal,
				mfi_account_deposit.nilai_cadangan_bagihasil
				FROM
				mfi_account_deposit_break
				INNER JOIN mfi_account_deposit ON mfi_account_deposit_break.account_deposit_no = mfi_account_deposit.account_deposit_no
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_branch ON mfi_cif.branch_code = mfi_branch.branch_code
				INNER JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				WHERE mfi_account_deposit.status_rekening != '0'
				";

				$param[] = $tanggal;

				if($cabang=="00000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="00000")
				{
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $cabang;
				}

				if($produk!="")
				{
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $rembug;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/

	// public function export_lap_transaksi_tabungan($cabang='',$rembug='',$from_date,$thru_date)
	public function export_lap_transaksi_tabungan($cabang='',$from_date='',$thru_date='',$jenis_transaksi) // rembug dihilangkan krn TAM khusus individu
	{
		$sql = "SELECT 
				mfi_trx_account_saving.branch_id,
				mfi_trx_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.description 
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_trx_account_saving.trx_date BETWEEN ? AND ?
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang!="00000"){
					$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $cabang;
				}
				if($jenis_transaksi!=''){
					$sql .= " AND mfi_trx_account_saving.trx_saving_type = ?";
					$param[] = $jenis_transaksi;
				}

				$sql .= " ORDER BY mfi_trx_account_saving.trx_date ASC";
				// if($rembug!="00000"){
				// 	$sql .= " AND mfi_cif.cm_code=?";
				// 	$param[] = $rembug;
				// }
				$query = $this->db->query($sql,$param);
				// echo "<pre>";
				// print_r($this->db);
				// die();
				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/



	/****************************************************************************************/	
	// LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/

	public function export_lap_transaksi_akun($cabang='',$rembug='',$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_trx_gl.branch_code,
				mfi_trx_gl.trx_date,
				mfi_trx_gl_detail.account_code,
				mfi_gl_account.account_name,
				mfi_trx_gl_detail.flag_debit_credit,
				mfi_trx_gl_detail.amount,
				mfi_trx_gl_detail.description,
				mfi_cif.nama  
				FROM 
				mfi_trx_gl_detail,
				mfi_trx_gl,
				mfi_gl_account,
				mfi_branch,
				mfi_cif,
				mfi_cm
				WHERE 
				mfi_trx_gl_detail.trx_gl_id=mfi_trx_gl.trx_gl_id 
				AND mfi_trx_gl_detail.account_code=mfi_gl_account.account_code
				AND mfi_branch.branch_code=mfi_trx_gl.branch_code
				AND mfi_cif.branch_code=mfi_branch.branch_code
				AND mfi_cm.cm_code=mfi_cif.cm_code
				AND mfi_trx_gl.trx_date BETWEEN ? AND ?
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang=="00000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="00000")
				{
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $cabang;
				}

				if($rembug!="")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/

	public function get_data_rekap_transaksi_rembug_by_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select branch_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_branch.branch_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_kelompok_cr
				from mfi_branch
				union all
				select
				mfi_branch.branch_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_branch
				) as foo
				group by branch_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				select branch_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_branch.branch_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_kelompok_cr
				from mfi_branch
				where mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				union all
				select
				mfi_branch.branch_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_branch
				where mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				) as foo
				group by branch_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_rembug_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select cm_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_cm.cm_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_kelompok_cr
				from mfi_cm
				union all
				select
				mfi_cm.cm_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_cm
				) as foo
				group by cm_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_rembug_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				select cm_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_cm.cm_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_kelompok_cr
				from mfi_cm,mfi_branch
				where mfi_cm.branch_id = mfi_branch.branch_id and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				union all
				select
				mfi_cm.cm_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_cm,mfi_branch
				where mfi_cm.branch_id = mfi_branch.branch_id and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				) as foo
				group by cm_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_petugas_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select fa_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_fa.fa_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				union all
				select
				mfi_fa.fa_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				) as foo
				group by fa_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_petugas_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				
				select fa_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_fa.fa_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				and mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				union all
				select
				mfi_fa.fa_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				and mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
				) as foo
				group by fa_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function cetak_akad_pembiayaan_get_institution()
	{
		$sql = "SELECT * FROM mfi_institution ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_get_kopegtel_by_code($kopegtel_code)
	{
		$sql = "SELECT 
					 nama_kopegtel AS institution_name
					,wilayah
					,alamat 
					,ketua_pengurus AS officer_name
					,'Ketua Kopegtel' AS officer_title
				FROM mfi_kopegtel WHERE kopegtel_code=? ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_get_cabang($branch_code)
	{
		$sql = "SELECT mfi_branch.*, mfi_jabatan.nama_jabatan 
				FROM mfi_branch, mfi_jabatan 
				WHERE mfi_branch.branch_officer_title=mfi_jabatan.kode_jabatan AND mfi_branch.branch_code=?";
		$query = $this->db->query($sql,array($branch_code));
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_data_banmod($account_financing_id="")
	{
		$sql = "SELECT
						 mfi_account_financing.account_financing_id
						,mfi_account_financing.cif_no
						,mfi_account_financing.account_financing_no
						,mfi_account_financing.pokok
						,mfi_account_financing.margin
						,mfi_account_financing.registration_no
						,mfi_cif.nama
						,mfi_cif.alamat
						,mfi_cif.rt_rw
						,mfi_cif.desa
						,mfi_cif.kecamatan
						,mfi_cif.kabupaten
						,mfi_cif.kodepos
						,mfi_cif.pekerjaan
						,mfi_cif.no_ktp
						,mfi_cif.usia
						,mfi_cif.branch_code
						,mfi_cif.tmp_lahir
						,mfi_cif.tgl_lahir
						,mfi_cif.nama_pasangan
						,mfi_cif.telpon_seluler
						,mfi_account_financing_reg.description
						,mfi_account_financing_reg.registration_no
						,mfi_account_financing_reg.tanggal_pengajuan
						-- ,mfi_account_financing_reg.nama_bank
						-- ,mfi_account_financing_reg.no_rekening
						-- ,mfi_account_financing_reg.atasnama_rekening
						,mfi_account_financing_reg.pengajuan_melalui
						,mfi_account_financing_reg.kopegtel_code
						,mfi_account_financing.akad_no
						,mfi_account_financing.tanggal_akad
						,mfi_account_financing.jangka_waktu
						,mfi_account_financing.periode_jangka_waktu
						,mfi_product_financing.product_name
						,mfi_product_financing.product_code
						,mfi_account_financing.angsuran_pokok
						,mfi_account_financing.angsuran_margin
						,mfi_account_financing.angsuran_catab
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.tanggal_jtempo
						,mfi_account_financing.biaya_administrasi
						,mfi_account_financing.biaya_jasa_layanan
						,mfi_account_financing.biaya_asuransi_jiwa
						,mfi_account_financing.biaya_notaris
						,mfi_account_financing.keterangan_jaminan
						,mfi_account_financing.uang_muka
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.akad_no
						,mfi_account_financing.nisbah_bagihasil
						,mfi_list_code_detail.display_text
						,(SELECT mfi_list_code_detail.display_text FROM mfi_list_code_detail WHERE mfi_account_financing.jenis_jaminan = mfi_list_code_detail.display_sort AND mfi_list_code_detail.code_group='jaminan') jenis_jaminan
						,(SELECT mfi_list_code_detail.display_text FROM mfi_list_code_detail WHERE mfi_account_financing.jenis_jaminan_sekunder = mfi_list_code_detail.display_sort AND mfi_list_code_detail.code_group='jaminan') jenis_jaminan_sekunder
						,mfi_account_financing.keterangan_jaminan_sekunder
						,mfi_pegawai.band
						,mfi_pegawai.posisi
						,mfi_pegawai.loker
						,mfi_pegawai.code_divisi
						,mfi_kopegtel.status_chaneling
						,mfi_kopegtel.ketua_pengurus
						,mfi_kopegtel.deskripsi_ketua_pengurus
						,mfi_kopegtel.nama_bank
						,mfi_kopegtel.bank_cabang
						,mfi_kopegtel.nomor_rekening
						,mfi_kopegtel.atasnama_rekening
						,mfi_kopegtel.nik
						,mfi_kopegtel.jabatan
						,CASE
			            	WHEN mfi_account_financing_reg.pengajuan_melalui='koptel' THEN ''
			            	ELSE (SELECT k.nama_kopegtel FROM mfi_kopegtel k WHERE k.kopegtel_code=mfi_account_financing_reg.kopegtel_code)
			        	 END AS nama_kopegtel
						,mfi_pegawai.agama
					FROM
						mfi_account_financing
					INNER JOIN mfi_account_financing_reg  ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
					INNER JOIN mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
					INNER JOIN mfi_list_code_detail ON mfi_account_financing.peruntukan = mfi_list_code_detail.display_sort
					LEFT JOIN mfi_pegawai ON mfi_account_financing.cif_no = mfi_pegawai.nik
					LEFT JOIN mfi_kopegtel ON mfi_account_financing.cif_no = mfi_kopegtel.kopegtel_code
					WHERE mfi_account_financing.account_financing_id = ?
						AND mfi_list_code_detail.code_group='peruntukan'
						";
		$query = $this->db->query($sql,array($account_financing_id));
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_data($account_financing_id="")
	{
		$sql = "SELECT
						 mfi_account_financing.account_financing_id
						,mfi_account_financing.cif_no
						,mfi_account_financing.account_financing_no
						,mfi_account_financing.pokok
						,mfi_account_financing.margin
						,mfi_account_financing.registration_no
						,mfi_cif.nama
						,mfi_cif.alamat
						,mfi_cif.rt_rw
						,mfi_cif.desa
						,mfi_cif.kecamatan
						,mfi_cif.kabupaten
						,mfi_cif.kodepos
						,mfi_cif.pekerjaan
						,mfi_cif.no_ktp
						,mfi_cif.usia
						,mfi_cif.branch_code
						,mfi_cif.tmp_lahir
						,mfi_cif.tgl_lahir
						,mfi_cif.nama_pasangan
						,mfi_cif.telpon_seluler
						,mfi_account_financing_reg.description
						,mfi_account_financing_reg.registration_no
						,mfi_account_financing_reg.tanggal_pengajuan
						,mfi_account_financing_reg.nama_bank
						,mfi_account_financing_reg.no_rekening
						,mfi_account_financing_reg.atasnama_rekening
						,mfi_account_financing_reg.pengajuan_melalui
						,mfi_account_financing_reg.kopegtel_code
						,mfi_account_financing.akad_no
						,mfi_account_financing.tanggal_akad
						,mfi_account_financing.jangka_waktu
						,mfi_account_financing.periode_jangka_waktu
						,mfi_product_financing.product_name
						,mfi_product_financing.product_code
						,mfi_account_financing.angsuran_pokok
						,mfi_account_financing.angsuran_margin
						,mfi_account_financing.angsuran_catab
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.tanggal_jtempo
						,mfi_account_financing.biaya_administrasi
						,mfi_account_financing.biaya_jasa_layanan
						,mfi_account_financing.biaya_asuransi_jiwa
						,mfi_account_financing.biaya_notaris
						,mfi_account_financing.keterangan_jaminan
						,mfi_account_financing.uang_muka
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.akad_no
						,mfi_account_financing.nisbah_bagihasil
						,mfi_list_code_detail.display_text
						,(SELECT mfi_list_code_detail.display_text FROM mfi_list_code_detail WHERE mfi_account_financing.jenis_jaminan = mfi_list_code_detail.display_sort AND mfi_list_code_detail.code_group='jaminan') jenis_jaminan
						,(SELECT mfi_list_code_detail.display_text FROM mfi_list_code_detail WHERE mfi_account_financing.jenis_jaminan_sekunder = mfi_list_code_detail.display_sort AND mfi_list_code_detail.code_group='jaminan') jenis_jaminan_sekunder
						,mfi_account_financing.keterangan_jaminan_sekunder
						,mfi_pegawai.band
						,mfi_pegawai.posisi
						,mfi_pegawai.loker
						,mfi_pegawai.code_divisi
						,mfi_kopegtel.status_chaneling
						,mfi_kopegtel.ketua_pengurus
						,mfi_kopegtel.nik
						,mfi_kopegtel.jabatan
						,CASE
			            	WHEN mfi_account_financing_reg.pengajuan_melalui='koptel' THEN ''
			            	ELSE (SELECT k.nama_kopegtel FROM mfi_kopegtel k WHERE k.kopegtel_code=mfi_account_financing_reg.kopegtel_code)
			        	 END AS nama_kopegtel
						,mfi_pegawai.agama
					FROM
						mfi_account_financing
					INNER JOIN mfi_account_financing_reg  ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
					INNER JOIN mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
					INNER JOIN mfi_list_code_detail ON mfi_account_financing.peruntukan = mfi_list_code_detail.display_sort
					LEFT JOIN mfi_pegawai ON mfi_account_financing.cif_no = mfi_pegawai.nik
					LEFT JOIN mfi_kopegtel ON mfi_account_financing_reg.kopegtel_code = mfi_kopegtel.kopegtel_code
					WHERE mfi_account_financing.account_financing_id = ?
						AND mfi_list_code_detail.code_group='peruntukan'
						";
		$query = $this->db->query($sql,array($account_financing_id));
		return $query->row_array();
	}

	public function export_list_angsuran_pembiayaan_individu($tanggal,$tanggal2,$cabang,$petugas,$produk,$akad='',$pengajuan_melalui='',$tipe_angsuran='',$status_telkom='')
	{
		$sql = "
			SELECT
				b.account_financing_no,
				e.nama,
				b.pokok,
				b.margin,
				b.jangka_waktu,
				b.periode_jangka_waktu,
				(a.pokok+a.margin) jml_angsuran,
				a.pokok angsuran_pokok,
				a.margin angsuran_margin,
				(a.pokok+a.margin) jml_bayar,
				a.trX_date,
				b.jtempo_angsuran_last,
				b.saldo_pokok,
				b.saldo_margin,
				get_history_angsuran_ke(a.account_financing_no,a.trx_date) as angsuran_ke
			FROM mfi_trx_account_financing a
			JOIN mfi_account_financing b ON b.account_financing_no=a.account_financing_no
			JOIN mfi_product_financing c ON c.product_code=b.product_code
			LEFT JOIN mfi_account_financing_reg d ON d.registration_no=b.registration_no AND d.cif_no=b.cif_no
			LEFT JOIN mfi_cif e ON e.cif_no=b.cif_no
	
			WHERE a.trx_date BETWEEN ? AND ?
			AND a.trx_financing_type=1
		";
	//	LEFT JOIN mfi_pegawai ON mfi_pegawai.nik = e.cif_no
		$param[] = $tanggal;	
		$param[] = $tanggal2;

		if($cabang!="00000"){
			$sql.=" AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $cabang;
		}

        if($petugas!="000000")
        {
            $sql .= " AND b.fa_code = ? ";
            $param[] = $petugas;
        }

        if($produk!="0000")
        {
        	if($produk=='semua'){
				$sql .= " AND c.product_financing_gl_code='52'";
			}else{
				$sql .= " AND b.product_code=?";
				$param[] = $produk;
			}
            // $sql .= " AND b.product_code = ? ";
            // $param[] = $produk;
        }
        
    //    if($status_telkom!=''){
	//		$sql .= " AND mfi_pegawai.status_telkom=? ";
	//		$param[] = $status_telkom;
	//	}

		if($akad!="-")
		{
			$sql .= " AND b.akad_code = ? ";
			$param[] = $akad;
		}

		if($pengajuan_melalui!="-")
		{
			if($pengajuan_melalui=="koptel"){
				$sql .= " AND d.pengajuan_melalui = ? ";
				$param[] = $pengajuan_melalui;
			}else{
				$sql .= " AND d.kopegtel_code = ? ";
				$param[] = $pengajuan_melalui;
			}
		}

		if($tipe_angsuran!='' && $tipe_angsuran!="-")
		{
			$sql .= " AND a.tipe_angsuran = ? ";
			$param[] = $tipe_angsuran;					
		}

		$sql .= " order by a.trx_date asc";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// GET NAMA CABANG BY BRANCH_CODE
	public function get_nama_cabang($branch_code)
	{
		$sql = "SELECT branch_name FROM mfi_branch WHERE branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";

		$query = $this->db->query($sql,array($branch_code));
		// print_r($this->db);
		$data =  $query->row_array();
		if (count($data>0)) {
		return $data['branch_name'];
		} else {
		return 'SEMUA';
		}	
	}

	public function export_rekap_pengajuan_pembiayaan_product($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
						 c.product_name
						,sum(a.amount) amount
						,count(a.cif_no) AS num
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON b.cif_no=a.cif_no 
				INNER JOIN mfi_product_financing c ON a.product_code=c.product_code
				WHERE b.cif_type=1
				AND a.tanggal_pengajuan BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_list_jatuh_tempo_angsuran($tanggal,$tanggal2,$cabang,$petugas,$produk,$resort='')
	{
		/*$sql = "select
				a.account_financing_no,
				b.jtempo_angsuran_last,
				c.nama,
				d.product_name,
				(a.pokok+a.margin+a.catab) as besar_angsuran,
				(b.pokok+b.margin+b.cadangan_resiko) as besar_yg_dibayar,
				a.trx_date,
				(case 
				  when b.periode_jangka_waktu = 0 
				  then (b.jtempo_angsuran_next::date-a.jto_date::date)
				  when b.periode_jangka_waktu = 1
				  then ((b.jtempo_angsuran_next::date-a.jto_date::date)/7)
				  when b.periode_jangka_waktu = 2
				  then ((b.jtempo_angsuran_next::date-a.jto_date::date)/30)
				  when b.periode_jangka_waktu = 3
				  then 1
				  else 0
				end) as angsuran_ke
				from mfi_trx_account_financing a
				join mfi_account_financing as b on b.account_financing_no=a.account_financing_no and b.status_rekening=1
				join mfi_cif c on c.cif_no=b.cif_no
				join mfi_product_financing d on d.product_code=b.product_code
				left join mfi_cm e on e.cm_code=c.cm_code
				where a.trx_financing_type=1
				and a.trx_date between ? and ?
			   ";*/

		// $sql = "select
		// 		a.account_financing_no,
		// 		a.jtempo_angsuran_next,
		// 		b.nama,
		// 		c.product_name,
		// 		(last_day(a.tanggal_jtempo) + INTERVAL '1' MONTH) as tanggal_jtempo,
		// 		(a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab) as besar_angsuran,
		// 		(select (d.pokok+d.margin+d.catab) from mfi_trx_account_financing d where d.account_financing_no=a.account_financing_no and a.jtempo_angsuran_last=d.jto_date and d.trx_financing_type=1 and d.trx_date between ? and ?) as besar_yg_dibayar,
		// 		(select e.trx_date from mfi_trx_account_financing e where e.account_financing_no=a.account_financing_no and a.jtempo_angsuran_last=e.jto_date and e.trx_financing_type=1 and e.trx_date between ? and ?) as trx_date,
		// 		get_history_angsuran_ke(a.account_financing_no,a.jtempo_angsuran_last) as angsuran_ke
		// 		from mfi_account_financing a
		// 		left join mfi_cif b on b.cif_no=a.cif_no
		// 		left join mfi_product_financing c on c.product_code=a.product_code
		// 		where a.status_rekening=1
		// ";

		// $param[] = $tanggal;	
		// $param[] = $tanggal2;
		// $param[] = $tanggal;	
		// $param[] = $tanggal2;

		$sql = "select 
				a.cif_no,
				a.counter_angsuran,
				(select sum(angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as besar_angsuran,
				(select jtempo_angsuran_next from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as jtempo_angsuran_next,
				(select last_day(tanggal_jtempo) from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as tanggal_jtempo
				from mfi_account_financing a
				where a.status_rekening=1
			";

		if($tanggal!="" && $tanggal2!=""){
		 	$sql .=" AND a.jtempo_angsuran_next BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}

		if($cabang=="00000" || $cabang==""){
			$sql .= " ";
		}else if($cabang!="00000"){
			$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $cabang;
		}

        if($petugas!="000000")
        {
            $sql .= " AND a.fa_code = ? ";
            $param[] = $petugas;
        }

        if($produk!="0000")
        {
            $sql .= " AND a.product_code = ? ";
            $param[] = $produk;
        }

        if($resort!="00000")
        {
            $sql .= " AND a.resort_code = ? ";
            $param[] = $resort;
        }

		$sql .= " group by 1,2 ORDER BY a.counter_angsuran ";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function export_data_lengkap_anggota($cif_no)
	{
		$sql = "select * from mfi_cif where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	public function export_data_lengkap_tabungan($cif_no)
	{
		$sql = "select mfi_account_saving.*, mfi_product_saving.product_name from mfi_account_saving inner join mfi_product_saving on mfi_product_saving.product_code = mfi_account_saving.product_code where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	public function export_data_lengkap_deposito($cif_no)
	{
		$sql = "select mfi_account_deposit.*, mfi_product_deposit.product_name from mfi_account_deposit inner join mfi_product_deposit on mfi_product_deposit.product_code = mfi_account_deposit.product_code where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	function export_data_lengkap_pembiayaan($cif_no){
		$sql = "SELECT
		maf.*,
		mpf.product_name

		FROM mfi_account_financing AS maf
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code

		WHERE cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function export_rekap_pengajuan_pembiayaan_status($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
						 a.status 
						,sum(a.amount) amount
						,count(a.cif_no) AS num
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON b.cif_no=a.cif_no 
				INNER JOIN mfi_product_financing d ON a.product_code=d.product_code

				WHERE b.cif_type=1
				AND a.tanggal_pengajuan BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	/**
	* LAPORAN PAR TERHITUNG
	*/
	public function get_laporan_par_terhitung($date,$branch_code)
	{
		$flag_all_branch=$this->session->userdata('flag_all_branch');

		$sql = "
			select
			b.account_financing_no,
			d.nama,
			b.pokok,
			b.margin,
			b.saldo_pokok,
			b.saldo_margin,
			c.droping_date,
			b.angsuran_pokok,
			b.angsuran_margin,
			a.saldo_pokok,
			a.saldo_margin,
			a.hari_nunggak,
			a.freq_tunggakan,
			a.tunggakan_pokok,
			a.tunggakan_margin,
			a.par_desc,
			a.par,
			a.cadangan_piutang
			from mfi_par a
			left join mfi_account_financing b on b.account_financing_no=a.account_financing_no
			left join mfi_account_financing_droping c on c.account_financing_no=a.account_financing_no
			left join mfi_cif d on d.cif_no=b.cif_no
			where a.tanggal_hitung = ?
		";

		// jika bukan all branch
		// dan jika branch bukan PUSAT
		if($flag_all_branch=="0" || $branch_code!="00000"){
			$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
		}
		$sql .= "
			order by par_desc asc
		";
		$query = $this->db->query($sql,array($date,$branch_code));

		return $query->result_array();
	}

	/*
	LAPORAN LABA RUGI
	UJANG IRAWAN 18 SEPTEMBER 2014 
	07:07 WIB 
	*/
	public function export_lap_laba_rugi($branch_code,$from_date,$last_date)
	{
		$param = array();
		$report_code='20';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";
			
		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$exp = explode('#',$rows[$i]['formula']);
				
				if(count($exp) > 1){
					$rows[$i]['formula'] = $exp[0];
					$report_code = $exp[1];
					$rumus = $exp[2];
				}else{
					$formula = $rows[$i]['formula'];
				}

				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],date('Y-m-d',strtotime('-1 day '.$from_date)),$branch_code,$report_code);
				}

					// $formula=$rows[$i]['formula'];
				$amount=array();
				foreach($arr_amount as $key=>$value):
					// $formula=str_replace('$'.$key, $value.'::numeric', $formula);
					$amount[]=$value;
				endforeach;

				//RUMUS FORMULA
				if($rumus == "dikurang"){
					$formula = $amount[0] - $amount[1];
					$formula.= "::numeric";
				}else{
					$amount2 = !empty(@$amount[2]) ? $amount[2] : 0;
					$formula = $amount[0] + $amount[1] + $amount2;
					$formula.= "::numeric";
				}
				//END RUMUS
				
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$exp = explode('#',$rows[$i]['formula']);
				
				if(count($exp) > 1){
					$rows[$i]['formula'] = $exp[0];
					$report_code = $exp[1];
					$rumus = $exp[2];
				}else{
					$formula = $rows[$i]['formula'];
				}

				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}

					// $formula2=$rows[$i]['formula2'];
				$amount=array();
				foreach($arr_amount as $key=>$value):
					// $formula2=str_replace('$'.$key, $value.'::numeric', $formula2);
					$amount[]=$value;
				endforeach;

				//RUMUS FORMULA
				if($rumus == "dikurang"){
					$formula2 = $amount[0] - $amount[1];
					$formula2.= "::numeric";
				}else{
					$amount2 = !empty(@$amount[2]) ? $amount[2] : 0;
					$formula2 = $amount[0] + $amount[1] + $amount2;
					$formula2.= "::numeric";
				}
				//END RUMUS

				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}

	/**/
	public function get_account_saving_data_by_account_saving_no($account_saving_no)
	{
		$sql = "select 
				saving.account_saving_no,
				cif.cif_no,
				cif.nama,
				cif.alamat,
				cif.rt_rw,
				cif.desa,
				cif.kecamatan,
				cif.kabupaten,
				cif.kodepos
				from mfi_account_saving saving, mfi_cif cif
				where saving.cif_no=cif.cif_no and
				saving.account_saving_no = ?
		";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}


	public function export_rekapitulasi_npl($cabang)
	{
		$param=array();
		$sql = "select
				a.branch_code,
				a.branch_name,
				a.branch_class,
				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='L')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='L')
				end) as jml1,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='L')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='L')
				end) as saldo_pokok1,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='L')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='L') 
				end) as cpp1,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='KL')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='KL')
				end) as jml2,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='KL')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='KL')
				end) as saldo_pokok2,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='KL')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='KL') 
				end) as cpp2,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='R')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='R')
				end) as jml3,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='R')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='R')
				end) as saldo_pokok3,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='R')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='R') 
				end) as cpp3,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='M')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='M')
				end) as jml4,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='M')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='M')
				end) as saldo_pokok4,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='M')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.branch_code=a.branch_code and par_desc='M') 
				end) as cpp4
				from mfi_branch a
				where a.branch_class <> 0 and a.branch_class <> 1 and branch_code not in('10900','10901')
				";
		if($cabang!="00000"){
			$sql .= "and a.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?)";
			$param[] = $cabang;
		}
		$sql .=	"group by a.branch_code,a.branch_name,a.branch_class
				order by a.branch_code,a.branch_name asc;
				";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

    /*
    | Modul : Laporan Neraca Rinci
    | author : Sayyid Nurkilah
    | date : 2014-10-09 09:24
    */
	public function export_neraca_rinci_gl($branch_code='',$periode_bulan='',$periode_tahun='',$periode_hari)
	{
		$param = array();
		$from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
		$last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
		$report_code='11';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

			if($branch_code=="00000"){
				$param[] = $last_date;
				$param[] = 'all';
				$param[] = $last_date;
				$param[] = 'all';
				$param[] = $report_code;
			}else{
				$param[] = $last_date;
				$param[] = $branch_code;
				$param[] = $last_date;
				$param[] = $branch_code;
				$param[] = $report_code;
			}
		$query = $this->db->query($sql,$param);
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];	
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$last_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	
		}
		return $row;
	}

    /*
    | Modul : Laporan Laba Rugi Rinci
    | author : Sayyid Nurkilah
    | date : 2014-10-09 09:24
    */
	public function export_lap_laba_rugi_rinci($branch_code,$from_date,$last_date)
	{
		$param = array();
		
		$report_code='21';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime('-1 day '.$from_date));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],date('Y-m-d',strtotime('-1 day '.$from_date)),$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}

	public function get_saldo_report_by_item_code2($report_code,$item_code,$branch_code,$from_date,$last_date)
	{
		$param = array();

		/* SALDO */
		$sql = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
				      else  
					fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
				      end  
				END,0) AS saldo
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param[] = $from_date;
		$param[] = $branch_code;
		$param[] = $from_date;
		$param[] = $branch_code;
		$param[] = $report_code;
		$param[] = $item_code;

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$exp = explode('#',$rows[$i]['formula']);
	
			if(count($exp) > 1){
				$rows[$i]['formula'] = $exp[0];
				$report_code = $exp[1];
				$rumus = $exp[2];
			}else{
				$formula = $rows[$i]['formula'];
			}

			$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
			}

				// $formula=$rows[$i]['formula'];
			$amount=array();
			foreach($arr_amount as $key=>$value):
				// $formula=str_replace('$'.$key, $value.'::numeric', $formula);
				$amount[]=$value;
			endforeach;

			//RUMUS FORMULA
			if($rumus == "dikurang"){
				$formula = $amount[0] - $amount[1];
				$formula.= "::numeric";
			}else{
				$amount2 = !empty(@$amount[2]) ? $amount[2] : 0;
				$formula = $amount[0] + $amount[1] + $amount2;
				$formula.= "::numeric";
			}

			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			$saldo=$rows['saldo'];
		}

		/*SALDO MUTASI*/
		$param2 = array();
		$sql2 = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1
				      else  
					   fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)
				      end  
				END,0) AS saldo_mutasi
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param2[] = $from_date;
		$param2[] = $last_date;
		$param2[] = $branch_code;
		$param2[] = $from_date;
		$param2[] = $last_date;
		$param2[] = $branch_code;
		$param2[] = $report_code;
		$param2[] = $item_code;

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();
		
		if($rows2['item_type']=='2'){ // FORMULA
			$exp = explode('#',$rows[$i]['formula']);
	
			if(count($exp) > 1){
				$rows[$i]['formula'] = $exp[0];
				$report_code = $exp[1];
				$rumus = $exp[2];
			}else{
				$formula = $rows[$i]['formula'];
			}

			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code($item_codes2[$j],$last_date,$branch_code,$report_code);
			}
			
			$amount=array();
			foreach($arr_amount as $key=>$value):
				$amount[]=$value;
			endforeach;

			//RUMUS FORMULA
			if($rumus == "dikurang"){
				$formula2 = $amount[0] - $amount[1];
				$formula2.= "::numeric";
			}else{
				$amount2 = !empty(@$amount[2]) ? $amount[2] : 0;
				$formula2 = $amount[0] + $amount[1] + $amount2;
				$formula2.= "::numeric";
			}
			//END RUMUS

			if($formula2==''){
				$saldo_mutasi=0;
			}else{
				$sqlsal2="select ($formula2) as saldo_mutasi";
				$quesal2=$this->db->query($sqlsal2);
				$rowsal2=$quesal2->row_array();
				$saldo_mutasi=$rowsal2['saldo_mutasi'];
			}
		}else{
			$saldo_mutasi=$rows2['saldo_mutasi'];
		}

		$return['saldo'] = $saldo;
		$return['saldo_mutasi'] = $saldo_mutasi;

		return $return;

	}


	public function get_saldo_report_by_item_code($report_code,$item_code,$branch_code,$periode_bulan,$periode_tahun,$periode_hari)
	{
		$param = array();
		$last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

		$sql = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
				      else  
					fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
				      end  
				END,0) AS saldo
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type";
		
		$param[] = $last_date;
		$param[] = $branch_code;
		$param[] = $last_date;
		$param[] = $branch_code;
		$param[] = $report_code;
		$param[] = $item_code;

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$last_date,$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			$sqlsal="select ($formula) as saldo";
			$quesal=$this->db->query($sqlsal);
			$rowsal=$quesal->row_array();
			$saldo=$rowsal['saldo'];
		}else{
			$saldo=$rows['saldo'];
		}
		return $saldo;
	}

	public function get_branch_by_branch_induk($branch_induk,$branch_class_output)
	{
		switch ($branch_class_output) {
			case '1':
			$sql = "select * from mfi_branch where branch_class=1 order by branch_code";
			break;
			case '2':
			$sql = "select * from mfi_branch where branch_class=2 and branch_induk = ? order by branch_code";
			break;
			case '3':
			$sql = "select * from mfi_branch where branch_class=3 and branch_induk = ? order by branch_code";
			break;
			default:
			$sql = "";
			break;
		}
		if($sql==""){
			return array();
		}else{
			$query = $this->db->query($sql,array($branch_induk));
			return $query->result_array();
		}
	}

	public function get_nama_petugas_by_financing_reg_no($financing_no='')
	{
	$sql ="SELECT a.fa_name FROM mfi_fa a
			INNER JOIN mfi_account_financing b ON b.fa_code=a.fa_code
			INNER JOIN mfi_account_financing_reg c ON c.registration_no=b.registration_no 
			WHERE b.account_financing_no = ?
			";
		$query = $this->db->query($sql,array($financing_no));
		$data = $query->row_array();
		return $data['fa_name'];
	}

	/*************************************************************************************/
	//CETAK HASIL SCORING
	public function cetak_hasil_scoring_adm($account_financing_scoring_id='')
	{
		$sql ="SELECT * FROM mfi_account_financing_scoring_adm WHERE account_financing_scoring_id =? ";
		$query = $this->db->query($sql,array($account_financing_scoring_id));
		return $query->result_array();
	}
	public function cetak_hasil_scoring($account_financing_scoring_id='')
	{
		$sql ="SELECT * FROM mfi_account_financing_scoring WHERE account_financing_scoring_id =? ";
		$query = $this->db->query($sql,array($account_financing_scoring_id));
		return $query->row_array();
	}	
	public function get_cif_by_account_financing_reg_scoring($account_financing_scoring_id)
	{
		$sql = "SELECT   c.branch_code
						,c.nama
						,a.account_financing_reg_id
						,a.amount
						,a.description 
						,a.registration_no
						,a.tanggal_pengajuan
						,a.status
						,b.account_financing_scoring_id
						,b.total_skor
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_account_financing_scoring b ON a.registration_no=b.registration_no
				INNER JOIN mfi_cif c ON a.cif_no=c.cif_no 
				WHERE b.account_financing_scoring_id=? ";
		$query = $this->db->query($sql,array($account_financing_scoring_id));
		return $query->row_array();
	}
	public function cek_skor_adm($account_financing_scoring_id='',$administrasi_value='')
	{
		$sql = "SELECT COUNT(*) AS skor FROM mfi_account_financing_scoring_adm 
				WHERE account_financing_scoring_id =? AND administrasi_value=?
			   ";
		$query = $this->db->query($sql,array($account_financing_scoring_id,$administrasi_value));
		$data = $query->row_array();
		if ($data['skor']>0) {
			return 'yes';
		} else {
			return 'no';
		}
		
	}
	public function get_value_scoring_by_code_val($code_group='',$code_value='')
	{
		$sql = "SELECT display_text from mfi_list_code_detail where code_group = ? AND code_value=?
			   ";
		$query = $this->db->query($sql,array($code_group,$code_value));
		$data = $query->row_array();
		if (isset($data['display_text'])) {
			return $data['display_text'];
		} else {
			return '';
		}
		
	}

	/*
	| GET CODES BY FORMULA
	*/
	function get_codes_by_formula($formula)
	{
		$explode=explode('$',$formula);
		$length=count($explode);
		$idx=0;
		for($i=0;$i<$length;$i++){
			if(trim($explode[$i])!=""){
				$arr_string[] = substr($explode[$i],0,7);
			}
		}
		return $arr_string;
	}
	/*
	| GET SALDO BY ITEM CODES
	*/
	function get_amount_from_item_code($item_code,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_group_glaccount2(gl_report_item_id,item_type, ? , ?)*-1         
		              else fn_get_saldo_group_glaccount2(gl_report_item_id,item_type, ? , ?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ? AND item_code=?
        ";
		if($branch_code=="00000"){
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	//CETAK HASIL SCORING
	/*************************************************************************************/

	/***********************************************************************************/
	//EXPORT ANGSURAN
	public function export_rekap_angsuran_pembiayaan_petugas($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
					fa_name
					,count(mfi_account_financing.account_financing_no) jumlah
					,sum(mfi_trx_account_financing.pokok) pokok
					,sum(mfi_trx_account_financing.margin) margin
					,sum((mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin)) total
				FROM mfi_account_financing
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_trx_account_financing ON mfi_account_financing.account_financing_no=mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing.registration_no=mfi_account_financing_reg.registration_no
				INNER JOIN mfi_fa ON mfi_account_financing_reg.fa_code=mfi_fa.fa_code
				WHERE  mfi_cif.cif_type = 1 AND mfi_trx_account_financing.trx_financing_type = 1				
					AND mfi_trx_account_financing.trx_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
					$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	public function export_rekap_angsuran_pembiayaan_produk($branch_code='',$tanggal='',$tanggal2='')
	{
		// $sql = "
		// 	SELECT 
		// 		product_name
		// 		,count(mfi_account_financing.account_financing_no) jumlah
		// 		,sum(mfi_trx_account_financing.pokok) pokok
		// 		,sum(mfi_trx_account_financing.margin) margin
		// 		,sum((mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin)) total
		// 	FROM mfi_account_financing
		// 	INNER JOIN mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
		// 	INNER JOIN mfi_trx_account_financing ON mfi_account_financing.account_financing_no=mfi_trx_account_financing.account_financing_no
		// 	INNER JOIN mfi_product_financing ON mfi_account_financing.product_code=mfi_product_financing.product_code
		// 		WHERE mfi_cif.cif_type = 1 and mfi_trx_account_financing.trx_financing_type = 1				
		// 		AND mfi_trx_account_financing.trx_date BETWEEN ? AND ? 
		// ";

		$sql = "
			SELECT
				 c.product_name
				,count(*) jumlah
				,sum(a.pokok) pokok
				,sum(a.margin) margin
				,sum(a.pokok+a.margin) total
			FROM mfi_trx_account_financing a
			JOIN mfi_account_financing b ON b.account_financing_no=a.account_financing_no
			JOIN mfi_product_financing c ON c.product_code=b.product_code
			WHERE a.trx_financing_type=1
			AND a.trx_date BETWEEN ? AND ?
		";


		$param[] = $tanggal;	
		$param[] = $tanggal2;

		if($branch_code=="00000" || $branch_code=="")
		{
		$sql .= " ";
		}
		elseif($branch_code!="00000")
		{
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		$sql.=" GROUP BY 1 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	public function export_rekap_angsuran_pembiayaan_peruntukan($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
						display_text
						,count(mfi_account_financing.account_financing_no) jumlah
						,sum(mfi_trx_account_financing.pokok) pokok
						,sum(mfi_trx_account_financing.margin) margin
					,sum((mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin)) total
				FROM mfi_account_financing
				INNER JOIN mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_trx_account_financing ON mfi_account_financing.account_financing_no=mfi_trx_account_financing.account_financing_no
					JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value::integer=mfi_account_financing.peruntukan
				where mfi_list_code_detail.code_group='peruntukan' AND mfi_cif.cif_type = 1 and mfi_trx_account_financing.trx_financing_type = 1				
					AND mfi_trx_account_financing.trx_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
					$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	public function export_rekap_angsuran_pembiayaan_cabang($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
					branch_name
					,count(mfi_account_financing.account_financing_no) jumlah
					,sum(mfi_trx_account_financing.pokok) pokok
					,sum(mfi_trx_account_financing.margin) margin
					,sum((mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin)) total
				FROM mfi_account_financing
				INNER JOIN mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_trx_account_financing ON mfi_account_financing.account_financing_no=mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_branch ON mfi_account_financing.branch_code=mfi_branch.branch_code
				where  mfi_cif.cif_type = 1 and mfi_trx_account_financing.trx_financing_type = 1			
					AND mfi_trx_account_financing.trx_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
					$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	public function export_rekap_angsuran_pembiayaan_resort($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
					resort_name
					,count(mfi_account_financing.account_financing_no) jumlah
					,sum(mfi_trx_account_financing.pokok) pokok
					,sum(mfi_trx_account_financing.margin) margin
					,sum((mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin)) total
				FROM mfi_account_financing
				INNER JOIN mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_trx_account_financing ON mfi_account_financing.account_financing_no=mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_resort ON mfi_account_financing.resort_code=mfi_resort.resort_code
					WHERE mfi_cif.cif_type = 1 and mfi_trx_account_financing.trx_financing_type = 1				
					AND mfi_trx_account_financing.trx_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
					$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}
	//END EXPORT ANGSURAN
	/***********************************************************************************/


	/*
	| GET SALDO MUTASI BY ITEM CODES
	*/ 
	function get_amount_mutasi_from_item_code($item_code,$from_date,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id,item_type, ? , ? , ?)*-1         
		              else fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id,item_type, ? , ? , ?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";
		if($branch_code=="00000"){
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	/*
	| BEGIN EXPORT TXT KOPTEL
	| Ade Sagita 2014-04-01 20:30
	*/
	public function export_txt_list_jatuh_tempo_angsuran($tanggal,$tanggal2,$produk='')
	{
		$param = array();
		// $sql = "SELECT
		// 		 a.cif_no
		// 		,a.jtempo_angsuran_next
		// 		,(a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab) as besar_angsuran				
		// 		,get_history_angsuran_ke(a.account_financing_no,a.jtempo_angsuran_last) as angsuran_ke
		// 		,a.tanggal_akad
		// 		,(last_day(a.tanggal_jtempo) + INTERVAL '1' MONTH) as tanggal_jtempo
		// 		from mfi_account_financing a
		// 		left join mfi_cif b on b.cif_no=a.cif_no
		// 		left join mfi_product_financing c on c.product_code=a.product_code
		// 		where a.status_rekening=1
		// 		AND a.jtempo_angsuran_next BETWEEN ? AND ?
		// 		--AND a.counter_angsuran=1
		// ";

		$sql = "SELECT 
				a.cif_no,
				a.counter_angsuran,
				(select sum(saldo_pokok+saldo_margin+angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as saldo_sebelumnya,
				(select sum(angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as besar_angsuran,
				(select jtempo_angsuran_next from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as jtempo_angsuran_next,
				(select last_day(tanggal_jtempo) from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as tanggal_jtempo
				from mfi_account_financing a
				where a.status_rekening=1
			";

		if($tanggal!="" && $tanggal2!=""){
		 	$sql .=" AND a.jtempo_angsuran_next BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}

        if($produk!="0000")
        {
        	if($produk=='semua'){
				$sql .= " AND a.product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
			}else{
				$sql .= " AND a.product_code=?";
				$param[] = $produk;
			}
           /* $sql .= " AND a.product_code = ? ";
            $param[] = $produk;*/
        }

        $sql .= " group by 1,2 ORDER BY a.counter_angsuran";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_data_jaminan($registration_no='')
	{
		$sql = "SELECT a.*, b.province,c.city
				FROM
				mfi_jaminan a
				LEFT JOIN mfi_province_code b ON a.provinsi=b.province_code
				LEFT JOIN mfi_province_city c ON a.kota=c.city_code
				WHERE a.registration_no = ? ";

		$query = $this->db->query($sql,array($registration_no));
		return $query->row_array();
	}

	public function preview_setoran_twp($trx_id='')
	{
		$sql = "SELECT 
				 c.nama_pegawai
				,a.nik
				,c.code_divisi
				,c.loker
				,c.kerja_bantu
				,a.amount
				from mfi_temp_twp a 
				-- inner join mfi_account_saving b ON a.account_saving_no=b.account_saving_no AND a.nik=b.cif_no
				left join mfi_pegawai c on a.nik=c.nik
				inner join mfi_cif d on a.nik=d.cif_no
				WHERE a.trx_id = ?
				ORDER BY c.code_divisi,c.loker,c.kerja_bantu ";

		$query = $this->db->query($sql,array($trx_id));
		return $query->result_array();
	}

	public function preview_penarikan_twp($trx_id='')
	{
		$sql = "SELECT 
					b.nama_pegawai
					,a.nik
					,c.saldo_riil
					from 
					mfi_temp_twp a
					left join mfi_pegawai  b on a.nik=b.nik
					left join mfi_account_saving c on c.cif_no=a.nik and c.product_code='01'
					WHERE a.trx_id = ? and a.flag_debit_credit='D'
					ORDER BY 3
 				";

		$query = $this->db->query($sql,array($trx_id));
		return $query->result_array();
	}

	public function download_pegawai_pensiun($tgl1='',$tgl2='')
	{
		$sql = "SELECT
				 nama_pegawai
				,nik
				,code_divisi
				,loker
				,kerja_bantu
				FROM mfi_pegawai
				WHERE tgl_pensiun_normal BETWEEN ? AND ?
				ORDER BY code_divisi, loker, kerja_bantu ";

		$query = $this->db->query($sql,array($tgl1,$tgl2));
		return $query->result_array();
	}
	/*
	| END EXPORT TXT KOPTEL
	| Ade Sagita 2014-04-01 20:30
	*/

	public function get_pejabatakad($code_product='') // pejabat yg menandatangani akad
	{
		$param = array();
		$sql = "SELECT * FROM mfi_list_code_detail WHERE code_group=? ";
		$param[] = 'pejabatakad_'.$code_product;
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_seri_akad_pembiayaan() // seri akad
	{
		$sql = "SELECT display_text FROM mfi_list_code_detail WHERE code_group='serisurat' and code_value='akad' ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		$seri = ($data['display_text']) ? $data['display_text'] : '-' ;
		return $seri;
	}

	function termin_cetak_akad_pembiayaan_banmod($account_financing_id)
	{
		$sql = "SELECT a.*
				FROM mfi_account_financing_reg_termin a
				LEFT JOIN mfi_account_financing_reg b ON a.account_financing_reg_id=b.account_financing_reg_id
				LEFT JOIN mfi_account_financing c ON b.registration_no=c.registration_no
				WHERE c.account_financing_id=?
				ORDER BY a.termin
		";
		$query = $this->db->query($sql,array($account_financing_id));
		return $query->result_array();
	}

	public function export_rekap_pengajuan_pembiayaan_melalui($branch_code='',$tanggal='',$tanggal2='')
	{
		$sql = "SELECT 
				(case when (a.pengajuan_melalui='koperasi')
				then (select nama_kopegtel from mfi_kopegtel where kopegtel_code=a.kopegtel_code)
				else 'KOPTEL LANGSUNG' end
				) as pengajuan_melalui
				,sum(a.amount) amount
				,count(a.cif_no) AS num
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON b.cif_no=a.cif_no 
				INNER JOIN mfi_product_financing d ON a.product_code=d.product_code
				WHERE b.cif_type=1
				AND a.tanggal_pengajuan BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_rekap_pencairan_pembiayaan_melalui($branch_code,$tanggal,$tanggal2)
	{
		$sql = "SELECT
				(case when (mfi_account_financing_reg.pengajuan_melalui='koperasi')
				then (select nama_kopegtel from mfi_kopegtel where kopegtel_code=mfi_account_financing_reg.kopegtel_code)
				else 'KOPTEL LANGSUNG' end
				) as pengajuan_melalui,
				COUNT(mfi_cif.cif_no) AS num,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin,
				SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
				FROM
				mfi_cif
				JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
				WHERE mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_rekap_jatuh_tempo_melalui($branch_code,$tanggal,$tanggal2)
	{
		$sql = "SELECT 
				(case when (c.pengajuan_melalui='koperasi')
				then (select nama_kopegtel from mfi_kopegtel where kopegtel_code=c.kopegtel_code)
				else 'KOPTEL LANGSUNG' end
				) as pengajuan_melalui
				,count(a.cif_no) as jumlah_anggota
				,sum(a.angsuran_pokok) as pokok
				,sum(a.angsuran_margin) as margin
				,sum((a.angsuran_pokoK+a.angsuran_margin)) as total
				FROM
				mfi_account_financing a
				INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
				LEFT JOIN mfi_account_financing_reg c ON c.registration_no=a.registration_no
				WHERE a.jtempo_angsuran_next BETWEEN ? AND ? ";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_rekap_pencairan_pembiayaan_produk($branch_code,$tanggal,$tanggal2)
	{
		$sql = "
			SELECT
				c.product_name,
				count(*) as num,
				sum(a.pokok) as pokok,
				sum(a.margin) as margin,
				sum(a.pokok+a.margin) as total
			FROM mfi_account_financing a
			JOIN mfi_account_financing_droping b ON a.account_financing_no=b.account_financing_no
			JOIN mfi_product_financing c ON c.product_code=a.product_code
			WHERE a.tanggal_akad BETWEEN ? AND ?

		";
		// $sql = "SELECT
		// 				mfi_product_financing.product_name,
		// 				Count(mfi_cif.cif_no) AS num,
		// 				SUM(mfi_account_financing.pokok) AS pokok,
		// 				SUM(mfi_account_financing.margin) AS margin,
		// 				SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
		// 		FROM
		// 				mfi_cif
		// 				JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
		// 				JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
		// 				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing.product_code
		// 		WHERE
		// 					mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_rekap_pencairan_pembiayaan_akad($branch_code,$tanggal,$tanggal2)
	{
		$sql = "SELECT
						mfi_akad.akad_name,
						Count(mfi_cif.cif_no) AS num,
						SUM(mfi_account_financing.pokok) AS pokok,
						SUM(mfi_account_financing.margin) AS margin,
						SUM((mfi_account_financing.pokok+mfi_account_financing.margin)) AS total
				FROM
						mfi_cif
						JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
						JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_account_financing.cif_no
						LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_account_financing.akad_code
				WHERE
							mfi_account_financing_droping.droping_date BETWEEN ? AND ? ";


				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code=="00000" || $branch_code=="")
				{
				$sql .= " ";
				}
				elseif($branch_code!="00000")
				{
				$sql .= " AND mfi_account_financing.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1 ";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

}