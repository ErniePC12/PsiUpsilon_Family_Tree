<?php include_once "database.php"; $query_Majors = mySQLQueryNew("SELECT major FROM members_majors"); ?><html><head><title>Delta Nu Psi - Psi Upsilon, Delta Nu</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"><?php include "style.css";?></head><body><span class="menuLink lastUpdated"><? print 'Last Updated: '. date('F j, Y, g:i a'); ?></span><span class="menuLink pageLinkUpper"><a href="index.html">All members listed by Pledge Class</a></span><span class="menuLink pageLinkLower"><a href="minors.html">All members listed by Minors</a></span>    <div style="text-align:center;">        <p class="delta" style="font-size:18pt;"><strong>All Members of<br>Delta Nu Psi</strong> &amp; <strong class="psiu">Psi Upsilon</strong></p><!--*****************************************************************************************************************************************************************************-->        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;width:35em;"><?php $y=$m=0;$n=1;$combined_array=array();    while ($row_Majors = mysqli_fetch_assoc($query_Majors)) {        $combined_array = array_unique(array_merge($combined_array,explode(",",$row_Majors['major']) ) );        $n++;    }    sort($combined_array);    foreach ($combined_array as &$major){        print "<tr><th colspan=\"\"><h3 class=\"major_line \"><a name=\"".$major."\">".$major."</a></h3></th></tr>\n";            $query_Members = "SELECT id, concat(first_name, ' \"<i>', nickname, '</i>\" ', last_name) as full_name, nickname, pledge_class FROM members WHERE major LIKE '%".$major."%' ORDER BY last_name ASC";        $all_Members = mySQLQueryNew($query_Members);        $rowTotal = $all_Members->num_rows;         while ($row_member = mysqli_fetch_assoc($all_Members)) {//            if ($row_member['nickname'] != "" ){$nickname=" \"".htmlentities($row_member['nickname'])."\" ";}else{$nickname="";}            print "<tr><td class=\"left_side\"  onclick=\"\">".$row_member['full_name']." </td></tr>\n";         }    }		print " Total Majors Listed: ".($n-1);?>        </table><!--*****************************************************************************************************************************************************************************-->    </div>	<span style="position:fixed;bottom:0;font-size:10pt;"><?php $end_time = explode(' ', microtime()); $total_time = $end_time[0] + $end_time[1] - $start_time; printf('-- %.3f seconds.--', $total_time); ?>	</span>	<?php include "tracking.php";?></body></html>