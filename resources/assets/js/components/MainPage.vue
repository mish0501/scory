<template id="MainPage">
  <div>
    <nav class="navbar navbar-inverse navbar-fixed-top" id="menu">
      <div class="container">
        <div class="navbar-header">
          <button type="button" id="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Меню</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand scroll-effect" data-scroll="top">GreenSheet</a>
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
        <h1>Green Sheet</h1>
      </div>
    </div>

    <div class="container">

      <!-- About -->
      <div class="row" id="about">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="text-center">За проекта</h2>
          <p class="text-justify">Чрез „Green Sheet“ можете лесно и бързо да генерирате най-различни тестове във всяка една образователна област, за всеки един клас по раздели.</p>
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
          <p><a class="btn btn-success btn-lg btn-block" href="/vue/test" role="button">Избери си тест</a></p>
        </div>
        <div class="col-md-4 col-md-offset-2 text-center">
          <h2>Влез в стая за тестове</h2>

          <test-room-form></test-room-form>
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
          <invite-email-form></invite-email-form>
        </div>
      </div>

      <hr>

      <!-- Contact -->
      <div class="row" id="contact">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="text-center">Контакти</h2>
        </div>
        <div class="col-md-10 col-md-offset-1">
          <contact-form></contact-form>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div>
  </div>
</template>

<script>
  export default {
    components: {
      'test-room-form': require('./MainPage/JoinTestRoomForm.vue'),
      'invite-email-form': require('./MainPage/InviteEmailForm.vue'),
      'contact-form': require('./MainPage/ContactForm.vue')
    }
  }
</script>
