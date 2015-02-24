<?
## delete tag srom string
function DelTags($text)
{
	return preg_replace('|\<.*?\>(.*?)\<.*?\>|ixs','$1', $text);
}
############# TAGS #######################
## function used by function change ling tag	
function ATagCallback($p) 
{
	$href = DelXSS($p[1]);
	return " <a href=\"$href\" target=_blank>тут</a>";
}

## function change A tag to html <a>
function SetATag($text) 
{
	return preg_replace_callback('|\[a\](.*?)\[/a\]|ixs', 'ATagCallback', $text);
}

## function used by function change ling tag	
function URLTagCallback($p) 
{
	$href = trim( DelXSS($p[1]) );
	$link_name = trim( DelXSS($p[2]) );
	return " <a href=\"$href\" target=_blank title=\"$href\">$link_name</a>";
}

## function change A tag to html 
function SetURLTag($text) 
{
	return preg_replace_callback('|\[url (.*?)\](.*?)\[/url\]|ixs', 'URLTagCallback', $text);
}

## function set image tag
function SetImageTag($text) {
	return preg_replace('|\[img\](.*?)\[/img\]|ixs','<img src=$1>', $text);
}
## set all html tags
function SetHTMLTags(&$t)
{
	$tags = Array('h1','h2','h3','h4','b','i','table','td','tr','th','li');
	foreach($tags as $v) $t = preg_replace('|\['.$v.'\](.*?)\[/'.$v.'\]|ixs','<'.$v.'>$1</'.$v.'>', $t);
	$stags = Array('br','hr');
	foreach($stags as $v) $t = preg_replace('|\['.$v.'\]|ixs','<'.$v.'>', $t);
	return $t;
}
## set justify
function SetAlignTags(&$t)
{
	$colors = Array('center'=>'jc','left'=>'jl','right'=>'jr','justify'=>'jj');
	foreach($colors as $k=>$v) $t = preg_replace('|\['.$k.'](.*?)\[/'.$k.'\]|ixs','<div class='.$v.'>$1</div>', $t);
	return $t;
}

## set panel tag callback
function SetPanelTagCallback( $p ) 
{
	static $selId = 0;
	$rnd = rand( 100, 999 );
	$res = '<span id="sel'.$selId.$rnd.'" onclick="selectText(\\\'sel'.$selId.$rnd.'\\\')" class="panel">'.$p[1].'</span>';
	$selId++;
	return $res;
}


## set panel tag
function SetPanelTag( &$t )
{
	$t = preg_replace_callback('|\[p](.*?)\[/p\]|ixs', "SetPanelTagCallback", $t);
	return $t;
}

## set colors
function SetColorTags(&$t)
{
	$colors = Array('y'=>'yc','q'=>'quote','gc'=>'gc','g'=>'gc','r'=>'rc','o'=>'oc','m'=>'quote');
	foreach($colors as $k=>$v) $t = preg_replace('|\['.$k.'](.*?)\[/'.$k.'\]|ixs','<span class='.$v.'>$1</span>', $t);
	return $t;
}
## set quote warning tags
function SetQuoteTags(&$t)
{
	$colors = Array('quote'=>'citation');
	foreach($colors as $k=>$v) $t = preg_replace('|\['.$k.'](.*?)\[/'.$k.'\]|ixs','<div class='.$v.'>$1</div>', $t);
	return $t;
}
function BlocksCallBack($p) 
{
	//echo "<script>alert('{$p[0]}');</script>";
	return str_replace("<br>","",$p[0]);
}
## set block tags
function SetBlockTags(&$t)
{
	$tags = Array('console'=>'console','c'=>'code','code'=>'code');
	foreach($tags as $k=>$v) 
	{
		$t = preg_replace_callback('|\['.$k.'](.*?)\[/'.$k.'\]|ixs', "BlocksCallBack", $t);
		$t = preg_replace('|\['.$k.'](.*?)\[/'.$k.'\]|ixs','<pre class='.$v.'>$1</pre>', $t);
	}
	return $t;
}

## function used by function change ling tag	
function hrefCallBack($p) 
{
	$name = htmlspecialchars($p[0]);
	$href = !empty($p[1]) ? $name : "http://$name";
	DelXSS($href);
	return " <a href=\"$href\" target=_blank>$name</a>";
}

## function change LINK tag to html div
function HrefActivate($text) 
{
	return preg_replace_callback('{\s(?:(\w+://)|www\.)[\w-]+(\.[\w-]+)*(?: : \d+)?[^<>"\'()\[\]\s]*(?:(?<![[:punct:]])|(?<=[-/&+*]))}xis',"hrefCallback", $text);
}
## function change email adress to html div
function emailActivate($text) 
{
	return preg_replace('{\s[\w-.]+@[\w-]+(\.[\w-]+)*}xs','<a href="mailto:$0">$0</a>', $text);
}
## function prepare smile
function SetSmiles(&$text) 
{
	for($i=1;$i<99;$i++) $text = str_replace(" :".$i.": ", " <img src=/img/".$i.".gif> ", $text);
	return $text;
}

################ LANGUAGE ######################
## function used by function change C/C++ tag 
function LangCallBack($p) 
{
	$text =  str_replace("<br>","",$p[2]);
	return "<pre class=\"brush: ".$p[1]."\">$text</pre>";	
}
## function change C++ tag to html div
function SetLangTags($text) 
{
	global $langs;
	foreach($langs as $l) $text = preg_replace_callback('|\[('.$l.')\](.*?)\[/'.$l.'\]|ixs',"LangCallBack", $text);
	return $text;
}
##
function IsHexDec( $ch )
{
	$bResult = false;
	$symbols = "0123456789abcdefABCDEF";
	$sym_len = strlen( $symbols );
	for( $i = 0; $i < $sym_len; ++$i )
		if( $ch == $symbols[$i] )
		{
			$bResult = true;
			break;
		}
	return $bResult;
}
function CheckColor( $color )
{
	$bResult = false;
	do
	{
		if( $color[0] != '#' ) break;
		if( strlen($color) != 7 ) break;
		
		if( !IsHexDec($color[1]) || !IsHexDec($color[2]) || !IsHexDec($color[3]) || 
			!IsHexDec($color[4]) || !IsHexDec($color[5]) || !IsHexDec($color[6]) )
		break;		
		 
		$bResult = true;
	}
	while( false );
	return $bResult;
}
function ColorCallBack( $p )
{
	if( !CheckColor($p[1]) ) return $p[2];
	return "<span style=\"color:{$p[1]}\">{$p[2]}</span>";
}
function SetColor( &$text )
{
	$text = preg_replace_callback('|\[color=(\#.*?)\](.*?)\[/color\]|ixs',"ColorCallBack", $text);
	return $text;
}

################ HIDE ######################
## SetHTAg callback
function tagHCallback($p)
{
	$ts = trim(date('s').rand(1,1000));
	$pts = $ts-1;
	return "<table><tr onclick=SH($ts) class=precode><td id=$pts>[+] View</td></tr><tr id=$ts style=\'display:none;\'><td class=msg>{$p[1]}</td></tr></table>";
}
## function change h tag to html div
function SetHTag($text) 
{
	//$text =  " ".str_replace("<br>","\n",$text);	
	return preg_replace_callback("|\[h\](.*?)\[/h\]|ixs","tagHCallback", $text);
}

################ VIDEO ######################
## function used by function change video tag
function videoCallBack($p) 
{
	$url = $p[1];
	return '<iframe width="1040" height="620" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
	//return "<a onClick=\"javascript:ShowVideo(\'$url\');\" target=_blank style=\'color:yellow;\'>Watch</a>";
	//return '<object style="height: 688px; width: 850px"><param name="movie" value="'.$url.'"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="'.$url.'" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="850" height="688"></object>';
	//return '<embed src="'.$url.'" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="850" height="688">';
}
## function change VIDEO tag to html div
function SetVideoTag($text) 
{
	return preg_replace_callback('|\[video\](.*?)\[/video\]|ixs',"videoCallback", $text);
}

############### MAIN ######################
## CONVERT ALL TAGS
function PrepareMsg($text)
{
# spec symvols
	$text = str_replace("<","&lt;",$text);
	$text = str_replace(">","&gt;",$text);
	//$text = str_replace('"',"&quot;",$text);
	$text = preg_replace("'(\r\n)'si","<br>\\1", $text);	
# link & mail
	$text = HrefActivate($text);
	$text = emailActivate($text);
	$text = SetATag($text);
	$text = SetURLTag( $text );
# HTML tags
	SetHTMLTags($text);
	SetColorTags($text);
	SetColor( $text );
	SetBlockTags($text);
	SetQuoteTags($text);
	SetPanelTag(&$text);
#text-align
	SetAlignTags(&$text);
# languages tags
	$text = SetLangTags($text);
# other tags	
	$text = SetImageTag($text);
	$text = SetVideoTag($text);
	$text = SetHTag($text);
	SetSmiles($text);
	
	$text = str_replace("</div><br>","</div>",$text);
	$text = str_replace("<br>\r\n<pre ","\r\n<pre ",$text);
	$text = str_replace("</pre><br>","</pre>",$text);
	$text = str_replace("</li><br>\r\n<li>","</li><li>",$text);
	$text = str_replace("</tr><br>","</tr>",$text);
		
	return $text;
}
?>
