/** Basic upload manager for single or multiple files (Safari 4 Compatible)
 * @author  Andrea Giammarchi
 * @blog    WebReflection [webreflection.blogspot.com]
 * @license Mit Style License
 */

var sendFile = 2 * 1024*1024*1024; // maximum allowed file size
// should be smaller or equal to the size accepted in the server for each file

// function to upload a single file via handler
sendFile = (function(toString, maxSize){
    var isFunction = function(Function){
        return  toString.call(Function) === "[object Function]";
    },		
    split = "onabort.onerror.onloadstart.onprogress".split("."),
    length = split.length;
    return  function(handler){
        fileSize =handler.file.fileSize;
        if(fileSize ==undefined){
            fileSize = handler.file.size;
        }
        if(maxSize && maxSize < fileSize){
			
            if(isFunction(handler.onerror))
                handler.onerror();
            return;
        };
        var xhr = new XMLHttpRequest();
    upload = xhr.upload;
    for(i = 0; i < length; i++)
        xhr.upload[split[i]] = (function(event){
            return  function(rpe){
                if(isFunction(handler[event]))
                    handler[event].call(handler,rpe,xhr);
            };
        })(split[i]);

        xhr.onreadystatechange = function(rpe) {
            if ((this.readyState == 4) ) {
                if(isFunction(handler.onload))
                    handler.onload(rpe,this);
            }	
        };
	
        /*		upload.addEventListener("load", 
			function(rpe){			
					
	 */
        //	Access-Control-Request-Headers:Origin, X-Requested-With, Content-Disposition, X-File-Name, Content-Type
        filename = handler.file.fileName;
        if (filename == undefined) filename=handler.file.name;
		
        xhr.open("post", handler.url, true);
        xhr.setRequestHeader("If-Modified-Since", "Mon, 26 Jul 1997 05:00:00 GMT");
        //xhr.setRequestHeader("Origin", "http://mycloud.anka.ws");
        xhr.setRequestHeader("Cache-Control", "no-cache");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader("X-File-Name", filename);
        xhr.setRequestHeader("X-File-Size", fileSize);
        xhr.setRequestHeader("Content-Type", "application/octet-stream");
        xhr.setRequestHeader("Content-Disposition",'attachment,filename="'+filename+'"');
        xhr.send(handler.file);
        return  handler;
    };
})(Object.prototype.toString, sendFile);

// function to upload multiple files via handler
function sendMultipleFiles(handler){
    onload = handler.onload;
    handler.current = 0;
    handler.sent = 0;
    handler.file = UploadList.shift();
    if (handler.file==undefined) return handler;
    sendFile(handler).onload = function(rpe, xhr){
        handler.current++;
        handler.sent += handler.file.fileSize;
        if(xhr.status==200){
            if(onload) {
                handler.onload = onload;
                handler.onload(rpe, xhr);
            }
        }
        handler.file = UploadList.shift();
        if(!(handler.file==undefined)){    
            
            sendFile(handler).onload = arguments.callee;
        }         
    };
    return  handler;
};