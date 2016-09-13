<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Влизане в стая за тестове</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Михаил Георгиев">
    <link rel="icon" href="/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/normalize.css" rel="stylesheet">
    <link href="/assets/css/test.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav>
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 text-center">
            <p class="title">Моля изчакайте</p>
          </div>
          <div class="pull-right text-center col-md-1">
            <a href="/endtest"><i class="fa fa-times fa-3x"></i></a>
          </div>
        </div>
      </div>
    </nav>

    <br><br><br>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="tabs">
            Моля изчакайте, докато всички влязат в стаята и учителят пусне теста!
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/test.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    <script>
      function parse(str) {
          var args = [].slice.call(arguments, 1),
              i = 0;

          return str.replace(/%s/g, function() {
              return args[i++];
          });
      }

      var table = $('tbody');
      var pusher = new Pusher("{{env("PUSHER_KEY")}}", {
        cluster: 'eu'
      })
      var channel = pusher.subscribe('TestRoomChanel');
      channel.bind('TestStart', function(data) {
        var code = data.code;
        var route = parse('{{url("/")}}/%s/start', code);

        window.location.replace(route);
      });
    </script>
  </body>
</html>
