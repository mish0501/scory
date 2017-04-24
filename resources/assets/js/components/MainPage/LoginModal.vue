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
                                <form>
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Парола</label>
                                        <input type="password" class="form-control" id="password" placeholder="Парола">
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Вход</button>
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
                        <button type="button" class="btn btn-primary" @click.parent="OpenRegister()">Нов за Scory?</button>
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
                                <form>
                                    <div class="form-group">
                                        <label for="username">Име</label>
                                        <input type="text" class="form-control" id="name" placeholder="Име">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Парола</label>
                                        <input type="password" class="form-control" id="password" placeholder="Парола">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Повтори паролата</label>
                                        <input type="password" class="form-control" id="password-confirmation" placeholder="Повтори паролата">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
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
    export default {       
        mounted() {
            $(window).on('message', this.onMessage)
        },

        destroyed () {
            $(window).off('message', this.onMessage)
        },

        methods: {
            OpenLogin() {
                $('#RegisterModal').modal('hide');
                $('#LoginModal').modal('show');
            },

            OpenRegister() {
                $('#LoginModal').modal('hide');
                $('#RegisterModal').modal('show');
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