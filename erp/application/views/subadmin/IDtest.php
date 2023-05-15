<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Convert PDF to JPEG</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    
    <style>
    body{ font-family:Tahoma, Geneva, sans-serif; color:#000; font-size:11px; background-color:#D3D3D3; margin:0; padding:0;}
    </style>
    <style type="text/css">
    #upload-form {
        padding: 40px;
        background: #D3D3D3;
        border: 1px solid #000;
        margin-left: auto;
        margin-right: auto;
        width: 400px;
    }
    #upload-form input[type=file] {
        border: 1px solid #ddd;
        padding: 4px;
    }
    #upload-form input[type=submit] {
        height: 30px;
    }
</style>
    
    <style type="text/css">    
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
  </head>
  <body>
   <form enctype="multipart/form-data"  id="upload-form"  action="<?php echo base_url().'subadmin/download_img';?>" method="post">
<h2>How to convert PDF to JPEG in PHP Example</h2><br />
 Select PDF File: <input name="myfile" type="file" /><br /><br />
 <input type="submit" value="Upload" />
 </form> <h2><?=$message?></h2><br /><?=$display?>;
</body>
</html>