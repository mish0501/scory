<!DOCTYPE html>
<html>
  <head>
    <title>Green Sheet - Администраторски панел</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta content='text/html;charset=utf-8' http-equiv='content-type'>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/assets/images/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-16x16.png" sizes="16x16">
    <!-- /Favicons -->

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

    <style media="screen">
      #main-nav-bg {
        z-index: 1
      }

      #main-nav {
        z-index: 2
      }
    </style>
  </head>
  <body class='contrast-grass-green'>
    <div id="app">
      <header>
        <nav class='navbar navbar-default'>
          <a class='navbar-brand' href='/admin/home'>
            <img height="21" class="logo" alt="Flatty" src="/admin/assets/images/logo.svg" />
            <img height="21" class="logo-xs" alt="Flatty" src="/admin/assets/images/logo_xs.svg" />
          </a>
          <a class='toggle-nav btn pull-left' href='#'>
            <i class='icon-reorder'></i>
          </a>
          <ul class='nav'>
            @if(Auth::user()->can('list-mail'))
              <messeges-widget></messeges-widget>
            @endif
            <li class='dropdown dark user-menu'>
              <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                @if(Auth::user()->avatar != NULL)
                  <img id='avatar' width="60" height="60" alt="" src="{{ Auth::user()->files()->find(Auth::user()->avatar)->url }}" />
                @else
                  <img id='avatar' width="23" height="23" alt="" src="/admin/assets/images/avatar/avatar.jpg" />
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
                  <form method="POST" action="{{ url('/logout') }}" accept-charset="UTF-8" id="logout-form">
                    {{ csrf_field() }}
                  </form>
                  <a href="#" onclick="document.getElementById('logout-form').submit();">
                    <i class="icon-signout"></i>
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
            <ul class='nav nav-stacked'>
              <router-link to="/admin/home" tag="li">
                <a>
                  <i class='icon-dashboard'></i>
                  <span>Начало</span>
                </a>
              </router-link>

              @if(Entrust::can('list-subject'))
                <router-link to="/admin/subject" tag="li">
                  <a>
                    <i class='icon-book'></i>
                    <span>Предмет</span>
                  </a>
                </router-link>
              @endif

              @if(Entrust::can('list-partition'))
                <router-link to="/admin/partition" tag="li">
                  <a>
                    <i class='icon-folder-open'></i>
                    <span>Раздел</span>
                  </a>
                </router-link>
              @endif

              @if(Entrust::can('list-question'))
                <router-link to="/admin/question" tag="li">
                  <a>
                    <i class='icon-question'></i>
                    <span>Въпроси</span>
                  </a>
                </router-link>
              @endif

              <router-link to="/admin/testroom" tag="li">
                <a>
                  <i class='icon-group'></i>
                  <span>Стая за тестове</span>
                </a>
              </router-link>

              @if(Entrust::can('list-invitation') && Entrust::hasRole('admin'))
                <router-link to="/admin/invite" tag="li">
                  <a>
                    <i class='icon-envelope'></i>
                    <span>Покана</span>
                  </a>
                </router-link>
              @endif

              @if(Entrust::can('list-mail') && Entrust::hasRole('admin'))
                <router-link to="/admin/mail" tag="li">
                  <a>
                    <i class='icon-comments'></i>
                    <span>Съобщения</span>
                  </a>
                </router-link>
              @endif

              @if(Entrust::hasRole('admin') || (Entrust::hasRole('teacher') && Entrust::can('delete-testroom')))
                <router-link to="/admin/trash" tag="li">
                  <a>
                    <i class='icon-trash'></i>
                    <span>Кошче</span>
                  </a>
                </router-link>
              @endif

              @if(Entrust::hasRole('admin'))
                <li>
                  <a class="dropdown-collapse">
                    <i class='icon-cogs'></i>
                    <span>Настройки на сайта</span>
                    <i class='icon-angle-down angle-down'></i>
                  </a>

                  <router-link to="/admin/settings" tag="ul" class="nav nav-stacked" active-class="in">
                    <router-link to="/admin/settings/users" tag="li">
                      <a>
                        <span>Потребители</span>
                      </a>
                    </router-link>
                    <router-link to="/admin/settings/permissions" tag="li">
                      <a>
                        <span>Права</span>
                      </a>
                    </router-link>
                    <router-link to="/admin/settings/roles" tag="li">
                      <a>
                        <span>Роли</span>
                      </a>
                    </router-link>
                  </router-link>
                </li>
              @endif
            </ul>
          </div>
        </nav>
        <section id='content'>
          <div class='container'>
            <router-view></router-view>

            <footer id='footer'>
              <div class='footer-wrapper'>
                <div class='row'>
                  <div class='col-sm-6 text'>
                    Copyright © 2015 Green Sheet
                  </div>
                </div>
              </div>
            </footer>
          </div>
        </section>
      </div>
    </div>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <script src="/assets/js/app.js"></script>

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
    <!-- / theme file [required] -->
    <script src="/admin/assets/javascripts/theme.js" type="text/javascript"></script>

    <script type="text/javascript">
      $('li.dropdown').on('click', function() {
        $(this).toggleClass('open');
      });
    </script>

  </body>

</html>
