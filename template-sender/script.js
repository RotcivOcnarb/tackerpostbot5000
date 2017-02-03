function readURL(input, num) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah' + num)
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	
	var numSources = 1;
	
	function changeX(id, val){
		var img = document.getElementById("source-image" + id);
		img.style.left = val + "px";
	}
	
	function changeY(id, val){
		var img = document.getElementById("source-image" + id);
		img.style.top = val + "px";
	}
	
	function changeWidth(id, val){
		var img = document.getElementById("source-image" + id);
		img.style.width = val + "px";
	}
	
	function changeHeight(id, val){
		var img = document.getElementById("source-image" + id);
		img.style.height = val + "px";
	}
	
	function changeColor(id, val){
		var img = document.getElementById("source-image" + id);
		img.style.border = "1px solid " + val;
	}
	
	function remove(id){
		var img = document.getElementById("source-image" + id);
		img.parentNode.removeChild(img);
		var div = document.getElementById("class" + id);
		div.parentNode.removeChild(div);
	}
	
$(document).ready(function() {
	$('#myForm').on('submit', function(e) {
		//prevent the default submithandling
		//e.preventDefault();
		//send the data of 'this' (the matched form) to yourURL
		$.post('enviar.php', $(this).serialize());
	});
});
	
function addMore(){
	
	var div = document.getElementById("source-selector");
	var imgContainer = document.getElementById("image-container");
	
	var img = document.createElement("IMG");
	img.id = "source-image" + numSources;
	img.style = "position: absolute;  top: 0px;  left: 0px; border: 1px solid red; width: 100px; height:100px;";
	
	imgContainer.appendChild(img);
	
	//var html = '<div id="class'+numSources+'" style="margin: 5px;">	<h3>Source '+numSources+'</h3><br>X: <input type="text" value="0" oninput="changeX('+numSources+', this.value)"/><br>	Y: <input type="text" value="0" oninput="changeY('+numSources+', this.value)"/><br>	Width: <input type="text" value="100" oninput="changeWidth('+numSources+', this.value)"/><br>	Height: <input type="text" value="100" oninput="changeHeight('+numSources+', this.value)"/><br></div>';
	
	var html = '<div id="class'+numSources+'" style="margin: 5px;"><h3>Source '+numSources+'</h3><br>					X: <input name="X'+numSources+'" type="text" value="0" oninput="changeX('+numSources+', this.value)"/><br>					Y: <input type="text" name="Y'+numSources+'" value="0" oninput="changeY('+numSources+', this.value)"/><br>					Width: <input type="text" name="Width'+numSources+'" value="100" oninput="changeWidth('+numSources+', this.value)"/><br>					Height: <input type="text" name="Height'+numSources+'" value="100" oninput="changeHeight('+numSources+', this.value)"/><br>					Cor: <select name="Color'+numSources+'" oninput="changeColor('+numSources+', this.value)"> 						<option value="red">Vermelho</option>						<option value="green">Verde</option>						<option value="blue">Azul</option>						<option value="orange">Laranja</option>						<option value="purple">Roxo</option>						<option value="yellow">Amarelo</option>					</select>					<input type="button" onclick="remove('+numSources+')" value="Remover"></div>';
	
	div.insertAdjacentHTML('beforeend', html);
	numSources ++;
}