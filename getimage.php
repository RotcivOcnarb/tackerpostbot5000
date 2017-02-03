<?php

	$response = 'templates/meme.jpeg';
	
	$error = '';
	
		//abre a pasta de template
		$folder = "templates/";
		$dh = opendir($folder);
		while (false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}
		
		//abre a pasta de sources
		$folderSrc = "sources/";
		$dhSrc = opendir($folderSrc);
		while (false !== ($filenameSrc = readdir($dhSrc))) {
			$filesSrc[] = $filenameSrc;
		}

		if($files != false){
			//seleciona uma imagem aleatória da pasta
			do{
			$selected = rand(2, count($files) - 1);
			}while(endsWith($files[$selected], ".txt"));
			$response = "templates/".$files[$selected];
						
			//carrega a imagem própriamente dita na variavel $img
			$img = '';
			
				if(endsWith($response, ".png")){
					$img = imagecreatefrompng($response);
				}
				else if (endsWith($response, ".jpg") || endsWith($response, ".jpeg")){
					$img = imagecreatefromjpeg($response);
				}

			
			if($img == ''){
				$error = "ERROR";
			}
			
			//lê o arquivo config do template
			$config = file_get_contents("configs/".explode(".", $files[$selected])[0].".json");
			$json_a = json_decode($config);
			$num_sources = (count(get_object_vars($json_a)));
			
			//pra cada source do arquivo
			foreach(get_object_vars($json_a) as $name => $conj){
				
				//seleciona uma imagem aleatória da pasta
				do{
				$selectedSrc = rand(2, count($filesSrc) - 1);
				}while(endsWith($filesSrc[$selectedSrc], ".txt"));
				$responseSrc = "sources/".$filesSrc[$selectedSrc];
								
				//carrega a imagem própriamente dita na variavel $imgSrc
				$imgSrc = '';
					if(endsWith($responseSrc, ".png")){
						$imgSrc = imagecreatefrompng($responseSrc);
					}
					else if (endsWith($responseSrc, ".jpg")){
						$imgSrc = imagecreatefromjpeg($responseSrc);
					}

				if($imgSrc == ''){
					$error = "ERROR";
				}

				if($name == "overlay"){
					if($conj == "true"){
						$responseOver = "overlay/".$files[$selected];
						
						$imgOver = '';
						if(endsWith($responseOver, ".png")){
							$imgOver = imagecreatefrompng($responseOver);
						}
						else if (endsWith($responseOver, ".jpg")){
							$imgOver = imagecreatefromjpeg($responseOver);
						}
						
						if($imgOver == ''){
							$error = "ERROR";
						}
						
						imagecopyresized($img, $imgOver, 0, 0, 0, 0, getimagesize($responseOver)[0], getimagesize($responseOver)[1], getimagesize($responseOver)[0], getimagesize($responseOver)[1]);

					}
				}
				else{
					foreach(get_object_vars($conj) as $source){
					//copia a source pra cima do template
					imagecopyresized($img, $imgSrc, $source->x, $source->y, 0, 0, $source->width, $source->height, getimagesize($responseSrc)[0], getimagesize($responseSrc)[1]);
				}
				}
			}
			
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$nums = explode(".", $ip);
			
			$ip_sem_ponto = '';
			
			foreach($nums as $n){
				$ip_sem_ponto .= $n;
			}
			
			
			imagepng($img, "result/result".$ip_sem_ponto.".png");
			if($error == ''){
				echo "result/result".$ip_sem_ponto.".png";
			}
			else{
				echo $error;
			}

		}
	function endsWith($haystack, $needle){
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}
	
?>