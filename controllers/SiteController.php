<?php
namespace controllers;

use core\Controller;
use core\App;

use models\Task;
use models\Order;
use models\Login;
use models\User;

use widgets\Pagination;


class SiteController extends Controller
{
	public function actionIndex()
	{
		$request = App::request();
		$authorized = User::isAuthorized();

		$order = new Order();
		$order->load($request->get());

		$pagination = new Pagination([
			'limit' => 3,
			'count' => Task::find()->count()
		]);

		$models = Task::find()
					  ->limit($pagination->limit, $pagination->offset)
					  ->order($order->getCriteria())
					  ->all();


		$this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
			'order' => $order,
			'authorized' => $authorized,
			'page' => $pagination->getPage(),
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