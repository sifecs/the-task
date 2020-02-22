<?php
$this->layout('leiOut', ['title' => 'страница регистрации']) ?>

<div class="container">
    <form  action="/loginBackend/" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email Адресс</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Ведите Email адрес</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <small class="form-text text-muted">Ведите парольс</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

