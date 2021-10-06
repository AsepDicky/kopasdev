<?php
  $CI = get_instance();
?>
<style type="text/css">
#hor-minimalist-head
{
  
  font-size: 10px;
  background: #fff;
  margin: 0;
  border-collapse: collapse;
  white-space: normal;
  /*border: 1px solid #888;*/
}
#hor-minimalist-b
{
  
  font-size: 10px;
  background: #fff;
  border-collapse: collapse;
  white-space: normal;
  margin-top: 10px;
  /*border: 1px solid #888;*/
}
#hor-minimalist-b th
{
  font-size: 10px;
  font-weight: normal;
  color: #000;
  width: 190px;
  padding: 2px;
  border: 1px solid #888;
}
#hor-minimalist-b td
{
  color: #000;
  font-size: 10px ;
  padding: 2px;
  border: 1px solid #888;
}
</style>
<?php
  $jumlah_pembiayaan = (isset($get['jumlah_pembiayaan'])?$get['jumlah_pembiayaan']:"0");
  $pelunasan_koptel = (isset($get['pelunasan_koptel'])?$get['pelunasan_koptel']:"0");
  if ($get['product_code']=='58') {
    $angsuran_pertama=0;
  } else {
    $angsuran_pertama = (isset($get['angsuran_pertama'])?$get['angsuran_pertama']:"0");
  }
  $biaya_administrasi = (isset($get['biaya_administrasi'])?$get['biaya_administrasi']:"0");
  $biaya_notaris = (isset($get['biaya_notaris'])?$get['biaya_notaris']:"0");
  $premi_asuransi_tambahan = (isset($get['premi_asuransi_tambahan'])?$get['premi_asuransi_tambahan']:"0");
  $ujroh = (isset($get['ujroh'])?$get['ujroh']:"0");
  $jumlah_koptel_transfer = (isset($get['jumlah_koptel_transfer'])?$get['jumlah_koptel_transfer']:"0");
  $pelunasan_kopeg = (isset($get['pelunasan_kopeg'])?$get['pelunasan_kopeg']:"0");
  $premi_asuransi = (isset($get['premi_asuransi'])?$get['premi_asuransi']:"0");
  $jumlah_diterima_karyawan = $get['jumlah_pembiayaan']-$angsuran_pertama-$biaya_administrasi-$biaya_notaris-$premi_asuransi-$premi_asuransi_tambahan-$pelunasan_kopeg-$pelunasan_koptel;
  $product_name = $get['product_name'];
  // $jumlah_diterima_karyawan = $jumlah_koptel_transfer-$premi_asuransi-$premi_asuransi_tambahan-$pelunasan_kopeg-$biaya_notaris;
?>
<table id="hor-minimalist-head" width="100%" align="left">
  <tr>
    <td style="width:250px;">
      <!-- <img src="<?php echo base_url('assets/img/logo-koptel-asli.png');?>" height="50"> -->
    </td>
    <td style="text-align:center;">
      <b><h4>KOPERASI PT TELEKOMUNIKASI</h4>                           
      JL. CIWULAN NO. 23 BANDUNG - 40114<br/>                           
      TLP  022 - 7201420, 022 - 7200431</b>                          
    </td>
  </tr>
</table>
<hr>
<table id="hor-minimalist-head" width="100%" align="center">
  <tr>
    <td align="center" style="text-align:center;">
      <p><b><u><h4 style="margin:0">SURAT PERINTAH BAYAR (SPB)</h4></u></b></p>
    </td>
  </tr>
</table>
<table id="hor-minimalist-b" align="left">
  <tr>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>CATATAN BAGIAN ASAL</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> NOMOR </td>
          <td style="border:none;"> : <?php echo (isset($get['no_spb'])?$get['no_spb']:"");?></td>
        </tr>
        <tr>
          <td style="border:none;"> TANGGAL </td>
          <td style="border:none;"> : <?php echo (isset($get['tanggal_spb'])?$get['tanggal_spb']:"");?></td>
        </tr>
        <tr>
          <td style="border:none;"> AKUN </td>
          <td style="border:none;"> : <?php echo (isset($get['akun'])?$get['akun']:"");?></td>
        </tr>
        <tr>
          <td style="border:none;"> TAHUN </td>
          <td style="border:none;"> : <?php echo date("Y");?> </td>
        </tr>
      </table>      
    </td>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>CATATAN BAGIAN ANGGARAN</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> LOKASI </td>
          <td style="border:none;"> : - </td>
        </tr>
        <tr>
          <td style="border:none;"> BEBAN/TAHUN </td>
          <td style="border:none;"> : Eksploitasi /  Investasi / <?php echo date("Y");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> AKUN </td>
          <td style="border:none;"> : <?php echo (isset($get['akun'])?$get['akun']:"");?></td>
        </tr>
      </table>                           
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="2">
      <p style="text-align:center;">
        <b>PENGURUS/MANAGER</b><br/>
        <b>KOPERASI PT TELEKOMUNIKASI INDONESIA (KOPTEL)</b> 
      </p>  
      <p style="text-align:left;margin-left:10px;">
        Bendahara Koperasi PT Telekomunikasi Indonesia di Jl. Ciwulan No. 23 Bandung diminta untuk membayarkan uang sebesar  :
        <br/><br/>
        <div style="font-size:12px;font-weight:bold;">Rp. <?php echo (isset($get['jumlah_pembiayaan'])?number_format($get['jumlah_pembiayaan'],0,',','.'):"0");?> 
        (<?php echo ucwords((isset($get['jumlah_pembiayaan'])?$CI->terbilang($get['jumlah_pembiayaan']):"-"));?>) </div>
      </p>
      <p style="text-align:left;">
        <table>
          <tr>
            <td style="border:none;width:350px;"> 
              <table>
                <tr>
                  <td style="border:none;"> KEPADA </td>
                  <td style="border:none;"> :  Daftar Terlampir </td>
                </tr>
                <tr>
                  <td style="border:none;"> NAMA </td>
                  <td style="border:none;"> :  Daftar Terlampir </td>
                </tr>
                <tr>
                  <td style="border:none;"> ALAMAT </td>
                  <td style="border:none;"> :  Daftar Terlampir </td>
                </tr>
                <tr>
                  <td style="border:none;"> UNTUK </td>
                  <td style="border:none;"> : Penyaluran Pembiayaan <?php echo $product_name; ?> Thn <?php echo date('Y') ?> </td>
                </tr>
              </table>   
            </td>
            <td style="border:none;width:350px;"> 
              <table>
                <tr>
                  <td style="border:none;"> NAMA </td>
                  <td style="border:none;"> : Daftar Terlampir AJB BUMI PUTERA 1912 </td>
                </tr>
                <tr>
                  <td style="border:none;"> NO. REKENING </td>
                  <td style="border:none;"> : Daftar Terlampir NO. REKENING 130-00-0129707-9 </td>
                </tr>
                <tr>
                  <td style="border:none;"> PADA BANK </td>
                  <td style="border:none;"> : Daftar Terlampir BANK MANDIRI </td>
                </tr>
                <tr>
                  <td style="border:none;"> CABANG </td>
                  <td style="border:none;"> : Daftar Terlampir Cabang BANDUNG </td>
                </tr>
              </table>   
            </td>
          </tr>
        </table>    
      </p>
      <p style="text-align:center;">
        <table>
          <tr>
            <td style="width:200px;border:none;text-align:right;" colspan="3"> 
              BANDUNG, <?php echo date("d/m/Y");?>
            </td>
          </tr>
          <tr>
            <td style="width:200px;border:none;text-align:right;" colspan="3"> 
            </td>
          </tr>
          <tr>
            <td style="width:200px;border:none;text-align:center;" colspan="3"> 
              MENGETAHUI/MENYETUJUI                             
            </td>
          </tr>
          <tr>
            <td style="width:200px;border:none;text-align:right;" colspan="3"> 
            </td>
          </tr>
          <tr>
            <td style="width:200px;border:none;text-align:center;"> 
              RUSBID OPERASI BISNIS
              <br/><br/><br/><br/><br/>
              <p>
                <u><?php echo (isset($get['approve_3_by'])?strtoupper($get['approve_3_by']):"");?></u>
                <br/>NIK : 642019
              </p>
            </td>
            <td style="width:200px;border:none;text-align:center;"> 
              KETUA KOPTEL 
              <br/><br/><br/><br/><br/>
              <p>
                <u><?php echo (isset($get['approve_1_by'])?strtoupper($get['approve_1_by']):"");?></u>
                <br/>NIK : 641905
              </p>
            </td>
            <td style="width:200px;border:none;text-align:center;"> 
              BENDAHARA 
              <br/><br/><br/><br/><br/>
              <p>
                <u><?php echo (isset($get['approve_2_by'])?strtoupper($get['approve_2_by']):"");?></u>
                <br/>NIK : 642003
              </p>
            </td>
          </tr>
        </table>    
      </p>
    </td>
  </tr>
  <tr>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>1. CATATAN PEMBAYARAN</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;font-weight:bold;"> Jumlah Pembiayaan </td>
          <td style="border:none;font-weight:bold;"> : </td>
          <td style="border:none;text-align:right;font-weight:bold;"> <?php echo (isset($get['jumlah_pembiayaan'])?number_format($get['jumlah_pembiayaan'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> <b>POTONGAN</b> </td>
          <td style="border:none;"> </td>
          <td style="border:none;text-align:right;"> </td>
        </tr>
        <tr>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
        </tr>
        <tr>
          <td style="border:none;"> Angsuran Pertama </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo number_format($angsuran_pertama,0,',','.'); ?> </td>
        </tr>
        <tr>
          <td style="border:none;"> Biaya Administrasi </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['biaya_administrasi'])?number_format($get['biaya_administrasi'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> Biaya Notaris </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['biaya_notaris'])?number_format($get['biaya_notaris'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> Konpensasi Pembiayaan Koptel </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['pelunasan_koptel'])?number_format($get['pelunasan_koptel'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
        </tr>
        <tr>
          <td style="border:none;"> Premi Asuransi </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['premi_asuransi'])?number_format($get['premi_asuransi'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> Premi Asuransi Tambahan </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['premi_asuransi_tambahan'])?number_format($get['premi_asuransi_tambahan'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;"> Konpensasi Pelunasan Kopegtel </td>
          <td style="border:none;"> : </td>
          <td style="border:none;text-align:right;"> <?php echo (isset($get['pelunasan_kopeg'])?number_format($get['pelunasan_kopeg'],0,',','.'):"0");?> </td>
        </tr>
        <tr>
          <td style="border:none;font-weight:bold;"> Jumlah Diterima Pegawai </td>
          <td style="border:none;font-weight:bold;"> : </td>
          <td style="border:none;text-align:right;font-weight:bold;"> <?php echo (isset($jumlah_diterima_karyawan)?number_format($jumlah_diterima_karyawan,0,',','.'):"0");?> </td>
        </tr>
      </table>      
    </td>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>2. PERHITUNGAN UANG MUKA</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> Besar Uang Muka </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Sudah Dikembalikan </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Sisa Yang Dikembalikan </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Dikembalikan Dengan SPB Ini </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Saldo </td>
          <td style="border:none;"> : </td>
        </tr>
      </table>                               
    </td>
  </tr>
  <tr>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>3. Catatan Penerimaan</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> Telah Terima Uang Sebesar </td>
          <td style="border:none;">  </td>
        </tr>
        <tr>
          <td style="border:none;">  </td>
          <td style="border:none;">  </td>
        </tr>
      </table>                   
    </td>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>4. Catatan Transfer</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> Transfer Tanggal </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Nomor GB </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Tanggal GB </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Rek. Bank No. </td>
          <td style="border:none;"> : </td>
        </tr>
      </table>                   
    </td>
  </tr>
  <tr>
    <td style="width:360px;text-align:center;" valign="top">
      <p>BANDUNG, <?php echo date("d/m/Y");?></p>
      <br/><br/><br/>
      <p>
      <u>(.............................................)</u><br/>
        NIK : 
      </p>
    </td>
    <td style="width:360px;text-align:center;" valign="top">
      <p>BANDUNG, <?php echo date("d/m/Y");?></p>
      <br/><br/><br/>
      <p>
      <u>(.............................................)</u><br/>
        NIK : 
      </p>
    </td>
  </tr>
  <tr>
    <td style="width:360px;" valign="top">
      <table>
        <tr>
          <td colspan="2" style="border:none;">
            <b><u>5. Catatan Pembukuan</u></b>
          </td>
        </tr>
        <tr>
          <td style="border:none;"> Dicatat Dalam SIMAK </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Nomor Bukti Pembukuan </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Tanggal </td>
          <td style="border:none;"> : </td>
        </tr>
        <tr>
          <td style="border:none;"> Tanggal Entry </td>
          <td style="border:none;"> : </td>
        </tr>
      </table>                   
                           
    </td>
    <td style="width:360px;" valign="top">
                           
    </td>
  </tr>
</table>
