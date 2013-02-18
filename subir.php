<html>
<head>
<title>Upload File To MySQL Database</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.box {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    border: 1px solid #000000;
}
-->
</style>
</head>

<body>
<?
if(isset($_POST['upload']))
{
        $fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        
        $fp = fopen($tmpName, 'r');
        $content = fread($fp, $fileSize);
        $content = addslashes($content);
        fclose($fp);
        
        if(!get_magic_quotes_gpc())
        {
            $fileName = addslashes($fileName);
        }
        

        include 'config.php';
        $connection=mysql_connect("$bdservidor","$bdunombre","$bdpass")
or die("Error conectando a la base de datos");
$db=mysql_select_db("$bdnombre",$connection)
or die ("Error seleccionando la base de datos");
        
        $query = "INSERT INTO upload (name, size, type, content ) ".
                 "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

        mysql_query($query) or die('Error, query failed');                    
        
        
        echo "<br>File $fileName uploaded<br>";
}        
?>
<form action="" method="POST" enctype="multipart/form-data" name="uploadform">
  <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
    <tr> 
      <td width="246"><input type="hidden"
name="MAX_FILE_SIZE" value="2000000"><input name="userfile"
type="file" class="box" id="userfile">
         </td>
      <td width="80"><input name="upload" type="submit" class="box" id="upload" value="  Upload  "></td>
    </tr>
  </table>
</form>
</body>
</html>