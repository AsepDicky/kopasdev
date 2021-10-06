 
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:-20px;">
    <thead>
      <tr>
        <th style="padding:5px; border:0.5px solid; text-align:center">No</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">Nama</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">NIK</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">Divisi</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">Loker</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">Kerja bantu</th>
        <th style="padding:5px; border:0.5px solid; text-align:center">Saldo</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($result as $data): ?>
      <tr>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555;"><?php echo $data['nama_pegawai'];?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555;"><?php echo $data['nik'];?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555;"><?php echo $data['code_divisi'];?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555;"><?php echo $data['loker'];?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555;"><?php echo $data['kerja_bantu'];?></td>
            <td style="padding:5px; font-size:9px; border:solid 0.5px #555; text-align:right"><?php echo number_format($data['saldo_riil']);?></td>
      </tr>
    <?php endforeach?>
    </tbody>
</table>
