<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
Hello User you have give <i><u><b><?php echo $completed;?>%</b></u></i> right answer and <i><u><b><?php echo $false;?>%</b></u></i> false answer.

<?php
echo 'Please <a href="'.site_url('test/index/'.$course_id.'/'.$test_id).'">click here</a> to regive the exam';
?> 
</body>
</html>