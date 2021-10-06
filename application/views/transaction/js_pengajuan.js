$(function(){
    var form_pengajuan = $('#form-pengajuan');
    var alert_error=$(".alert-danger");
    var alert_error_message=$("#alert_error_message");
    var alert_success=$("#alert_success");

    function convert_numeric(value)
    {
        result = value.toString().replace(/\./g,'')//.replace(/\,/g,'.');
        return result;
    }

    function pembulatan_total_angsuran(nominal)
    {
      nominal = convert_numeric(Math.round(nominal));
      nr = nominal.substr(nominal.length-3);
      nl = nominal.substr(0,nominal.length-3);

      if(nr>0){
        n=parseFloat(nl+'000');
        n+=parseFloat(1000);
      // }else if(nr>0){
      //   n=parseFloat(nl+'500');
      }else{
        n=parseFloat(nominal);
      }
      // console.log('nl:'+nl);
      // console.log('nr:'+nr);
      // console.log('n:'+n);
      // console.log('nominal:'+nominal);
      // ntmblangpkk=parseFloat(n)-parseFloat(nominal);
      // return ntmblangpkk;
      return n;
    }

    /*event untuk pengajuan melalui koptel atau mitra koperasi*/
    $("input[name='melalui']").click(function(){
        if($("#melalui2").is(':checked')==true){
            $("#mitra").show();
        }else{
            $("#mitra").hide();
        }
    })

    /*event jika pegawai memiliki beberapa kopegtel*/
    var jml_pegawai_kopeg = $("#jml_pegawai_kopeg",form_pengajuan).val();
    if(jml_pegawai_kopeg>0){
        $("#data_pembiayaan",form_pengajuan).show();
        $("#flag_melalui1",form_pengajuan).hide();
        $("#div_pengajuan_melalui",form_pengajuan).hide();
        $("#mitra",form_pengajuan).show();
        // $("#melalui2",form_pengajuan).attr("checked", true);
        $("#flag_melalui_val",form_pengajuan).val('1');
    }else{
        $("#data_pembiayaan",form_pengajuan).show();
        $("#flag_melalui1",form_pengajuan).show();
        // $("#flag_melalui2",form_pengajuan).hide();
        $("#mitra",form_pengajuan).hide();
        // $("#melalui1",form_pengajuan).attr("checked", true);
        $("#flag_melalui_val",form_pengajuan).val('0');
    }

    /*event ketika kewajiban ke kopegtel > 0*/
    $("#jumlah_angsuran",form_pengajuan).keyup(function(){
        var jumlah_angsuran = Template.ConvertNumeric($(this).val());
        if(jumlah_angsuran>0){
            $("#lunasi",form_pengajuan).show();
        }else{
            $("#lunasi",form_pengajuan).hide();
            $("#div_saldo_kewajiban",form_pengajuan).hide();
            $("#saldo_kewajiban",form_pengajuan).val('0');
            $("#flag_lunas",form_pengajuan).attr("checked",false);
        }
    })
    $("#jumlah_angsuran",form_pengajuan).change(function(){
        var jumlah_angsuran = Template.ConvertNumeric($(this).val());
        if(jumlah_angsuran>0){
            $("#lunasi",form_pengajuan).show();
        }else{
            $("#lunasi",form_pengajuan).hide();
            $("#div_saldo_kewajiban",form_pengajuan).hide();
            $("#saldo_kewajiban",form_pengajuan).val('0');
            $("#flag_lunas",form_pengajuan).attr("checked",false);
        }
    })

    /*event ketika kewajiban ke koptel > 0*/
    $("#jumlah_kewajiban",form_pengajuan).keyup(function(){
        var jumlah_kewajiban = Template.ConvertNumeric($(this).val());
        if(jumlah_kewajiban>0){
            $("#lunasi_koptel",form_pengajuan).show();
        }else{
            $("#lunasi_koptel",form_pengajuan).hide();
            $("#div_saldo_kewajiban_koptel",form_pengajuan).hide();
            $("#saldo_kewajiban_koptel",form_pengajuan).val('0');
            $("#flag_lunas_koptel",form_pengajuan).attr("checked",false);
        }
    })
    $("#jumlah_kewajiban",form_pengajuan).change(function(){
        var jumlah_kewajiban = Template.ConvertNumeric($(this).val());
        if(jumlah_kewajiban>0){
            $("#lunasi_koptel",form_pengajuan).show();
        }else{
            $("#lunasi_koptel",form_pengajuan).hide();
            $("#div_saldo_kewajiban_koptel",form_pengajuan).hide();
            $("#saldo_kewajiban_koptel",form_pengajuan).val('0');
            $("#flag_lunas_koptel",form_pengajuan).attr("checked",false);
        }
    })

    /*event margin dan angsuran*/
    $("#produk",form_pengajuan).change(function(){
        var produk_code = $(this).val();
        var jenis_margin  = $('option:selected', this).attr('jenis_margin');
        hitung_margin_form_add();
        if(produk_code!=''){
            cek_max_jangka_waktu(produk_code);
            status_dokumen_lengkap_func_add($(this).val());
            $("#notif_jk_waktu",form_pengajuan).show();
        }else{
            $("#notif_jk_waktu",form_pengajuan).hide();
        }
        if(jenis_margin=='2'){
            $("#div_angsuran_pokok",form_pengajuan).hide();
            $("#div_angsuran_margin",form_pengajuan).hide();
            $("#div_total_angsuran",form_pengajuan).hide();
        }else if(jenis_margin=='3'){
            $("#div_angsuran_pokok",form_pengajuan).hide();
            $("#div_angsuran_margin",form_pengajuan).hide();
            $("#div_total_angsuran",form_pengajuan).show();
        }else{
            $("#div_angsuran_pokok",form_pengajuan).show();
            $("#div_angsuran_margin",form_pengajuan).show();
            $("#div_total_angsuran",form_pengajuan).show();
        }
        $("#jenis_margin",form_pengajuan).val(jenis_margin);
    }) 
    $("#peruntukan",form_pengajuan).change(function(){
        get_akad_by_peruntukan();
    })
    $("#jumlah_pembiayaan",form_pengajuan).change(function(){
        hitung_margin_form_add();
    })
    $("#jangka_waktu",form_pengajuan).change(function(){
        hitung_margin_form_add();
    })
    $("#jumlah_pembiayaan",form_pengajuan).keyup(function(){
        hitung_margin_form_add();
    })
    $("#jangka_waktu",form_pengajuan).keyup(function(){
        hitung_margin_form_add();
    })

    function cek_max_jangka_waktu(produk_code){
        /*
        | Untuk mengecek jangka waktu maksimal yang ada di tabel product_financing
        */
        var pensiun = $("#masa_pensiun",form_pengajuan).val();
        var thn_pensiun = pensiun.substring(0,4);
        var bln_pensiun = pensiun.substring(7,5);
        var tgl_pensiun = pensiun.substring(10,8);
        var monthInterval = monthDiff(new Date(),new Date(thn_pensiun, bln_pensiun, tgl_pensiun));
        if(monthInterval>60){
          $.ajax({
            url: site_url+"layanan/cek_max_jangka_waktu",
            type: "POST",
            async:false,
            dataType: "json",
            data: {produk_code:produk_code},
            success: function(response)
            {
              var max_jangka_waktu = response.max_jangka_waktu;
              $("#notif_jk_waktu",form_pengajuan).html("Jangka waktu maksimal "+(max_jangka_waktu)+" bulan");
            },
            error: function(){
              alert("Error. Please Contact Your Administrator");
            }
          })
        }else{
            $("#notif_jk_waktu",form_pengajuan).html("Jangka waktu maksimal "+(monthInterval-1)+" bulan");
        }
        /*
        | end
        */
    }

    function get_akad_by_peruntukan(){
        /*
        | Untuk mencari akad berdasarkan product
        */
        var code_value = $("#peruntukan",form_pengajuan).find('option:selected').attr('code_value');
        $.ajax({
            url: site_url+"layanan/get_akad_by_peruntukan",
            type: "POST",
            async:false,
            dataType: "json",
            data: {code_value:code_value},
            success: function(response)
            {
                $("#akad",form_pengajuan).val(response.akad_name);
            },
            error: function(){
              alert("Error. Please Contact Your Administrator");
            }
          })
        /*
        |end
        */
    }

    function monthDiff(d1, d2) {
        /*event untuk menentukan jangka waktu angsuran*/
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth() + 1;
        months += d2.getMonth();
        return months <= 0 ? 0 : months;
    }

    function hitung_margin_form_add()
    { 
        var jenis_margin = $("#produk",form_pengajuan).find('option:selected').attr('jenis_margin');
        var pokok = Template.ConvertNumeric($("#jumlah_pembiayaan",form_pengajuan).val());
        var jangkawaktu = $("#jangka_waktu",form_pengajuan).val();
        if(jenis_margin=='2'){
            //effektif
            get_total_pokok_efektif_form1();
        }else if(jenis_margin=='3') {
          var tmvalid = true;
          if (pokok=='' || pokok=='0') {
            tmvalid = false;
          }
          if (jangkawaktu=='' || jangkawaktu=='0') {
            tmvalid = false;
          }
          if (tmvalid==true) {
            get_total_margin_dan_angsuran_anuitas_form1();
          }
        }else{ 
            //flat   
            var rate = $("#produk",form_pengajuan).find('option:selected').attr('maxrate');
            var amount = Template.ConvertNumeric($("#jumlah_pembiayaan",form_pengajuan).val());
            var jangka_waktu = $("#jangka_waktu",form_pengajuan).val();
            var v_total_angsuran = 0;
            var v_angsuran_pokok = 0;

            if(rate==''){
              rate = eval(0);
            }else{
              rate = eval(rate);
            }
            if(amount==''){
              amount = eval(0);
            }else{
              amount = eval(amount);
            }
            if(jangka_waktu==''){
              jangka_waktu = eval(0);
            }else{
              jangka_waktu = eval(jangka_waktu);
            }

            // total_margin = (rate*amount*jangka_waktu/1200);
            total_margin = ((rate/1200)*amount*jangka_waktu);

            angsuran_pokok = (amount/jangka_waktu);

            angsuran_margin = (eval(total_margin)/jangka_waktu);

            total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))
            var v_total_angsuran = pembulatan_total_angsuran(total_angsuran);
            var v_angsuran_pokok = v_total_angsuran-angsuran_margin;
            $("#jumlah_margin",form_pengajuan).val(Template.NumberFormat(total_margin,0,',','.'));
            $("#angsuran_pokok",form_pengajuan).val(Template.NumberFormat(v_angsuran_pokok,0,',','.'));
            $("#angsuran_margin",form_pengajuan).val(Template.NumberFormat(angsuran_margin,0,',','.'));
            $("#total_angsuran",form_pengajuan).val(Template.NumberFormat(v_total_angsuran,0,',','.'));
        }
    }

    /*Lunasi ke kopegtel*/
    $("#flag_lunas",form_pengajuan).change(function() {
      if(this.checked) {
        $("#saldo_kewajiban",form_pengajuan).val(0).prop(0);
        $("#div_saldo_kewajiban",form_pengajuan).show();
      }else{
        $("#div_saldo_kewajiban",form_pengajuan).hide();
      }
    });

    /*Lunasi ke koptel*/
    $("#flag_lunas_koptel",form_pengajuan).change(function() {
      if(this.checked) {
        $("#saldo_kewajiban_koptel",form_pengajuan).val(0).prop(0);
        $("#div_saldo_kewajiban_koptel",form_pengajuan).show();
      }else{
        $("#div_saldo_kewajiban_koptel",form_pengajuan).hide();
      }
    });

    /*Cek THP*/
    //var val_thp = $("#thp",form_pengajuan).val();
    //if(val_thp>"0"){
      //  $("#thp",form_pengajuan).attr('readonly', true);
       // $("#thp",form_pengajuan).prop('readonly', true);
    //}else{
     //   $("#thp",form_pengajuan).attr('readonly', false);
       // $("#thp",form_pengajuan).prop('readonly', false);
    //}

   $("#thp",form_pengajuan).keyup(function(){
       hitung_thp();
    })

    function hitung_thp()
    {
        var thp = Template.ConvertNumeric($("#thp",form_pengajuan).val());
        var total_thp = parseFloat(thp);

        if(total_thp==''){
          total_thp = eval(0);
        }else{
          total_thp = eval(total_thp);
        }

        thp_40 = (total_thp*40/100);

        $("#persen_thp",form_pengajuan).val(Template.NumberFormat(thp_40,0,',','.'));
    }

    /*event untuk menjalankan proses pengajuan pembiayaan*/
    form_pengajuan.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-inline', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(a,b){},
        rules: {
            alamat_rumah:{required:true},
            no_ktp:{required:true},
            no_telp_kantor:{required:true},
            no_handphone:{required:true},
            status_rumah:{required:true},
            bank:{required:true},
            cabang:{required:true},
            nomor_rekening:{required:true},
            // nama_suami_istri:{required:true},
            // pekerjaan_suami_istri:{required:true},
            // jumlah_tanggungan:{required:true},
            produk:{required:true},
            peruntukan:{required:true},
            // keterangan_peruntukan:{required:true},
            jumlah_pembiayaan:{required:true},
            jangka_waktu:{required:true},
            melalui:{required:true},
            jumlah_angsuran:{required:true}
            // flag_lunas:{required:true}
            // ktp:{required:true},
            // slip_gaji:{required:true},
            // buku_tabungan:{required:true}
        },
        invalidHandler: function (event, validator) { //display error alert on form submit              
            alert_error.show();
            alert_success.hide();
            alert_error_message.hide();
            Template.scrollTo(alert_error, -200);
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-control').removeClass('success').addClass('error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change dony by hightlight
            $(element).closest('.form-control').removeClass('error'); // set error class to the control group
        },
        submitHandler: function (form) {
            console.log(form);

            /*customize validasi*/
            var bValid = true;
            var nik = $("#nik",form_pengajuan).val().replace(/\//g,'');
            if($("#jumlah_kewajiban",form_pengajuan).val()==''){$("#jumlah_kewajiban",form_pengajuan).val(0).prop(0)}
            if($("#jumlah_angsuran",form_pengajuan).val()==''){$("#jumlah_angsuran",form_pengajuan).val(0).prop(0)}
            var masa_pensiun = $("#masa_pensiun",form_pengajuan).val();
            var thp = Template.ConvertNumeric($("#thp",form_pengajuan).val());
            var thp_40 = Template.ConvertNumeric($("#persen_thp_plus",form_pengajuan).val());
            // var thp_40 = Template.ConvertNumeric($("#persen_thp",form_pengajuan).val());
            var jumlah_kewajiban = Template.ConvertNumeric($("#jumlah_kewajiban",form_pengajuan).val());
            var jumlah_angsuran = Template.ConvertNumeric($("#jumlah_angsuran",form_pengajuan).val());
            var total_angsuran = Template.ConvertNumeric($("#total_angsuran",form_pengajuan).val());
            var jangka_waktu = $("#jangka_waktu",form_pengajuan).val();
            var jangka_waktu_produk  = $("#produk option:selected",form_pengajuan).attr('max_jangka_waktu');
            v_thp = eval(thp);
            v_thp_40 = eval(thp_40);
            v_jumlah_kewajiban = eval(jumlah_kewajiban);
            v_jumlah_angsuran = eval(jumlah_angsuran);
            v_jangka_waktu = eval(jangka_waktu);
            v_jangka_waktu_produk = eval(jangka_waktu_produk);
            total_angsuran = eval(total_angsuran);


            if($("#flag_thp100",form_pengajuan).val()=="1"){
              var_thp=v_thp;
            }else{
              var_thp=v_thp_40;
            }

            if($("#flag_lunas",form_pengajuan).is(':checked')==true){
              n_thp=eval(var_thp);
            }else{
              n_thp=eval(var_thp-v_jumlah_angsuran);
            }
            
            jum = parseFloat(n_thp)-parseFloat(total_angsuran);

            if(total_angsuran<persen_thp){
              bValid = false;
              message="Batas maksimal angsuran "+Template.NumberFormat(thp_40,0,',','.')+". Sesuaikan jumlah pengajuan atau hubungi admin koptel";
            }
            if($("#status_financing_reg",form_pengajuan).val()!='0'){
              message = 'Tidak dapat dilanjutkan \r\nPegawai masih memiliki pengajuan pembiayaan yang belum diproses';
              bValid = false;
            }
            if($("#melalui2",form_pengajuan).is(':checked')==true && $("#mitra_koperasi",form_pengajuan).val()==''){
              message = "Harap pilih mitra koperasi ";
              bValid = false;
            }
            if($("#jumlah_pembiayaan",form_pengajuan).val()=='0'){
              message = "Jumlah pembiayaan tidak boleh nol ";
              bValid = false;
            }
            // if(v_jangka_waktu>v_jangka_waktu_produk){
            //   bValid = false;
            //   message="Jangka waktu angsuran tidak boleh lebih dari "+v_jangka_waktu_produk+" bulan";
            // }

            explode2 = masa_pensiun.split('-');
            var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];

            // $.ajax({
            //   url: site_url+"layanan/cek_masa_pensiun",
            //   type: "POST",
            //   async:false,
            //   dataType: "html",
            //   data: {jangka_waktu:jangka_waktu,masa_pensiun:masa_pensiun},
            //   success: function(response)
            //   {
            //       explode = response.split("|");
            //       if(explode[0]=="false"){
            //         bValid = false;
            //         message = "Jangka waktu melebihi masa pensiun ( "+show_pensiun+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
            //       }
            //       if(eval(explode[1])<v_jangka_waktu){
            //         bValid = false;
            //         message = "Jangka waktu melebihi masa pensiun ( "+show_pensiun+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
            //       }
            //       if(eval(explode[1])<0){
            //         bValid = false;
            //         message = "Pegawai akan pensiun dalam 1 bulan kedepan ( "+show_pensiun+" )";
            //       }
            //   },
            //   error: function(){
            //     bValid = false;
            //     message = "Error. Please Contact Your Administrator";
            //   }
            // })

            if($("#agree",form_pengajuan).is(':checked')==false){
              bValid = false;
              message="anda belum menyetujui ketentuan yang berlaku !";
            }

            if(bValid==true){
                var conf = confirm("Yakin data sudah benar ?");
                if(conf){
                    $.ajax({
                        type:"POST",
                        dataType:"json",
                        data:$(form).serialize(),
                        url:site_url+"layanan/save_pengajuan",
                        success: function(response){
                            if(response.success===true){
                                /*set value thp dan jumlah kewajiban*/
                                $("#thp",form_pengajuan).val(0);
                                $("#persen_thp",form_pengajuan).val(0);
                                $("#jumlah_kewajiban",form_pengajuan).val(0);
                                // $("#span_message_success",form_pengajuan).html(response.status_message);
                                // $("#span_message_success","#form-upload-dokumen").html(response.status_message);
                                // alert_success.show();
                                // alert_error.hide();
                                // alert_error_message.hide();
                                // $("#alert_success_dok").show();
                                // $("#form-upload-dokumen").show();
                                // $("#form-pengajuan").hide();
                                $("#form-pengajuan").trigger('reset');
                                // Template.scrollTo(alert_success, -200);
                                if (response.uw_policy=='NM') {
                                    if(response.product_code=='54'){
                                        // alert(response.product_code)
                                        //Multiguna
                                        document.location.href='pengajuan?successmulti=nm&an='+response.an;
                                    }else if(response.product_code=='56'){
                                        // alert(response.product_code)
                                        //KPR
                                        document.location.href='pengajuan?successkpr=nm&an='+response.an;
                                    }else{
                                        // alert(response.product_code)
                                        //Smile
                                        document.location.href='pengajuan?success=nm&an='+response.an;
                                    }
                                } else {
                                    if(response.product_code=='54'){
                                        // alert(response.product_code)
                                        //Multiguna
                                        document.location.href='pengajuan?successmulti=m&an='+response.an;
                                    }else if(response.product_code=='56'){
                                        // alert(response.product_code)
                                        //KPR
                                        document.location.href='pengajuan?successkpr=m&an='+response.an;
                                    }else{
                                        // alert(response.product_code)
                                        //Smile
                                        document.location.href='pengajuan?success=m&an='+response.an;
                                    }
                                }
                            }else{
                                alert(response.status_message);
                            }
                        },
                        error: function(){
                            alert("Failed to Connect into Database, Please Contact Your Administrator!")
                        }
                    })
                }  
            }else{
                $("#span_message").html(message);
                alert_success.hide();
                alert_error.hide();
                alert_error_message.show();
                Template.scrollTo(alert_error_message, -200);
            }
        }
    });

    $("#btn_cancel",form_pengajuan).click(function(e){
        e.preventDefault();
        form_pengajuan.trigger('reset');
    });

    //  $("#upload_dok").click(function(e){
    //     bValid = true;
    //     var dok_ktp = $("#dok_ktp").val()
    //     var dok_slip_gaji = $("#dok_slip_gaji").val()
    //     var dok_buku_tabungan = $("#dok_buku_tabungan").val()
    //     var dok_buku_tabungan_haji = $("#dok_buku_tabungan_haji").val()

    //     // if (dok_ktp=='') {
    //     //     alert('Fotokopi KTP diperlukan');
    //     //     bValid = false;                
    //     //     e.preventDefault();
    //     // }else if (dok_slip_gaji=='') {
    //     //     alert('Fotokopi slip gaji diperlukan');
    //     //     bValid = false;                
    //     //     e.preventDefault();
    //     // }else if (dok_buku_tabungan=='') {
    //     //     alert('Fotokopi halaman muka buku tabungan diperlukan');
    //     //     bValid = false;                
    //     //     e.preventDefault();
    //     // }else if (bValid==true) {
    //         $("#form-upload-dokumen").trigger('submit');
    //     // } else{
    //         // alert("Mohon isi dokumen dengan benar")
    //     // };
    // });

    $('#upload_dok').click(function(){

        var iframe = $('<iframe name="postiframe" id="postiframe" style="display: none"></iframe>');

        $("body").append(iframe);

        var form = $('#form-upload-dokumen');
        form.attr("method", "post");
        form.attr("encoding", "multipart/form-data");
        form.attr("enctype", "multipart/form-data");
        form.attr("target", "postiframe");
        form.submit();

        $("#postiframe").load(function () {
            iframeContents = this.contentWindow.document.body.innerHTML;
            console.log(iframeContents);
            if (iframeContents=='true') {
                $('#alert_success_dok').show();
                $('#alert_error_dok').hide();
            } else {
                $('#alert_success_dok').hide();
                $('#alert_error_dok').show();
                $('#span_message_error').html(iframeContents);
            }
        });

        return false;

    })

    function status_dokumen_lengkap_func_add(product_code) {
      $.ajax({
        type:"POST",dataType:"json",data:{product_code:product_code},
        url:site_url+'layanan/get_status_dokumen_lengkap',
        success: function(response) {
          status_dokumen_lengkap = response.status_dokumen_lengkap;
          if (status_dokumen_lengkap==0) {
            $('#div_angsuran_pokok',form_pengajuan).hide();
            $('#div_angsuran_margin',form_pengajuan).hide();
          } else {
            $('#div_angsuran_pokok',form_pengajuan).show();
            $('#div_angsuran_margin',form_pengajuan).show();
          }
        },error:function(){
          alert('Internal Server Error! Please Contact Your Administrator.');
        }
      })
    }

    function get_total_pokok_efektif_form1(){
      var margin = $('#produk option:selected',form_pengajuan).attr('maxrate');
      var jangka_waktu = $('#jangka_waktu',form_pengajuan).val();
      var amount  = $('#jumlah_pembiayaan',form_pengajuan).val();

        $.ajax({
          url: site_url+"layanan/get_margin_efektif",
          type: "POST",
          async:false,
          dataType: "html",
          data: {
              pokok:amount
              ,jangkawaktu:jangka_waktu
              ,margin_tahun:margin
            },
          success: function(response)
          {
            $("#jumlah_margin",form_pengajuan).val(Template.NumberFormat(response,0,',','.'));
            $("#angsuran_pokok",form_pengajuan).val('0');
            $("#angsuran_margin",form_pengajuan).val('0');
            $("#total_angsuran",form_pengajuan).val('0');
            $("#angsuran_pokok",form_pengajuan).prop('0');
            $("#angsuran_margin",form_pengajuan).prop('0');
            $("#total_angsuran",form_pengajuan).prop('0');
            $("#div_angsuran_pokok",form_pengajuan).hide();
            $("#div_angsuran_margin",form_pengajuan).hide();
            $("#div_total_angsuran",form_pengajuan).hide();
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
    }

    /* BEGIN ANUITAS */
    function get_total_margin_dan_angsuran_anuitas_form1(){
      var margin  = $('#produk option:selected', form_pengajuan).attr('maxrate');
      var jangka_waktu  = $('#jangka_waktu', form_pengajuan).val();
      var amount  = $('#jumlah_pembiayaan', form_pengajuan).val();

        $.ajax({
          url: site_url+"layanan/get_total_angsuran_anuitas",
          type: "POST",
          async:false,
          dataType: "json",
          data: {
              pokok:amount
              ,jangkawaktu:jangka_waktu
              ,margin_tahun:margin
            },
          success: function(response)
          {
            var total_angsuran = response.total_angsuran;
            $("#jumlah_margin",form_pengajuan).val(number_format(response.total_margin,0,',','.'));
            $("#total_angsuran",form_pengajuan).val(number_format(total_angsuran,0,',','.'));
            $("#angsuran_pokok",form_pengajuan).val('0');
            $("#angsuran_pokok",form_pengajuan).prop('0');
            $("#angsuran_margin",form_pengajuan).val('0');
            $("#angsuran_margin",form_pengajuan).prop('0');
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
      
    }

});