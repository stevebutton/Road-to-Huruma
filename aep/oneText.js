/**
	Ajax Extensible Page - (c) 2007 Denis Sureau
	http://ajax.xul.fr
	Version 1.2.
*/

/**
	A script to change the text of a link
	and call a function according to each content.
*/	


var textDevelop = "Develop";
var textSummarize = "Summarize";
function switchText(element)
{
	var d = textDevelop.length;
	var s = textSummarize.length;
	
	var content = element.firstChild.data;

	if(content == textDevelop)
	{		
		element.firstChild.data = textSummarize;
		develop();
		return;				
	}
	if(content == textSummarize)
	{
		element.firstChild.data = textDevelop;
		summarize();
		return;				
	}
}
	