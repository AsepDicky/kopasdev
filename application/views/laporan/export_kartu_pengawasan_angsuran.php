<?php 
  $CI = get_instance();
?>
<div style="font-size:11px;">
<table align="center" cellspacing="0" cellpadding="0">
  <tr style="background-color:#eee;">
    <td width="550" style="border:1px solid #ddd;">
      <table>
        <tr>
          <td style="width:115px;padding:5px 1px 5px 1px;">No.Rek Pembiayaan</td>
          <td style="width:5px;padding:5px 1px 5px 1px;">:</td>
          <td style="width:200px;padding:5px 1px 5px 1px;"><?php echo $data['account_financing_no']; ?></td>

          <td style="width:85px;padding:5px 1px 5px 1px;">Plafon</td>
          <td style="width:5px;padding:5px 1px 5px 1px;">:</td>
          <td style="width:140px;padding:5px 1px 5px 1px;"><?php echo number_format($data['pokok'],0,',','.'); ?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">No.Rek Tabungan</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo $data['account_saving_no']; ?></td>

          <td style="padding:5px 1px 5px 1px;">Margin</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo number_format($data['margin'],0,',','.'); ?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Nama</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo $data['nama']; ?></td>

          <td style="padding:5px 1px 5px 1px;">Jangka Waktu</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;">
            <?php 
            $periode_jangka_waktu = '';
            switch($data['periode_jangka_waktu']){
              case "0":
              $periode_jangka_waktu=' Hari';
              break;
              case "1":
              $periode_jangka_waktu=' Minggu';
              break;
              case "2":
              $periode_jangka_waktu=' Bulan';
              break;
              case "3":
              $periode_jangka_waktu='x Jatuh Tempo';
              break;
            }
            echo $data['jangka_waktu'].''.$periode_jangka_waktu; 
            ?>
          </td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Produk</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo $data['product_name']; ?></td>

          <td style="padding:5px 1px 5px 1px;">Tgl Cair</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo date('d-m-Y',strtotime($data['droping_date'])); ?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Untuk</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo $data['untuk']; ?></td>

          <td style="padding:5px 1px 5px 1px;">Tgl. J tempo</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo date('d-m-Y',strtotime($data['tanggal_jtempo'])); ?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">PYD Ke</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php echo $data['pydke']; ?></td>

          <td style="padding:5px 1px 5px 1px;"></td>
          <td style="padding:5px 1px 5px 1px;"></td>
          <td style="padding:5px 1px 5px 1px;"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" cellpadding="0" cellspacing="0">            
  <tr>
      <td colspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;">Tanggal</td>
      <td colspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;">Angsuran</td>
      <td rowspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;padding-top:20px;" width="80">Saldo Hutang</td>
      <td rowspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;padding-top:20px;" width="125">Validasi</td>
  </tr>
  <tr>
      <td style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="60">Angsur</td>
      <td style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="60">Bayar</td>
      <td style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="15">Ke</td>
      <td style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="80">Jumlah</td>
  </tr>
  <?php echo $row_angsuran;?>
</table>
<br>
  <div style="width:610px;margin-left:70px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td align="center" width="200">NASABAH</td>
        <td align="center" width="130">&nbsp;</td>
        <td align="center" width="280"><?php echo $institution['institution_name'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <!-- <td align="center">( <?php $echo = (isset($cetak_petugas))?$cetak_petugas:'-'; echo $echo;?>)</td> -->
        <td align="center"><?php $echo = (isset($data['nama']))?$data['nama']:'-'; echo $echo;?></td>
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo $data_cabang['branch_officer_name'];?></td>
      </tr>
    </table>
  </div>
  <!-- <div style="width:610px;margin-left:70px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td align="center" width="120">&nbsp;</td>
        <td align="center" width="330"><?php echo $institution['institution_name'];?><br>KANTOR CABANG SYARIAH <?php echo $data_cabang['branch_name'];?></td>
        <td align="center" width="100">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">(<?php echo $data_cabang['branch_officer_name'];?>)</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
  </div> -->
</div>