<?
	$f = file('pass.txt');
	mysql_pconnect("localhost","root","i love you");
	mysql_select_db("sl");
	foreach($f as $k => $v) {
		$v = substr($v,0,strlen($v)-2);
		//@mysql_query("INSERT ignore INTO hack.hashes (pass,md5) VALUES('$v',md5('$v'))");
		echo "'".$v."'<br>";
		
	}
?>