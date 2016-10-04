<?php
	require_once "db.php";
	require_once("token.php");
	class Account {
		public $nus_id = '', $token, $info;

		public function goto_login() {
			header('Location: /rzone/login.php');
			exit();
		}

		public function get_info() {
			global $db;
			if (!array_key_exists('nusnet_id', $_COOKIE)
				|| !array_key_exists('token_str', $_COOKIE)) {
				$this->goto_login();
			}
			$this->nus_id = $_COOKIE['nusnet_id'];
			$this->token = new Token($this->nus_id, $_COOKIE['token_str']);
			if ($this->token->verify()) {
				$record = $db->query(
					'select * from members where nus_id like ?;',
					[$this->nus_id]
				)[0];
				$this->info = $record;
				return true;
			} else {
				$this->goto_login();
			}
		}

		public function login($nus_id) {
			$token = new Token($nus_id);
			$token->generate();
			$token->save();
			setcookie('nusnet_id', $nus_id, time() + 30 * 24 * 3600, '/rzone/');
			setcookie('token_str', $token->token_str, time() + 30 * 24 * 3600, '/rzone/');
		}
	}
	$account = new Account();
?>
