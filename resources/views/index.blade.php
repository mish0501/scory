<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Михаил Георгиев">

    <title>Scory</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#49bf67">
    <meta name="msapplication-TileColor" content="#49bf67">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#49bf67">
    <!-- /Favicons -->

    <link href="/assets/css/app.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" id="menu">
      <div class="container">
        <div class="navbar-header">
          <button type="button" id="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Меню</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand scroll-effect" data-scroll="top">Scory</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="menu-item"><a data-scroll="about" class="scroll-effect">За проекта</a></li>
            <li class="menu-item"><a data-scroll="student" class="scroll-effect">Ученик?</a></li>
            <li class="menu-item"><a data-scroll="teacher" class="scroll-effect">Учител?</a></li>
            <li class="menu-item"><a data-scroll="contact" class="scroll-effect">Контакти</a></li>
            <li><a class="login" href="/login/">Вход</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Top -->
    <div class="jumbotron" id="top">
      <div class="container">
        <h1>Scory</h1>
      </div>
    </div>

    <div class="container">

      <!-- About -->
      <div class="row" id="about">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="text-center">За проекта</h2>
          <p class="text-justify">Чрез „Scory“ можете лесно и бързо да генерирате най-различни тестове във всяка една образователна област, за всеки един клас по раздели.</p>
        </div>
      </div>

      <hr>

      <!-- Student -->
      <div class="row" id="student">
        <header class="col-md-10 col-md-offset-1 text-center">
          <h2>Ученик?</h2>
          <p>Ако си ученик можеш да си избереш една от тези опции.</p>
        </header>
        <div class="col-md-4 col-md-offset-1 text-center">
          <h2>Избери си тест</h2>
          <p class="text-justify">Избери класа си, предмета и раздела, който искаш да се упражняваш.</p>
          <p><a class="btn btn-success btn-lg btn-block" href="{{ route('class') }}" role="button">Избери си тест</a></p>
        </div>
        <div class="col-md-4 col-md-offset-2 text-center">
          <h2>Влез в стая за тестове</h2>
          {!! Form::open([
              'route' => ['testroom.join'],
              'autocomplete' => 'off'
          ]) !!}
            <div class="form-group">
              @if(Session::has('room_code_error'))
                <div class="alert alert-danger">
                  <b>{{ Session::get('room_code_error') }}</b>
                  @foreach($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
                </div>
              @endif

              <label class="sr-only">Въведи кода на стаята</label>
              <input type="text" name="roomcode" class="form-control input-lg" id="roomcode" placeholder="Въведи кода на стаята">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-lg btn-block">Влез в стаята</button>
            </div>
          </form>
        </div>
      </div>

      <hr>

      <!-- Teacher -->
      <div class="row" id="teacher">
        <header class="col-md-10 col-md-offset-1 text-center">
          <h2>Учител?</h2>
          <p class="text-center">За да можете да използвате сайта, трябва да получите покана. За тази цел въведете e-mail си и ще я изпратим.</p>
        </header>
        <div class="col-md-10 col-md-offset-1 text-center">
          @if(Session::has('invite_email'))
              <div class="alert alert-success col-md-6 col-md-offset-3">
                  {{ Session::get('invite_email') }}
              </div>
          @endif

          @if($errors->has('invite-email'))
              <div class="alert alert-danger col-md-6 col-md-offset-3">
                  @foreach($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
              </div>
          @endif
          {!! Form::open([
            'route' => ['invite'],
            'class' => 'form-inline',
            'autocomplete' => 'off'
            ]) !!}
            <div class="form-group">
              <input type="email" class="form-control input-lg" style="min-width:420px" name="invite-email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block">Изпрати</button>
            </div>
          </form>
        </div>
      </div>

      <hr>

      <!-- Contact -->
      <div class="row" id="contact">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="text-center">Контакти</h2>
        </div>
        <div class="col-md-10 col-md-offset-1">
          @if(Session::has('mail_send'))
              <div class="alert alert-success">
                  {{ Session::get('mail_send') }}
              </div>
          @endif

          @if($errors->any() && !$errors->has('roomcode') && !$errors->has('invite-email'))
              <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
              </div>
          @endif

            {!! Form::open([
              'route' => ['contact'],
              'class' => 'form-horizontal',
              'autocomplete' => 'off'
              ]) !!}
            <div class="form-group">
              <div class="col-xs-6">
                <input type="text" class="form-control input-lg" name="first_name" placeholder="Име" value="{{Request::old('first_name')}}">
              </div>
              <div class="col-xs-6 pull-right">
                <input type="text" class="form-control input-lg" name="last_name" placeholder="Фамилия" value="{{Request::old('last_name')}}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <input type="email" class="form-control input-lg" name="email" placeholder="Email" value="{{Request::old('email')}}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <input type="text" class="form-control input-lg" name="subject" placeholder="Относно" value="{{Request::old('subject')}}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control input-lg" rows="7" name="message" placeholder="Съобщение">{{Request::old('message')}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-lg btn-block">Изпрати</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/scroll.js"></script>
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/main.js"></script>
     @if(Session::has('mail_send') || Session::has('error_mail_send'))
       <script type="text/javascript">
         scroll.toID('contact');
       </script>
    @endif
    @if(Session::has('room_code_error'))
      <script type="text/javascript">
        scroll.toID('student');
      </script>
    @endif
    @if($errors->has('invite-email') || Session::has('invite_email'))
      <script type="text/javascript">
        scroll.toID('teacher');
      </script>
    @endif
  </body>
</html>
