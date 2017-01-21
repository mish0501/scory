<!DOCTYPE html>
<html>
  <head>
    <title><?php $s = explode(" ",$__env->yieldContent('title'));unset($s[2]);unset($s[3]);$s = implode(" ",$s); echo $s;?> | Scory - Администраторски панел</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta content='text/html;charset=utf-8' http-equiv='content-type'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content='Flat administration template for Twitter Bootstrap. Twitter Bootstrap 3 template with Ruby on Rails support.' name='description'>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#49bf67">
    <meta name="msapplication-TileColor" content="#49bf67">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#49bf67">#51b212">
    <!-- /Favicons -->

    <style>
      @media only screen and (max-width: 620px){
        .dataTables_wrapper {
          overflow: auto !important;
        }
      }
    </style>
    @yield('style')
    <!-- / bootstrap [required] -->
    <link href="/admin/assets/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
    <!-- / theme file [required] -->
    <link href="/admin/assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
    <!-- / coloring file [optional] (if you are going to use custom contrast color) -->
    <link href="/admin/assets/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
      <script src="/admin/assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="/admin/assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->
  </head>
  <body class='contrast-red'>
    <header>
      <nav class='navbar navbar-default'>
        <a class='navbar-brand' href='/admin/home'>
          <img width="81" height="21" class="logo" alt="Flatty" src="/admin/assets/images/logo.svg" />
          <img width="21" height="21" class="logo-xs" alt="Flatty" src="/admin/assets/images/logo_xs.svg" />
        </a>
        <a class='toggle-nav btn pull-left' href='#'>
          <i class='icon-reorder'></i>
        </a>
        <ul class='nav'>
          <li class='dropdown light only-icon'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
              <i class='icon-cog'></i>
            </a>
            <ul class='dropdown-menu color-settings'>
              <li class='color-settings-body-color'>
                <div class='color-title'>Тема</div>
                <a data-change-to='/admin/assets/stylesheets/light-theme.css' href='#'>Светла<small>(по подразбиране)</small></a>
                <a data-change-to='/admin/assets/stylesheets/dark-theme.css' href='#'>Тъмна</a>
                <a data-change-to='/admin/assets/stylesheets/dark-blue-theme.css' href='#'>Тъмно синя</a>
              </li>
              <li class='divider'></li>
              <li class='color-settings-contrast-color'>
                <div class='color-title'>Цвят на сайта</div>
                <a data-change-to="contrast-red" href="#"><i class='icon-cog text-red'></i>Червен<small>(по подразбиране)</small></a>
                <a data-change-to="contrast-blue" href="#"><i class='icon-cog text-blue'></i>Син</a>
                <a data-change-to="contrast-orange" href="#"><i class='icon-cog text-orange'></i>Оранжев</a>
                <a data-change-to="contrast-purple" href="#"><i class='icon-cog text-purple'></i>Лилав</a>
                <a data-change-to="contrast-green" href="#"><i class='icon-cog text-green'></i>Зелен</a>
                <a data-change-to="contrast-muted" href="#"><i class='icon-cog text-muted'></i>Сив</a>
                <a data-change-to="contrast-fb" href="#"><i class='icon-cog text-fb'></i>Facebook</a>
                <a data-change-to="contrast-dark" href="#"><i class='icon-cog text-dark'></i>Черен</a>
                <a data-change-to="contrast-pink" href="#"><i class='icon-cog text-pink'></i>Розов</a>
                <a data-change-to="contrast-grass-green" href="#"><i class='icon-cog text-grass-green'></i>Тревно зелен</a>
                <a data-change-to="contrast-sea-blue" href="#"><i class='icon-cog text-sea-blue'></i>Морско синьо</a>
                <a data-change-to="contrast-banana" href="#"><i class='icon-cog text-banana'></i>Бананово жълто</a>
                <a data-change-to="contrast-dark-orange" href="#"><i class='icon-cog text-dark-orange'></i>Тъмно оранжево</a>
                <a data-change-to="contrast-brown" href="#"><i class='icon-cog text-brown'></i>Кафяво</a>
              </li>
            </ul>
          </li>
          <li class='dropdown medium only-icon widget'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
              <i class='icon-comments'></i>
              <div class='label counter'></div>
            </a>
            <ul class='dropdown-menu messageScreen'></ul>
          </li>
          <li class='dropdown dark user-menu'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
              @if(Auth::user()->avatar != NULL)
                <img width="60" height="60" alt="" src="/admin/assets/images/avatar/thumbs/{{ Auth::user()->avatar }}" />
              @else
                <img width="23" height="23" alt="" src="/admin/assets/images/avatar/avatar.jpg" />
              @endif
              <span class='user-name'>{{ Auth::user()->name }}</span>
              <b class='caret'></b>
            </a>
            <ul class='dropdown-menu'>
              <li>
                <a href='/admin/user/{{ Auth::user()->id }}'>
                  <i class='icon-cog'></i>
                  Настройки
                </a>
              </li>
              <li class='divider'></li>
              <li>
                {!! Form::open([
                  'url' => ['/logout'],
                  'id' => 'logout-form',
                ]) !!}
              {{Form::close()}}
                <a href="#" onclick="document.getElementById('logout-form').submit();">
                  <i class='icon-signout'></i>
                  Изход
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </header>
    <div id='wrapper'>
      <div id='main-nav-bg'></div>
      <nav id='main-nav'>
        <div class='navigation'>
          <div class='search'>
            <form action='search_results.html' method='get'>
              <div class='search-wrapper'>
                <input value="" class="search-query form-control" placeholder="Търси..." autocomplete="off" name="q" type="text" />
                <button class='btn btn-link icon-search' name='button' type='submit'></button>
              </div>
            </form>
          </div>
          <ul class='nav nav-stacked'>
            <li @if (Route::currentRouteName() == 'admin.home') class='active' @endif>
              <a href='{{ route("admin.home") }}'>
                <i class='icon-dashboard'></i>
                <span>Начало</span>
              </a>
            </li>

            @if(Entrust::can('list-subject'))
              <li @if (Route::currentRouteName() == 'admin.subject.index' || Route::currentRouteName() == 'admin.subject.create' || Route::currentRouteName() == 'admin.subject.edit') class="active" @endif>
                <a href="{{ route('admin.subject.index') }}">
                  <i class='icon-book'></i>
                  <span>Предмет</span>
                </a>
              </li>
            @endif

            @if(Entrust::can('list-partition'))
              <li @if (Route::currentRouteName() == 'admin.partition.index' || Route::currentRouteName() == 'admin.partition.create' || Route::currentRouteName() == 'admin.partition.edit') class="active" @endif>
                <a href="{{ route('admin.partition.index') }}">
                  <i class='icon-folder-open'></i>
                  <span>Раздел</span>
                </a>
              </li>
            @endif

            @if(Entrust::can('list-question'))
              <li @if (Route::currentRouteName() == 'admin.question.index' || Route::currentRouteName() == 'admin.question.create' || Route::currentRouteName() == 'admin.question.edit') class="active" @endif>
                <a href="{{ route('admin.question.index') }}">
                  <i class='icon-question'></i>
                  <span>Въпроси</span>
                </a>
              </li>
            @endif

            <li @if (Route::currentRouteName() == 'admin.testroom.index' || Route::currentRouteName() == 'admin.testroom.active' || Route::currentRouteName() == 'admin.testroom.create' || Route::currentRouteName() == 'admin.testroom.start' || Route::currentRouteName() == 'admin.testroom.end' || Route::currentRouteName() == 'admin.testroom.results' || Route::currentRouteName() == 'admin.testroom.studentResults') class="active" @endif>
              <a href="{{ route('admin.testroom.index') }}">
                <i class='icon-group'></i>
                <span>Стая за тестове</span>
              </a>
            </li>

            @if(Entrust::can('list-invitation') && Entrust::hasRole('admin'))
              <li @if (Route::currentRouteName() == 'admin.invite.index' || Route::currentRouteName() == 'admin.invite.create') class="active" @endif>
                <a href="{{ route('admin.invite.index') }}">
                  <i class='icon-envelope'></i>
                  <span>Покана</span>
                </a>
              </li>
            @endif

            @if(Entrust::can('list-mail') && Entrust::hasRole('admin'))
              <li @if (Route::currentRouteName() == 'admin.mail.index' || Route::currentRouteName() == 'admin.invite.create') class="active" @endif>
                <a href="{{ route('admin.mail.index') }}">
                  <i class='icon-comments'></i>
                  <span>Съобщения</span>
                </a>
              </li>
            @endif

            @if(Entrust::hasRole('admin') || (Entrust::hasRole('teacher') && Entrust::can('delete-testroom')))
              <li>
                <a class="@if (Route::currentRouteName() == 'admin.trash') in @endif" href="/admin/trash">
                  <i class='icon-trash'></i>
                  <span>Кошче</span>
                </a>
              </li>
            @endif

            @if(Entrust::hasRole('admin'))
              <li>
                <a class="dropdown-collapse @if (Route::currentRouteName() == 'admin.settings.users.index' || Route::currentRouteName() == 'admin.settings.users.edit' || Route::currentRouteName() == 'admin.settings.permissions.index' || Route::currentRouteName() == 'admin.settings.permissions.edit' || Route::currentRouteName() == 'admin.settings.permissions.create' || Route::currentRouteName() == 'admin.settings.roles.index' || Route::currentRouteName() == 'admin.settings.roles.edit' || Route::currentRouteName() == 'admin.settings.roles.create') in @endif">
                  <i class='icon-cogs'></i>
                  <span>Настройки на сайта</span>
                  <i class='icon-angle-down angle-down'></i>
                </a>

                <ul class='@if (Route::currentRouteName() == 'admin.settings.users.index' || Route::currentRouteName() == 'admin.settings.users.edit' || Route::currentRouteName() == 'admin.settings.permissions.index' || Route::currentRouteName() == 'admin.settings.permissions.edit' || Route::currentRouteName() == 'admin.settings.permissions.create' || Route::currentRouteName() == 'admin.settings.roles.index' || Route::currentRouteName() == 'admin.settings.roles.edit' || Route::currentRouteName() == 'admin.settings.roles.create') in @endif nav nav-stacked'>
                  <li @if (Route::currentRouteName() == 'admin.settings.users.index' || Route::currentRouteName() == 'admin.settings.users.edit') class='active' @endif>
                    <a href='/admin/settings/users'>
                      <span>Потребители</span>
                    </a>
                  </li>
                  <li @if (Route::currentRouteName() == 'admin.settings.permissions.index' || Route::currentRouteName() == 'admin.settings.permissions.edit' || Route::currentRouteName() == 'admin.settings.permissions.create') class='active' @endif>
                    <a href='/admin/settings/permissions'>
                      <span>Права</span>
                    </a>
                  </li>
                  <li @if (Route::currentRouteName() == 'admin.settings.roles.index' || Route::currentRouteName() == 'admin.settings.roles.edit' || Route::currentRouteName() == 'admin.settings.roles.create') class='active' @endif>
                    <a href='/admin/settings/roles'>
                      <span>Роли</span>
                    </a>
                  </li>
                </ul>
              </li>
            @endif
          </ul>
        </div>
      </nav>
      <section id='content'>
        <div class='container'>
          <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>
              <div class='page-header page-header-with-buttons'>
                <h1 class='pull-left'>
                  <span>@yield('title')</span>
                </h1>
                @yield('create-button')
              </div>
              @if(Session::has('flash_message'))
                  <div class="alert alert-success">
                      {{ Session::get('flash_message') }}
                  </div>
              @endif

              @if($errors->any())
                  <div class="alert alert-danger">
                      @foreach($errors->all() as $error)
                          <p>{{ $error }}</p>
                      @endforeach
                  </div>
              @endif

              @yield('content')
            </div>
          </div>
          <footer id='footer'>
            <div class='footer-wrapper'>
              <div class='row'>
                <div class='col-sm-6 text'>
                  Copyright © 2015 Scory
                </div>
              </div>
            </div>
          </footer>
        </div>
      </section>
    </div>


    <!-- / jquery [required] -->
    <script src="/admin/assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
    <!-- / jquery mobile (for touch events) -->
    <script src="/admin/assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
    <!-- / jquery migrate (for compatibility with new jquery) [required] -->
    <script src="/admin/assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- / jquery ui -->
    <script src="/admin/assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <!-- / jQuery UI Touch Punch -->
    <script src="/admin/assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
    <!-- / bootstrap [required] -->
    <script src="/admin/assets/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
    <!-- / modernizr -->
    <script src="/admin/assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
    <!-- / retina -->
    <script src="/admin/assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
    <!-- / theme file [required] -->
    <script src="/admin/assets/javascripts/theme.js" type="text/javascript"></script>
    <!-- / demo file [required!] -->
    <script src="/admin/assets/javascripts/demo.js" type="text/javascript"></script>

    <script src="//js.pusher.com/3.2/pusher.min.js"></script>
    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      var messageScreen = $('ul.messageScreen');
      var messageCounter = $('.counter');
      var pusher = new Pusher("{{env('PUSHER_KEY')}}",{
        cluster: 'eu',
        encrypted: true
      });

      function loadMessages() {
        var initMessage = $.ajax({
          method: 'POST',
          url: '{{ route("getAllMessages") }}',
          data: {
            _token: '{{ csrf_token() }}'
          }
        }).done(function(data) {
          $('input[name=_token]').attr('value', data[0].token);
          var messages = '';

          if(data[0].id != null){
            for (var i = 0; i < data.length; i++) {
              messages += '<li><a href="/admin/mail/' + data[i].id + '"><div class="widget-body"><div class="pull-left icon"><i class="icon-comments text-success"></i></div><div class="pull-left text">' + data[i].name + ' изпрати съобщение <small class="text-muted">' + data[i].time + '</small></div></div></a></li><li class="divider"></li>';
            }
          }

          messages += '<li class="widget-footer"><a href="{{route("admin.mail.index")}}">Всички съобщения</a></li>'

          if(data[0].count != 0){
            messageCounter.html(data[0].count);
          }

          messageScreen.html(messages);
        });
      }

      loadMessages()

      var channel = pusher.subscribe('MailChanel');
      channel.bind("NewMail", function(data) {
        if(data.new_mail){
          loadMessages()
        }
      });
    </script>

    @yield('javascript')
  </body>

</html>
