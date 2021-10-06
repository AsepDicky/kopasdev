<h3 align="center" style="line-height:30px;"><?php echo $this->session->userdata('institution_name').'<br>'.$branch_name.'<br>MUTASI SALDO PEMBIAYAAN'; ?></h3>
<table>
    <tr>
        <td>Periode</td>
        <td>:</td>
        <td><?php echo $periode_bulan.'-'.$periode_tahun; ?></td>
    </tr>
</table>
<hr size="1">
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <thead>
        <tr>
            <th rowspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">No. Rekening</th>
            <th rowspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Nama</th>
            <th rowspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Produk</th>
            <th rowspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Tgl Droping</th>
            <th rowspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Plafon</th>
            <th colspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Saldo Awal</th>
            <th colspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Angsuran</th>
            <th colspan="2" align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Saldo Akhir</th>
        </tr>
        <tr>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Pokok</th>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Margin</th>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Pokok</th>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Margin</th>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Pokok</th>
          <th align="center" style="background: #EEE; border:#999 solid 1px; padding:5px; font-size:11px;">Margin</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$total_awal_pokok = 0;
		$total_awal_margin = 0;
		$total_angsuran_pokok = 0;
		$total_angsuran_margin = 0;
		$total_akhir_pokok = 0;
		$total_akhir_margin = 0;
        foreach($data as $row){
			$total_awal_pokok += $row['saldo_pokok'];
			$total_awal_margin += $row['saldo_margin'];
			$total_angsuran_pokok += $row['angsuran_pokok'];
			$total_angsuran_margin += $row['angsuran_margin'];
			$total_akhir_pokok = $total_awal_pokok - $total_angsuran_pokok;
			$total_akhir_margin = $total_awal_margin - $total_angsuran_margin;
		?>
        <tr>
            <td align="left" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo $row['account_financing_no'] ?></td>
            <td align="left" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo $row['nama'] ?></td>
            <td align="center" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo $row['product_name'] ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo $row['tanggal_akad'] ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['pokok']=='')?'':number_format($row['pokok'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['saldo_pokok']=='')?'':number_format($row['saldo_pokok'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['saldo_margin']=='')?'':number_format($row['saldo_margin'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['angsuran_pokok']=='')?'':number_format($row['angsuran_pokok'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['angsuran_margin']=='')?'':number_format($row['angsuran_margin'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['akhir_pokok']=='')?'':number_format($row['akhir_pokok'],2,',','.')) ?></td>
            <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo (($row['akhir_margin']=='')?'':number_format($row['akhir_margin'],2,',','.')) ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tr>
        <td colspan="5" align="center" style="border:#999 solid 1px; padding:5px; font-size:10px;"><strong>Total</strong></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_awal_pokok,2,',','.'); ?></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_awal_margin,2,',','.'); ?></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_angsuran_pokok,2,',','.'); ?></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_angsuran_margin,2,',','.'); ?></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_akhir_pokok,2,',','.'); ?></td>
        <td align="right" style="border:#999 solid 1px; padding:5px; font-size:10px;"><?php echo number_format($total_akhir_margin,2,',','.'); ?></td>
    </tr>
</table>