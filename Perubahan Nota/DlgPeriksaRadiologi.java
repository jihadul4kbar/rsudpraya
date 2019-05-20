<?php
 include '../conf/conf.php';
?>
<html>
    <head>
        <!-- <link href="style.css" rel="stylesheet" type="text/css" media="screen" /> -->
    <style type="text/css">
    table.style1{border:1px solid #000; border-collapse:collapse;}
    body,td,th {
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
    }
    </style>
    </head>
    <body>

    <?php
    reportsqlinjection();      
        $norm       =$_GET['norm'];
        $pasien     =$_GET['pasien'];
        $tanggal    =$_GET['tanggal'];
        $jam        =$_GET['jam'];
        $pjlab      =$_GET['pjlab'];
        $petugas    =$_GET['petugas'];
        $kasir      =$_GET['kasir'];
        $nopriksa   =$_GET['nopriksa'];

        $_sql = "select temp1, temp2, temp3, temp4, temp5, temp6, temp7, temp8, temp9, temp10, temp11, temp12, temp13, temp14 from temporary_radiologi order by no asc";   
        $hasil=bukaquery($_sql);
      $t = "SELECT a.status_lanjut, a.umurdaftar, a.sttsumur , b.png_jawab,  c.noorder, d.nm_poli, e.alamat, e.no_peserta, e.jk FROM reg_periksa a, penjab b, permintaan_radiologi c, poliklinik d, pasien e WHERE a.no_rawat = '$nopriksa' and a.no_rkm_medis = e.no_rkm_medis  and a.kd_pj = b.kd_pj and a.no_rawat = c.no_rawat and a.kd_poli = d.kd_poli";
      $h = bukaquery($t);
      $r = mysqli_fetch_array($h);

        if(mysqli_num_rows($hasil)!=0) { 
            $setting=  mysqli_fetch_array(bukaquery("select nama_instansi,alamat_instansi,kabupaten,propinsi,kontak,email,logo from setting"));
            echo "   
            <fieldset style='padding:0 3px; margin:0; border:1px solid #000;'>
            <table width='".getOne("select notalabrad from set_nota")."' cellpadding='0' cellspacing='1' border='0' class='style5'>
                <tr><td height='44' style='border-bottom:1px solid black; padding-bottom:3px;'>
                    <div style='font-size:12px; font-weight:bold;'>".$setting["nama_instansi"]."</div>
                    <div>".$setting["alamat_instansi"].", ".$setting["kabupaten"].", ".$setting["propinsi"]."
                    ".$setting["kontak"]."</div></td>
                    <td width='11%' style='border-bottom:1px solid black; font-weight:bold; font-size:14px;' align='center'>
                    RAD
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                    <table width='100%'>
                       <tr>
                        <td width='20%' valign='top'>No. Rekam Medis</td>
                        <td width='1%' valign='top'>:</td>
                        <td width='27%' valign='top'>$norm / $nopriksa</td>
                        <td valign='top' width='23%'>No. Pelayanan</td>
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
                          }else{
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
                     </table>
                    </td>
                  </tr>
                  <tr>
                    <td width='98%'>
                    <table class='style1' width='102%'>
                      <thead>
                     <tr align='center' class='style3' style='border-bottom:1px solid black;'>
                        <td width='1%' class='style3' style='border-right:1px solid black;'>No.</td>
                        <td width='36%' class='style3' style='border-right:1px solid black;'>Nama Pemeriksaan</td>  
                        <td width='13%' class='style3' style='border-right:1px solid black;'>Jumlah</td>
                      </tr>
                  </thead>
                  <tbody>";
                  $z=1;
                  while($item = mysqli_fetch_array($hasil)) {
                     if($item[0]<>"Total Biaya Pemeriksaan Radiologi"){
                        echo "<tr class='isi'>
                                  <td align='center' style='border-right:1px solid black;'>&nbsp;$z</td>
                                  <td style='border-right:1px solid black;'>&nbsp;$item[0]</td>
                                  <td style='border-botton:1px solid black;' align='right'>&nbsp;".formatDuit($item[1])."</td>
                              </tr>";  
                     }else if($item[0]=="Total Biaya Pemeriksaan Radiologi"){
                         echo "<tr align='center' class='style3' style='border-top:1px solid black;'>
                                  <td  colspan='2' style='border-right:1px solid black;text-transform: uppercase;'><b>&nbsp;$item[0]<b></td>
                                  <td align='right'><b>&nbsp;".formatDuit($item[1])."<b></td>
                              </tr>";  
                     }
                     $z++;                                   
                  }


                  echo "                  

                  </tbody>
                  </table>
                  </td>	 	
                 </tr>
                 <tr>
                  <td>
                    <table width='100%'>
                     <tr>
                       <td width='17%' align='right'>&nbsp;</td>
                        <td width='41%' align='right'>&nbsp;</td>
                        <td width='27%' align='right'>&nbsp;</td>
                        <td width='15%' align='center'>Praya, $tanggal</td>
                     </tr>
                     <tr>
                       <td width='17%' align='right'>&nbsp;</td>
                        <td width='41%' align='right'>&nbsp;</td>
                        <td width='27%' align='center'>Telah diverifikasi oleh : </td>
                        <td width='15%' align='center'>Petugas</td>
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
                       <td width='17%'>-Lembar Kuning </td>
                        <td width='41%'>Untuk : Arsip Ruang Perawatan </td>
                        <td width='27%' align='center'>(------------------------ ) </td>
                        <td width='15%' align='center'>(".str_replace("_"," ", $petugas).")</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                     </tr>
                    </table>
                  </td>
                 </tr>
             </table>
             </fieldset>";  
        } else {echo "<font color='000000' size='1'  face='Times New Roman'><b>Data Pemeriksaan Radiologi masih kosong !</b>";}

    ?>  

    </body>
</html>
