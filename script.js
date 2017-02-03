  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   
   var accessToken;
   var uid;
   
   function postReal(){
	   
	   var img = document.getElementById("meme-img").src.split("?")[0];
	   console.log("Checando se a imagem " + img + " é um meme");
	   d = new Date();
	   if(document.getElementById("meme-img").src.substring(31).startsWith("/result")){
		console.log("Imagem é um meme! Postando no facebook;")
			   //Posta na pagina
			FB.api(
			"/"+uid+"/photos",
			"post",
			{
				"message": "" ,
				"url" : img
				
				//"access_token": accessToken
				
			},
			function (response) {
			  if (response && !response.error) {
				console.log(response);
				
				var small_loading = document.getElementById("small-loading");
				small_loading.style.display = "none";
				alert("Postado com sucesso!");
			  }
			  else{
				  console.log(response.error);
			  }
			});
	   }
	   console.log("Fim");
   }
   
   function postTimeline(){
	  
	  var small_loading = document.getElementById("small-loading");
	 small_loading.style.display = "block";
	  
	  
	  
	  FB.init({
		  appId      : 'ID DO APLICATIVO CRIADO NO FACEBOOK (kkk ce ta loco q eu vou deixar o meu aqui)',
		  xfbml      : true,
		  version    : 'v2.8'
		});
		
		var uri = encodeURI('http://tackerpostbot5000.esy.es/');
		//Faz o login
		FB.getLoginStatus(function(response) {
		  if (response.status === 'connected') {
			accessToken = response.authResponse.accessToken;
			uid = response.authResponse.userID;
			console.log('Logged in. ' + accessToken);
			postReal();
		  }
		  else {
			  
			FB.login(function(response){
				accessToken = response.authResponse.accessToken;
				uid = response.authResponse.userID;
				postReal();
				
				}, {scope: 'publish_actions,  user_photos'} );
				
		  }
		  
		},
		{scope: 'publish_actions, user_photos'});

		FB.AppEvents.logPageView();
	  

   }
   
var ajaxRequest;  // The variable that makes Ajax possible!

function ajaxFunction(){


      try{
         // Opera 8.0+, Firefox, Safari 
         ajaxRequest = new XMLHttpRequest();
      }catch (e){

         // Internet Explorer Browsers
         try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
         }catch (e) {
            try{
               ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){

               // Something went wrong
               alert("Your browser broke!");
               return false;
            }
         }
      }
   }
   
   function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
	}

var intervalo;
var error = document.getElementById("error-prints");

	
$(document).ready(function(){
	error = document.getElementById("error-prints");
  generateUpper();
  
});


function generateUpper(){
	error.innerHTML = "";
	error.insertAdjacentHTML("beforeend", "Gerando meme... <br>");
	generateMeme();
}

function regenerateMeme(){
	error.insertAdjacentHTML("beforeend", "Muito tempo para gerar o meme, gerando novo meme...<br>");
	generateMeme();
}

function generateMeme(){
	if(intervalo != null){
		clearTimeout(intervalo);
	}
	intervalo = setTimeout(regenerateMeme, 15000);
	document.getElementById("meme-img").src = "loading.gif";
	ajaxFunction();
	ajaxRequest.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		d = new Date();
		
		if(this.responseText.startsWith("result")){
			document.getElementById("meme-img").src = this.responseText+"?"+d.getTime();
			error.insertAdjacentHTML("beforeend", "Meme gerado com sucesso!<br>");
			clearTimeout(intervalo);
		}
		else{
			document.getElementById("meme-img").src = "erro.png";
			error.insertAdjacentHTML("beforeend", "Não foi possível fazer a requisição do servidor, tentando novamente... <br>");
			generateMeme();
		}
	  }
	};
    ajaxRequest.open("GET", "getimage.php", true);
    ajaxRequest.send();
}