<html>
<head>
<title>PHP File type check example</title>
</head>
<body>

<form action="upload.php" enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit">

</form>

<?php

if(isset($_POST['Submit']))
{ 

$extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
{
move_uploaded_file($_FILES['file']['tmp_name'],("uploads/".$_FILES['file']['name']));
Echo "<script>alert('upload Done');
</script><b>Uploaded !!!</b><br>name : uploads/".$_FILES['file']['name'];

}
else
{
echo "File is not image";
}
}


?>
</body>
</html>