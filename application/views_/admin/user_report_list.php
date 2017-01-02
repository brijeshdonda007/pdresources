<!--Start [ Root Link ]-->
<div class="root_address">
  <a href="<?php echo site_url('admin/admin/dashboard'); ?>" class="root_link">Admin Panel</a>
  <span class="root_vr">/</span><span class="root_link_remove">User Report List</span>
  <div class="clear"></div>
</div>
<!--End [ Root Link ]-->


<div class="page">
    
  <!--Start [ Right Nav ]-->
  <div class="right_nav" style="width:98%">
  
  	<!--Start [ Right Nav Part 1 ]-->
    <div class="page_title">User Report List</div>

     <form name="search_form" id="search_form" action="<?php echo site_url('admin/report/user_report'); ?>" method="post">
        <div class="page_btn_space_left" style="350px;">
          <input type="button" class="btn_search" name="btn_search" id="search_btn" />
          <input type="text" value="<?php echo $search['searchText'] ?>" name="searchText" class="input_search" />
		</div>
        <div style="float:left; margin:8px 0 0 10px;">Games : <?php echo form_dropdown('game_id',$GameDrop,set_value('game_id',$search['game_id'])," id='cp_id' style='width:100px'"); ?></div>
        <div style="float:left; margin:8px 0 0 10px;">Date : <?php echo form_dropdown('dateOption',$dateDrop,set_value('dateOption',$search['dateOption'])," id='dateOption' style='width:86px;' onchange='javascript:getDateOption(this.value);'"); ?></div>
		<div style="float:left; margin:8px 0 0 10px;" id="dateCustom">
        	From : <input type="text" name="startDate" id="startDate" value="<?php echo $search['startDate']; ?>" style="width:75px;" /> &nbsp;&nbsp;&nbsp;
            To : <input type="text" name="endDate" id="endDate" value="<?php echo $search['endDate']; ?>" style="width:75px;" />
        </div>
		<div style="float: left; margin: 5px 0pt 0pt 10px;"><input type="submit" value="Go" style="padding: 1px 3px;"></div>
     </form>
    <!--End [ Right Nav Part 1 ]-->
    
	<!--Start [ Right Nav Part 2 ]-->
    <form name="delete_form" id="delete_form" action="<?php echo site_url('admin/game_report/deleteUser'); ?>" method="post" onsubmit="return giveNotation();" >
     
     <div class="clear"></div>
     
      <table cellpadding="0" cellspacing="0" border="0" class="page_table">
          <thead class="table_header">
              <tr class="page_table_head">
                  <th width="1%"> No.</th>
                  <th width="7%"> User Name </th>
                  <th width="23%" > No. of times played </th>
              </tr>
          </thead>
          
          <tbody class="table_body">
          <?php
		  	  $i = 1;
              foreach($listArr as $list) {
              echo '<tr id="row_'.$list['id'].'">';
              echo '<td>'.$i.'</td>';
              echo '<td>'.$list['user_name'].'</td>';
              echo '<td>'.$list['userCount'].'</td>';
			  
              echo '</tr>';
			  $i++;
            }
			if(count($listArr) == 0)
				echo "<tr align='center'><td colspan='5'>No Records Found</td></tr>";
          ?>
          </tbody>
      </table>
    </form>
    <!--Start [ Right Nav Part 2 ]-->
    
    <!--Start [ Right Nav Part 3 ]-->
    <div id="pager" class="pager">
    <form name="paging_form" action="" method="post">
       <?php echo $links; ?>
       <?php echo form_dropdown('per_page',$per_page_drop,set_value('per_page',$this->session->userdata('per_page')),' class="pagesize" id="pageValue" onchange="javascript:updatePerPage(this.value);"'); ?>
    </form>
    <div class="clear"></div>
    </div>
    <!--End [ Right Nav Part 3 ]-->

  </div>
  <!--End [ Right Nav ]-->
  
  <div class="clear"></div>
</div>

<script type="text/javascript">
$('#search_btn').click(function() {  $('#search_form').submit();  });

	$(function(){
		$("#startDate").datepicker({changeMonth: true,changeYear: true,showOn: 'button',buttonImageOnly: true,buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
		$("#endDate").datepicker({changeMonth: true,changeYear: true,showOn: 'button',buttonImageOnly: true,buttonImage: '<?php echo base_url(); ?>js/calendar/images/calendar.gif',showAnim: 'fadeIn'});
	});
	
	function getDateOption(dateOption)
	{
		if(dateOption != "Custom")
			$('#dateCustom').css('display','none');
		else
			$('#dateCustom').css('display','block');
	}
	getDateOption($('#dateOption').val());
</script>