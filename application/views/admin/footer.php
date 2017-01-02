	</div>
  <!--End [ Layout ]-->
</center>

<?php
	$cur_url_parts = explode("/",current_url());

	if(is_numeric(end($cur_url_parts)) && $start != 0)
		$urlToGO = str_replace(end($cur_url_parts),"",current_url());
	else
		$urlToGO = current_url();
?>

<script type="text/javascript">
function updatePerPage(perPage)
{
	$.ajax({
		url: "<?php echo site_url('admin/admin/updatePerPage'); ?>/"+perPage,
		success: function(msg) {
			document.location = "<?php echo $urlToGO; ?>";
		}
	});
}

$(document).ready(function() { $(".page_table").tablesorter({headers: { 0: { sorter: false } } , widthFixed: true , widgets: ['zebra']}); });

function checkAll()
{
	for (var i=0;i<document.delete_form.elements.length;i++)
	{
		var e=document.delete_form.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox'))
		{
			e.checked=document.delete_form.allbox.checked;
		}
	}
	return false;
}

function giveNotation(textToShow)
{
	if(textToShow == null || textToShow == "undefined")
		textToShow = "Please select items to remove.";
		
	var bvm=0;
	for (var i=0;i<document.delete_form.elements.length;i++)
	{
		var e=document.delete_form.elements[i];
		
		if ((e.name != 'allbox') && (e.type=='checkbox') && e.checked)
			bvm++;
	}

	if(bvm == 0)
	{
		alert(textToShow);
		return false;
	}
	else
		return confirm("Are You Sure?");
}
</script>

</body>
</html>