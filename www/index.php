<html>

<head>
	<link rel="stylesheet" href="css/dropzone.css">
	<link rel="stylesheet" href="css/processing.css">
</head>

<body id="bd">

  <h1>Drag-drop-upload-processing demo</h1>

<!--  Step 1 : Dropzone -->

  <div id="my-dropzone" class="dropzone"></div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="dropzone.js"></script>
	<script>
	var myDropzone;
	
	function resetProcessState() {
		$("#plog").html('');
		$('#my-processing').hide();
	}
	function goProcessState() {
      $('#my-dropzone').addClass("disabled");
      myDropzone.disable();
    }
	function stopProcessState() {
      $('#my-dropzone').removeClass("disabled");
	  myDropzone.removeAllFiles();
      myDropzone.enable();
    }
	
	$(function() {
		var totalFiles = 0, completeFiles = 0, files = '';
    myDropzone = new Dropzone('#my-dropzone', {
      url: "upload.php?username=<?= $_GET['username'] ?>&topic_id=<?= $_GET['topic_id'] ?>",
      clickable: true,
      uploadMultiple: false,
	  maxFiles: 1
    });
    myDropzone.on('addedfile', function(file) {
	  resetProcessState();
      totalFiles += 1;
    }).on('removed file', function (file) {
        totalFiles -= 1;
    }).on('success', function(file, responseText) {
      msg = $.parseJSON(responseText);
	  goProcessState();
	  processingState(msg);
    }).on('complete', function (file) {
	console.log("complete");
      completeFiles += 1;
      if (completeFiles === totalFiles) {}
    })
	})
	</script>

<!--  Step 2 : Progression display while process -->

  <div id="my-processing" class="processing" style="display: none;">
	  <pre id="plog">
	  </pre>
  </div>
  <script>
  
var req = false;
function createRequest() {
    req = new XMLHttpRequest();
}

function loadProgress(url) {
    try {
        if (req) { req.abort(); req = false; }

        createRequest();

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
        try {
            ShowProgress(req.response);
        }
        catch (e) { alert(e.message); }
    } else if  (req.readyState == 4) {
		stopProcessState();
	}
}

var lastDelimiterPosition = -1;
function ShowProgress(input) {
    $("#plog").html(input);
}
  
  function processingState( msg ) {
    $('#my-processing').show();
	loadProgress("process.php?hash="+msg.hash);
  }
  </script>

</body>

</html>