<?php
	function Reemplaza($string){
		$string = str_replace("(", " ",$string);
		$string = str_replace(")", " ",$string);
		$string = str_replace(".", " ",$string);
		$string = str_replace(",", " ",$string);
		$string = str_replace("°", " ",$string);
		$string = str_replace("'", " ",$string);
		$string = str_replace("!", " ",$string);
		$string = str_replace("#", " ",$string);
		$string = str_replace("%", " ",$string);
		$string = str_replace("=", " ",$string);
		$string = str_replace("?", " ",$string);
		$string = str_replace("¡", " ",$string);
		$string = str_replace("¿", " ",$string);
		$string = str_replace("*", " ",$string);
		$string = str_replace("{", " ",$string);
		$string = str_replace("}", " ",$string);
		$string = str_replace("[", " ",$string);
		$string = str_replace("]", " ",$string);
		$string = str_replace(">", " ",$string);
		$string = str_replace("<", " ",$string);
		$string = str_replace(";", " ",$string);
		$string = str_replace(":", " ",$string);
		$string = str_replace("_", " ",$string);
		$string = str_replace("-", " ",$string);
		$string = str_replace("+", " ",$string);
		$string = str_replace("-", " ",$string);
		$string = str_replace("&", " ",$string);
		$string = str_replace("|", " ",$string);
		$string = str_replace("á", "A",$string);
		$string = str_replace("é", "E",$string);
		$string = str_replace("í", "I",$string);
		$string = str_replace("ó", "O",$string);
		$string = str_replace("ú", "U",$string);
		$string = str_replace("Á", "A",$string);
		$string = str_replace("É", "E",$string);
		$string = str_replace("Í", "I",$string);
		$string = str_replace("Ó", "O",$string);
		$string = str_replace("Ú", "U",$string);
		$string = str_replace("ü", "U",$string);
		$string = str_replace("ö", "O",$string);
		return $string;
	}

	function Acomodar($string,$pos,$numero,$str){
		$tamaño=strlen($string);
		$espacios="";
		$salida="";

		if($numero>$tamaño){
			for($i=0;$i<($numero-$tamaño);$i++){
			$espacios.=$str;
			}
			switch ($pos) {
				case 'r':
					$salida=$espacios.$string;
					break;
				
				case 'l':
					$salida=$string.$espacios;
					break;
			}
			return $salida;
		}else{
			if($numero>0){
				return substr($string,0,$numero);
			}else{
				return substr($string,0,$tamaño);
			}
			
		}
		
	}

?>