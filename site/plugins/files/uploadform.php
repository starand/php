<?
	include_once "../files/common.php";
	include_once "../users/users.php";

	if(!($user=CheckUser())) EchoErrorMsg("","../../users/enter.php");
?>

<br><center><div class='frmframe' style='width:380px;'><table class='frmlist' cellspacing='0'>
<form method='post' action='../plugins/files/upload.php' enctype='multipart/form-data' name='uploadfile' target='uploadframe'>
<tr class='frmttl'><td colspan='2' class='paddingc'>Завантажити файл</td></tr>
<tr style='background:#282828;'><td class='paddingc'>File name :</td><td class='paddingc'><input type='text' name='filename' >
<div style='font-size:9px;'>З таким іменем файл буде скачуватися</div></td></tr>
<tr style='background:#333333;'><td class='paddingc'>File description :</td><td class='paddingc'><input type='text' name='filedesc' ></td></tr>
<tr style='background:#282828;'><td colspan='2' class='paddingc'><input type='file' name='file'> <input type='submit' value='Завантажити'></td></tr>
</form>
</td></tr></table></div>



<iframe name='uploadframe' frameborder="no" src='../files/blank.php'></iframe>