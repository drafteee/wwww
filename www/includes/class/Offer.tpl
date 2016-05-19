<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>InfoCity</title>

  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/styleOffer.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.css">

</head>
<body>
  <div id="page_align" class="b3radius">
    <div class="container">
      {header}
    <div id="content">
      {info_content}
      <div class="content_top">
        <div class="check" id="id_Check">
          {check}
        </div>
      </div>
      <div class="content_middle" id="id_content_middle">
        <div class="content_middle_top">
          {content_middle_top}
        </div>
        <div class="content_middle_bottom">
          {content_middle_bottom}
        </div>
      </div>
      {content_bottom}
    </div>
    {footer}
    </div>
  </div>
  {modal_window}
  
  <script src="js/jquery.js"></script>
  <script src="js/myscript_offer.js"></script>
  <script src="js/salvattore.min.js"></script>
  <script src="js/home.js"></script>

</body>
</html>