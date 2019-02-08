<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="Stylesheet" type="text/css" href="<?php echo STYLE_DIR; ?>">
<title>GPZ</title>
</head>
<body>

<div class="header">Generator Protokołów Zbiorczych</div>

<form method="post" action="index.php" enctype="multipart/form-data">
<div class="main">Miejsce wzorcowania</div>
<input type="text" name="PLACE" value="ZAKLADY POLCONTACT WARSZAWA SP. Z O.O."><br>
<div class="main">Producent przekładników</div>
<input type="text" name="PROD" value="ZAKLADY POLCONTACT WARSZAWA SP. Z O.O."><br>
<div class="main">Data</div>
<input type="text" name="DATE" value="<?php echo date('d.m.Y'); ?>"><br>
<div class="main">Uwagi</div>
<input type="text" name="COMMENTS" value="-"><br>
<div class="main">Typ przekładników</div>
<div class="main">
<input type="radio" name="TYPE" value="1" checked>Prądowe
<input type="radio" name="TYPE" value="2" >Napięciowe
</div><br>
<div class="main">
Miejsca dziesiętne dla napięć/prądów&nbsp
<select name="PRECUI">
<option value="0">0</option>
<option value="1">1</option>
<option value="2" selected>2</option>
<option value="3">3</option>
<option value="4">4</option>
</select>
</div><br>
<div class="main">
Miejsca dziesiętne dla kątów&nbsp
<select name="PRECA">
<option value="0" selected>0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>
</div><br>
<div class="main"><input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory=""></div>
<br><br>
<div class="middle"><input type="submit" class="button" value="Generuj protokoły"></div>
</form>

</body>
</html>