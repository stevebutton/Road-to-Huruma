	/*
	This file is part of YAPB Bulk Uploader.

    'YAPB Bulk Uploader' is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    'YAPB Bulk Uploader' is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with 'YAPB Bulk Uploader'.  If not, see <http://www.gnu.org/licenses/>.
	
	Note that this software makes use of other libraries that are published under their own
	license. This program in no way tends to violate the licenses under which these 
	libraries are published.
	
	*/

var ybu_swfu;

function ybu_cancel(fileid)
{
	var file = ybu_swfu.getFile(fileid);
	
	if(file.filestatus == SWFUpload.FILE_STATUS.IN_PROGRESS)
	{
		//stop upload
		ybu_swfu.stopUpload();
	}
	else if(file.filestatus == SWFUpload.FILE_STATUS.QUEUED)
	{
		//cancel upload
		ybu_swfu.cancelUpload(fileid, true);
	}
}

function ybu_fileDialogComplete(num_files_queued) 
{
	ybu_swfu.startUpload();
}

function ybu_fileQueued(file)
{

	//show progress list
	var progressDiv = document.getElementById("ybu_progress");
	progressDiv.style.visibility = "visible";
	
	//get progress list en done element
	var progressElem = document.getElementById("ybu_progress_list");
	var doneDiv = document.getElementById("ybu_done");

	//check if previous upload is finished 
	if(doneDiv.style.visibility == "visible")
	{
		//hide done div
		doneDiv.style.visibility = "hidden";
		
		//clear old files from list
		progressElem.innerHTML = ""; 
	}

	//Add file to progress list	
	var liElem = document.createElement("LI");
	liElem.id = "ybu_file_"+file.id;
	liElem.className = "ybu_file";
	
	var pElem = document.createElement("P");
	pElem.innerHTML = file.name + " (pending, <a href='javascript:ybu_cancel(\""+file.id+"\")'>cancel</a>)";
	liElem.appendChild(pElem);
	
	var divElem = document.createElement("DIV");
	divElem.id = "ybu_file_progress_"+file.id;
	divElem.className = "ybu_file_progress";
	liElem.appendChild(divElem);

	progressElem.appendChild(liElem);
}

function ybu_fileQueueError(file, error_code, message) 
{
	var msg;
	switch (error_code) 
	{
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			msg = "Too many file are queued for upload. You may upload up to " + message + "files.";
			break;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			msg = "The file "+ file.name + " is too big. You may upload files up to "+  ybu_swfu.settings.file_size_limit;
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			msg = "The file " + file.name + " is zero bytes. Files must be a bit bigger...";
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			msg = "The file " + file.name + " is of an incorrect type. Accepted types are " + ybu_swfu.settings.file_types;
			break;
		default:
			msg = "Unknown file queue error ("+error_code+")for "+file.name + ": " + message;
			break;
	}
	
	window.status = msg;
	window.alert(msg);
}


function ybu_uploadStart(file)
{
	//alert("starting: "+file.name);

	//get form values
	var exifdate = document.getElementById("ybu_exifdate").checked ? 1 : 0;
	var iptc = document.getElementById("ybu_iptc").checked ? 1 : 0;
	var categories = document.getElementById("ybu_category");
	var status = document.getElementById("ybu_post_status").value;
	
	//get datetime value
	var yy = document.getElementById("ybu_yy").value;
	var mm = document.getElementById("ybu_mm").value;
	var dd = document.getElementById("ybu_dd").value;
	var hh = document.getElementById("ybu_hh").value;
	var mn = document.getElementById("ybu_mn").value;
	var ss = document.getElementById("ybu_ss").value;
	var date = ""+yy+"-"+mm+"-"+dd+" "+hh+":"+mn+":"+ss;
	
	//add post params
	ybu_swfu.addFileParam(file.id, "post_title", file.name.replace("_"," "));
	ybu_swfu.addFileParam(file.id, "exifdate", exifdate);
	ybu_swfu.addFileParam(file.id, "post_status", status);
	ybu_swfu.addFileParam(file.id, "ybu_iptc", iptc);
	
	//add date only if not using exifdate
	if(!exifdate)
		ybu_swfu.addFileParam(file.id, "post_date", date); 
	
	//get all selected categories
	var selected = Array();
	for (var i = 0; i < categories.options.length; i++) 
	   if (categories.options[i].selected)
		   selected.push(categories.options[i].value);
	
	ybu_swfu.addFileParam(file.id, "post_category", selected.join(","));
	 
	//ybu_swfu.addFileParam(file.id, "filesize", file.size);

	return true;
}

function ybu_uploadProgress(file, complete, total)
{
	var done = Math.round(complete / total * 100);
	
	var msg = "";
	if(done>=100)
		msg = file.name + " (crunching...)";
	else
		msg = file.name + " ("+done+"%, <a href='javascript:ybu_cancel(\""+file.id+"\")'>stop!</a>)";

	var progressDiv = document.getElementById("ybu_file_progress_"+file.id);
	progressDiv.style.width = "" + done +"%";
	progressDiv.innerHTML = "<p>"+msg+"</p>";

	var progressLi = document.getElementById("ybu_file_"+file.id);
	var progressP = progressLi.getElementsByTagName("p")[0];
	progressP.innerHTML = msg;
}

function ybu_uploadSuccess(file, serverData)
{
	//clear string in file element
	var progressLi = document.getElementById("ybu_file_"+file.id);
	var progressP = progressLi.getElementsByTagName("P")[0];
	var progressDiv = document.getElementById("ybu_file_progress_"+file.id);
	progressDiv.style.width = "100%";

	//set correct text and style in progress overlay 
	var msg = " ";
	if(serverData.substr(0,4)=="Err:")
	{
		//error
		progressDiv.className = "ybu_error";
		msg = file.name + " ("+serverData.substring(5)+")";
	}
	else
	{
		//success
		progressDiv.className = "ybu_done";
		msg = file.name + " ("+serverData+")";
	}
	
	//display message
	progressDiv.innerHTML = "<p>"+msg+"</p>";
	progressP.innerHTML = msg;

}

function ybu_uploadError(file, error_code, message)
{
	//alert("Error: "+message);
	var msg;
	var removeItem = false;
	switch (error_code) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			if(message==403)
				msg = "Authentication Error";
			else
				msg = "HTTP Error "+message;
			
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			msg = "Upload failed: "+message;
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			msg = "IO Error: "+message;
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			msg = "Security Error: "+message;
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			msg = "Upload Size Limit Exceeded: "+message;
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			msg = "Failed Validation: "+message;
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			msg = "Upload Cancelled";
			break;                 
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			msg = "Upload Stopped";
			break;
		default:
			msg = "Unknown Error("+error_code + "): " + message;
			break;
	} 
	
	//show error
	var progressLi = document.getElementById("ybu_file_"+file.id);
	var progressP = progressLi.getElementsByTagName("P")[0];
	progressP.innerHTML = file.name + " ("+msg+")";

	//show error in progress overlay
	var progressDiv = document.getElementById("ybu_file_progress_"+file.id);
	progressDiv.className = "ybu_error";
	progressDiv.style.width = "100%";
	progressDiv.innerHTML = "<p>"+file.name + " ("+msg+")</p>";
}

function ybu_uploadComplete(file)
{
	
	var stats = ybu_swfu.getStats();
	//alert(stats.files_queued);
	
	if(stats.files_queued > 0)
	{
		//next upload
		ybu_swfu.startUpload();
	}
	else
	{
		//show done
		var doneDiv = document.getElementById("ybu_done");
		doneDiv.style.visibility = "visible";
	}
}
