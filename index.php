<?php
header("Content-Type:text/html;charset:utf-8");

$host = "localhost";
$port = 3306;
$base = "d2";
$user = "root";
$pass = "123";

$link=@mysqli_connect($host,$user,$pass,$base,$port) or die("cannot connect server");
mysqli_set_charset($link,"utf8");


$action = $_GET["action"];//url传递过来的值赋给action
switch ($action)
{
	case "addtype":  addtype();  break;
	case "edittype": edittype(); break;
	case "deltype":  deltype();  break;
	case "delurl":   delurl();   break;
	case "addurl":   addurl();   break;
	case "editurl":  editurl();  break;
	default: show();
}

function show()
{
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<style>
.title		{font-family: Arial; font-size: 30px; color: #8B008B}
.style		{font-family: Arial; font-size: 26px; color: #ddaaff}
.cont		{font-family: Arial; font-size: 26px}
.admin		{font-size: 11px; color: #9fc607}
a:hover		{text-decoration: none}
a:link		{text-decoration: none}
a:visited	{text-decoration: none}
</style>
</head>

<body bgcolor=#FFE4E1>
<script language="JavaScript">
var rate = 20;//javascript声明变量
var obj;
var act = 0;
var elmH = 0;
var elmS = 128;
var elmV = 255;
var clrOrg;
var TimerID;

if (navigator.appName.indexOf("Microsoft", 0) != -1 && parseInt(navigator.appVersion) >= 4)
	Browser = true;
else
	Browser = false;

if (Browser)
{
	document.onmouseover = doRainbowAnchor;
	document.onmouseout = stopRainbowAnchor;
}

function doRainbow()
{
	if (Browser && act != 1)
	{
		act = 1;
		obj = event.srcElement;
		clrOrg = obj.style.color;
		TimerID = setInterval("ChangeColor()", 100);
	}
}

function stopRainbow()
{
	if (Browser && act != 0)
	{
		obj.style.color = clrOrg;
		clearInterval(TimerID);
		act = 0;
	}
}

function doRainbowAnchor()
{
	if (Browser && act != 1)
	{
		obj = event.srcElement;

		while (obj.tagName != 'A' && obj.tagName != 'BODY')
		{
			obj = obj.parentElement;
			if (obj.tagName == 'A' || obj.tagName == 'BODY')
				break;
		}

		if (obj.tagName == 'A' && obj.href != '')
		{
			act = 1;
			clrOrg = obj.style.color;
			TimerID = setInterval("ChangeColor()", 100);
		}
	}
}

function stopRainbowAnchor()
{
	if (Browser && act != 0)
	{
		if (obj.tagName == 'A')
		{
			obj.style.color = clrOrg;
			clearInterval(TimerID);
			act = 0;
		}
	}
}

function ChangeColor()
{
	obj.style.color = makeColor();
}

function makeColor()
{

	if (elmS == 0)
	{
		elmR = elmV;
		elmG = elmV;
		elmB = elmV;
	}

	else
	{
		t1 = elmV;
		t2 = (255 - elmS) * elmV / 255;
		t3 = elmH % 60;
		t3 = (t1 - t2) * t3 / 60;

		if (elmH < 60)
		{
			elmR = t1;
			elmB = t2;
			elmG = t2 + t3;
		}
		else if (elmH < 120)
		{
			elmG = t1;
			elmB = t2;
			elmR = t1 - t3;
		}
		else if (elmH < 180)
		{
			elmG = t1;
			elmR = t2;
			elmB = t2 + t3;
		}
		else if (elmH < 240)
		{
			elmB = t1;
			elmR = t2;
			elmG = t1 - t3;
		}
		else if (elmH < 300)
		{
			elmB = t1;
			elmG = t2;
			elmR = t2 + t3;
		}
		else if (elmH < 360)
		{
			elmR = t1;
			elmG = t2;
			elmB = t1 - t3;
		}
		else
		{
			elmR = 0;
			elmG = 0;
			elmB = 0;
		}
	}

	elmR = Math.floor(elmR);
	elmG = Math.floor(elmG);
	elmB = Math.floor(elmB);

	clrRGB = '#' + elmR.toString(16) + elmG.toString(16) + elmB.toString(16);

	elmH = elmH + rate;
	if (elmH >= 360)
		elmH = 0;

	return clrRGB;
}
//鼠标指向超级链接变色结束
</script>
<p align=center class=title><br><b>url management system</b></p>
<?php
	mysqli_query($GLOBALS['link'],"set names utf8");
	//$styles = mysqli_query($link,"SELECT * FROM urlstyle");
	$styles = @mysqli_query($GLOBALS['link'],"SELECT * FROM urlstyle") or die("cannot read data table");
	$number = @mysqli_num_rows($styles) or die("cannot get rows");

	for ($i = 0; $i < $number; $i++)
	{
		$current = mysqli_fetch_assoc($styles) or die("cannot fetch array");
		$id = $current["id"];
		$style = $current["style"];
		print "<br><table width=90% border=1 cellspacing=0 cellpadding=6 align=center>\n";
		print "<tr class=style><td width=50% colspan=2 align=left bgcolor=#eeeeee>  <b>$style</b></td></tr> <tr class=style><td width=70% colspan=2 align=left bgcolor=#ffeef1><a href=index.php?action=edittype&id=$id title=edittype class=admin>edittype</a> <a href=index.php?action=deltype&id=$id OnClick=\"return confirm('this will delete all the urls in the category,do you want to continue?');\" title=deltype class=admin>deltype</a> <a href=index.php?action=addtype title=addtype class=admin>addtype</a> <a href=index.php?action=addurl&id=$id title=addurl class=admin>addurl</a></td></tr>\n";

		$urls = @mysqli_query($GLOBALS['link'],"SELECT * FROM myurl WHERE style=$id") or die("cannot read data table");
		$nums = @mysqli_num_rows($urls);
		for ($j = 0; $j < $nums / 4; $j++)
		{
			print "<tr class=cont>";
			for ($k = 0; $k < 1; $k++)
			{
				if (1 * $j + $k < $nums)
				{
					$nowurl = mysqli_fetch_assoc($urls);
					$myid = $nowurl["id"];
					$url = $nowurl["url"];
					$description = $nowurl["description"];
					print "<td width=25% align=left bgcolor=#e3ebfe OnMouseOver=\"this.bgColor='#c4d3f6';\" OnMouseOut=\"this.bgColor='#e3ebfe';\"><a href=\"$url\" target=_blank>$url</a><a href=index.php?action=editurl&id=$myid title=editurl class=admin>editurl</a> <a href=index.php?action=delurl&id=$myid OnClick=\"return confirm('do you want to delete this url?');\" title=delurl class=admin>delurl</a>  </td>";
					print "<td width=25% align=left bgcolor=#e3ebfe OnMouseOver=\"this.bgColor='#c4d3f6';\" OnMouseOut=\"this.bgColor='#e3ebfe';\">$description</td>";
				}
				else
				print "<td width=25% bgcolor=#e3ebfe OnMouseOver=\"this.bgColor='#c4d3f6';\" OnMouseOut=\"this.bgColor='#e3ebfe';\"s>  </td>";
		}
			print "</tr>\n";
		}
		print "</table>\n";
	}
?>
</body>
</html>
<?php
	return;
}

function addtype()
{
	global $_POST;

	if (isset($_POST["style"]))
	{
		$style = $_POST["style"];
		if ($style == "") die("style cannot be empty");
		//if (ereg("'", $style)) die("no single quotation mark in style");
		@mysqli_query($GLOBALS['link'],"INSERT INTO urlstyle VALUES('', '$style')") or die("cannot insert new category");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return please click<a href=index.php>here</a> to return.
</body>
</html>
<?php
	}

	else
	{
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
</head>
<body>
<br><br><br>
<form action=index.php?action=addtype method=POST>
<table width=90% border=0 cellspacing=0 cellpadding=6 align=center>
<tr><td align=center><b>add new category</b><br><br></td></tr>
<tr><td align=center>new category name<input name=style type=text size=32></td></tr>
<tr><td align=center><input type=submit value=add>  </td></tr>
</table>
</form>
</body>
</html>
<?php
	}
	return;
}

function addurl()
{
	global $_GET;
	global $_POST;

	if (isset($_POST["description"]) && isset($_POST["url"]))
	{
		$description = $_POST["description"];
		$url = $_POST["url"];
		//$url = str_replace("^http:\/\/", "", $url);
		$style = 1;
		if (isset($_POST["style"])) $style = $_POST["style"];
		//if ($description == "") die("description cannot be empty");
		if ($url == "") die("url cannot be empty");
		//if (ereg("'", $description)) die("no single quotation mark in description");
		//if (ereg("'", $url)) die("no single quotation mark in url");
		@mysqli_query($GLOBALS['link'],"INSERT INTO myurl VALUES('', '$style', '$description', '$url')") or die("cannot add new url");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return click<a href=index.php>here</a> to return.
</body>
</html>
<?php
	}

	else
	{
		$styles = @mysqli_query($GLOBALS['link'],"SELECT * FROM urlstyle") or die("cannot read data table");
		$number = @mysqli_num_rows($styles);
		$options = "";
		for ($i = 0; $i < $number; $i++)
		{
			$current = mysqli_fetch_assoc($styles);
			$id = $current["id"];
			$style = $current["style"];
			$options .= "<option value=$id>$style</option>";
		}

		if (isset($_GET["id"]))
		{
			$id = $_GET["id"];
			$options = str_replace("<option value=$id>", "<option value=$id selected>", $options);
		}
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
</head>
<body>
<br><br><br>
<form action=index.php?action=addurl method=POST>
<table width=60% border=1 cellspacing=0 cellpadding=6 align=center>
<tr><td align=center><b>add new url</b><br><br></td></tr>
<tr><td align=left>new url comment: <input name=description type=text size=48></td></tr>
<tr><td align=left>new url: <input name=url type=text size=48 value=""></td></tr>
<tr><td align=left>add to type: <select name=style><?php echo $options;?></select></td></tr>
<tr><td align=center><input type=submit value=add>	</td></tr>
</table>
</form>
</body>
</html>
<?php
	}
	return;
}

function deltype()
{
	global $_GET;

	$id = $_GET["id"];
	@mysqli_query($GLOBALS['link'],"DELETE FROM myurl WHERE style = $id") or die("cannot delete url");
	@mysqli_query($GLOBALS['link'],"DELETE FROM urlstyle WHERE id = $id") or die("cannot delete category");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return click<a href=index.php>to return</a>
</body>
</html>
<?php
	return;
}

function delurl()
{
	global $_GET;

	$id = $_GET["id"];
	@mysqli_query($GLOBALS['link'],"DELETE FROM myurl WHERE id = $id") or die("cannot delete url");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return click<a href=index.php>here</a>to return.
</body>
</html>
<?php
	return;
}

function edittype()
{
	global $_GET;
	global $_POST;

	if (isset($_POST["style"]) && isset($_POST["id"]))
	{
		$id = $_POST["id"];
		$style = $_POST["style"];
		if ($style == "") die("style cannot be empty");
		//if (ereg("'", $style)) die("no single quotation mark in style");
		@mysqli_query($GLOBALS['link'],"UPDATE urlstyle SET style = '$style' WHERE id = '$id'") or die("cannot edit style");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return click<a href=index.php>here</a>to return.
</body>
</html>
<?php
	}

	else
	{
		$id = $_GET["id"];
		$result = @mysqli_query($GLOBALS['link'],"SELECT style FROM urlstyle WHERE id = '$id'") or die("cannot read data table");
		$result = mysqli_fetch_assoc($result);
		$style = $result["style"];
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
</head>
<body>
<br><br><br>
<form action=index.php?action=edittype method=POST>
<input name=id type=hidden value=<?php echo $id;?>>
<table width=90% border=0 cellspacing=0 cellpadding=6 align=center>
<tr><td align=center><b>edit category name</b><br><br></td></tr>
<tr><td align=center>new category name:  <input name=style type=text size=32 value='<?php echo $style;?>'></td></tr>
<tr><td align=center><input type=submit value=edit></td></tr>
</table>
</form>
</body>
</html>
<?php
	}
	return;
}

function editurl()
{
	global $_GET;
	global $_POST;

	if (isset($_POST["description"]) && isset($_POST["url"]) &&isset($_POST["id"]))
	{
		$id = $_POST["id"];
		$description = $_POST["description"];
		$url = $_POST["url"];
		//$url = preg_replace("^http:\/\/", "", $url);
		$style = 1;
		if (isset($_POST["style"])) $style = $_POST["style"];
		//if ($description == "") die("description cannot be empty");
		if ($url == "") die("url cannot be empty");
		//if (ereg("'", $description)) die("no single quotation mark in description");
		//if (ereg("'", $url)) die("no single quotation mark in url");
		@mysqli_query($GLOBALS['link'],"UPDATE myurl SET style = '$style', description = '$description', url = '$url' WHERE id = '$id'") or die("cannot edit url");
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
<meta http-equiv="refresh" Content="0; url=index.php">
</head>
<body>
if not return click<a href=index.php>here</a>to return.
</body>
</html>
<?php
	}

	else
	{
		$styles = @mysqli_query($GLOBALS['link'],"SELECT * FROM urlstyle") or die("cannot read data table");
		$number = @mysqli_affected_rows($styles);
		$options = "";
		for ($i = 0; $i < $number; $i++)
		{
			$current = mysqli_fetch_assoc($styles);
			$id = $current["id"];
			$style = $current["style"];
			$options .= "<option value=$id>$style</option>";
		}

		if (isset($_GET["id"]))
		{
			$id = $_GET["id"];
			$result = @mysqli_query($GLOBALS['link'],"SELECT * FROM myurl WHERE id = '$id'") or die("cannot read data table");
			$result = mysqli_fetch_assoc($result);
			$style = $result["style"];
			$description = $result["description"];
			$url = $result["url"];
			$options = ereg_replace("<option value=$style>", "<option value=$style selected>", $options);
		}
?>
<html><title>MY URLS</title>
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
</head>
<body>
<br><br><br>
<form action=index.php?action=editurl method=POST>
<input name=id type=hidden value=<?php echo $id;?>>
<table width=60% border=0 cellspacing=0 cellpadding=6 align=center>
<tr><td align=center><b>edit url</b><br><br></td></tr>
<tr><td align=left>new url statement: <input name=description type=text size=48 value='<?php echo $description;?>'></td></tr>
<tr><td align=left>new url: <input name=url type=text size=48 value='<?php echo $url;?>'></td></tr>
<tr><td align=left>add to category: <select name=style><?php echo $options;?></select></td></tr>
<tr><td align=center><input type=submit value=edit></td></tr>
</table>
</form>
</body>
</html>
<?php
	}
	return;
}
?>
