<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    public function index() {
		$this->load->database();
		
		$q_players = $this->db->query("SELECT * FROM users where user_type = 'player'");
		$players = $q_players->result_array();
		$total_players = $q_players->num_rows();
		$total_number_of_teams = floor($total_players / 18);
		$team_names = array('Bobs', 'Cats', 'Tigers', 'Lions', 'Blues', 'Reds', 'Yankees', 'Nuggets', 'Peanuts', 'Boys', 'Girls');
		$teams_keys = array_rand($team_names, $total_number_of_teams);
		
		// sort players by ranking in reverse
		usort($players, function ($a, $b) {
			if($a['ranking']==$b['ranking']) return 0;
    		return $a['ranking'] < $b['ranking'] ? 1 : -1;
		});
		
		// generate team objects 
		for ($x = 0; $x < $total_number_of_teams; $x += 1) {
			$team = new stdClass();
			$team->_name = $team_names[$teams_keys[$x]];
			$team->_players = array();
			$teams[] = $team;
		}
		
		// extract goalies from players
		$goalies = array();
		foreach ($players as $key=>$player) {
			if ($player['can_play_goalie'] == 1) {
				$goalie = $player;
				unset($players[$key]);
				$goalies[] = $goalie;
			}
		}
		
		// assign goalies to teams
		foreach ($goalies as $key=>$goalie) {
			$team_key = $key % $total_number_of_teams;
			$teams[$team_key]->_players[] = $goalie;
		}
		
		// assgin players to teams
		foreach ($players as $key=>$player) {
			$team_key = $key % $total_number_of_teams;
			if (count($teams[$team_key]->_players) < 22) {
				$teams[$team_key]->_players[] = 	$player;
			}
		}
		
		// calculate the total players rankings
		foreach ($teams as $team) {
			$score = 0;
			foreach ($team->_players as $p) {
				$score = $p['ranking'] + $score;
			}
			$team->_players_score = $score;
		}
		
		$data['teams'] = $teams;

       	$this->load->view('users', $data);
    }
}