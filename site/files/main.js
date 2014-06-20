var cHeight = 0;
var content = null;
var out_content = "";
var posX = 0; posY = 0;

function fDate(date)
{
	return '['+date.substr(11,8)+']';
}
function update()
{
	content = parent.chat.document.getElementById('content');
	// convert content to NM array, each elements to MESS array and addind his to parent.msgs array
	nm = content.innerHTML.split('¦');
	
	if(content.innerHTML.length > 0) for(i in nm) parent.msgs.push(nm[i]);
	// output
	out_content = ""; var i, len=0, x=0;
	len = parent.msgs.length;

	for(i=0; i<len-26; i++) parent.msgs.shift();
	for(i in parent.msgs) 
	{ 
			var ea = parent.msgs[i].split('•'); var num = ea[0];
			out_content += "<tr><td style='color:grey;width:91px;'>"+fDate(ea[3])+" </td><td style='font-weight:bold;width:100px;color:magenta;'>";
			out_content += ea[2]+"</td><td style='color:yellow;'>"+ea[4]+" </td></tr>";
	}
	
	num = parent.msgs.length-1;	lm = parent.msgs[num]; lma = lm.split('•');	parent.llm = lma[0];
	parent.main.document.send.llm.value = lma[0];
	
	var ins = parent.main.document.getElementById('ins');
	ins.innerHTML = "<table style='width:100%;font-size:12px;'>" + out_content + "</table>";
}

function ShowChat()
{
	var el = parent.main.document.getElementById('chat');
		el.style.visibility = '';
		el.style.width = 767;
		el.style.height = 520;
		if(posX == 0 && posY == 0) { posX = el.style.left; posY = el.style.top; }
		el.style.top = 30;
		el.style.left = posX;
	parent.chat.document.location.href='../chat/addchatmsg.php?llm='+parent.llm;
	if(parent.timer) clearInterval(parent.timer);
	parent.timer = window.setInterval("parent.chat.document.location.href='../chat/addchatmsg.php?llm='+parent.llm", 3000);
}

function x()
{
	clearInterval(parent.timer);
	var el = parent.main.document.getElementById('chat');
	el.style.visibility="hidden";

	parent.actions.document.location.href="../chat/close.php";
}

function ShowVideo(url)
{
	var el = parent.main.document.getElementById('video');
	el.style.visibility='';
	el.style.top= (window.outerHeight-400)/4;
	el.style.left = (window.outerWidth-640)/2;	
	el.style.width = 640;
	el.style.height = 410;
	parent.actions.document.location.href='../chat/showvideo.php?url='+url;	
}

function closevid()
{
	var el = document.getElementById('video');
	el.style.visibility="hidden";
	parent.main.document.location.reload();
}

function load(file, target) { $("#"+target).load(file); }