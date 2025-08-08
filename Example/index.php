<?php include 'test.php';?>
<!DOCTYPE html>
<html lang="en">

<head>

<style>

#loading-img{
display:none;
}

.response_msg{
margin-top:10px;
font-size:13px;
background:#E5D669;
color:#ffffff;
width:250px;
padding:3px;
display:none;
}

</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
    <title>CKAN ZENODO DOI</title>
  </head>
  <body>
   
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload File</h3>
		  <div class="form-group">
<label for="Title">Title</label>
<input type="text" class="form-control" name="title" placeholder="Title" required>
</div>
<div class="form-group">
<label for="APIkey">API Key</label>
<input type="text" class="form-control" name="apikey" placeholder="API Key" required>
</div>
<div class="form-group">
<label for="Description">Description</label>
<input type="text" class="form-control" name="description" placeholder="Description" required>
</div>
<div class="form-group">
<label for="Authors">Authors</label>
<input type="text" class="form-control" name="authors" placeholder="Authors" required>
</div>


<div class="form-group">
</div>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">upload</button>
		  <button type="submit" name="display" value="Display" id="display_results" onclick="openWin()">Display Results</button>
        </form>
      </div>
    </div>
	
	<script>
function openWin() {
  window.open("https://apl.geoecomar.ro/ckanz2/downloads.php");
}
</script>
	
  </body>
</html>