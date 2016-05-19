<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>InfoCity</title>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/styleindex.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.css">

</head>
<body>
  <div id="page_align" class="b3radius">
    <div class="container">
      {header}
      <div id="content">
        {content_header}
        <div id="content_body">
          {side_bar_type_news}
          {content_body_list_news}
        </div>
      </div>
      {footer}
    </div>
  </div>
  {modal_window}
  
  <script src="js/jquery.js"></script>
  <script src="js/myscript_index.js">  </script>
  <script src="js/home.js"></script>
</body>
</html>