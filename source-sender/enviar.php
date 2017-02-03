<!DOCTYPE html>
<html>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	</head>
	<body>
<?php

	$target_fileTMP;
	$uploadOk = 1;
	$imageFileType;

	checkTemplate($target_fileTMP, $uploadOk, $imageFileType);
	sendBoth($target_fileTMP, $uploadOk, $imageFileType);
	
	//checa template
	function checkTemplate(&$target_fileTMP, &$uploadOk, &$imageFileType){
		$target_fileTMP = "../sources/" . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_fileTMP,PATHINFO_EXTENSION);
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			echo "Arquivo não é uma imagem<br>";
			$uploadOk = 0;
		}	
		
		// Check if file already exists
		if (file_exists($target_fileTMP)) {
			echo "Sorry, file already exists.<br>";
			$uploadOk = 0;
		} 
		
		if ($_FILES["fileToUpload"]["size"] > 2 * 1024 * 1024) {
			echo "Arquivo muito grande<br>";
			$uploadOk = 0;
		} 
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			echo "Apenas arquivos .png, .jpg e .jpeg são aceitos atualmente<br>";
			$uploadOk = 0;
		}
	}
	
	
	//envia os dois
	function sendBoth(&$target_fileTMP, &$uploadOk, &$imageFileType){
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Alguma checagem não possibilitou que continuasse-mos com o upload";
		// if everything is ok, try to upload file
		} else {
			$target_fileTMP = "../sources/" . basename($_FILES["fileToUpload"]["name"]);
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_fileTMP)) {
				
			} else {
				echo "Erro ao tentar fazer upload da imagem<br>";
			}
		}
	}

?>

<script>
$(document).ready(function(){
	setInterval(redi, 2000);
});

function redi(){
	window.location.replace("..");
}
</script>


</body>
</html>