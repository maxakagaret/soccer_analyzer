<?php
if(!defined('_DS_')){
	define ('_DS_', DIRECTORY_SEPARATOR);
}
include_once (dirname(__FILE__)._DS_.'data.php');
include_once (dirname(__FILE__)._DS_.'helper.php');

/**
* Two teams' competition processing
* @param int $c1 - number of first team in data array
* @param int $c2 - number of second team in data array
* @return array(int) - two elements array - first team points, second team points
**/
function match($c1, $c2){
	global $isDebug;
	
	try{
		
		$firstTeamPotential = teamParametersProcessing($c1);

	}
	catch(Exception $ex){
		
		echo "Something wrong with first team. ".$ex->getMessage()." \n\r";

	}
	
	try{

		$secondTeamPotential = teamParametersProcessing($c2);

	}
	catch(Exception $ex){

		echo "Something wrong with second team. ".$ex->getMessage()." \n\r";

	}

	$luck = initLuck();
	$winner = getWinner($firstTeamPotential, $secondTeamPotential, $luck);
	$scores = getScores($firstTeamPotential,$secondTeamPotential,$luck,$winner);
	
	if($isDebug){
		switch ($winner){
			case 0: 
				$resultMessage = 'Команда "'.$firstTeamPotential['name'].'" выиграет у команды "'.$secondTeamPotential['name'].'" матч со счетом '; break;
			case 1: 
				$resultMessage = 'Команда "'.$firstTeamPotential['name'].'" проиграет команде "'.$secondTeamPotential['name'].'" матч со счетом '; break;
			case 2: 
				$resultMessage = 'Команды "'.$firstTeamPotential['name'].'" и "'.$secondTeamPotential['name'].'" сыграют вничью со счетом'; break;
		}
		echo $resultMessage.' '.$scores[0].':'.$scores[1].".<br /><br />\n\r";
	}

	return $scores;
}
?>