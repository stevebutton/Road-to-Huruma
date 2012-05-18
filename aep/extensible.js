/**
	Ajax Extensible Page - (c) 2007 Denis Sureau
	http://ajax.xul.fr
	Version 1.2.
*/


/**
	A framework to make web pages that are expanded at users request,
	from data hidden in the same page or taken from external files.
	Free and open source under the GNU GPL 2.0 licence.
	
	Usage: 
	Include this JavaScript file into the head section of your page. Read the manual for details.
	You can shorten this code by removing the comments but the copyright notive above.
*/	


function createXHR() 
{
    var request = false;
        try {
            request = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) {
            try {
                request = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (err3) {
				try {
				request = new XMLHttpRequest();
				}
				catch (err1) 
				{
					request = false;
				}
            }
        }
    return request;
}

function read(url, fun, element)
{ 
	var xhr=createXHR();

	xhr.open("GET", url, true);
	xhr.onreadystatechange=function()
	{ 
		if(xhr.readyState == 4)
		{
			var content = xhr.responseText;	
			fun(content, element);
		} 
	}; 

	xhr.send(null); 

} 


// Expand / Collapse a single object

function fileCallback(source, element)
{
	element.innerHTML = source;	// set the new content or cross
}

/**
	This function swaps the hidden text with the displayed one.
*/

function quietVerbose(element)
{
	var container = element.getAttribute("name");

	if(container == null || container.length == 0)
	{
		container = element.getAttribute("title");

		if(container == null || container.length == 0) 
		{
			container = element.getAttribute("src");
			if(container == null || container.length == 0) return;
			element.setAttribute("title", element.innerHTML);	// save content into title
			// loading an external text file and assign content into current element
			read(container, fileCallback, element);		// call Ajax to retrieve the file.
			return;
		}	
		
		var y = element.innerHTML;	// get shown text
		element.innerHTML = container;		// show hidden text
		element.setAttribute("title", y);	// save previously displayed text

	}

	var x = document.getElementById(container).innerHTML;	// get hidden text
	var y = element.innerHTML;	// get shown text

	element.innerHTML = x;		// show hidden text
	document.getElementById(container).innerHTML = y;	// save previously displayed text
}


/**
	Summarize a single element
*/	


function doQuiet(element)	// target is large, small is hidden
{
	var small = element.getAttribute('name');	// collapsed is hidden
	if(small == null || small.length == 0) 
	{
		container = element.getAttribute("title");	
		if(container == null || container.length == 0) return;
		var y = element.innerHTML;	// get shown text
		if(container.length > y.length) return; 
		element.innerHTML = container;		// show hidden text
		element.setAttribute("title", y);	// save previously displayed text
		return;
	}	

	var largeText = element.innerHTML;	// get large text displayed
	var smallText = document.getElementById(small).innerHTML;	// get small text hidden

	if(smallText.length > largeText.length) return;	// hidden text must be smaller than displayed

	document.getElementById(small).innerHTML = largeText;	// hide
	element.innerHTML = smallText;	// display

}


/**
	Develop a single element
*/	

function doVerbose(element)
{
	var largeID = element.getAttribute('name');	// the hidden larger text to display

	if(largeID == null || largeID.length == 0)
	{
		var content = element.getAttribute('title');
		if(content != null && content.length != 0)
		{
			// already loaded
			var x = element.innerHTML;	// get current content
			if(x.length > content.length) return; // current must be smaller
			element.innerHTML = content;
			element.setAttribute("title", x);
			return;
		}
		
		// Loading a file, saving current content into an attribute and replacing it by the content of the file
		var url = element.getAttribute('src');
		if(url == null || url.length == 0) return;
		element.setAttribute("title", element.innerHTML);	// save content into title
		// loading an external text file and assign content into current element
		read(url, fileCallback, element);		// call Ajax to retrieve the file.
		return;
	}	

	var smaller = element.innerHTML;	// currently displayed
	var larger = document.getElementById(largeID).innerHTML;	// is hidden and must be displayed

	if(smaller.length > larger.length) return;	// already developed, ignore

	element.innerHTML = larger;	// display big text
	document.getElementById(largeID).innerHTML = smaller;		// hide small text
}

/**
	Develop the whole page
*/	

function develop()
{
	var content;
	var list = document.getElementsByTagName("span");

	for(i = 0;  i < list.length;  i++)
	{
		var element = list.item(i);
		var id = element.getAttribute("id");		// not all span tags are processed
		if(id != null && id.length > 0) 
		{
			doVerbose(element);
		}	
	}
}


/**
	Summarize the whole page
*/	

function summarize()
{
	var content;
	var list = document.getElementsByTagName("span");

	for(i = 0;  i < list.length;  i++)
	{
		var element = list.item(i);
		var id = element.getAttribute('id');
		if(id != null && id.length > 0) 
		{
			doQuiet(element);
		}	
	}
}



