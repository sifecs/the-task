<?php $this->layout('leiOut', ['title' => 'Редактирование категорий']); ?>

    <div class="container">

        <a href="/addProduct/"> <button type="button" class="btn btn-outline-primary">Добавить товар</button> </a>

            <form class="pt-5 pb-5"  action="/addCategory/" method="post">
                <div class="form-group">
                    <label for="addCategoryInput">Название категории</label>
                    <input type="text" name="title" class="form-control" id="addCategoryInput" >
                    <small class="form-text text-muted">Напишите название категории и нажмите кнопку</small>
                </div>
                <button type="submit" class="btn btn-primary">Добавить категорию</button>
            </form>

        <div class="row">
            <?php foreach ($categories as $item) {  ?>
            <form class="col-md-12" method="post">
                <div class="col-md-12 row mb-3">
                    <div class="col-md-2">
                        <input type="text" name="title" value="<?=$item['title']?>">
                        <input type="hidden" name="id"  value="<?=$item['id']?>">
                    </div>
                    <div class="col-md-6">
                       <a href="/deleteCaterory/"> <button type="submit" formaction="/deleteCaterory/" class="btn btn-sm btn-primary">Удалить</button> </a>
                       <a href="/updateCaterory/"> <button type="submit" formaction="/updateCaterory/" class="btn btn-sm btn-primary">Изменить</button> </a>
<!--                        Я этот formaction атрибут искал около часа -->
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>

<?php
