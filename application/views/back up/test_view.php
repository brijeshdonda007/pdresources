<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" language="javascript">
	function validate_form(test_id,offset)
	{		
		textToShow = "Please select items to remove.";
		//alert(document.getElementsByName('selected[]').length);		
		var length=document.getElementsByName('selected[]').length;
		var flag=true;
		for(i=0;i<length;i++)
		{		
			if(document.getElementById('selected'+i).checked  == true)
			{
				flag=false;
				break;
			}
		}
		if(flag)
			alert('Please select any option for question');
		else
		{
			document.testForm.action ="<?php echo site_url('test/index/0');?>/"+test_id+"/"+offset;
			document.testForm.submit();
		}
	}
</script>
<body>
<h1>Welcome <?php
echo $this->session->userdata['userInfo']['cust_name'];
?></h1><br />
<?php
	if($error)	
		echo $error;
	else
	{
?>
    <form name="testForm" method="post" >
        <div style="width:100%;"><div align="left"><strong>Status:</strong>Exam is <?php echo $completed ?>% completed.</div><div align="center"><a href="<?php echo site_url('test/StopTest/'.$course_id.'/'.$TestInfo['test_id'].'/'.$offset.'/'.$test_attampt);?>">Pause/Breack Test</a></div></div>
        <?php
                if($completed == 100)
                    echo '<a href="'.site_url('test/result/'.$course_id.'/'.$TestInfo['test_id']).'">See Final Result</a>';
    ?>
    
        <?php
            if($prev >=0 && $offset >0)
            {           
        ?>
        <a href="<?php echo site_url('test/index/'.$course_id.'/'.$TestInfo['test_id'].'/'.$prev);?>" title="Previous">Previous</a>
        <?php
            }
        ?>
        <div style="margin-left:300px">
        <h1><?php		
        echo $TestQuestion['question_text'];
        ?></h1>
        <?php
            foreach($TestOptions as $key=>$val)
            {			
                if($cheaked == $val->option_id)
                {				
                    $selected='checked="checked"';
                }
                else
                    $selected='';
                    
                echo '<label><input type="radio" name="selected[]" id="selected'.$key.'" '.$selected.' value="'.$val->option_id.'" />'.$val->option_text.'</label><br>';		
                if($val->is_right_option == 'Yes')
                    echo '<input type="hidden" name="rightOption" value="'.$val->option_id.'" />';
            }
            
        ?>
        <input type="hidden"  name="question_id" value="<?php echo $TestQuestion['question_id'] ?>" />
        <?php
            if($next >0)            
            {
        ?>
            <a href="javascript:void(0);" title="Previous" onclick="javascript:validate_form(<?php echo $TestInfo['test_id']; ?>,<?php echo $next;?>);">Next</a>
         <?php
            }
            else
            {
         ?>
         <a href="javascript:void(0);" title="Previous" onclick="javascript:validate_form(<?php echo $TestInfo['test_id']; ?>,<?php echo $prev=$prev+1;?>);">Complete</a>
         <?php
            }
        ?>
        </div>
    </form>
<?php
	}
?>
</body>
</html>
