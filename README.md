baka-updates
============

Tracking Updates on Baka-Tsuki

Web Host
------------

The web host used is www.000webhost.com. It was free (1.5GB disk, 100GB/month bandwidth), and I was merely fooling around. It only allows one FTP account and two MySQL databases. It supports PHP but not other major languages. It does support: Curl, GD2 library, XML, Zend, .htaccess support, fopen(), and PHP sockets.

I'll provide the login information for the time being because security isn't my concern right now. Again, I was largely playing around.

To access pHpMyAdmin, go to [the login page](http://members.000webhost.com):

*Email: muffinzapplepear@gmail.com
*Psword: baka-tsuki

You'll need to go to cpanel.

*General Account Details*

*Domain: cloudbt.uphero.com
*IP Address: 31.170.160.110
*Username: a7104968
*Password: baka-tsuki

*File Upload Details*
*FTP Hostname: ftp.cloudbt.uphero.com or 31.170.160.110
*FTP Username: a7104968
*FTP Passsword: baka-tsuki

MySQL Connection Information
------------

*$mysql_host = "mysql16.000webhost.com";
*$mysql_database = "a7104968_bt";
*$mysql_user = "a7104968_cloud";
*$mysql_password = "baka-tsuki";

MySQL Tables
------------
*table: project*
Field	Type	Collation	Attributes	Null	Default	Extra	
p_id	int(11)		UNSIGNED ZEROFILL	No		auto_increment	 
p_name	varchar(50)	latin1_general_ci		No	
p_url	varchar(100)	utf8_unicode_ci		Yes	NULL
author	varchar(50)	latin1_general_ci		Yes	NULL
img_url	varchar(100)	latin1_general_ci		Yes	NULL	
p_date	date			Yes	NULL	
p_status	varchar(20)	latin1_general_ci		Yes	NULL	
external	varchar(100)	latin1_general_ci		Yes	NULL
genre	varchar(100)	latin1_general_ci		Yes	NULL	
summary	text	latin1_general_ci		Yes	NULL	
forumlink	varchar(100)	latin1_general_ci		Yes	NULL	

*table: updates*
Field	Type	Collation	Attributes	Null	Default	Extra	
u_id	int(11)		UNSIGNED ZEROFILL	No		auto_increment	
u_date	date			No			
p_id	int(11)		UNSIGNED ZEROFILL	No		
vol	text	latin1_general_ci		Yes	NULL	
ch	text	latin1_general_ci		Yes	NULL	
usr	text	latin1_general_ci		Yes	NULL	

Xataface Frontend
------------

I also installed a [Xataface](http://xataface.com/) application frontend on the root directory of the webserver because I don't like using pHpMyAdmin to do you regular data entry. The two major folders you see are the directories from the Xataface installation.

If you're interested, an application can be built entirely through Xataface (the *bt* directory). The *xataface* directory probably shouldn't be touched.

To try out the Xataface front end, go to [this link](http://cloudbt.uphero.com/bt/).

Again, there's no security.

What Next?
------------

Write some of your own pHp, connect to the database, and figure out how to make something useful out of this thing.

The little code generator I made can be found at:

*http://cloudbt.uphero.com/bt_update_wiki.php