<?php
namespace controllers;

use core\Controller;
use core\App;

use models\User;

use models\Login;
use models\Category;


class SiteController extends Controller
{
	public function actionIndex()
	{


		$categories = Category::find()
							  ->where(['IS', 'parent_id', null])
							  ->all();

		$this->render('index', [
			'categories' => $categories,
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