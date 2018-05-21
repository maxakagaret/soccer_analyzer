# Soccer analyzer
Simple analyzer of soccer matches between 2 team

<h2>index.php</h2>

<h3>match(t1,t2)</h3>

Main function. Process the match results.

@param int - index of first team

@param int - index of second team

@return array(int) - array of two integer - result of match (ex. [3,2])

<h2>helper.php</h2>

<h3>teamParametersProcessing(teamNuber)</h3>

Team's data processing

@param int - number of team in data array

@return array(int) - array(mixed) - array of processed data

@throws Exception if no data

<h3>initLuck()</h3>

Random generated luck

@return array(float)

<h3>getWinner(firstTeamPotential, secondTeamPotential, luck)</h3>

Who will be winner?

@param array(mixed) - potential of first team

@param array(mixed) - potential of second team

@param array(float) - luck

@return array(string) - result [0 - first team wins, 1 - first team1, 2 - draw]

<h3>getScores(firstTeamPotential, secondTeamPotential, winner)</h3>

What scores will get both team

@param array(mixed) - potential of first team

@param array(mixed) - potential of second team

@param int - who is the winner

@return array(int) - teams scores
