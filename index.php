<html>

<head>
	<link rel="stylesheet" href="css/dropzone.css">
</head>

<body id="bd">
  <div id="my-dropzone" class="dropzone"></div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="dropzone.js"></script>
	<script>
	$(function() {
		var totalFiles = 0, completeFiles = 0, files = '';
    var myDropzone = new Dropzone('#my-dropzone', {
      url: "upload.php?username=<?= $_GET['username'] ?>&topic_id=<?= $_GET['topic_id'] ?>&hashing=<?= $_GET['hashing'] ?>",
      clickable: true,
      uploadMultiple: false
    });
    myDropzone.on('addedfile', function(file) {
      totalFiles += 1;
    }).on('removed file', function (file) {
        totalFiles -= 1;
    }).on('complete', function (file) {
      completeFiles += 1;
      if (completeFiles === totalFiles) {}
    }).on('success', function(file, responseText) {
      msg = $.parseJSON(responseText);
      parent.postMessage(msg, '*');
      $('.dz-success').hide();
    })
	})
	</script>
</body>

</html>