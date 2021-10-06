<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 15px;
  font-weight: normal;
  color: #000;
  padding: 10px 8px;
  border-top: 2px solid #6678b1;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b .no
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 19%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 8%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 13%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}

/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 4px 10px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #262626;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
-->
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        Rekap Saldo Anggota Berdasarkan Rembug
        </div>
        <!--  
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:14px;">
        Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div> 
        -->
        <hr >
      </div>
      <table id="hor-minimalist-b" style="margin-left:13px;">
          <tbody>
            <tr>
              <td class="no">Kode</td>
              <td class="anggota">Keterangan</td>
              <td class="jumlah">Jumlah<br>Anggota</td>
              <td class="pokok">LWK</td>
              <td class="pokok">Investasi</td>
              <td class="pokok">Wajib</td>
              <td class="pokok">Kelompok</td>
              <td class="pokok">Sukarela</td>
            </tr>
            <?php
            $no = 1; 
            $total_anggota  = 0;
            $total_setoran_lwk  = 0;
            $total_simpanan_pokok    = 0;
            $total_tabungan_minggon   = 0;
            $total_tabungan_sukarela   = 0;
            $total_tabungan_kelompok   = 0;
            foreach ($result as $row):
              $total_anggota += $row['jumlah_anggota'];
              $total_setoran_lwk += $row['setoran_lwk'];
              $total_simpanan_pokok += $row['simpanan_pokok'];
              $total_tabungan_minggon += $row['tabungan_minggon'];
              $total_tabungan_sukarela += $row['tabungan_sukarela'];
              $total_tabungan_kelompok += $row['tabungan_kelompok'];
            ?>
            <tr class="value">
              <td class="val_anggota"><?php echo $no++;?></td>
              <td class="val_anggota" style="text-align:left;"><?php echo $row['cm_name'];?></td>
              <td class="val_jumlah"><?php echo $row['jumlah_anggota'];?></td>
              <td class="val_pokok"><?php echo number_format($row['setoran_lwk'],0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($row['simpanan_pokok'],0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($row['tabungan_minggon'],0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($row['tabungan_kelompok'],0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($row['tabungan_sukarela'],0,',','.');?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="value">
              <td class="val_pokok" style="font-weight:bold;border-left:solid #999" colspan="2">GRAND TOTAL :</td>
              <td class="val_pokok" style="text-align:center;"><?php echo number_format($total_anggota,0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($total_setoran_lwk,0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($total_simpanan_pokok,0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($total_tabungan_minggon,0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($total_tabungan_kelompok,0,',','.');?></td>
              <td class="val_pokok"><?php echo number_format($total_tabungan_sukarela,0,',','.');?></td>
            </tr>
          </tbody>
      </table>
</page>