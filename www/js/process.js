var myDropzone;

var DROPZONE_ID = '#my-dropzone';
var PROCESS_LOG_ID = '#plog';
var PROCESS_BLOCK_ID = '#my-processing';
	
function resetProcessState() {
	$( PROCESS_LOG_ID ).html('');
	$( PROCESS_BLOCK_ID ).hide();
}
function goProcessState() {
	$( DROPZONE_ID ).addClass("disabled");
	myDropzone.disable();
}
function stopProcessState() {
	$( DROPZONE_ID ).removeClass("disabled");
	myDropzone.removeAllFiles();
	myDropzone.enable();
}

function showProgress(input) {
	$( PROCESS_LOG_ID ).html(input);
}

function processingState( msg ) {
	$( PROCESS_BLOCK_ID ).show();
	loadProgress( "process.php?filename="+msg.filename );
}
  
// STEP 1 : DRAG & DROP
	
$(function() {
    myDropzone = new Dropzone( DROPZONE_ID , {
      url: "upload.php?username=<?= $_GET['username'] ?>",
      clickable: true,
      uploadMultiple: false,
	  maxFiles: 1
    });
    myDropzone.on('addedfile', function(file) {
	  resetProcessState();
    }).on('success', function(file, responseText) {
      msg = $.parseJSON(responseText);
	  goProcessState();
	  processingState(msg);
    })
});
	
// STEP 2 : PROCESS

var req = false;

function loadProgress(url) {
    try {
        if (req) { req.abort(); req = false; }

        req = new XMLHttpRequest();

        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send("");
        }
        else { alert('unable to create request'); }
    }
    catch (e) { alert(e.message); }
}

function processReqChange() {
	// XMLHttpRequest  ::  req.readyState == 
	// 0: request not initialized 
	// 1: server connection established
	// 2: request received 
	// 3: processing request 
	// 4: request finished and response is ready
    if (req.readyState == 3) {
        showProgress(req.response);
    } else if  (req.readyState == 4) {
		stopProcessState();
	}
}
