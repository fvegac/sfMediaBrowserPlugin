<?php sfMediaBrowserUtils::loadAssets('list') ?>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
        $("#uploader").pluploadQueue({
		// General settings
		runtimes : 'flash',
		url : '<?php echo url_for('@sf_media_browser_plupload');?>',
		max_file_size : '10mb',
		chunk_size : '1mb',
		unique_names : true,

		// Resize images on clientside if we can
		resize : {width : 320, height : 240, quality : 90},

		// Flash settings
		flash_swf_url : '/sfMediaBrowserPlugin/js/plupload/plupload.flash.swf'
	});



	// Client side form validation
	$('form').submit(function(e) {
		var uploader = $('#uploader').pluploadQueue();

		// Validate number of uploaded files
		if (uploader.total.uploaded == 0) {
			// Files in queue upload them first
			if (uploader.files.length > 0) {
				// When all files are uploaded submit form
				uploader.bind('UploadProgress', function() {
					if (uploader.total.uploaded == uploader.files.length)
						$('form').submit();
				});

				uploader.start();
			} else
				alert('You must at least upload one file.');

			e.preventDefault();
		}
	});
});
</script>

<div id="" style="width:1000px;padding-bottom:0.5em;margin:0 auto;">
    <h3>Se subiran los archivos al directorio <?php echo $dir_upload?></h3>
<form method="post" action="<?php echo url_for('@sf_media_browser_files_create_multi')?>" enctype="multipart/form-data" accept-charset="utf-8">
	<div id="uploader">
	<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
    <input type="hidden" name="dir" id="dir" value="<?php echo $dir_upload?>">
    <input type="submit" value="Guardar">
</form>
</div>