<?php


namespace controllers;

use core\Controller;
use models\Product;
use core\App;
use core\Response;

class CartController extends Controller
{

	public function actionAdd($id)
	{
		$request = App::request();

		$product = Product::findById($id);

		$productsInfoJson = json_encode([
			'template' => $this->renderPartial('cart/_product-cart-template'),
			'item' => $product->getAttributes(),
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
		]);
	}

}