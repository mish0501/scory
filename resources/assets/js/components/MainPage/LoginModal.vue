<template lang="html">
    <div>
        <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="LoginModal">Вход</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                
                                <alert :alert="alert" v-if="hasAlert"></alert>

                                <form @submit.prevent="Login()">
                                    <div class="form-group">
                                        <label for="username">Потребителско име</label>
                                        <input type="text" class="form-control" id="username" placeholder="Въведете потребителско си име" v-model="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Парола</label>
                                        <input type="password" class="form-control" id="password" placeholder="Въведете паролата си" v-model="password">
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block" @click.prevent="Login()">Вход</button>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-block facebook" @click.prevent="openLink('facebook')">Влез с Facebook</button>
                                        <button class="btn btn-block google" @click.prevent="openLink('google')">Влез с Google+</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click.parent="OpenRegister()">Нямаш акаунт? Регистрирай се.</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="RegisterModal">Регистрация</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                
                                <alert :alert="alert" v-if="hasAlert"></alert>

                                <form @submit.prevent="Register()">
                                    <div class="form-group">
                                        <label for="name">Име</label>
                                        <input type="text" class="form-control" id="name" placeholder="Въведете името и фамилията си" v-model="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Потребителско име</label>
                                        <input type="text" class="form-control" id="username" placeholder="Въведете потребитеското си име" v-model="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Парола</label>
                                        <input type="password" class="form-control" id="password" placeholder="Въведете паролата си" v-model="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirmation">Повтори паролата</label>
                                        <input type="password" class="form-control" id="password-confirmation" placeholder="Повторете паролата си" v-model="confirmPassword">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block" @click.prevent="Register()">Регистрация</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click.parent="OpenLogin()">Вече имаш акаунт? Влез.</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from "../Alert.vue"
    export default { 
        data() {
            return {
                username: '',
                email: '',
                password: '',
                name: '',
                confirmPassword: '',
                hasAlert: false,
                alert: {}
            }
        },

        components: {
            "alert": Alert
        },

        mounted() {
            $(window).on('message', this.onMessage)
        },

        destroyed () {
            $(window).off('message', this.onMessage)
        },

        methods: {
            OpenLogin() {
                this.reset()
                $('#RegisterModal').modal('hide');
                $('#LoginModal').modal('show');
            },

            OpenRegister() {
                this.reset()
                $('#LoginModal').modal('hide');
                $('#RegisterModal').modal('show');
            },

            reset(){
                this.username = ''
                this.email = ''
                this.password = ''
                this.confirmPassword = ''
                this.name = ''
            },

            Login(){
                let data = {
                    username: this.username,
                    password: this.password,
                    type: 'student'
                }

                this.hasAlert = false

                this.$http.post('/login', data).then(
                    (response) => {
                        if(response.data.user) {
                            this.$store.dispatch('set_user', response.data.user)

                            $('#LoginModal').modal('hide');
                        } else {
                            this.alert.type = 'alert-danger'
                            this.alert.messages = [
                                response.data.username
                            ]                            
                            this.hasAlert = true
                        }
                    }, (error) => {
                        this.alert.type = 'alert-danger'
                        this.alert.messages = []
                        if (Object.keys(error.data).length > 1) {
                            for(var messages in error.data){
                                for(var message in error.data[messages]){
                                    this.alert.messages.push(error.data[messages][message])
                                }
                            }
                        }else {
                            for(var message in error.data){
                                this.alert.messages = error.data[message][0]
                            }
                        }
                        this.hasAlert = true
                    }
                )
            },

            Register(){
                let data = {
                    name: this.name,
                    username: this.username,
                    password: this.password,
                    'password_confirmation': this.confirmPassword,
                    type: 'student'
                }

                this.hasAlert = false

                this.$http.post('/register', data).then(
                    (response) => {                        
                        this.$store.dispatch('set_user', response.data)

                        $('#RegisterModal').modal('hide');
                    }, (error) => {
                        this.alert.type = 'alert-danger'
                        this.alert.messages = []
                        if (Object.keys(error.data).length > 1) {
                            for(var messages in error.data){
                                for(var message in error.data[messages]){
                                    this.alert.messages.push(error.data[messages][message])
                                }
                            }
                        }else {
                            for(var message in error.data){
                                this.alert.messages = error.data[message][0]
                            }
                        }
                        this.hasAlert = true
                    }
                )
            },
            
            onMessage (e) {
                const data = e.originalEvent.data

                if (!data.user) {
                    return
                }
                
                this.$store.dispatch('set_user', data.user)

                $('#LoginModal').modal('hide');
            },

            openLink (provider) {
                let width = parseInt((window.screen.width * 80) / 100, 10)
                let height = parseInt((window.screen.height * 70) / 100, 10)

                if (width < 640) {
                    width = 640
                }

                if (height < 420) {
                    height = 420
                }

                const top = parseInt((window.screen.height - height) / 2, 10)
                const left = parseInt((window.screen.width - width) / 2, 10)

                const options = `location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes,width=${width},height=${height},top=${top},left=${left}`
                let popup = window.open('/auth/'+ provider +'/redirect', null, options)
            }
        }
    }
</script>

<style lang="css">
    .facebook{
        color: #fff;
        background-color: #3B5998;
    }

    .facebook:hover {
        color: #fff;
        background-color: #324c81;
    }

    .google{
        color: #fff;
        background-color: #DB4437;
    }
    
    .google:hover {
        color: #fff;
        background-color: #ba3a2f;
    }
</style>