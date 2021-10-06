<page style="font-size: 10px;">
<table>
	<tr>
		<td>
			<img src="<?php echo base_url('assets/img/logo-baik.png'); ?>">
		</td>
		<td>
			<table>
				<tr>
					<td colspan="2">
						<strong>REKAP TRANSAKSI HARIAN KOPERASI BAIK</strong>
					</td>
				</tr>
				<tr>
					<td width="40" style="height:14px;font-weight:bold;" valign="bottom">CABANG</td>
					<td width="200" style="height:14px;font-weight:bold;" valign="bottom">:&nbsp; <?php echo str_replace('%20',' ',$cabang); ?></td>
				</tr>
				<tr>
					<td style="height:14px;font-weight:bold;" valign="bottom">MAJELIS</td>
					<td style="height:14px;font-weight:bold;" valign="bottom">:&nbsp; <?php echo str_replace('%20',' ',$majelis); ?></td>
				</tr>
			</table>
		</td>
		<td width="510"></td>
		<td valign="bottom" style="padding-bottom:10px;">
			<table>
				<tr>
					<td style="padding:4px 5px;width:70px;border:solid 1px #777;font-weight:bold;text-align:right;font-size:11px;">Tanggal</td>
					<td style="padding:4px 3px;width:20px;border:solid 1px #777;"></td>
					<td style="padding:4px 3px;width:20px;border:solid 1px #777;"></td>
					<td style="padding:4px 3px;width:40px;border:solid 1px #777;"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0">
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #777; border-left:solid 1px #777; text-align:center;width:42px; font-size:11px;" rowspan="3">NO</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center; width:90px; font-size:11px;" rowspan="3">ID</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center; width:120px; font-size:11px;" rowspan="3">NAMA</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; width:50px; font-size:11px;" rowspan="3">ABSEN</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #000; text-align:center; font-size:11px;" colspan="4">SETORAN</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; width:84px; font-size:11px;" rowspan="3">SALDO<br>SUKARELA</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #000; text-align:center; width:84px; font-size:11px;">PENARIKAN</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center; font-size:11px;" colspan="3">REALISASI PEMBIAYAAN</td>
		</tr>
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center;" colspan="2">Angsuran</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:84px;" rowspan="2">Tab.<br>Sukarela</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center;width:84px;" rowspan="2">Tab.<br>Berencana</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center;width:84px;" rowspan="2">Tab.<br>Sukarela</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:84px;" rowspan="2">Plafon</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:84px;" rowspan="2">Adm.</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:84px;" rowspan="2">Asuransi</td>
		</tr>
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:30px;">Frek</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:84px;">@</td>
		</tr>
		<?php 
		$total_jumlah_angsuran = 0;
		$total_setoran_berencana = 0;
		$total_tabungan_sukarela = 0;
		$total_adm = 0;
		$total_droping = 0;
		$total_asuransi = 0;
		$no = 1;
		foreach($data as $row): 
			$total_jumlah_angsuran += $row['jumlah_angsuran'];
			$total_setoran_berencana += $row['setoran_berencana'];
			$total_tabungan_sukarela += $row['tabungan_sukarela'];
			$total_adm += $row['adm'];
			$total_droping += $row['droping'];
			$total_asuransi += $row['asuransi'];
		?>
		<tr>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $no ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $row['cif_no'] ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px;"><?php echo $row['nama'] ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px;">&nbsp;</td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;">&nbsp;</td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['jumlah_angsuran'],0,',','.') ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['setoran_berencana'],0,',','.') ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['tabungan_sukarela'],0,',','.') ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['adm'],0,',','.') ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['droping'],0,',','.') ?></td>
			<td style="font-size:11px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo number_format($row['asuransi'],0,',','.') ?></td>
		</tr>
		<?php 
		$no++;
		endforeach; 
		?>
		<tr>
			<td colspan="2" rowspan="4" style="text-align:center;padding:0; border-left:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777">
				<br>isilah absen dengan kode<br>
				<div style="width:140px;margin-top:-5px;height:84px;">
					<table cellspacing="1" cellpadding="0" style="margin:auto;">
						<tr>
							<td style="text-align:center;border:solid 1px #777;" width="20">H</td>
							<td align="left" valign="bottom"> &nbsp; Hadir</td>
						</tr>
						<tr>
							<td style="text-align:center;border:solid 1px #777;">I</td>
							<td align="left" valign="bottom"> &nbsp; Izin</td>
						</tr>
						<tr>
							<td style="text-align:center;border:solid 1px #777;">S</td>
							<td align="left" valign="bottom"> &nbsp; Sakit</td>
						</tr>
						<tr>
							<td style="text-align:center;border:solid 1px #777;">A</td>
							<td align="left" valign="bottom"> &nbsp; Alfa</td>
						</tr>
					</table>
				</div>
			</td>
			<td style="border-right:solid 1px #777"></td>
			<td style="font-size:11px; padding:3px 5px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;" colspan="2">TOTAL</td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;"></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_setoran_berencana,0,',','.'); ?></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_tabungan_sukarela,0,',','.'); ?></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold;"></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_adm,0,',','.'); ?></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_droping,0,',','.'); ?></td>
			<td style="font-size:11px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_asuransi,0,',','.'); ?></td>
		</tr>
		<tr>
			<td style="height:25px;" colspan="11">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td style="background:#F7F7F7; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">KAS AWAL</td>
			<td style="background:#F7F7F7; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">INFAQ</td>
			<td style="background:#F7F7F7; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">SETORAN</td>
			<td style="background:#F7F7F7; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">PENARIKAN</td>
			<td style="background:#F7F7F7; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">SALDO KAS</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td style="border-bottom:solid 1px #777; borderr-right:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">&nbsp;</td>
			<td style="border-bottom:solid 1px #777; border-right:solid 1px #777; ">&nbsp;</td>
			<td style="border-bottom:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
			<td style="border-bottom:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
			<td style="border-bottom:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
</table>

</page>
