<?
	include_once "../files/common.php";
?>
<br><br><br><br>
<center><form action='/files/main.php'>
<div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='padding' colspan='2'>Параметри пошуку</td></tr>
<tr><td class='srchkey' colspan='2'>Шукати :</td></tr>
<tr><td class='srchkey' colspan='2'><input name="fstr" type="text" class="rinp" value="<? if(isset($_SESSION['find_str'])) echo $_SESSION['find_str'];?>" style="width:100%"/></td></tr>
<tr><td class='srchkey' >Користувач : <input name="usr" type="text" class="rinp" value='*'/></td>
	<td class='srchkey-b'><b>Тип пошуку :</b> FullText <input type=radio name='type' value=1 style='border:0px'>
	Like <input type=radio name='type' value=0 style='border:0px' checked>	</td></tr>
	<input type=hidden name='script' value='dosearch'>
<tr><td class='srchkey' colspan='2' style='text-align:center;'><input type=submit value="Шукати" class="fb" ></td></tr>
</table></div>
</form>

<br><br><br><br>
<center><form action='/files/main.php'>
<div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='padding' colspan='4'>Пошук у:</td></tr>
<tr><td class='srchkey'>Google:</td><td class='srchkey'>Msdn:</td><td class='srchkey'>Video:</td><td class='srchkey'>Wiki:</td></tr>
<tr><td class='srchkey'>
	<form action='http://www.google.com.ua/search' style='height:18px;color:white;' target='_blank'>
	<input type='hidden' name='btnI' value='1'>
	<input type='hidden' name='hl' value='ru'>
	 <input type=text name='q' style='width:100%;color:yellow;'>
	</form>
</td><td class='srchkey'>
	<form action='http://www.google.com.ua/search' name='msdn' style='height:18px;color:white;' target='_blank' onSubmit='q.value="msdn "+str.value;'>
	<input type='hidden' name='btnI' value='1'>
	<input type='hidden' name='hl' value='ru'>
	<input type='hidden' name='q'>
	<input type=text name='str' style='width:100%;'>
	</form>
</td><td class='srchkey'>
	<form action='http://www.google.com.ua/search' style='height:22px;color:white;' target='_blank'>
	<input type='hidden' name='tbs' value='vid:1'>
	<input type='hidden' name='hl' value='ru'>
	<input type=text name='q' style='width:100%;'>
	</form>
</td><td class='srchkey'>
	<form action='http://ru.wikipedia.org/w/index.php' style='height:18px;color:white;' target='_blank'>
	<input type=text name='search' style='width:100%;'>
	</form>
</td></tr>
</table></div>

<!-- end search block -->
<br><br><br><br>

