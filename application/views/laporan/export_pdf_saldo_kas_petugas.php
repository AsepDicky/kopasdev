<?php $CI =& get_instance() ?>

<div align="center" style="text-align:center;font-weight:bold;font-size:15px;padding:5px 0"><?php echo strtoupper($this->session->userdata('institution_name')) ;?></div>
<div align="center" style="text-align:center;font-weight:bold;font-size:15px;padding:5px 0;margin-bottom:20px;">LAPORAN SALDO KAS PETUGAS</div>

<table>
  <tr>
    <td style="font-size:10px">Cabang</td>
    <td style="font-size:10px">:</td>
    <td style="font-size:10px"><?php echo $cabang;?></td>
  </tr>
  <tr>
    <td style="font-size:10px">Tanggal</td>
    <td style="font-size:10px">:</td>
    <td style="font-size:10px"><?php echo $CI->format_date_detail($tanggal,'id',false,'-'); ?></td>
  </tr>
</table>
<table style="margin-top:10px" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
            <th style="width:25px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">No</th>
            <th style="width:70px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Kas Petugas</th>
            <th style="width:210px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Pemegang Kas</th>
            <th style="width:80px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Saldo Awal</th>
            <th style="width:80px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Mutasi Debet</th>
            <th style="width:80px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Mutasi Credit</th>
            <th style="width:80px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;">Saldo Akhir</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $no=1;
        $total_saldoawal= 0;
        $total_debet = 0;
        $total_credit = 0;
        $total_saldoakhir = 0;
        foreach ($saldo_kas_petugas as $data):
          $saldoakhir = $data['saldoawal']+$data['mutasi_debet']-$data['mutasi_credit'];
          $total_saldoawal+=$data['saldoawal'];
          $total_debet+=$data['mutasi_debet'];
          $total_credit+=$data['mutasi_credit'];
          $total_saldoakhir+=$saldoakhir;
      ?>
      <tr>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;"><?php echo $no++;?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;"><?php echo $data['account_cash_code'];?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;"><?php echo $data['fa_name'];?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($data['saldoawal'],0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($data['mutasi_debet'],0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($data['mutasi_credit'],0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($saldoakhir,0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
        $data_total = $saldo_kas_petugas;
    ?>
      <tr>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;">&nbsp;</td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;">&nbsp;</td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;font-weight:bold;">Total</td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;font-weight:bold;"><?php echo number_format($total_saldoawal,0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;font-weight:bold;"><?php echo number_format($total_debet,0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;font-weight:bold;"><?php echo number_format($total_credit,0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-top:solid 0px #FFF;text-align:right;font-weight:bold;"><?php echo number_format($total_saldoakhir,0,',','.');?></td>
      </tr>
    </tbody>
</table>