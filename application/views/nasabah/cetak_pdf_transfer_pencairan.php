<html>
<head>
	<title></title>
	<style type="text/css">
	.title{
		font-size:8px;
		padding: 5px;
		text-align: center;
		border:solid 1px #ccc;
		border-left:solid 0px #fff;
	}
	.content-title{
		font-size:10px;
		border-right:solid 1px #ccc;
		border-bottom:solid 1px #ccc;
		padding: 5px;
		font-weight: bold;
		color: blue;
	}
	.content{
		font-size:8px;
		border-right:solid 1px #ccc;
		border-bottom:solid 1px #ccc;
	}
	.first{
		border-left:solid 1px #ccc;
	}
	.textleft {
		text-align: left;
	}
	.textright {
		text-align: right;
	}
	.textcenter {
		text-align: center;
	}
	.textwrap {
		word-wrap:normal;
	}
	</style>
</head>
<body>
	<page backtop="0" backright="0" backbottom="0" backleft="0">
		<h3 align="center">DAFTAR PENYALURAN PEMBIAYAAN MANDIRI KOPTEL & KOPTEL SMILE TAHUN 2015</h3>
		<table cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="title first">NO</th>
					<th class="title">NIK</th>
					<th class="title" width="90">NAMA</th>
					<th class="title">HR AREA</th>
					<th class="title">JENIS<br>PEMBIAYAAN</th>
					<th class="title">BANK/CABANG</th>
					<th class="title">NOMOR</th>
					<th class="title">ATAS NAMA</th>
					<th class="title">BESAR<br>PEMBIAYAAN</th>
					<th class="title">POTONGAN<br>PREMI<br>ASURANSI</th>
					<th class="title">UJROH</th>
					<th class="title">POTONGAN<br>ANGSURAN<br>PERTAMA</th>
					<th class="title">BIAYA<br>PREMI<br>TAMBAHAN</th>
					<th class="title">KOMPENSASI<br>PELUNASAN<br>KOPTEL</th>
					<th class="title">JUMLAH<br>KOPTEL<br>TRANSFER</th>
					<th class="title">TRANSFER<br>PREMI<br>ASURANSI</th>
					<th class="title">KOMPENSASI<br>PELUNASAN<br>KOPEGTEL</th>
					<th class="title">JUMLAH<br>DITERIMA<br>KARYAWAN</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="18" class="content-title first"><span >DI TRANSFER KE REKENING PRIBADI</span></td>
				</tr>
				<?php 
				$no=0;
				foreach($datas as $data):
				$no++;
				$ujroh = $data['biaya_asuransi_jiwa']*5/100;
				$angsuran_pertama = $data['angsuran_pokok']+$data['angsuran_margin'];
				$transfer_premi_asuransi = $data['biaya_asuransi_jiwa']-$ujroh;
				$jumlah_diterima_karyawan = $data['pokok']-$data['biaya_asuransi_jiwa']-$angsuran_pertama-$data['biaya_administrasi']-$data['kewajiban_koptel']-$data['kewajiban_kopegtel'];
				$jumlah_koptel_transfer = $transfer_premi_asuransi+$data['kewajiban_kopegtel']+$jumlah_diterima_karyawan;
				?>
				<tr>
					<td class="content first textright"><?php echo $no; ?></td>
					<td class="content textcenter"><?php echo $data['cif_no']; ?></td>
					<td class="content"><?php echo $data['nama']; ?></td>
					<td class="content"><?php echo $data['nama_kopegtel']; ?></td>
					<td class="content"><?php echo $data['jenis_pembiayaan']; ?></td>
					<td class="content textwrap" width="80"><?php echo $data['nama_bank'].' '.$data['bank_cabang']; ?></td>
					<td class="content"><?php echo $data['no_rekening']; ?></td>
					<td class="content textwrap" width="80"><?php echo $data['atasnama_rekening']; ?></td>
					<td class="content textright"><?php echo number_format($data['pokok'],0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($data['biaya_asuransi_jiwa'],0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($ujroh,0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($data['angsuran_margin'],0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($angsuran_pertama,0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($data['biaya_administrasi'],0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($data['kewajiban_koptel'],0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($jumlah_koptel_transfer,0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($transfer_premi_asuransi,0,',','.'); ?></td>
					<td class="content textright"><?php echo number_format($jumlah_diterima_karyawan,0,',','.'); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</page>
</body>
</html>