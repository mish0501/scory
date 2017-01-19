<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Стая за тестове</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Михаил Георгиев">
    <link rel="icon" href="/favicon.ico">

    <link href="/assets/css/app.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/assets/images/favicons/manifest.json">
    <link rel="mask-icon" href="/assets/images/favicons/safari-pinned-tab.svg" color="#51b212">
    <link rel="shortcut icon" href="/assets/images/favicons/favicon.ico">
    <meta name="msapplication-config" content="/assets/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#51b212">
    <!-- /Favicons -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <script>
      window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]) ?>
    </script>
  <body>

    <div id="app">
      <router-view></router-view>
    </div>

    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/test.js"></script>
  </body>
</html>
