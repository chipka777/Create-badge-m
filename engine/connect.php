<?php 

class Connection {
	public function dbConnect() {
		return new PDO("mysql:host=localhost;dbname=league_badgem","league_chase","chase123");
	}
}

?>