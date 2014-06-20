<?
	if( !defined('PLUGIN_PATH') || !isset($detId) ) die();
	
	include_once PLUGIN_PATH."files.php";

	$detail = GetItem( $detId ); if( !$detail ) die( "Detail don\'t exists !" );
	$cat = GetCategory( $detail['itCatId'] ); if( !$cat ) die( "Category don\'t exists !" );

	echo "<div style='margin:0px 0px 20px 20px'>";
	
	echo "<a href='$SCRIPT_NAME?$QUERY_STRING' class='nodecor'><h2>{$detail['itName']} &nbsp; [ {$cat['catName']} ] ( {$detail['itCount']} ) </h2></a>";
	echo "<div style='width:100%;text-align:right;'>
			<span style='float:left'>Details : </span>
			<span style='float:right;'>
				<a href='/files/main.php?script=radio&catId={$detail['itCatId']}&editId={$detail['itId']}'>[ edit ]</a>
			</span><BR>
		</div>";
		
	echo "<pre style='font-family: Trebuchet MS;background:#000000;border:solid 1px #000066;padding:10px;'>{$detail['itDesc']} </pre>";

	$files = GetFiles( $detail['itId'] );
	if( $files )
	{
		echo "<b style='color:#0080BF;'>Files : </b> ";
		foreach($files as $f )
		{
			echo "<a href='/plugins/radio/download.php?fid={$f['fileId']}&view=' target='_blank' title='View'>{$f['fileName']}</a>";
			echo " <a href='/plugins/radio/download.php?fid={$f['fileId']}' target='actions' style='text-decoration:none;' title='Download'>
					<img src='/img/download.jpg' style='vertical-align:middle'/></a>";
			
			if( $f != end($files) ) echo ", ";
		}
	}
	
	include_once PLUGIN_PATH."uploadform.php";
	
	
	echo "</div>";
?>