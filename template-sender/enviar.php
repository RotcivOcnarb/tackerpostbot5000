<!DOCTYPE html>
<html>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	</head>
	<body>
<?php
	
	class sourceImage{
	
		public $x;
		public $y;
		public $width;
		public $height;
		
		function __construct($x, $y, $width, $height){
			$this->x = $x;
			$this->y = $y;
			$this->width = $width;
			$this->height = $height;
		}
		
	}


	$target_fileTMP;
	$uploadOk = 1;
	$imageFileType;
	
	$values = array('red' => array(), 'green' => array(), 'blue' => array(), 'orange' => array(), 'purple' => array(), 'yellow' => array());
	
	/*
	$red = array();
	$green = array();
	$blue = array();
	$orange = array();
	$purple = array();
	$yellow = array();
	*/
	
	foreach($_POST as $nome => $valor){
		
		/*
			red
			green
			blue
			orange
			purple
			yellow

		*/

		if(substr($nome, 0, 5) == "Color"){
			
			$num = substr($nome, -1);
			
			switch($valor){
				case "red":
					$values['red'][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
				case "green":
					$values["green"][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
				case "blue":
					$values["blue"][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
				case "orange":
					$values["orange"][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
				case "purple":
					$values["purple"][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
				case "yellow":
					$values["yellow"][] = new sourceImage($_POST['X'.$num], $_POST['Y'.$num], $_POST['Width'.$num], $_POST['Height'.$num]);
					break;
			}
		}
		
	}
	
	//debugando imagens
	/*
	echo "<br>Red: ";
	if(isset($values["red"])) print_r($values["red"]); 
	echo "<br>Green: ";
	if(isset($values["green"]))print_r($values["green"]);
	echo "<br>Blue: ";
	if(isset($values["blue"]))print_r($values["blue"]);
	echo "<br>Orange: ";
	if(isset($values["orange"]))print_r($values["orange"]);
	echo "<br>Purple: ";
	if(isset($values["purple"]))print_r($values["purple"]);
	echo "<br>Yellow: ";
	if(isset($values["yellow"]))print_r($values["yellow"]);
	*/
	foreach($values as $color){
		print_r($color);
		echo "<br>";
	}
	
	if($_FILES["overlayToUpload"]["name"] != ''){
		echo "<br>Overlay exists";
	}
	else{
		echo "<br>Overlay not defined";
	}
	
	echo "<br>JSON generated: <br><br>";
	
	//abre o começo do JSON
	$json = "{\n";
	
	$ic = 0;
	
	//pra cada cor existente, existe um array de imagens
	foreach($values as $colorname => $color){
		
			//inicia o objeto da cor		
			$json .= "\t\"".$colorname."\" : {\n";
			
			//popula com as imagens
			$i = 0; //id da imagem
			$ttl = count($color); //n total de imagens
			foreach($color as $valnm => $img){//pra cada imagem naquela cor
				$json .= "\t\t\"".$i."\" : {\n";//inicia a imagem com o ID dela
				
				$json .= "\t\t\t\"x\" : \"".$img->x."\", \"y\" : \"".$img->y."\", \"width\" : \"".$img->width."\", \"height\" : \"".$img->height."\"\n";
				
				$json .= "\t\t}";//fecha a imagem
				if($i < $ttl - 1) $json .= ",";//se essa não for a ultima, coloca uma virgula dps da chave
				$json .= "\n";
				$i++;
			}
			
			//fecha objeto
			
			$json .= "\t}";
			if($ic < count($values) - 1) $json .= ",";
			$json .= "\n";
		
		$ic ++;
	}
	
	if($_FILES["overlayToUpload"]["name"] != ''){
			$json .= ",\n \t \"overlay\" : \"true\"\n";
	}
	
	$json .= "}";
	
	$info = pathinfo($_FILES["fileToUpload"]["name"]);
	
	file_put_contents("../configs/".basename($_FILES["fileToUpload"]["name"], ".".$info['extension']).".json", $json);
	
	
	checkTemplate($target_fileTMP, $uploadOk, $imageFileType);
	if($_FILES["overlayToUpload"]["name"] != ''){
		checkOverlay($target_fileTMP, $uploadOk, $imageFileType);
	}
	sendBoth($target_fileTMP, $uploadOk, $imageFileType);
	
	//checa template
	function checkTemplate(&$target_fileTMP, &$uploadOk, &$imageFileType){
		$target_fileTMP = "../templates/" . basename($_FILES["fileToUpload"]["name"]);
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
	
	//checa overlay
	function checkOverlay(&$target_fileTMP, &$uploadOk, &$imageFileType){
		$target_fileTMP = "../overlay/" . basename($_FILES["overlayToUpload"]["name"]);
		$imageFileType = pathinfo($target_fileTMP,PATHINFO_EXTENSION);
		
		
		
		$check = getimagesize($_FILES["overlayToUpload"]["tmp_name"]);
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
		
		if ($_FILES["overlayToUpload"]["size"] > 2 * 1024 * 1024) {
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
			$target_fileTMP = "../templates/" . basename($_FILES["fileToUpload"]["name"]);
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_fileTMP)) {
				
			} else {
				echo "Erro ao tentar fazer upload da imagem<br>";
			}
			$target_fileTMP = "../overlay/" . basename($_FILES["fileToUpload"]["name"]);
			if($_FILES["overlayToUpload"]["name"] != ''){
				if (move_uploaded_file($_FILES["overlayToUpload"]["tmp_name"], $target_fileTMP)) {
					
				} else {
				echo "Erro ao tentar fazer upload do Overlay<br>";
				}
			}
		}
	}

?>


<center>
<canvas id="canvas"></canvas>
</center>

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