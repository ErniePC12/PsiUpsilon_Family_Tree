<?php
date_default_timezone_set('America/New_York');
$start_time = explode(' ', microtime()); $start_time = $start_time[1] + $start_time[0];

/********************************************************************************************************************************************************/
function mySQLQueryNew($theQuery){
// CONNECT TO THE DATABASE
	$DB_NAME = 'deltanupsi';
	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = 'tessa';
	
	$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if ($result = mysqli_query($link, $theQuery))
	/* close connection */
	mysqli_close($link);

	return $result;
}

/********************************************************************************************************************************************************/
function mySQLQuery($theQuery) {
    $databaseHost = 'localhost';
    $databaseUser = 'root';
    $databasePassword = 'tessa';
/*  $databaseUser = 'deltanup_mfried'; */
/*  $databasePassword = 'makaha'; */
    $databaseName = 'deltanupsi';

    $databaseConnection = mysqli_pconnect($databaseHost, $databaseUser, $databasePassword); // or die('Error Connecting To The MySQL Database!');
    mysql_select_db($databaseName);

    $theResult = mysql_query($theQuery) or die("<b style=\"color: red;\">MySQL ERROR! " . mysql_error() . ", While Executing Query: <i>$theQuery</i></b>");

    mysql_close($databaseConnection);
    return $theResult;
}
/********************************************************************************************************************************************************/
function lookup_bigNew($id, $set=""){
    if (($id != '') && ($id != '0')){
        $result=mysqli_fetch_assoc(mySQLQueryNew("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$id'"));

        $set .= "<a href=\"#".$result['pledge_class']."\" style=\"white-space:nowrap;\">".$result['first_name']." ".$result['last_name']." (PC: ".$result['pledge_class'].")</a> ";
//        if ($result['bigs'] > '0'){ $set.=" -&gt; <br>".lookup_bigNew($result['bigs']); }
    }
    return $set;
}
/********************************************************************************************************************************************************/
function lookup_bigsNew($id, $set="", $big_array=array()){
    if (($id != '') && ($id != '0')){
echo "<pre>";
    $big_array = array_merge($big_array,explode(",",$id) );
    $c=count($big_array);
echo "</pre>";
        
        foreach ($big_array as &$row_big ){
            $result=mysql_fetch_assoc(mySQLQueryNew("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$row_big'"));
//            $result=mysql_fetch_assoc(mySQLQuery("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$row_big'"));
            $set .= "<a href=\"#".$result['pledge_class']."\" style=\"white-space:nowrap;\">".$result['first_name']." ".$result['last_name']." (PC: ".$result['pledge_class'].")</a> ";
            if ($result['bigs'] > '0'){ $set.=" -&gt; <br>".lookup_bigs($result['bigs']); } else {$set .= "<br><br>";}
        }
//        print_r($combined_array);
    }
    return $set;
}
/********************************************************************************************************************************************************/
function lookup_familyNew($id, $set=""){
    $sql="SELECT id, big, first_name,last_name,big_pledge_class,little,little_first,little_last,little_pledge_class FROM biglittlelisting WHERE big = '$id' ORDER BY little_pledge_class ASC";
/*     $sql="SELECT id, big, first_name,last_name,big_pledge_class,little,little_first,little_last,little_pledge_class FROM biglittlelisting WHERE little = '$id' ORDER BY little_pledge_class ASC"; */
    $result=mySQLQueryNew($sql);
    $num = $result->num_rows;
//    $num = mysql_num_rows($result);
    if ($num > '0') {
        while ($family = mysqli_fetch_assoc($result)){
/*         echo "<pre><br>"; print_r($family); echo "</pre>"; */
/*                 $set .= "<td><a href=\"#".$family['little_pledge_class']."\" style=\"white-space:nowrap;\">".$family['little_first']." ".$family['little_last']." (PC: ".$family['little_pledge_class'].")</a></td>"; */
            $set .= "<a href=\"#".$family['little_pledge_class']."\" style=\"white-space:nowrap;\">".$family['little_first']." ".$family['little_last']." (PC: ".$family['little_pledge_class'].")</a> ";
//            $set .= "<a href=\"#".$family['big_pledge_class']."\" style=\"white-space:nowrap;\">".$family['first_name']." ".$family['last_name']." (PC: ".$family['big_pledge_class'].")</a> ";
            if ($num >= '1'){ $set.=" <br> "; }
/*             if ($num >= '1'){ $set.=" ".lookup_family($family['little'], " "); } */
/*             if ($num > '1'){ $set.=" ".lookup_family($family['big']); } */
        } /* End WHILE */
    } /* End IF */
    return $set;
}
/********************************************************************************************************************************************************/
function debug($string, $array="no")
{
    echo "<pre style=\"text-align:left;\">";
    
    echo "</pre>";
    return 0;
}
function mySQLQueryBackup($theQuery){
// CONNECT TO THE DATABASE
	$DB_NAME = 'deltanupsi';
	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = 'tessa';
	
	echo '<pre>';
	
	$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	$tmp = mysqli_query($con,$theQuery);
	mysqli_close($con);

	$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

// A QUICK QUERY ON A FAKE USER TABLE
//    $stmt = $mysqli->prepare($theQuery);
//    $stmt->execute();
 	$query = $theQuery;
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	$result = mysqli_query($mysqli, $query);
	print_r($mysqli);
//	print_r($tmp);
//	while($row1=mysqli_fetch_array($tmp,MYSQLI_NUM))
//        print_r($row1);
	while($row=mysqli_fetch_array($tmp,MYSQLI_BOTH)){  //MYSQLI_ASSOC

//	   print_r($row);
	   $rtemp[]=$row;
    }
    echo '</pre>';
return $rtemp;
break;    
	$row=mysqli_fetch_array($tmp,MYSQLI_ASSOC);
//	print_r($row);
//	print_r($rtemp);
	
//    print_r($result);
//    print_r($stmt);

$rs=$result->get_result();
//$rs=$stmt->get_result();
$arr = $rs->fetch_all(MYSQLI_ASSOC);

//echo $mysqli->host_info . "\n";
//    $set = $result->fetch_all(MYSQLI_ASSOC);

while($row = $result->fetch_row()){
    $set[]= $row[0];
    //$set = $result->fetch_assoc();
}
// GOING THROUGH THE DATA

	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
//			echo stripslashes($row['pledge_class']);
//            $set[]=$row['0'];
//			print_r($row); 
		}
	}
	else {
		echo 'NO RESULTS';	
	}

	print_r($set);
echo '</pre>';
// CLOSE CONNECTION
//	$mysqli->close();
	mysqli_close($mysqli);
	mysqli_free_result($result);


//	print_r( $result->fetch_assoc() );
}

/********************************************************************************************************************************************************/
/********************************************************************************************************************************************************/
function lookup_family($id, $set=""){
    $sql="SELECT id, big, first_name,last_name,big_pledge_class,little,little_first,little_last,little_pledge_class FROM biglittlelisting WHERE big = '$id' ORDER BY little_pledge_class ASC";
/*     $sql="SELECT id, big, first_name,last_name,big_pledge_class,little,little_first,little_last,little_pledge_class FROM biglittlelisting WHERE little = '$id' ORDER BY little_pledge_class ASC"; */
    $result=mySQLQueryNew($sql);
//    $num = mysql_num_rows($result);
    if ($num > '0') {
        while ($family = mysql_fetch_array($result)){
/*         echo "<pre><br>"; print_r($family); echo "</pre>"; */
/*                 $set .= "<td><a href=\"#".$family['little_pledge_class']."\" style=\"white-space:nowrap;\">".$family['little_first']." ".$family['little_last']." (PC: ".$family['little_pledge_class'].")</a></td>"; */
            $set .= "<a href=\"#".$family['little_pledge_class']."\" style=\"white-space:nowrap;\">".$family['little_first']." ".$family['little_last']." (PC: ".$family['little_pledge_class'].")</a> ";
//            $set .= "<a href=\"#".$family['big_pledge_class']."\" style=\"white-space:nowrap;\">".$family['first_name']." ".$family['last_name']." (PC: ".$family['big_pledge_class'].")</a> ";
            if ($num >= '1'){ $set.=" <br> "; }
/*             if ($num >= '1'){ $set.=" ".lookup_family($family['little'], " "); } */
/*             if ($num > '1'){ $set.=" ".lookup_family($family['big']); } */
        } /* End WHILE */
    } /* End IF */
    return $set;
}
/********************************************************************************************************************************************************/
/********************************************************************************************************************************************************/
function lookup_big($id, $set=""){
    if (($id != '') && ($id != '0')){
        $result=mysql_fetch_assoc(mySQLQuery("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$id'"));
        
        $set .= "<a href=\"#".$result['pledge_class']."\" style=\"white-space:nowrap;\">".$result['first_name']." ".$result['last_name']." (PC: ".$result['pledge_class'].")</a> ";
        if ($result['bigs'] > '0'){ $set.=" -&gt; <br>".lookup_big($result['bigs']); }
    }
    return $set;
}
/********************************************************************************************************************************************************/
/********************************************************************************************************************************************************/
function lookup_bigs($id, $set="", $big_array=array()){
    if (($id != '') && ($id != '0')){
echo "<pre>";
    $big_array = array_merge($big_array,explode(",",$id) );
    $c=count($big_array);
echo "</pre>";
        
        foreach ($big_array as &$row_big ){
            $result=mysql_fetch_assoc(mySQLQueryNew("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$row_big'"));
//            $result=mysql_fetch_assoc(mySQLQuery("SELECT id, first_name,last_name,nickname,pledge_class, bigs FROM MEMBERS WHERE id = '$row_big'"));
            $set .= "<a href=\"#".$result['pledge_class']."\" style=\"white-space:nowrap;\">".$result['first_name']." ".$result['last_name']." (PC: ".$result['pledge_class'].")</a> ";
            if ($result['bigs'] > '0'){ $set.=" -&gt; <br>".lookup_bigs($result['bigs']); } else {$set .= "<br><br>";}
        }
//        print_r($combined_array);
    }
    return $set;
}
/********************************************************************************************************************************************************/
?>