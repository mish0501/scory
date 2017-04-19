<template id="MainPage">
  <div>
    <nav class="navbar navbar-inverse navbar-fixed-top" id="menu">
      <div class="container">
        <div class="navbar-header">
          <button type="button" id="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Меню</span>
            <i class="fa fa-bars fa-4" aria-hidden="true" style="color: white"></i>
          </button>
          <a class="navbar-brand scroll-effect" data-scroll="top">
            <span id="logo"></span> Scory
          </a>
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
      <div class="color-overlay"></div>
      <div class="container">
        <h1>Добре дошли!</h1>
      </div>
    </div>

    <div class="container">

      <!-- About -->
      <div class="row" id="about">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="text-center">За проекта</h2>
          <br>
          <p class="text-center aboutTitle">За учениците.</p>
          <p class="text-center">
            Подготви се за тестове. Бъди крачка напред пред останалите. Упражнявай се, преглеждай уроци.
            <br>
            Бъди най-добрия.
          </p>

          <hr>

          <p class="text-center aboutTitle">За учителите.</p>
          <p class="text-center">
            „Scory“ е вашият най-добър помощник с подготовката на тестове и уроци.
          </p>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1">
        <hr>
      </div>

      <!-- Student -->
      <div class="row" id="student">
        <header class="col-md-10 col-md-offset-1 text-center">
          <h2>Ученик?</h2>
          <p>Ако си ученик можеш да си избереш една от тези опции.</p>
        </header>
        <div class="col-md-4 col-md-offset-1 text-center">
          <h2>Влез в стая за тестове</h2>
          
          <test-room-form :start="false" v-if="isLogged"></test-room-form>

          <div v-else>
            <p class="text-center">Влез в акаунта си, за да можеш да влезеш в стая за тестове.</p>
            <p>
              <button type="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#LoginModal">
                Вход
              </button>
            </p>
          </div>
        </div>
        <div class="col-md-4 col-md-offset-2 text-center">
          <h2>Избери си тест</h2>
          <p class="text-center">Избери класа си, предмета и раздела, по който искаш да се упражняваш.</p>
          <p><a class="btn btn-danger btn-lg btn-block" href="/test/select" role="button">Избери си тест</a></p>
        </div>
        <div class="col-md-4 col-md-offset-4 text-center">
          <h2>Прегледай урок</h2>
          <p class="text-center">Избери класа си, предмета и раздела, по който искаш да прегледаш уроците.</p>
          <p><router-link tag="a" :to="{path: '/lesson/select'}" class="btn btn-danger btn-lg btn-block" role="button">Прегледай урок</router-link></p>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1">
        <hr>
      </div>

      <!-- Teacher -->
      <div class="row" id="teacher">
        <header class="col-md-10 col-md-offset-1 text-center">
          <h2>Учител?</h2>
          <p class="text-center">За да можете да използвате сайта, трябва да получите покана. За тази цел въведете e-mail си и ще я изпратим.</p>
        </header>
        <div class="col-md-6 col-md-offset-3 text-center">
          <invite-email-form></invite-email-form>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1">
        <hr>
      </div>

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
        <p>&copy; Scory 2017</p>
      </footer>
    </div>

    
    <login-modal></login-modal>
  </div>
</template>

<script>
  import JoinTestRoomForm from "./MainPage/JoinTestRoomForm.vue"
  import InviteEmailForm from "./MainPage/InviteEmailForm.vue"
  import ContactForm from "./MainPage/ContactForm.vue"
  import LoginModal from "./MainPage/LoginModal.vue"

  export default {
    components: {
      'test-room-form': JoinTestRoomForm,
      'invite-email-form': InviteEmailForm,
      'contact-form': ContactForm,
      'login-modal': LoginModal
    },

    mounted() {
      this.$http.get('/api/user').then((response) => {
        this.$store.dispatch('set_user', response.data)
      }, console.error)
    },

    computed: {
      isLogged() {
        return this.$store.getters.User.id !== null;
      }
    }
  }
</script>
