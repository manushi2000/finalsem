<?php
/* This calculator is your for free by Calendarscripts.info. You have no obligations for anything - you can modify, redistribute, sell it or whatever you want to do.
We will appreciate if you don't remove the link at the bottom, but that's not required. */

/* Feel free to modify the CSS and the texts below. - no problem at all. Just don't touch the PHP code or the specual codes which are surrounded with %% unless you know what you are doing. */

/* Version 1.1 released on Nov 7, 2011*/
?>
<style type="text/css">
.calculator_table
{
	font-size:11px;
	font-family:verdana, arial, sans-serif;
	border:2pt solid #4444FF;
	padding:25px;
	width:300px;	
}
</style>
<?php if(!empty($_POST['calculator_ok'])):
	//last cycle date
	$date="$_POST[dateyear]-$_POST[datemonth]-$_POST[dateday]";
	
	//convert to time
	$lasttime=mktime(0,0,0,$_POST['datemonth'],$_POST['dateday'],$_POST['dateyear']);
    
    // next period start
    $next_period=$lasttime + $_POST['days']*24*3600;
    $next_period=date("F d, Y",$next_period);
	
	//first fertile day
	$firstdaytime=$lasttime + $_POST['days']*24*3600 - 16*24*3600;
	$firstday=date("F d, Y",$firstdaytime);
	
	//last fertile day
	$lastdaytime=$lasttime + $_POST['days']*24*3600 - 12*24*3600;
	$lastday=date("F d, Y",$lastdaytime);
	
	//have to adjust due date?
	$diff=$_POST['days'] - 28;
	
	//due date $date + 280 days
	$duedatetime=$lasttime + 280*24*3600 + $diff*24*3600;
	$duedate=date("F d, Y",$duedatetime);
	
	?>
	<div class="calculator_table">
	<p>Here are the results based on the information you provided:</p>
    <p>Your next <b>menstrual period</b> is expected to start on <strong><?php echo $next_period?></strong>.</p>
	<p>You next <b>most fertile</b> period is <strong><?php echo $firstday?> to <?php echo $lastday?></strong>.</p>
	<p>If you conceive within this timeframe, your estimated <b>due date</b> will be <strong><?php echo $duedate?></strong>.</p>
	<p align="center"><input type="button" value="Calculate again!" onclick="window.location='http://<?php echo $_SERVER['HTTP_HOST'];?><?php echo $_SERVER['REQUEST_URI']?>'"></p>
	</div>
<?php else:
	//the calculator comes here
	?>
	<div class="calculator_table">
	<form method="post">
	<p>Please select the first day of your last menstrual period:</p>
	<p><?php echo date_chooser("date",date("Y-m-d"))?></p>
	<p>Usual number of days in your period: <select name="days">
	<?php
	for($i=20;$i<=45;$i++)
	{
		if($i==28) $selected='selected="true"';
		else $selected='';
		echo "<option $selected value='$i'>$i</option>";
	}
	?>
	</select></p>
	<p align="center"><input type="submit" name="calculator_ok" value="Calculate"></p>
	</form>
	</div>
<?php endif;

//to print a date chooser - get name and value in mysql date format
function date_chooser($name,$value="")
{
	$months=array('','January','February','March','April','May','June','July','August',
	'September','October','November','December');
	
	if(empty($value)) $value=date("Y-m-d");
	
	$parts=explode("-",$value);
	
	$day=$parts[2]+0;
	$month=$parts[1]+0;
	$year=$parts[0];
	
	$chooser="";
	
	$chooser.="<select name='".$name."month'>";
	for($i=1;$i<=12;$i++)
	{
		if($i==$month) $selected='selected="true"';
		else $selected='';
		$chooser.="<option $selected value='$i'>$months[$i]</option>";
	}
	$chooser.="</select> / ";
	
	$chooser.="<select name='".$name."day'>";
	for($i=1;$i<=31;$i++)
	{
		if($i==$day) $selected='selected';
		else $selected='';
		$chooser.="<option $selected value='$i'>$i</option>";
	}
	$chooser.="</select> / ";
	
	$chooser.="<select name='".$name."year'>";
	for($i=(date("Y")-1);$i<=2050;$i++)
	{
		if($i==$year) $selected='selected';
		else $selected='';
		$chooser.="<option $selected>$i</option>";
	}
	$chooser.="</select> ";	
	
	return $chooser;
}
?>