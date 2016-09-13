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
            <p class="title">Въведи си името и фамилията</p>
          </div>
          <div class="pull-right text-center col-md-1">
            <a href="/endtest"><i class="fa fa-times fa-3x"></i></a>
          </div>
        </div>
      </div>
    </nav>

    <br><br><br>

    <div class="container">
      {!! Form::open([
        'route' => 'testroom.connect',
        'class' => 'form',
        'autocomplete' => 'off'
        ]) !!}
        <input type="hidden" name="code" value="{{$code}}">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="tabs">
              <input type="text" name="name" placeholder="Име">
            </div>
            <br>
            <div class="tabs">
              <input type="text" name="lastname" placeholder="Фамилия">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6 col-md-offset-3 submit">
              <button type="submit" class="btn btn-success btn-lg btn-block">Продължи напред</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/test.js"></script>
  </body>
</html>
