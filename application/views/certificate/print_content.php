<?php 
	if($CourseInfo['course_image'])
		$small_name=base_url().$CourseInfo['course_image'];
	else
		$small_name=base_url().'image/course_image.jpg';
?>
        <div class="layout">	
            <div class="header"></div>
            <div class=" main_space">
                <p class="heading_text">CERTIFICATE OF COMPLETION</p>
                <p class="heading_text_boless"><?php echo $UserInfo['cust_fname'].' '.$UserInfo['cust_lname']; ?></p>
                <p class="heading_text_boless">License #: ND4596</p>
                <p class="heading_text_boless">Total Hours earned : <?php echo $CourseInfo['course_ce_hours']?> hrs</p>
                <p class="heading_text_margin">Reading in the Brain | by Stanislas Dahaene</p>        
                <div class="border_space">
                    <div class="image_holder">
                    	<img src="<?php echo $small_name; ?>" />
                        <?php if($TestPassingInfo) { ?>
                        <p class="heading_text">Date Completed: <?php echo date('m/d/Y',strtotime($TestPassingInfo['test_passing_date'])) ?></p>
                        <?php } ?>
                        <p class="heading_text">Course Description:</p>
                        <div class="book_detail_text"><?php echo $CourseInfo['course_desc']?></div>
                        <div class="clear"></div>  
                    </div>
                </div>
                <div class="clear"></div>      
                <p class="heading_text_margin">The following accreditations apply :</p>
                <div class="book_detail_text">Professional Development Resources is a CPE Accredited Provider with the Commission on Dietetic Registration (Provider #PR001). CPE accreditation does not constitute endorsement by CDR of provider programs or materials. Professional Development Resources is also a provider with the Florida Council of Dietetics and Nutrition (Provider #50-1635-5).</div>      
                <?php if($AuthourInfo){ ?>  
                <div class="sign"></div>
                <p class="book_detail_text"><?php echo $AuthourInfo['author_fname'].' '.$AuthourInfo['author_lname'] ?>, <?php echo $AuthourInfo['author_title'] ?></p>
                <p class="book_detail_text">Professional Development Resources</p>
                <p class="book_detail_text">PO Box 550659</p>
                <p class="book_detail_text">Jacksonville, FL 32255</p>
                <p class="book_detail_text">800-979-9899</p>        
                <?php } ?>
            </div>            
        </div>   
        <script type="text/javascript">
			window.onload(
				window.print() 
			);
        </script> 
    </body>
</html>
