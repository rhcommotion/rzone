<?php
	require_once("lib/account.php");
	require_once 'lib/db.php';
	$account->get_info();
	
	function inject_json($var_name, $obj) {
		echo "<script>var $var_name = JSON.parse('" . json_encode($obj) . "');</script>";
	}

	function page_start() {
		global $db, $account;
		header("Cache-Control: no-cache, must-revalidate");
  	header("Pragma: no-cache");
  	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>

	<html>
	<head>
		<style>
			html, body {
				position: relative;
				width: 100%;
				height: 100%;
				//overflow: hidden;
			}
			.header {
				position: relative;
				border-bottom: 1px solid;
				width: 100%;
				height: 6em;
			}
			.header-img {
				height: 100%;
			}
			.welcome {
				position: absolute;
				margin: 0;
				left: -16px;
				top: 0;
				width: 100%;
				text-align: right;
			}
			.logout {
				position: absolute;
				right: 2ch;
				bottom: -8px;
			}
			.page-body {
				position: relative;
				width: 100%;
				height: calc(100% - 6em - 15px);
			}
			.sidebar {
				position: relative;
				font-size: 115%;
				//font-weight: bold;
				width: 11em;
				height: 100%;
				padding: .5em;
				border-right: 1px solid black;
				overflow: auto;
				line-height: 1.5;
			}
			.page-content {
				position: absolute;
				top: 0;
				left: 14.4em;
				width: calc(100% - 14.4em - 1em);
				height: 100%;
				overflow: auto;
			}
			.sidebar > div::before {
				content: '- ';
			}
			.sidebar > div > div::before {
				content: '\2022 ';
			}
			.sidebar > div > div {
				font-size: 90%;
				padding-left: 1em;
			}
		</style>
		<style>
			table, table td, table th {
				border: 1px solid black;
			}
			table td {
				padding: .5em;
				line-height: 1.2;
			}
			td, th {
				text-align: center;
			}
		</style>
		<script src='u.js'></script>
	</head>
	<body>
		<div class='header'>
			<a href='index.php'><img class='header-img' src='img/rzone-header.png'></a>
			<h2 class='welcome'>Welcome, <?php echo $account->info['name']; ?></h2>
			<a href='logout.php'><h3 class='logout'>Logout</h3></a>
		</div>
		<div class='page-body'>
			<div class='sidebar'>
				<div>
					<a href='index.php'>Profile</a>
				</div>
				<div>
					<a href='my-activities.php'>My Activities</a>
				</div>
				<div>
					Activity Application
					<!--div>
						<a href='appl-inst.php'>Instruction</a>
					</div>
					<div>
						<a href='appl-faq.php'>FAQ</a>
					</div-->
					<div>
						<a href='appl.php'>Apply</a>
					</div>
					<div>
						<a href='my-appl.php'>My Applications</a>
					</div>
					<div>
						<a href='appl-history.php'>History</a>
					</div>
				</div>
				<!--div>
					<a href='req-submission.php'>Request Submission</a>
				</div-->
				<!--div>
					<a href='fac-b.php?v=1&d=<?php echo (new DateTime('now'))->format('Y-m-d'); ?>'>Facilities Booking</a>
				</div-->
				<?php 
					// Activity head panel
					$is_head = $db->query_get1('select is_activity_head(?);', [$account->nus_id]);
					if ($is_head) {
				?>
					<div>
						Application Management
				<?php
					$rows = $db->query('call get_manageable_activities(?);', [$account->nus_id]);
					$f = function ($row) {
						echo "<div>
								<a href='appl-man.php?i=$row[0]'>$row[1]</a>
							</div>";
						return 0;
					};
					array_map($f, $rows);
				?>
					</div>
					<div>
						Activity Management
				<?php
					$rows = $db->query('call get_manageable_activities(?);', [$account->nus_id]);
					$f = function ($row) {
						echo "<div>
								<a href='activity-man.php?i=$row[0]'>$row[1]</a>
							</div>";
						return 0;
					};
					array_map($f, $rows);
				?>
					</div>
				<?php
					}
				?>
				<?php 
					// JCRC Panel
					if ($account->info['type'] === 'jcrc') {
				?>
					<div>
						JCRC Panel
						<div>
							<a href='jcrc-options.php'>R-Zone System Options</a>
						</div>
						<div>
							<a href='jcrc-residents.php'>Residents</a>
						</div>
					</div>
					<div>
						Media Request
						<div>
							<a href='msr-new.php'>New Request</a>
						</div>
						<div>
							<a href='msr-track.php'>Track Requests</a>
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<div class='page-content'>
				

<?php
	}
	//
	function page_end() {
?>

			</div>
		</div>

	</body>
	</html>

<?php
	}
?>
