<?php $CI =& get_instance() ?>

<div align="center" style="text-align:center;font-weight:bold;font-size:15px;padding:5px 0"><?php echo strtoupper($this->session->userdata('institution_name')) ;?></div>
<div align="center" style="text-align:center;font-weight:bold;font-size:15px;padding:5px 0;margin-bottom:20px;">LAPORAN TRANSAKSI KAS PETUGAS</div>

<table>
  <tr>
    <td style="font-size:10px">Kode Kas</td>
    <td style="font-size:10px">:</td>
    <td style="font-size:10px"><?php $account_cash_name_ = str_replace("%20"," ", $account_cash_name);  echo $account_cash_name_; ?></td>
  </tr>
  <tr>
    <td style="font-size:10px">Pemegang Kas</td>
    <td style="font-size:10px">:</td>
    <td style="font-size:10px"><?php $pemegeng_kas_ = str_replace("%20"," ", $pemegeng_kas); echo $pemegeng_kas_; ?></td>
  </tr>
  <tr>
    <td style="font-size:10px">Tanggal</td>
    <td style="font-size:10px">:</td>
    <td style="font-size:10px"><?php echo $CI->format_date_detail($tanggal,'id',false,'-'); ?> s.d <?php echo $CI->format_date_detail($tanggal2,'id',false,'-'); ?></td>
  </tr>
</table>
<table style="margin-top:10px" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
            <th style="width:25px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">No</th>
            <th style="width:70px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Tanggal</th>
            <th style="width:250px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Keterangan</th>
            <th style="width:100px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Debet</th>
            <th style="width:100px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF">Credit</th>
            <th style="width:100px;text-align:center;font-size:10px;border:solid 1px #999;padding:4px;">Saldo </th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $CI = get_instance();
        $no=1;
        $saldo = (isset($transaksi_kas_petugas[0]['saldoawal']))?$transaksi_kas_petugas[0]['saldoawal']:0;
        foreach ($transaksi_kas_petugas as $data):
          if($data['flag_debet_credit']=='D'){
            $saldo += $data['trx_debet'];
          }
          if($data['flag_debet_credit']=='C'){
            $saldo -= $data['trx_credit'];
          }
      ?>
      <tr>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;"><?php echo $no++;?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:center;"><?php echo $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;"><?php echo $data['description'];?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($data['trx_debet'],0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-right:solid 0px #FFF;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($data['trx_credit'],0,',','.');?></td>
            <td style="font-size:9px;border:solid 1px #999;padding:4px;border-top:solid 0px #FFF;text-align:right;"><?php echo number_format($saldo,0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>
    </tbody>
</table>