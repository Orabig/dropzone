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
	$(function() {
		var totalFiles = 0, completeFiles = 0, files = '';
    var myDropzone = new Dropzone('#my-dropzone', {
      url: "upload.php?username=<?= $_GET['username'] ?>&topic_id=<?= $_GET['topic_id'] ?>",
      clickable: true,
      uploadMultiple: false,
	  maxFiles: 1
    });
    myDropzone.on('addedfile', function(file) {
	console.log("add "+file.name);
      totalFiles += 1;
    }).on('removed file', function (file) {
	console.log("remove");
        totalFiles -= 1;
    }).on('success', function(file, responseText) {
	console.log("success");
      msg = $.parseJSON(responseText);
      $('#my-dropzone').addClass("disabled");
      myDropzone.disable();
	  processingState(msg);
    }).on('complete', function (file) {
	console.log("complete");
      completeFiles += 1;
      if (completeFiles === totalFiles) {}
    })
	})
	</script>

<!--  Step 1 : Dropzone -->
  <div id="my-processing" class="processing" style="display: none;">Processing en cours...</div>
  <script>
  function processingState( msg ) {
    $('#my-processing').show();
	console.log("processing");
	console.log(msg.hash);
  }
  </script>

</body>

</html>