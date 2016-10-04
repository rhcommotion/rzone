<?php

class DB {
	public $pdo;
	function __construct($db_name) {
		$this->pdo = new PDO("mysql:host=localhost;dbname=$db_name", 'root', '');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
	}
	function __destruct() {
			$this->pdo = null;
	}
	// returns the number of rows affected
	function execute($query, $args = []) {
		$stmt = $this->pdo->prepare($query);
		$rtn = $stmt->execute($args);
		if ($rtn) {
			$n = $stmt->rowCount();
			$stmt->closeCursor();
			return $n;
		} else {
			throw new Exception("DB: Cannot execute $query");
		}
	}
	// returns an array of records. records are both array-indexed and assoc dict.
	function query($query, $args = []) {
		$stmt = $this->pdo->prepare($query);
		$rtn = $stmt->execute($args);
		if ($rtn) {
			$arr = $stmt->fetchAll(PDO::FETCH_BOTH);
			$stmt->closeCursor();
			return $arr;
		} else {
			throw new Exception("DB: Cannot query $query");
		}
	}
	// returns the value of row 1, col 1, with fallback value.
	function query_get1($query, $args = [], $fallback = null) {
		$stmt = $this->pdo->prepare($query);
		$rtn = $stmt->execute($args);
		if (!$rtn) {
			throw new Exception("DB: Cannot query $query");
		}
		$arr = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if ($arr) {
			return $arr[0];
		} else {
			return $fallback;
		}
	}
	function get_option($k) {
		$v = $this->query_get1('select get_option(?);', [$k]);
		return is_null($v) ? '' : $v;
	}
	function set_option($k, $v) {
		$rtn = $this->execute('call set_option(?, ?);', [$k, $v]);
		/*
		if ($rtn !== 1) {
			throw new Exception("DB: set_option failed for ($k: $v).");
		}
		*/
	}
}
$db = new DB('rzone');

?>
