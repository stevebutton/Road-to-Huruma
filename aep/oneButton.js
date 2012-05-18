/**
	Ajax Extensible Page - (c) 2007 Denis Sureau
	http://ajax.xul.fr
	Version 1.2.
*/

/**
	A script to change the image of a button
	and call a function according to each image.
*/	


var buttonDevelop = "develop.gif";
var buttonSummarize = "summarize.gif";
function switchButton(element)
{
	var d = buttonDevelop.length;
	var s = buttonSummarize.length;
	
	var image = element.firstChild;
	var name = image.getAttribute("src");
	var iname = name.substr(name.length - d, d);

	if(iname == buttonDevelop)
	{		
		image.setAttribute("src", buttonSummarize);
		develop();
		return;				
	}
	iname = name.substr(name.length - s, s);
	if(iname == buttonSummarize)
	{
		image.setAttribute("src", buttonDevelop);
		summarize();
		return;				
	}
}
	
