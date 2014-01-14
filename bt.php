<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Baka-Tsuki Project List</title>
    <style>
    	body {font-size: 90%;}
    	table {width: 80%; background-color: #F5FFE1;padding:10px;border-radius: 5px;}
    	th {border-bottom: 2px solid orange;}
    	td {padding: 5px;border:1px solid gray;}
    </style>
  </head>
 <body height="100%">
<?php 
// set database server access variables: 
$host = "mysql16.000webhost.com"; 
$user = "a7104968_cloud"; 
$pass = "baka-tsuki"; 
$db = "a7104968_bt"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 

// select database 
mysql_select_db($db) or die ("Unable to select database!"); 

// create query 

$query = 'SELECT updates.u_id, updates.p_id, updates.u_date, updates.vol, updates.ch, updates.usr, project.p_name, project.p_url, project.img_url, project.p_date, project.p_status, project.external, project.genre
FROM updates
INNER JOIN ( 
	SELECT MAX( updates.u_date ) AS LatestDate, updates.p_id 
	FROM updates
	GROUP BY updates.p_id
) SubMax 
ON updates.u_date = SubMax.LatestDate
AND updates.p_id = SubMax.p_id
LEFT JOIN project';

$query1 = $query.' ON updates.p_id = project.p_id
WHERE (project.p_status = "ACTIVE" OR project.p_status = "STALL") AND u_date > DATE_SUB(NOW(),INTERVAL 1 YEAR) ORDER BY project.p_name';
$queryS = $query.' ON updates.p_id = project.p_id
WHERE (project.p_status = "ACTIVE" OR project.p_status = "STALL") AND u_date <= DATE_SUB(NOW(),INTERVAL 1 YEAR) ORDER BY project.p_name';
$query2 = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "TEASER" ORDER BY project.p_name';
$query3 = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "COMPLETE" ORDER BY project.p_name';
$query4 = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ABANDON" ORDER BY project.p_name';

// execute query FULL PROJECT
$fullproject = mysql_query($query1) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($fullproject) > 0) { 
	echo '<h1>Active Projects</h1>';
	echo '<table>';
	echo '<tr><th>Project Name</th><th>Last Update</th><th>Volume</th><th>Chapter</th><th>By Contributer</th></tr>';
    while($row = mysql_fetch_assoc($fullproject)) {
    	echo '<tr><td><a href=\"'.$row["p_url"].'\">'.$row["p_name"].'</a></td><td>'.$row["u_date"].'</td><td>'.$row["vol"].'</td><td>'.$row["ch"].'</td><td>'.$row["usr"].'</td></tr>';
    }
    echo '</table>';
}
else {
	echo "No results";
}
mysql_free_result($fullproject);

// execute query STALLED
$stall = mysql_query($queryS) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($stall) > 0) { 
	echo '<h1>Stalled Projects (No update within 1 Year)</h1>';
	echo '<table>';
	echo '<tr><th>Project Name</th><th>Last Update</th><th>Volume</th><th>Chapter</th><th>By Contributer</th></tr>';
    while($row = mysql_fetch_assoc($stall)) {
    	echo '<tr><td><a href=\"'.$row["p_url"].'\">'.$row["p_name"].'</a></td><td>'.$row["u_date"].'</td><td>'.$row["vol"].'</td><td>'.$row["ch"].'</td><td>'.$row["usr"].'</td></tr>';
    }
    echo '</table>';
}
else {
	echo "No results";
}
mysql_free_result($stall);

// execute query TEASER
$teaser = mysql_query($query2) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($teaser) > 0) { 
	echo '<hr><h1>Teaser Projects</h1>';
	echo '<table>';
	echo '<tr><th>Project Name</th><th>Last Update</th><th>Volume</th><th>Chapter</th><th>By Contributer</th></tr>';
    while($row = mysql_fetch_assoc($teaser)) {
    	echo '<tr><td><a href=\"'.$row["p_url"].'\">'.$row["p_name"].'</a></td><td>'.$row["u_date"].'</td><td>'.$row["vol"].'</td><td>'.$row["ch"].'</td><td>'.$row["usr"].'</td></tr>';
    }
    echo '</table>';
}
else {
	echo "No results";
}
mysql_free_result($teaser);

// execute query COMPLETE
$complete = mysql_query($query3) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($complete) > 0) { 
	echo '<hr><h1>Completed Projects</h1>';
	echo '<table>';
	echo '<tr><th>Project Name</th><th>Last Update</th><th>Volume</th><th>Chapter</th><th>By Contributer</th></tr>';
    while($row = mysql_fetch_assoc($complete)) {
    	echo '<tr><td><a href=\"'.$row["p_url"].'\">'.$row["p_name"].'</a></td><td>'.$row["u_date"].'</td><td>'.$row["vol"].'</td><td>'.$row["ch"].'</td><td>'.$row["usr"].'</td></tr>';
    }
    echo '</table>';
}
else {
	echo "No results";
}
mysql_free_result($complete);

// execute query ABANDON
$abandon = mysql_query($query4) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($abandon) > 0) { 
	echo '<hr><h1>Abandoned Projects</h1>';
	echo '<table>';
	echo '<tr><th>Project Name</th><th>Last Update</th><th>Volume</th><th>Chapter</th><th>By Contributer</th></tr>';
    while($row = mysql_fetch_assoc($abandon)) {
    	echo '<tr><td><a href=\"'.$row["p_url"].'\">'.$row["p_name"].'</a></td><td>'.$row["u_date"].'</td><td>'.$row["vol"].'</td><td>'.$row["ch"].'</td><td>'.$row["usr"].'</td></tr>';
    }
    echo '</table>';
}
else {
	echo "No results";
}
mysql_free_result($abandon);

// close connection 
mysql_close($connection); 

?> 

</body>
</html>