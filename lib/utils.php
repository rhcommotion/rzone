<?php
	function gen_rnd_base64($len) {
		$len1 = ceil($len * 3 / 4);
		$rnd_bytes = openssl_random_pseudo_bytes($len1);
		$base64_str = substr(base64_encode($rnd_bytes), 0, $len);
		return $base64_str;
	}

	//echo gen_rnd_base64(16);

?>
