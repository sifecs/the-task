<?php $this->layout('leiOut', ['title' => 'Добавление товаров']); ?>

    <div class="container">

        <a href="/editCategories/"><button type="button" class="btn btn-outline-success">Добавить-изменить категории</button> </a>

        <form  action="/addProductBackend/" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titleAddProduct">Название</label>
                <input type="text" name="title" class="form-control" id="titleAddProduct">
                <small class="form-text text-muted">Напишите название товара</small>
            </div>
            <div class="form-group">
                <label for="descriptionAddProduct">Описание</label>
                <input type="text" name="description" class="form-control" id="descriptionAddProduct">
                <small class="form-text text-muted">Напишите описание товара</small>
            </div>

            <div class="form-group">
                <label for="ImgAddProduct">Картинка</label>
                <input type="file" name="myfile" class="form-control" id="ImgAddProduct">
                <small class="form-text text-muted">Выберите картинку товара</small>
            </div>

            <div class="form-group">
                <label for="categoryAddProduct">Категория</label>
<!--                <input type="text" name="id_categories" class="form-control" id="categoryAddProduct">-->
                <select class="form-control" id="categoryAddProduct" name="id_categories">
                    <option disabled>Выберите Категорию</option>
                    <?php foreach ($categories as $item) { ?>
                        <option value="<?=$item['id']?>"> <?=$item['title']?> </option>
                    <?php } ?>
                </select>
                <small class="form-text text-muted">Выберите категорию товара</small>
            </div>

            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>

    </div>

<?php


//id
//title
//description
//img
//id_categories