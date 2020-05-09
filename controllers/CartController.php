<?php


namespace controllers;

use core\Controller;
use models\Product;
use core\App;
use core\Response;
use helpers\ArrayHelper;
use models\ProductSearch;

class CategoryController extends Controller
{

	public function actionIndex($id)
	{
		$request = App::request();

		$products = ProductSearch::search($request->get());

		$productsInfoJson = json_encode([
			'template' => $this->renderPartial('product/_product-template'),
			'items' => ArrayHelper::convertToArray($products),
			'keyTemplate' => 'productItem',
		], JSON_THROW_ON_ERROR);


		if($request->isPost()) {
			Response::setContantType(Response::TYPE_JSON);
			echo $productsInfoJson;
			die();
		}

		$product = new Product();
		$product->sort = $request->get('sort');

		$this->render('index', [
			'productsInfoJson' => $productsInfoJson,
			'product' => $product,
		]);
	}

}