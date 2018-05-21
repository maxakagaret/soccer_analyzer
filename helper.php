<?php
/**
* Team's data processing
* @param int - number of team in data array
* @return array(mixed) - array of processed data
* @throws Exception if no data
**/
function teamParametersProcessing($teamNumber){
	global $data;
	if(isset($data[$teamNumber]) && !empty($data[$teamNumber])){

		$teamData = $data[$teamNumber];
		$winCoeff = $teamData['win'] / $teamData['games'];
		$defeatCoeff = $teamData['defeat'] / $teamData['games'];
		$drawCoeff = $teamData['draw'] / $teamData['games'];
		$scoreCoeff = $teamData['goals']['scored'] / $teamData['games'];
		$skipedCoeff = $teamData['goals']['skiped'] / $teamData['games'];
		$gameSuccessCoeff = $winCoeff / ($defeatCoeff + $drawCoeff);
		$gameDefeatCoeff = $defeatCoeff / ($winCoeff + $drawCoeff);
		$gameDrawCoeff = $drawCoeff / ($winCoeff + $drawCoeff);

		return [
			'name' => $teamData['name'],
			'gameSuccess' => $gameSuccessCoeff,
			'gameDefeat' => $gameDefeatCoeff,
			'gameDraw' => $gameDrawCoeff,
			'scoreChance' => $scoreCoeff,
			'skipedChance' => $skipedCoeff
		];

	}
	else{

		throw new Exception("No such team or no data for this team.");

	}
}

/**
* Random generated luck
* @return array(float)
**/
function initLuck(){
	$winLuckCoeff = mt_rand(-100,100) / 100;
	$defeatLuckCoeff = mt_rand(-100,100) / 100;
	$drawLuckCoeff = mt_rand(-100,100) / 100;

	return [
		'winLuckCoeff' => $winLuckCoeff,
		'defeatLuckCoeff' => $defeatLuckCoeff,
		'drawLuckCoeff' => $drawLuckCoeff,
	];
}

/**
* Who will be winner?
* @param array(mixed) - potential of first team
* @param array(mixed) - potential of second team
* @param array(float) - luck
* @return array(string) - result [0 - first team wins, 1 - first team1, 2 - draw]
**/
function getWinner($firstTeamPotential, $secondTeamPotential, $luck){
	$winCoeff = $firstTeamPotential['gameSuccess'] / $secondTeamPotential['gameSuccess'];
	$loseCoeff = $firstTeamPotential['gameDefeat'] / $secondTeamPotential['gameDefeat'];
	$drawCoeff = $firstTeamPotential['gameDraw'] / $secondTeamPotential['gameDraw'];

	if($winCoeff + $luck['winLuckCoeff'] > $loseCoeff + $luck['defeatLuckCoeff']){
		
		if($winCoeff + $luck['winLuckCoeff'] > $drawCoeff + $luck['drawLuckCoeff']){
			
			return 0;

		}
		else{
			
			return 2;

		}

	}
	else{
		if($loseCoeff + $luck['defeatLuckCoeff'] > $drawCoeff + $luck['drawLuckCoeff']){
			
			return 1;

		}
		else{
			
			return 2;

		}	
	}
}

/**
* What scores will get both team
* @param array(mixed) - potential of first team
* @param array(mixed) - potential of second team
* @param int - who is the winner
* @return array(int) - teams scores
**/
function getScores($firstTeamPotential, $secondTeamPotential, $winner){
	$firstTeamScoreCoeff = $firstTeamPotential['scoreChance'] + $secondTeamPotential['skipedChance'];
	$secondTeamScoreCoeff = $secondTeamPotential['scoreChance'] + $firstTeamPotential['skipedChance'];
	$coeffDifference = ceil(abs($firstTeamScoreCoeff-$secondTeamScoreCoeff));
	$scoreLuck = mt_rand(1,3);
	$scoreDifference = floor(abs($scoreLuck-$coeffDifference));

	switch ($winner){
		case 0: return [$scoreLuck, $scoreDifference];
		case 1: return [$scoreDifference, $scoreLuck];
		case 2: return [$scoreLuck, $scoreLuck];
		default: return [0,0];
	}
}
?>