<!DOCTYPE html>
<html>
<?php 
$this->layout = false;
?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiresias | 404 Page not found</title>
    <style type="text/css">
    .middle-box {
  background: #ffffff none repeat scroll 0 0;
  border: 2px solid #6e6e6e;
  box-shadow: 11px 12px 7px #616161;
  color: #0000;
  margin: 10% auto;
  padding: 10px 50px;
  text-align: center;
  width: 50%;
}

    a.btn {
      background: #000 none repeat scroll 0 0;
      border: 1px solid #fff;
      color: #fff;
      margin: 8%;
      padding: 5px 10px;
      text-decoration: none;
    }
    </style>
</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">

        <h1>404</h1>
        <h3 class="font-bold">Page Not Found</h3>

        <div class="error-desc">
            Sorry, but the page you are looking for has not been found. Try checking the URL for error, then hit the refresh button on your browser or click below to go to home page of website.
            <br><br>
            <?php
                echo $this->Html->link(
                    'Go To Home Page',
                    '/',
                    ['class' => 'btn btn-primary']
                );                
            ?>
        </div>
    </div>
</body>
</html>
