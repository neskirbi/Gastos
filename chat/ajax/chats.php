<?php

session_start();

	$ids=$_REQUEST['ids'];
	$cliente=$_REQUEST['cliente'];






$ids=explode(',', $ids);
$res=array();
for ($i=0; $i <count($ids) ; $i++) {

	if($_SESSION['user_tipo']=='5')
	{
		$archivo="../chats/".$cliente.'chat'.$ids[$i].'.txt';

	}else{
		$archivo="../chats/".$ids[$i].'chat'.$cliente.'.txt';
	}
	
	
	if(file_exists($archivo))
	{
		

		$fp = fopen($archivo, "r");
		$contenido='';

		while(!feof($fp)) {
			$contenido =$contenido. fgets($fp). "<br/>";
		}
			fclose($fp);

			$obj->id=$ids[$i];;
			$obj->msn=$contenido;
			$res[]=$obj;

	}else
	{
	 	if($abierto = fopen($archivo, "a"))
	    {
	        
	            
	    }
	    else{

	            //echo json_encode("{'res':'2'}");
	    }
	}
}

$obj->contenido=json_encode($res);



echo  json_encode($obj);

?>