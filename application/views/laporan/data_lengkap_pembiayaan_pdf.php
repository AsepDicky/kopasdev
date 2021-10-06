<?php
switch ($pembiayaan['periode_jangka_waktu']) {
	case '0':
	$desc_periode_jangka_waktu="Harian";
	break;
	case '1':
	$desc_periode_jangka_waktu="Mingguan";
	break;
	case '2':
	$desc_periode_jangka_waktu="Bulanan";
	break;
	case '3':
	$desc_periode_jangka_waktu="Jatuh Tempo";
	break;
	default:
	$desc_periode_jangka_waktu="-";
	break;
}
$total_angsuran=$pembiayaan['angsuran_pokok']+$pembiayaan['angsuran_margin']+$pembiayaan['angsuran_catab'];
$total_biaya_adm=$pembiayaan['simpanan_wajib_pinjam']+$pembiayaan['biaya_administrasi']+$pembiayaan['biaya_jasa_layanan'];
?>
<page>
<div style="margin-bottom:10px;margin-top:20px;border-bottom:solid 1px #555;padding-bottom:25px;">
  	<div style="text-align:center;width:100%;font-size:17px;line-height:25px;font-weight:bold;">
    	<?php echo strtoupper($this->session->userdata('institution_name')) ;?>
    	<br/>
    	<?php echo $this->session->userdata('branch_name');?>
    	<br>
    	LAPORAN DATA LENGKAP PEMBIAYAAN
  	</div>
</div>
<table width="600" cellspacing="5" cellpadding="5" style="margin-top:0;font-size:12px;">
	<tr>
		<td width="150">Petugas</td>
		<td>: &nbsp; <?php echo $fa['fa_name'] ?></td>
	</tr>
	<tr>
		<td>Resort</td>
		<td>: &nbsp; <?php echo (isset($resort['resort_name'])==false)?"-":$resort['resort_name'] ?></td>
	</tr>
	<tr>
		<td>No.Pengajuan</td>
		<td>: &nbsp; <?php echo $pembiayaan['registration_no'] ?></td>
	</tr>
	<tr>
		<td>No.Costumer</td>
		<td>: &nbsp; <?php echo $cif['cif_no'] ?></td>
	</tr>
	<tr>
		<td>Nama Lengkap</td>
		<td>: &nbsp; <?php echo $cif['nama'] ?></td>
	</tr>
	<tr>
		<td>Nama Panggilan</td>
		<td>: &nbsp; <?php echo $cif['panggilan'] ?></td>
	</tr>
	<tr>
		<td>Nama Ibu Kandung</td>
		<td>: &nbsp; <?php echo $cif['ibu_kandung'] ?></td>
	</tr>
	<tr>
		<td>Tempat/Tanggal Lahir</td>
		<td>: &nbsp; <?php echo $cif['tmp_lahir'].', '.$cif['tgl_lahir'] ?></td>
	</tr>
</table>
<p></p>
<table width="600" cellspacing="5" cellpadding="5" style="margin-top:0;font-size:12px;">
	<tr>
		<td width="150">Account Saving No</td>
		<td>: &nbsp; <?php echo $pembiayaan['account_saving_no'] ?></td>
		<td width="100"></td>
		<td>Jadwal Angsuran</td>
		<td>: &nbsp; Reguler</td>
	</tr>
	<tr>
		<td>Produk</td>
		<td>: &nbsp; <?php echo $produk['product_name'] ?></td>
		<td></td>
		<td>Angsuran Pokok</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['angsuran_pokok'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Akad</td>
		<td>: &nbsp; <?php echo $akad['akad_name'] ?></td>
		<td></td>
		<td>Angsuran Margin</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['angsuran_margin'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Jangka Waktu Angsuran</td>
		<td>: &nbsp; <?php echo $pembiayaan['jangka_waktu'].' '.$desc_periode_jangka_waktu ?></td>
		<td></td>
		<td>Cadangan Tabungan</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['angsuran_catab'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Uang Muka</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['uang_muka'],0,',','.') ?>,-</td>
		<td></td>
		<td>Total Angsuran</td>
		<td>: &nbsp; Rp <?php echo number_format($total_angsuran,0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Nilai Pembiayaan</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['pokok'],0,',','.') ?>,-</td>
		<td></td>
		<td>Simpanan Wajib Pinjam</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['simpanan_wajib_pinjam'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Titipan Notaris</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['titipan_notaris'],0,',','.') ?>,-</td>
		<td></td>
		<td>Biaya Administrasi</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['biaya_administrasi'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Margin Pembiayaan</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['margin'],0,',','.') ?>,-</td>
		<td></td>
		<td>Biaya Jasa Layanan</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['biaya_jasa_layanan'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Tanggal Pengajuan</td>
		<td>: &nbsp; <?php echo date('d/m/Y',strtotime($pembiayaan['tanggal_pengajuan'])) ?></td>
		<td></td>
		<td>Total Biaya ADM</td>
		<td>: &nbsp; Rp <?php echo number_format($total_biaya_adm,0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Tanggal Registrasi</td>
		<td>: &nbsp; <?php echo date('d/m/Y',strtotime($pembiayaan['tanggal_registrasi'])) ?></td>
		<td></td>
		<td>Biaya Notaris</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['biaya_notaris'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Tanggal Akad</td>
		<td>: &nbsp; <?php echo date('d/m/Y',strtotime($pembiayaan['tanggal_akad'])) ?></td>
		<td></td>
		<td>Premi Asuransi Jiwa</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['biaya_asuransi_jiwa'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Tanggal Angsuran Ke-1</td>
		<td>: &nbsp; <?php echo date('d/m/Y',strtotime($pembiayaan['tanggal_mulai_angsur'])) ?></td>
		<td></td>
		<td>Premi Asuransi Jaminan</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['biaya_asuransi_jaminan'],0,',','.') ?>,-</td>
	</tr>
	<tr>
		<td>Tanggal Jatuh Tempo</td>
		<td>: &nbsp; <?php echo date('d/m/Y',strtotime($pembiayaan['tanggal_jtempo'])) ?></td>
	</tr>
</table>
<p></p>
<table width="600" cellspacing="5" cellpadding="5" style="margin-top:0;font-size:12px;">
	<tr>
		<td width="150"><strong>Jaminan Primer</strong></td>
		<td></td>
		<td></td>
		<td width="150"><strong>Jaminan Sekunder</strong></td>
		<td></td>
	</tr>
	<tr>
		<td>Jaminan</td>
		<td>: &nbsp; <?php echo $pembiayaan['txt_jenis_jaminan'] ?></td>
		<td></td>
		<td>Jaminan</td>
		<td>: &nbsp;<?php echo ($pembiayaan['txt_jenis_jaminan_sekunder']=="")?"-":$pembiayaan['txt_jenis_jaminan_sekunder'] ?></td>
	</tr>
	<tr>
		<td valign="top">Keterangan</td>
		<td valign="top">: &nbsp; <div style="width:205px;white-space:nowrap;"><?php echo $pembiayaan['keterangan_jaminan'] ?></div></td>
		<td></td>
		<td valign="top">Keterangan</td>
		<td valign="top">: &nbsp;&nbsp;<div style="width:205px;white-space:nowrap;"><?php echo ($pembiayaan['keterangan_jaminan_sekunder']=="")?"-":$pembiayaan['keterangan_jaminan_sekunder'] ?></div></td>
	</tr>
	<tr>
		<td>Jumlah</td>
		<td>: &nbsp; <?php echo $pembiayaan['jumlah_jaminan'] ?></td>
		<td></td>
		<td>Jumlah</td>
		<td>: &nbsp; <?php echo ($pembiayaan['jumlah_jaminan_sekunder']=="")?"-":$pembiayaan['jumlah_jaminan_sekunder'] ?></td>
	</tr>
	<tr>
		<td>Taksasi</td>
		<td>: &nbsp; Rp <?php echo number_format($pembiayaan['nominal_taksasi'],0,',','.') ?>,-</td>
		<td></td>
		<td>Taksasi</td>
		<td>: &nbsp; <?php echo ($pembiayaan['nominal_taksasi_sekunder']=="0")?"-":'Rp  '.number_format($pembiayaan['nominal_taksasi_sekunder'],0,',','.').',-'; ?></td>
	</tr>
	<tr>
		<td>Presentase</td>
		<td>: &nbsp; <?php echo round($pembiayaan['presentase_jaminan'],2) ?>%</td>
		<td></td>
		<td>Presentase</td>
		<td>: &nbsp; <?php echo ($pembiayaan['presentase_jaminan_sekunder']=="")?"-":round($pembiayaan['presentase_jaminan_sekunder'],2).'%'; ?></td>
	</tr>
</table>
<p></p>
<table width="600" cellspacing="5" cellpadding="5" style="margin-top:0;font-size:12px;">
	<tr>
		<td width="150">Sektor Ekonomi</td>
		<td>: &nbsp; <?php echo $pembiayaan['txt_sektor_ekonomi'] ?></td>
	</tr>
	<tr>
		<td>Peruntukan Pembiayaan</td>
		<td>: &nbsp; <?php echo $pembiayaan['txt_peruntukan'] ?></td>
	</tr>
	<tr>
		<td>Menggunakan Wakalah?</td>
		<td>: &nbsp; <?php echo ($pembiayaan['flag_wakalah']=="0")?"Tidak":"Ya"; ?></td>
	</tr>
</table>
</page>