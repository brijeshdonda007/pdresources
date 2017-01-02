<!--Srart [ part3 ]-->
<div class="part3">
	<div class="footer_space">
    	<div class="footer_left">
        	<div class="footer_para"><?php $temp=$this->mdl_config->get_allconfig(5); echo $temp['config_description']; ?>.</div>
            <div class="footer_logo_raw">
            	<div class="curly_left"></div>
                <a href="<?php echo site_url(); ?>" class="footer_logo"></a>
                <div class="copy_right_space">
                	<p class="copyright">©2012 Professional Development Resources, Inc. </p>
                    <p class="copyright"><a href="<?php echo site_url('page/index/7'); ?>">Privacy Policy</a> | <a href="<?php echo site_url('page/index/8'); ?>">Terms of Service</a></p>
                </div>
                <div class="curly_right"></div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="footer_right">
        	<div class="bottom_link_column">
            	<?php 
				$page_link=$this->mdl_page->get_page();
			 	if($page_link)
				{
					foreach($page_link as $key=>$val)
					{
						$url=site_url('page/index/'.$val['page_id']);//$val['page_id'];						
						echo '<a href="'.$url.'" class="social_link">'.$val['page_title'].'</a>';
					}
				}
				?>            
                <div class="clear"></div>
            </div>
            <div class="bottom_link_column">
            	<?php 
					$ConfigUrl=$this->mdl_config->getAllUrlConfig();
					if($ConfigUrl)
					{
						foreach($ConfigUrl as $key=>$val)
						{
							$target='';
							if($val['config_description'])
							{
								$url=$val['config_description'];
								$target='target="_blank"';
							}
							else
								$url='javascript:void(0)';
							echo '<a href="'.$url.'" '.$target.' class="social_link">'.$val['config_title'].'</a>';			
						}
					}
				?>            	              
                <div class="clear"></div>
            </div>
            <div class="bottom_link_column" style="width:80px;">
            	<div class="like_btn_space"><div class="fb-like" data-href="<?php echo site_url(); ?>" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false"></div></div>
                <div class="like_btn_space" style="padding-top:5px;">
                	<!-- Place this tag where you want the +1 button to render -->
                    <g:plusone size="medium"></g:plusone>
                    
                    <!-- Place this render call where appropriate -->
                    <script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                </div>
                <div class="like_btn_space"></div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--End [ part3 ]-->
</body>
</html>
