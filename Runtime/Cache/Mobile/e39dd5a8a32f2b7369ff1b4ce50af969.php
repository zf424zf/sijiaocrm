<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>imageupload</title>
</head>
<body>
<form action="uploadimage.html" name="form1" method="post" enctype="multipart/form-data">
    <input type="file" name="images[]">
    <input type="file" name="images[]">
    <input type="file" name="images[]">
    <input type="submit" name="提交">
</form>
</body>
</html>