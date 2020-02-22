<?php

namespace  App\controllers;

use App\models\QueryBuilder;
use Delight\Auth\Auth;
use Intervention\Image\ImageManager;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;
use PDO;

$host = $_SERVER['DOCUMENT_ROOT'];

class HomeController{

    private $view;
    private $auth;
    private $queryBuilder;
    private $imageManager;

    public function __construct(Engine $view, Auth $auth, QueryBuilder $queryBuilder, ImageManager $imageManager)
        {
            $this->view = $view;
            $this->auth = $auth;
            $this->queryBuilder = $queryBuilder;
            $this->imageManager = $imageManager;
        }

        function index() {
            $products = $this->queryBuilder->all('product');
            $categories = $this->queryBuilder->all('categories');

            echo $this->view->render('index', [
                'products' => $products,
                'categories'=>$categories,
                'auth'=> $this->auth,
                'queryBuilder'=>$this->queryBuilder
            ]);
       }

        function login() {
            echo $this->view->render('login');
        }

        function loginBackend () {
            try {
               $this->auth->login($_POST['email'],$_POST['password']);
                header("Location: $host/home/");
               // echo 'Пользователь вошел в систему';
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                die('Неверный адрес электронной почты');
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Неправильный пароль');
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                die('Email не подтвержден');
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Слишком много запросов');
            }
        }

        function logOut () {
            $this->auth->logOut();
            header("Location: $host/home/");
    }

        function profale () {
//            try {
//                $this->auth->admin()->addRoleForUserById('1', \Delight\Auth\Role::ADMIN);
//            }
//            catch (\Delight\Auth\UnknownIdException $e) {
//                die('неизвестный идентификатор пользователя1');
//            }

            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    echo 'Указанный пользователь является администратором';
                    $products = $this->queryBuilder->all('product');
                    $categories = $this->queryBuilder->all('categories');
                    echo $this->view->render('profale',['products'=>$products,'categories'=>$categories, 'queryBuilder' => $this->queryBuilder]);
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function editCategories () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $categories = $this->queryBuilder->all('categories');
                    echo $this->view->render('editCategories',['categories'=>$categories]);
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function deleteCaterory () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $this->queryBuilder->delete('categories',$_POST['id']);
                    header("Location: $host/editCategories/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function updateCaterory () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $data = ['title'=>$_POST['title']];
                    $this->queryBuilder->update('categories',$data,$_POST['id']);
                    header("Location: $host/editCategories/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function addCategory () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $data = [
                        'title'=>$_POST['title']
                    ];
                    $this->queryBuilder->add('categories', $data);
                    header("Location: $host/editCategories/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function addProduct () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $products = $this->queryBuilder->all('product');
                    $categories = $this->queryBuilder->all('categories');
                    echo $this->view->render('addProduct',['products'=>$products, 'categories'=>$categories]);
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function deleteProduct () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    $this->queryBuilder->delete('product',$_POST['id']);
                    header("Location: $host/profale/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function addProductBackend () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    if (!empty($_FILES['myfile']['name'])) {
                        $str_random = md5(time());
                        $img = $this->imageManager->make($_FILES['myfile']['tmp_name']);
                        $img->save('views/Upload/' . $str_random . $_FILES['myfile']['name']);
                        $_POST['img'] = $str_random . $_FILES['myfile']['name'];
                    }
                    $this->queryBuilder->add('product', $_POST);
                    header("Location: $host/profale/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

        function updateProduct () {
            $id = $this->auth->getUserId();
            try {
                if ( $this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                    if (!empty($_FILES['fileImg']['name'])) {
                        $str_random = md5(time());
                        $img = $this->imageManager->make($_FILES['fileImg']['tmp_name']);
                        $img->save('views/Upload/'.$str_random.$_FILES['fileImg']['name']);
                        $_POST['img'] = $str_random.$_FILES['fileImg']['name'];
                    }

                    $this->queryBuilder->update('product', $_POST, $_POST['id']);
                    header("Location: $host/profale/");
                }
                else {
                    echo 'Указанный пользователь не является администратором';
                }
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                die('неизвестный идентификатор пользователя2');
            }
        }

    }
?>