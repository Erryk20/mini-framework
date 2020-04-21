<?php
namespace controllers;

use core\Controller;
use core\App;

use models\Task;
use models\User;

class TaskController extends Controller
{
	public function actionCreate()
	{
		$model = new Task();
		$request = App::request();

		$alertMessage = null;
		if ($model->load($request->post()) && $model->save()) {
			$alertMessage = 'Задача добавлена';
			$model->refresh();
		};

		$this->render('create', [
			'model'=> $model,
			'alertMessage' => $alertMessage,
			'authorized' => User::isAuthorized()
		]);
	}

	/**
	 * @param string $id
	 *
	 * @throws \ErrorException
	 * @throws \ReflectionException
	 */
	public function actionUpdate($id)
	{
		$request = App::request();

		if (!User::isAuthorized()) {
			$request->redirect('/site/login');
		}

		$model = $this->getModel($id);

		$alertMessage = null;
		if ($model->load($request->post()) && $model->save()) {
			$alertMessage = 'Задача оновлена';
		};

		$this->render('create', [
			'model'=> $model,
			'alertMessage' => $alertMessage,
			'authorized' => User::isAuthorized()
		]);
	}

	/**
	 * @param string $id
	 *
	 * @return Task|null
	 * @throws \ErrorException
	 */
	public function getModel($id)
	{
		if($model = Task::findById($id)) {
			return $model;
		}

		throw new \ErrorException("Record not found");
	}

}