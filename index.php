<!DOCTYPE html>
<html>
	<head>
		<title>TackerPostBot5000</title>
		<link rel="stylesheet" type="text/css" href="css.css">
		<link rel="icon" href="favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
			<script src="script.js"></script> 
		<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="overlay">
	
		 <ul class="topnav" id="myTopnav">
		  <li><a href="template-sender">Enviar Template</a></li>
		  <li><a href="source-sender">Enviar Imagem</a></li>
		  <li><a href="#generate" onclick="generateUpper()">Gerar meme</a></li>
		  <li class="icon">
			<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
		  </li>
		</ul>
		
		<center>
		<br>
		<div id="contador">
	
			
	
			<?php 
			
			//contador de views
				$arquivo = "contador.txt";
				$handle = fopen($arquivo, 'r+');
				$data = fread($handle, 512);
				$contador = $data + 1;
				
				echo $contador." visualizações do site<br>";
				
				fseek($handle, 0);
				fwrite($handle, $contador);
				fclose($handle);
			
			//contador de templates
					//abre a pasta de template
				$folder = "templates/";
				$dh = opendir($folder);
				while (false !== ($filename = readdir($dh))) {
					$files[] = $filename;
				}
				
				$cont = count($files) - 2;
				echo $cont." templates enviados<br>";
				
			//contador de sources
					//abre a pasta de sources
				$folderSrc = "sources/";
				$dhSrc = opendir($folderSrc);
				while (false !== ($filenameSrc = readdir($dhSrc))) {
					$filesSrc[] = $filenameSrc;
				}
				
				$cont = count($filesSrc) - 2;
				echo $cont." imagens enviadas";
			?>
			
			</div>
			
		<img id="small-loading" src="small-loading.gif"></img>
		
		<div id="error-prints"></div>
		<div id="meme" width="60%">
			<img id="meme-img" width="100%" src="sources/bomdia.jpg"></img><br>
			<div class="fb-button-container" width="100%" height="100%">
				<a class="facebook-button" href="#facebook" onclick="postTimeline()">  Postar no facebook </a>
			</div>
		</div>
		</center>
		
		
		</div>
	</body>
</html>
