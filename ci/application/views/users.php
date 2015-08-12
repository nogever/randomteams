<!doctype html>
<html>
<head>
    <title>Teams</title>
    <?php // echo link_tag('assets/css/main.css'); ?>
    <style>
	body {
		padding: 0;
		margin: 0;
	}
	.team {
		width: 25%;
		float: left;
		padding: 30px;
		margin: 0;
		box-sizing: border-box;
		min-height: 600px;
	}
	.players {
		box-sizing: border-box;
	}
	.goalie {
		color: #CE5C5E;
		margin-left: 5px;
		font-size: 70%;	
	}
</style>
</head>
<body>
    <div class="teams">
        <?php
        foreach ($teams as $team) {
			echo '<div class="team">';
			echo heading('Team ' . $team->_name, 3);
			echo '<p>Total Rankings: ' . $team->_players_score . '</p>';			
			echo '<ul class="players">';
            foreach ($team->_players as $player) {
				echo '<li>' . $player['last_name'] . ', ' . $player['first_name'];
				if ($player['can_play_goalie'] == 1) {
					echo '<span class="goalie">G</span>';
				}
				echo '</li>';
			}
			//echo '</ul>';
//			echo ul( $team->_players, array('class' => 'players'));
			echo '</div>';
        }
        ?>
    </div>
    
</body>
</html>