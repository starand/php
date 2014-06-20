		var help_line = {
			b: 'Жирний текст: [b]text[/b]',
			i: 'Похилий текст: [i]text[/i]',
			u: 'Підкреслений текст: [u]text[/u]',
			q: 'Цитата: [quote]text[/quote]',
			c: 'Код: [code]code[/code]',
			p: 'Вставити зображення: [img]http://image_url[/img]',
			w: 'Вставить посилання: [url]http://url[/url] или [url=http://url]URL text[/url]',
			e: 'Список: добавити елемент списку',
			h: 'Вставити горизонтальну лінію',
			con: 'Консольний текст',
			tip: 'Порада: Можна швидко застосовувати стилі до виділеного тексту.'
		}
function helpline(help)
{
	document.forms['send'].helpbox.value = help_line[help];
}
function MarkSelection(mark)
{
	if (document.selection)
	{
		var str = document.selection.createRange();
		if (str.text != "")
		{
			str.text = '['+mark+']'+str.text+'[/'+mark+']';
		}
		else
		{
			alert("Спершу виділіть текст!!");
		}
	}
	else
	{
		alert("Спершу виділіть текст!!");
	}
}
function AddTag(tag) {
	document.send.mMsg.value += ' ['+tag+'] ';
	document.send.mMsg.focus();
}

// Surrounds the selected text with text1 and text2.
function surroundText(text1, text2)
{
	var textarea = document.getElementById('message');
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;

		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;

		if (temp_length == 0)
		{
			caretPos.moveStart("character", -text2.length);
			caretPos.moveEnd("character", -text2.length);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}

	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text1 + selection + text2 + end;

		if (textarea.setSelectionRange)
		{
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}
	
}
