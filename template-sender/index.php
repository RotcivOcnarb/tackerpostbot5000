<!DOCTYPE html>
<html>
	<head>
		<title>Enviar template</title>
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
		  <li><a href="">Enviar Template</a></li>
		  <li><a href="../source-sender">Enviar Imagem</a></li>
		  <li><a href=".." onclick="generateMeme()">Gerar meme</a></li>
		  <li class="icon">
			<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
		  </li>
		</ul>
	
		<center>
		<form action="enviar.php" id="myForm" method="POST" enctype="multipart/form-data">
			<table id="template-table">
			
				<tr>
					<td colspan="2">
						Template: <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this, 1);" accept="image/*">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Overlay (opcional): <input type="file" name="overlayToUpload" id="overlayToUpload" onchange="readURL(this, 2);" accept="image/*">
					</td>
				</tr>
				<tr>
					<td>
						<div class="parent" id="image-container">
							<img class="img1" id="blah1" src="#" alt="sem imagem selecionada"/>
							<img class="img2" id="blah2" src="#" alt="" style="position: absolute; left: 0px;"/>
						</div>
					</td>
					<td width="300px">
						<div id="source-selector">
							<input type="button" name="addmore" onclick="addMore()" value="Adicionar imagem"></input>
						</div>
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
