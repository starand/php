<?
	include_once "../users/users.php"; 
	include_once dirname(__FILE__)."\config.php";
	
	$user = CheckUser(); if(!$user || $user['uId'] != 1) die();
	
	$dir = "";
	if (isset($_GET['dir'])) $dir = $_GET['dir'];
	echo "<p style='color:magenta;'>[src] # \\".path_join($dir,"/")."</p>";

	$curr_dir = realpath(path_join($base_dir, $dir));
	files_list($curr_dir, $files, $dirs);
	
	foreach($dirs as $dir)
	{
		echo prepare_dir_link($dir);
	}
	echo ": ";
	
	foreach($files as $f)
	{
		echo prepare_file_link($f);
	}
	
	if (isset($_GET['file']))
	{
		echo '<link href="/forums/css/shCore.css" rel="stylesheet" type="text/css" />
<link href="/forums/css/shThemeFadeToGrey.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/forums/js/shCore.js"></script>';
		foreach($langs as $lang) echo "<script type='text/javascript' src='/forums/js/shBrush$lang.js'></script>";
	
		$file = correct_slashes($_GET['file']);
		$full_name = path_join($base_dir, $file);
		$ext = strtolower(pathinfo($full_name, PATHINFO_EXTENSION));
		
		switch ($ext)
		{
			case 'h':
			case 'cpp':
			case 'c':
			case 'cu':
			case 'hpp':
				echo "<pre class='brush: cpp'>".file_get_contents($full_name)."</pre>";
				break;
			default:
				echo "...";
		}
	}
?>

<script type="text/javascript">
SyntaxHighlighter.config.bloggerMode = true;
SyntaxHighlighter.config.clipboardSwf = '../forums/js/clipboard.swf';
SyntaxHighlighter.all();
</script>