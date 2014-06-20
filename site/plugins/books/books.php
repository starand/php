<?
	$BOOK_BASE = "e:\\lab\\.books\\";
	
function AddBook($path, $desc, $bcat)
{
	$query = "insert into books (bookPath, bookDesc, bookCat) values('$path', '$desc', $bcat)";
	return uquery($query);
}
function GetBooks($cat)
{
	$query = "select bookId from books where bookCat=$cat";
	if( !$cat ) $query = "select bookId from books ORDER BY bookId DESC LIMIT 10";	
	$res = uquery($query); 
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row['bookId']);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
function GetBook($id)
{
	global $BOOK_BASE;
	$query = "select * from books where bookId=$id";
	$res = @mysql_query($query);
	if($res && mysql_num_rows($res))
	{
		$book = mysql_fetch_array($res);
		$book['bookPath'] = $BOOK_BASE.$book['bookPath'];
		return $book;
	}
	return 0;
}
function GetBookCats($bc = 0)
{
	$query = "select * from book_cats where bcPid=$bc";
	$res = uquery($query); 
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
function GetBookCat($id)
{
	$query = "select * from book_cats where bcId=$id";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	return 0;
}
function AddBookCat($cat)
{
	$query = "insert into book_cats (bcDesc) values('$cat')";
	return uquery($query);
}
function IncBook($bid)
{
	$query = "update books set bookCount=bookCount+1 where bookId=$bid";
	return uquery($query);
}

function ShowCatList($bcats)
{
	if(!$bcats) return;
	echo "<center><div class='frmframe' style='width:230px;'><table class='frmlist' cellspacing='1'>";
	echo "<tr class='frmttl'><td class='msgttl' style='text-align:center;font-weight:bold;'>Категорії книг</td></tr>";
	if(!$bcats) echo "<tr><td class='frmcont'>Категорій не виявлено</td></tr>";
	else foreach($bcats as $v)
	{
		echo "<tr><td class='frmcont'><a style='font-weight:bold;' href=/files/main.php?script=books&bcat={$v['bcId']}> .:".$v['bcDesc'].":. </a></td></tr>";
	}
	echo "</table></div><br>";
}

function GetBookPath($bcid)
{
	global $BOOK_BASE;
	$bc = GetBookCat($bcid); if(!$bc) return "";
	$res = $bc['bcDesc'];
	if($bc['bcPid']) $res = GetBookPath($bc['bcPid'])."/".$res;
	return $BOOK_BASE.$res;
}

function GetShortBookPath($bcid)
{
	global $BOOK_BASE;
	$bc = GetBookCat($bcid); if(!$bc) return "";
	$res = $bc['bcDesc'];
	if($bc['bcPid']) $res = GetShortBookPath($bc['bcPid'])."/".$res;
	return $res;
}

function ShowBooks($bcat = 0)
{
	$books = GetBooks($bcat);
	echo "<center><div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='1'>";
	echo "<tr class='frmttl'><td colspan='2' class='msgttl' style='text-align:center;font-weight:bold;'>/Books/".GetShortBookPath($bcat)."</td></tr>";

	if($books) foreach($books as $f)
	{
		$v = GetBook($f);
		$bn = basename($v['bookPath']);
		if( !strlen($v['bookImage']) ) $v['bookImage'] = "empty.png";
		echo "<tr><td class='frmcont'>";
		echo "<a href=../plugins/books/download.php?bid={$v['bookId']} style='color:magenta;' title='Download'>";
		echo "	<img style='width:150px;' src='/plugins/books/screenshots/{$v['bookImage']}'></a></td>";
		echo "<td class='frmcont'>";		
		echo "	<div style='font-size:11px;padding:5px;'>{$v['bookDesc']}</div>";
		echo "	<div  style='text-align:right;font-size:9px;'>";
		echo "	<a href=../plugins/books/download.php?bid={$v['bookId']} target='actions' style='color:magenta;'>$bn</a>";
		echo "	&nbsp;".ConvertBytes(filesize($v['bookPath']))."&nbsp;[{$v['bookCount']}] </div>";
		echo "</td></tr>";
	}
	else echo "<tr><td class='frmcont'>Книг не виявлено</td></tr>";
	echo "</table></div>";
}

function ShowAddBookDlg($bcat)
{
	echo "<div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='0'><form action=''>";
	echo "<tr class='frmttl'><td class='msgttl' style='text-align:center;font-weight:bold;' colspan='2'>Додати книгу</td></tr>";
	
	echo "<tr><td class='frmcont' style='text-align:center;'><b>Path:</b></td>";
	echo "	<td class='frmcont'><input type='text' name='path' style='width:100%;'></td></tr>";
	echo "<tr><td class='frmcont' style='text-align:center;'><b>Desc:</b></td>";
	echo "	<td class='frmcont'><textarea name='desc' style='background:black;color:white;width:100%;height:130px;'></textarea></td></tr>";
	echo "		<input type=hidden name='bcat' value='$bcat'>";
	echo "<tr><td colspan='2' style='text-align:center;' class='frmcont'><input type=submit value=send></td></tr>";
	echo "</form></table></div>";
}

function ShowAddCatDlg()
{
	echo "<div class='frmframe' style='width:230px;'><table class='frmlist' cellspacing='1'><form action=''>";
	echo "<tr class='frmttl'><td class='msgttl' style='text-align:center;font-weight:bold;'>Додати категорію книг</td></tr>";
	echo "<tr><td class='frmcont' style='text-align:center;'><input type=text name='newcat'> <input type=submit value=send></td></tr>";
	echo "</form></table></div>";
}
?>