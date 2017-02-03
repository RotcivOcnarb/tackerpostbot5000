<!DOCTYPE html>
<html>
	<head>
		<title>Enviar imagem</title>
		<link rel="stylesheet" type="text/css" href="css.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="script.js"></script> 
		<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	</head>
	<body>
	
	<div class="overlay">
	
		 <ul class="topnav" id="myTopnav">
		  <li><a href="../template-sender">Enviar Template</a></li>
		  <li><a href="">Enviar Imagem</a></li>
		  <li><a href=".." onclick="generateMeme()">Gerar meme</a></li>
		  <li class="icon">
			<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
		  </li>
		</ul>
	
	
		<center>
		<form action="enviar.php" id="myForm" method="POST" enctype="multipart/form-data">
			<table id="image-table" border="2px">
			
				<tr>
					<td colspan="2">
						Source image: <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);" accept="image/*">
					</td>
				</tr>
				<tr>
					<td>
						<div class="parent" id="image-container"><center>
							<img class="img1" id="blah" src="#" alt="sem imagem selecionada" style="border: 1px solid black"/>
						</center></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="overflow: auto; white-space: nowrap;"><center>
						<input type="submit" value="Enviar" width="100%" name="submit">
					</center></td>
				</tr>
				
			</table>
		</form>	
			
			<br>
			
			<!-- 
			
			<div id="class'+numSources+'" style="margin: 5px;">
				<h3>Source '+numSources+'</h3><br>
					X: <input type="text" value="0" oninput="changeX('+numSources+', this.value)"/><br>
					Y: <input type="text" value="0" oninput="changeY('+numSources+', this.value)"/><br>
					Width: <input type="text" value="100" oninput="changeWidth('+numSources+', this.value)"/><br>
					Height: <input type="text" value="100" oninput="changeHeight('+numSources+', this.value)"/><br>
					Cor: <select oninput="changeColor('+numSources+', this.value)"> 
						<option value="red">Vermelho</option>
						<option value="green">Verde</option>
						<option value="blue">Azul</option>
						<option value="orange">Laranja</option>
						<option value="purple">Roxo</option>
						<option value="yellow">Amarelo</option>
					</select>
					<input type="button" onclick="remove('+numSources+')" value="Remover">
			</div>
			
			-->

		</center>
		
	
		</div>
	</body>
</html>
