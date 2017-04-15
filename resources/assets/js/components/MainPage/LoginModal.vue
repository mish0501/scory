<template lang="html">
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
                        <a href="/auth/facebook/redirect" role="button" class="btn btn-block facebook">Влез с Facebook</a>
                        <a href="/auth/google/redirect" role="button" class="btn btn-block google">Влез с Google+</a>
                    </div>
                </form>
            </div>
        </div>
        <hr>
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
    </div>
  </div>
</template>

<style lang="css">
    hr {
        border-top: 1px solid #ccc;
    }

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