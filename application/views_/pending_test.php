<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pending Test</title>
</head>

<body>
<h1>Welcome <?php
echo $this->session->userdata['userInfo']['cust_name'];
?></h1><br />Following tests are pending for you.To continue for that test please click on the test title <a href="<?php echo site_url('home/index/'); ?>">click here</a> to start new test <br />
<?php
	foreach($result as $key=>$val)
	{
		echo '<a href="'.site_url('home/index/'.$val['course_id'].'/'.$val['test_id'].'/'.$val['current_page_no'].'/'.$val['test_attampt']).'">'.$val['test_name'].'(attempt no. '.$val['test_attampt'].')</a><br>';
	}
?>
</body>
</html>