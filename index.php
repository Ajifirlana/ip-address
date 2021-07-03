
<!DOCTYPE html>
<html>
<head>
	<title>My IP</title>
  <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
            <?php 

            include 'knsj.php';

            $page = $_SERVER['PHP_SELF'];
            $sec = "10";
            $karakter ='1234567890123456';
            $seri = '1234';
            $shuffle = str_shuffle($karakter);
            $no_seri = str_shuffle($seri);
            $tgl= date("d-m-Y");
            ?>
            <label>IP VPS</label>
            <input type="text" name="ip_address" id="ip_address" required="" value=" <?
$ip=$_SERVER['REMOTE_ADDR'];
echo $ip;
?>">
<input type="hidden" name="tgl" id="tgl" value="<?php echo $tgl;?>">



            <?php $tgl_exp= date('d-m-Y', time() + (60 * 60 * 24 * 5)); ?>
<input type="hidden" id="tgl_exp" name="tgl_exp" value="<?php echo $tgl_exp;?>">
         <button type="submit" id="simpan" name="simpan">SIMPAN</button>
           </form>
<?php 
           $q = $conn->query("SELECT * FROM tb_ip ORDER BY tgl_exp ASC LIMIT 5"); 

    $no = 1; // nomor urut
    while ($dt = $q->fetch_assoc()) :
        ?>
        <?php if($dt['tgl'] >= $tgl_exp){
            echo "<td>";
        echo "VPS sudah Expired";
         echo "</td>";
        } ?>
        <?= $dt['ip_address'] ?>
<?php $cls[]=$dt;?>
      <?php echo json_encode($cls); ?>
   
        <?php
    endwhile;
    ?> 

<?php  
if(isset($_POST['simpan']))
{

include 'knsj.php';

$ip_address = $_POST['ip_address'];

$tgl = $_POST['tgl'];

$tgl_exp = $_POST['tgl_exp'];

$query = mysqli_query($conn,"SELECT * FROM tb_ip WHERE ip_address='$ip_address'");
$cek = mysqli_num_rows($query);  
if ($cek > 0) {
     echo "<script>alert('ip_address sudah ada'); window.location.href='index.php'</script>";

   }
  else {
// menginput data ke database
    $q = $conn->query("INSERT INTO tb_ip VALUES('','$ip_address','$tgl','$tgl_exp')"); // pesan jika data gagal disimpan
    echo "<script>alert('Data berhasil ditambahkan'); window.location.href='index.php'</script>";
  }
}

?>
</body>
</html>
