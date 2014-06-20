<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "files.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../../users/enter.php");

	$fl = GetFiles();
	if($fl)
	{
		$i = 0;
		echo "<br><center><div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='0'>";
		echo "<tr class='frmttl'><td class='paddingc'>ID</td><td class='paddingc'>І'мя</td><td class='paddingc'>Опис</td>";
		echo "<td class='paddingc'>Автор</td><td class='paddingc'>size</td><td class='paddingc'>md5 хеш</td></tr>";
		foreach($fl as $file)
		{
			$i++;
			$usr = GetUser($file['fileUid']);
			echo "<tr style='background:#".($i%2 ? "282828" : "333333")."' ><td class='paddingc'>{$file['fileId']}</td>";
			echo "<td class='paddingc'><a href='../plugins/files/download.php?fid={$file['fileId']}'>{$file['fileName']}</a></td>";
			echo "<td class='paddingc'>{$file['fileDesc']}</td><td class='paddingc'>".ALink($usr)."</td>";
			echo "<td class='paddingc'>".ConvertBytes($file['fileSize'])."</td><td class='paddingc'>{$file['fileMd5']}</td></tr>";
		}
		echo "</table></div>";
	}
	include_once '../plugins/files/uploadform.php';
?>