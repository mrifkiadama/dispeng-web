<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 

	$file=$id->file;


	 ?>
	 	 <object type="application/pdf" data="<?= base_url('./assets/dokument/SKK/').$file ?>"  style="height: 700px; width: 100%;" align="center">
	 	<embed type="application/pdf" src="<?= base_url('./assets/dokument/SKK/').$file ?>" ></embed>
	 	
	 </object>
	
</body>
</html>