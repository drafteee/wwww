<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>InfoCity</title>

  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/styleUsers.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.css">

</head>
<body>
  <div id="page_align" class="b3radius">
    <div class="container">
      {header}
    <div id="content">
      <div class="content_left">
        <div class="list_users b3radius" id="id_content_left">
        {list_users}
        </div>
      </div>
      <div class="content_right "> 
       <div class="content_right_top">
        <div class="chat b3radius">
          <ul class="info_user">
            {content_right_top}
          </ul>
         </div>
        </div>     
    </div>  
  </div>
  {footer}
  </div>
  </div>
  {modal_window}
  
  <script src="js/jquery.js"></script>
  <script src="js/myscript_users.js"></script>
  <script src="js/salvattore.min.js"></script>
  <script src="js/home.js"></script>

</body>
</html>