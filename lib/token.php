<?php
	require_once "db.php";
	require_once "utils.php";
	class Token {
		public $nus_id, $token_str = '';

		public function __construct($user_id, $str = null) {
			$this->nus_id = strtolower($user_id);
			if ($str) {
				$this->token_str = $str;
			}
		}
		public function generate() {
			$this->token_str = gen_rnd_base64(16);
		}
		public function save() {
			global $db;
			$rtn = $db->execute(
				"insert into login_token (token, nus_id, ip, port, ua)
					values (?, ?, ?, ?, ?);",
				[$this->token_str, $this->nus_id,
					$_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_PORT'],
					$_SERVER['HTTP_USER_AGENT']
				]
			);
			if ($rtn !== 1) {
				throw new Exception('token: cannot save.');
			}
		}
		public function verify() {
			global $db;
			$rtn = $db->query_get1(
				"select nus_id from login_token where (token like ?) and (nus_id like ?);",
				[$this->token_str, $this->nus_id]
			);
			return $rtn === $this->nus_id;
		}
	}
?>
