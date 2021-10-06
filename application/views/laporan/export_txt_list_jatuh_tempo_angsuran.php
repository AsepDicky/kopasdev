<?php
        header("Content-Type: plain/text");
        header("Content-Disposition: Attachment; filename=list_jatuh_tempo_angsuran.txt");
        header("Pragma: no-cache");
?>
<?php 
  $CI = get_instance(); 
  $i=0;
  $spasi = 10;
  foreach ($datas as $key) 
  {
    // if($i==0){
    // echo 'cif_no        ';
    // echo 'besar_angsuran     ';
    // echo 'tanggal_akad        ';
    // echo 'tanggal_jtempo';
    // echo "\r\n";      
    // }
    $spasi1='';
    for ($i=0; $i<$spasi ; $i++) { 
        $spasi1.=' ';
    }
    $spasi2='';
    for ($i=0; $i<(8+($spasi-strlen($key['besar_angsuran']))) ; $i++) { 
        $spasi2.=' ';
    }
    $spasi3='';
    for ($i=0; $i<($spasi) ; $i++) { 
        $spasi3.=' ';
    }

    echo $key['cif_no'];
    echo $spasi1.$key['saldo_sebelumnya'];
    echo $spasi1.$key['besar_angsuran'];
    echo $spasi2."01".substr(date("dmY",strtotime($key['jtempo_angsuran_next'])),-6);
    echo $spasi3.date("dmY",strtotime($key['tanggal_jtempo']));
    echo "\r\n";
    $i++;

  }
?> 
