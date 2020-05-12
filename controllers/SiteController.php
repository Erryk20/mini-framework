<?php
namespace controllers;

use core\Controller;
use core\App;

use models\User;

use models\Login;
use models\Category;
use models\Categories;
use models\Tree;


class SiteController extends Controller
{
	public function actionIndex()
	{


		$categories = Category::find()
							  ->where(['IS', 'parent_id', null])
							  ->all();


		$tree = (new Tree(Categories::find()->all()))->generate(0);

		$this->render('index', [
			'categories' => $categories,
			'tree' => $tree,
		]);
	}

	public function actionLogin()
	{
		$request = App::request();

		if (User::isAuthorized()) {
			$request->redirect('/');
		}

		$model = new Login();

		$alertMessage = '';
		if ($model->load($request->post()) && $model->validate()) {
			$user = User::findUser($model->login, $model->password);
			if ($user && $user->login()) {
				$request->redirect('/');
			}

			$alertMessage = 'Логін або пароль не дійсні';
		};

		$this->render('login', [
			'model'=> $model,
			'alertMessage' => $alertMessage
		]);

	}

	public function actionLogout()
	{
		$request = App::request();

		unset($_SESSION['user_id']);
		$request->redirect('/site/login');
	}

}