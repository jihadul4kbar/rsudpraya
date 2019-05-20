<?php
 include '../conf/conf.php';
?>
<html>
    <head>
        <!-- <link href="style.css" rel="stylesheet" type="text/css" media="screen" /> -->
    <style>
    table.style1{border:1px solid #000; border-collapse:collapse;}
    body,td,th {
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
    }
    </style>
        
    </head>
    <body>

    <?php
    //reportsqlinjection();      
        $norm       =$_GET['norm'];
        $pasien     =$_GET['pasien'];
        $tanggal    =$_GET['tanggal'];
        $jam        =$_GET['jam'];
        $pjlab      =$_GET['pjlab'];
        $petugas    =$_GET['petugas'];
        $kasir      =$_GET['kasir'];
        $nopriksa   =$_GET['nopriksa'];

        $_sql = "select * from temporary_lab where temp4='Pemeriksaan' order by no asc";   
        $hasil=bukaquery($_sql);

      /*$data = mysqli_fetch_array(bukaquery("SELECT a.status_lanjut, a.umurdaftar, a.sttsumur , b.png_jawab,  c.noorder, d.nm_poli, e.alamat, e.no_peserta, e.jk FROM reg_periksa a, penjab b, permintaan_lab c, poliklinik d, pasien e WHERE a.no_rawat = '$nopriksa' and a.no_rkm_medis = e.no_rkm_medis  and a.kd_pj = b.kd_pj and a.no_rawat = c.no_rawat and a.kd_poli = d.kd_poli"));
      echo "<pre>";
      print_r($data);*/
      $t = "SELECT a.status_lanjut, a.umurdaftar, a.sttsumur , b.png_jawab,  c.noorder, d.nm_poli, e.alamat, e.no_peserta, e.jk FROM reg_periksa a, penjab b, permintaan_lab c, poliklinik d, pasien e WHERE a.no_rawat = '$nopriksa' and a.no_rkm_medis = e.no_rkm_medis  and a.kd_pj = b.kd_pj and a.no_rawat = c.no_rawat and a.kd_poli = d.kd_poli";
      $h = bukaquery($t);
      $r = mysqli_fetch_array($h);

        
        if(mysqli_num_rows($hasil)!=0) { 
            $setting=  mysqli_fetch_array(bukaquery("select nama_instansi,alamat_instansi,kabupaten,propinsi,kontak,email,logo from setting"));
            echo "   
                  <fieldset style='padding:0 3px; margin:0; border:1px solid #000;'>
                    <table width='".getOne("select notalabrad from set_nota")."' cellpadding='0' cellspacing='1' border='0' class='style5'>
                      <tr><td style='border-bottom:1px solid black; padding-bottom:3px;'>
                          <div style='font-size:12px; font-weight:bold;'>".$setting["nama_instansi"]."</div>
                        <div>".$setting["alamat_instansi"].", ".$setting["kabupaten"].", ".$setting["propinsi"].",".$setting["kontak"]."</div></td>
                        <td width='11%' style='border-bottom:1px solid black; font-weight:bold; font-size:14px;' align='center'>LAB</td>
                      </tr>
                      <tr>
                      <td colspan='2'>
                        <table width='100%'>
                        
                        <tr>
                            <td width='20%' valign='top'>No. Rekam Medis</td>
                            <td width='1%' valign='top'>:</td>
                            <td width='27%' valign='top'>$norm</td>
                            <td valign='top' width='23%'>No. Priksa</td>
                            <td valign='top' width='1%'>:</td>
                            <td width='28%' valign='top'>$r[4]</td>
                        </tr>
                          <tr>
                            <td valign='top'>Nama</td>
                            <td valign='top'>:</td>
                            <td valign='top'>".str_replace("_"," ", $pasien)."</td>
                            <td width='23%' valign='top'>Kelamin</td>
                            <td width='1%' valign='top'>:</td>
                            <td valign='top'>";
                            if($r[8] == "L"){
                              echo "LAKI-LAKI";
                            }else {
                              echo "PEREMPUAN";
                            }
                            echo"
                            </td>
                          </tr>
                          <tr>
                            <td valign='top'>Umur</td>
                            <td valign='top'>:</td>
                            <td valign='top'>$r[1] $r[2]</td>
                            <td valign='top'>Asal Pasien</td>
                            <td valign='top'>:</td>
                            <td valign='top'>$r[0] - $r[5]</td>
                          </tr>
                          <tr>
                            <td valign='top'>Alamat</td>
                            <td valign='top'>:</td>
                            <td valign='top'>$r[6]</td>
                            <td valign='top'>Cara bayar</td>
                            <td valign='top'>:</td>
                            <td valign='top'><strong>$r[3]</strong></td>
                          </tr>
                          <tr>
                            <td valign='top'>Dokter Penanggung Jawab</td>
                            <td valign='top'>:</td>
                            <td valign='top'>".str_replace("_"," ", $pjlab)."</td>
                            <td valign='top'>No.Anggota/No.Peserta</td>
                            <td valign='top'>:</td>
                            <td valign='top'>"; 
                              if($r[3] === "UMUM"){
                                echo "-";
                              }else{
                                echo $r[7];
                              }
                            echo"
                            </td>
                          </tr>

                          </table>	 </td>
                      </tr>
                      <tr>
                      <td colspan='2'>
                        <table class='style1' width='100%'>
                        <thead>
                        <tr align='center' class='style3' style='border-bottom:1px solid black;'>
                          <td width='1%' class='style3' style='border-right:1px solid black;'>No.</td>
                          <td width='36%' class='style3' style='border-right:1px solid black;'>Nama Pemeriksaan</td>
                          <td width='13%' class='style3' style='border-right:1px solid black;'>Biaya</td>
                          </tr>
                        </thead>
                        <tbody>";
                        $z=1;
                        while($item = mysqli_fetch_array($hasil)) {
                             echo "<tr style='border-right:1px solid black;'>
                                       <td align='center' style='border-right:1px solid black;'>&nbsp;$z</td>
                                       <td style='border-right:1px solid black;'>&nbsp;$item[2]</td>
                                       <td align='right'>&nbsp;".formatDuit($item[3])."</td>
                                   </tr>";  
                             $_sql2 = "select * from temporary_lab where temp4='Detail Pemeriksaan' and temp1='$item[1]' order by no asc";   
							 $hasil2=bukaquery($_sql2);
							 while($item2=mysqli_fetch_array($hasil2)){
								 $z++;
								 echo "<tr class='isi'>
                                       <td align='center' style='border-right:1px solid black;'>&nbsp;$z</td>
                                       <td style='border-right:1px solid black;'>&nbsp;$item2[2]</td>
                                       <td align='right'>&nbsp;".formatDuit($item2[3])."</td>
                                   </tr>";  
							 }							 
                             $z++;                                   
                        } 
                        echo "
                        <tr style='font-weight:bold;'>
                          <td colspan='2' align='center' style='border-top:1px solid black;'>JUMLAH</td>
                          <td align='right' style='border-top:1px solid black;'>".formatDuit(getOne("select temp3 from temporary_lab where temp2='Total Biaya Pemeriksaan Lab'"))."</td>
                        </tr>"; 
                             echo "
                        
                        </tbody>
                        </table>	
                      </tr>
                      <tr>
                      <td colspan='2'><table width='100%'>
                          <tr>
                            <td width='15%' align='right'>&nbsp;</td>
                            <td width='29%' align='right'>&nbsp;</td>
                            <td width='33%' align='right'>&nbsp;</td>
                            <td width='23%' align='center'>Praya, $tanggal</td>
                          </tr>
                          <tr>
                            <td width='15%' align='right'>&nbsp;</td>
                            <td width='29%' align='right'>&nbsp;</td>
                            <td width='33%' align='center'>Telah diverifikasi oleh : </td>
                            <td width='23%' align='center'>Petugas</td>
                          </tr>
                          <tr>
                            <td>Keterangan : </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>- Lembar Putih (asli ) </td>
                            <td>Untuk : Bendahara Penerima </td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>- Lembar Merah </td>
                            <td>Untuk : Pasien Bersangkutan </td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width='15%'>- Lembar Kuning </td>
                            <td width='29%'>Untuk : Arsip Ruang Perawatan </td>
                            <td width='33%' align='center'>(------------------------ ) </td>
                            <td width='23%' align='center'>( $kasir )</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                    </fieldset>
            <tr class='isi12' padding='0'>
               <td>
                  <table width='100%' bgcolor='#ffffff' align='left' border='0' cellpadding='0' cellspacing='0' >
                     "; 
                    } else {echo "<font color='000000' size='1'  face='Times New Roman'><b>Data Pemeriksaan Lab masih kosong !</b>";}
                       
    ?>  



    </body>
</html>
