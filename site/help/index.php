<pre>
<?
	if ($handle = opendir('./')) 
	{
		echo "Files:\n\n";

		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if ($entry === '.' || $entry === '..' || $entry === 'index.php') continue;
			echo "<a href='http://{$_SERVER['SERVER_NAME']}/help/$entry'>$entry<a>\n";
		}

		closedir($handle);
	}
?>
</pre>