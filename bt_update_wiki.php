<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Baka-Tsuki Project List</title>
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

$query = 'SELECT updates.u_id, updates.p_id, updates.u_date, updates.vol, updates.ch, updates.usr, project.p_name, project.p_url, project.img_url, project.p_date, project.p_status, project.external, project.genre, project.author, project.summary, project.forumlink
FROM updates
INNER JOIN ( 
	SELECT MAX( updates.u_date ) AS LatestDate, updates.p_id 
	FROM updates
	GROUP BY updates.p_id
) SubMax 
ON updates.u_date = SubMax.LatestDate
AND updates.p_id = SubMax.p_id
LEFT JOIN project';

$complete = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "COMPLETE" ORDER BY project.p_name';
$caughtup = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "CAUGHT" ORDER BY project.p_name';
$active = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ACTIVE" AND u_date > DATE_SUB(NOW(),INTERVAL 3 MONTH) ORDER BY project.p_name';
$semi = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ACTIVE" AND u_date BETWEEN DATE_SUB(now(), INTERVAL 6 MONTH) AND DATE_SUB(now(), INTERVAL 3 MONTH) ORDER BY project.p_name';
$pause = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ACTIVE" AND u_date BETWEEN DATE_SUB(now(), INTERVAL 12 MONTH) AND DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY project.p_name';
$stall = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ACTIVE" AND u_date <= DATE_SUB(NOW(),INTERVAL 1 YEAR) ORDER BY project.p_name';
$teaser = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "TEASER" ORDER BY project.p_name';
$abandon = $query.' ON updates.p_id = project.p_id
WHERE project.p_status = "ABANDON" ORDER BY project.p_name';
$special = $query.' ON updates.p_id = project.p_id
WHERE u_date > DATE_SUB(NOW(),INTERVAL 2 WEEK) ORDER BY u_date DESC';

// execute query COMPLETE
$result = mysql_query($complete) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '&lt;noinclude&gt;<br>';
	echo '===Completed and Up-To-Date Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ Completed Projects<br>';
	echo '|-<br>';
	echo '! Project<br>';
	echo '! width="150pt" | Series Title<br>';
	echo '! Author<br>';
	echo '! Categories<br>';
	echo '! Summary<br>';
	echo '! Forum<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[[Image:'.$row["img_url"].'|50px]]<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["author"].'<br>';
    	echo '| style="font-size:90%;" |'.$row["genre"].'<br>';
    	echo '| style="font-size:90%;" |'.$row["summary"].'<br>';
    	echo '|['.$row["forumlink"].' x]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query CAUGHT UP
$result = mysql_query($caughtup) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ Projects Caught-Up to Most Recent Published Volume<br>';
	echo '|-<br>';
	echo '! Project<br>';
	echo '! width="150pt" | Series Title<br>';
	echo '! Author<br>';
	echo '! Categories<br>';
	echo '! Summary<br>';
	echo '! Forum<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[[Image:'.$row["img_url"].'|50px]]<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["author"].'<br>';
    	echo '| style="font-size:90%;" |'.$row["genre"].'<br>';
    	echo '| style="font-size:90%;" |'.$row["summary"].'<br>';
    	echo '|['.$row["forumlink"].' x]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query ACTIVE
$result = mysql_query($active) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Active Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ These projects have had at least one update in the past 3 months<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query SEMI-ACTIVE
$result = mysql_query($semi) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Semi-Active Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ These projects have had at least one update in the past 6 months<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query PAUSED
$result = mysql_query($pause) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Paused Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ These projects have had at least one update in the past 12 months<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query STALLED
$result = mysql_query($stall) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===On Hiatus (Stalled) Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ Stalled Projects (no updates for a year or more)<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query TEASER
$result = mysql_query($teaser) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Teaser Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ Teaser Projects<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);


// execute query ABANDON
$result = mysql_query($abandon) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Abandoned Projects===<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse"<br>';
	echo '|+ Abandoned Projects<br>';
	echo '|-<br>';
	echo '! Project<br>';
	echo '! Series Title<br>';;
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[[Image:'.$row["img_url"].'|50px]]<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}<br>Total count: '.$counter.'<br>';
}
else {
	echo "No results";
}
mysql_free_result($result);

// execute query RECENT
$result = mysql_query($special) or die ("Error in query: $query. ".mysql_error());
if (mysql_num_rows($result) > 0) { 
	echo '===Special===<br>&lt;div style="display:none;"&gt;&lt;/noinclude&gt;&lt;includeonly&gt;<br>';
	echo '{| border="1" class="wikitable sortable" style="font-size:90%; text-align:center; border:solid 1px; vertical-align:top; border-collapse:collapse; width:100%;"<br>';
	echo '|+ These projects have had at least one update in the past 2 weeks<br>';
	echo '|-<br>';
	echo '! Series Title<br>';
	echo '! Last Update<br>';
	echo '! Volume<br>';
	echo '! Chapter(s)<br>';
	echo '! Contributor<br>';
	$counter = 0;
    while($row = mysql_fetch_assoc($result)) {
    	echo '|-<br>';
    	echo '|[['.$row["p_url"].'|'.$row["p_name"].']]<br>';
    	echo '|'.$row["u_date"].'<br>';
    	echo '|'.$row["vol"].'<br>';
    	echo '|'.$row["ch"].'<br>';
    	echo '|[[User:'.$row["usr"].']]<br>';
    	$counter++;
    }
    echo '|}&lt;/includeonly&gt;&lt;noinclude&gt;<br>Total count: '.$counter.'<br>&lt;/div&gt;&lt;/noinclude&gt;';
}
else {
	echo "No results";
}
mysql_free_result($result);

// close connection 
mysql_close($connection); 

?> 

</body>
</html>