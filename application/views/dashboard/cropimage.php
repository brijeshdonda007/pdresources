<html>
    <head>
        <!--File css and js-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/default.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.Jcrop.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.Jcrop.css" />
        <script language="javascript" type="text/javascript">
			var bounds;
			var jcrop_api;
			var flag;
			$(document).ready(function(e) {                					
				parent.$(".dashboard_iframe_class").attr("style", 'width:533px;height:517px;display:block;');
				parent.setOverlayPos();				
				<?php if($flag) { ?>
					bindCropper2();
				<?php } 
				      else { ?>
					bindCropper();
				<?php } ?>
				$('#image_cropper_popup #scale_image_fix').off('click').on('click',function() {
						if ($('#scale_image_fix').attr('checked')) 
						{
							flag=1;		
						}
						else
						{
							flag=0;
						}
						//var flag=$('#scale_image_fix').val();
						document.location='<?php echo site_url('dashboard/CropImage'); ?>'+'/'+flag;
					});

            });															
			
			function bindCropper()
			{
				$('.cropbox2').addClass('display');
				$('.cropbox').removeClass('display');
				$('#cropbox').Jcrop({
					onRelease: updateCoords,
					onChange: updatePreview,
					onSelect: updatePreview,
					},
					function(){							
						jcrop_api = this;
						jcrop_api.animateTo([50,50,300,300]);							
						// Setup and dipslay the interface for "enabled"
						jcrop_api.setOptions({ allowResize: false,allowSelect: false });
						bounds = this.getBounds();
						boundx = bounds[0];
						boundy = bounds[1];																	
					});				
			}	
					
			function bindCropper2()
			{
				$('.cropbox').addClass('display');
				$('.cropbox2').removeClass('display');							
				$('#cropbox2').Jcrop({
					onRelease: updateCoords,
					onChange: updatePreview,
					onSelect: updatePreview,
					},
				function(){							
						jcrop_api = this;
						jcrop_api.animateTo([50,50,300,300]);							
						// Setup and dipslay the interface for "enabled"
						jcrop_api.setOptions({ allowResize: false,allowSelect: false });
						bounds = this.getBounds();
						boundx = bounds[0];
						boundy = bounds[1];							
					});												
			}

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};
			
			function updatePreview(c)
			{
				if (parseInt(c.w) > 0)
				{
					var rx = 100 / c.w;
					var ry = 100 / c.h;				
					$('#preview').css({
						width: Math.round(rx * boundx) + 'px',
						height: Math.round(ry * boundy) + 'px',
						marginLeft: '-' + Math.round(rx * c.x) + 'px',
						marginTop: '-' + Math.round(ry * c.y) + 'px'
					});
					updateCoords(c);
				}
			};
			
			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};			
		</script>
    <style type="text/css">
/*		height:294px !important;
		width:231px !important;
*/		.resize_image_apply{
			height:400px !important;
			width:400px !important;
			overflow:hidden !important;
		}
		.display{
			display:none !important;
		}
    </style>    
    </head>    
    <body>
    	<?php 
			if($UserInfo['cust_avatar'])
				$small_name=base_url().$UserInfo['cust_avatar'];
			else
				$small_name=base_url().'images/user_default_logo.png';
		?>
        <!--popup start]-->
        <div class="up_profile_space" id="upload_profile" >            
            <div class="up_profile_inner" id="image_cropper_popup" style="width:530px; height:515px;">
                <div class="popup_header" style="width:100%;">Crop Image</div>
                    <!-- This is the image we're attaching Jcrop to -->
                    <div style="padding:10px;">
                        <div style="float:left;height:400px;width:400px;overflow:auto;" class="cropbox">
                        	<img src="<?php echo $small_name;?>" id="cropbox"/>
                        </div>            
                        <div style="float:left;height:400px;width:400px;overflow:auto;" class="cropbox2">
                        	<img src="<?php echo $small_name;?>" id="cropbox2" height="400" width="400"/>
                        </div>            
                        <div style="float: left;height: 100px;margin: 10px auto auto 10px;overflow: hidden;width: 100px;">
                            <img src="<?php echo $small_name; ?>" id="preview" alt="Preview" class="jcrop-preview" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!-- This is the form that our event handler fills -->
                    <form action="<?php echo site_url('dashboard/SaveCropImage'); ?>" method="post" onSubmit="return checkCoords();">
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />
                        <input type="submit" class="submit_btn" style="margin-left:200px;" value="" />
                        <label><input type="checkbox" id="scale_image_fix" name="scale_image_fix" value="1" <?php if($flag) echo 'checked'; ?> />Scale to fit.</label>
                    </form>                    
              </div>
        </div>
        <!--popup end]-->
    </body>
</html>
