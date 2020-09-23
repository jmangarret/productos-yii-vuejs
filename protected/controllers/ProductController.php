<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + create',
			'putOnly + update',
			'deleteOnly + delete',
		);
	}

	public function filterPutOnly($filterChain)
	{
		if (Yii::app()->getRequest()->getIsPutRequest()){
			$filterChain->run();
		}else{
			throw new Exception("Error Processing Request", 1);
			
		}
	}

	public function filterDeleteOnly($filterChain)
	{
		if (Yii::app()->getRequest()->getIsDeleteRequest()){
			$filterChain->run();
		}else{
			throw new Exception("Error Processing Request", 1);	
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		header('Content-type: application/json', true, 200);

		$model = $this->loadModel($id);
		//var_dump($model->getAttributes()); die();
		echo json_encode($model->getAttributes());

		Yii::app()->end();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		header('Content-type: application/json', true, 200);

		$model=new Product;

		$model->attributes = Yii::app()->getRequest()->getRestParams();

		//$validate = CActiveForm::validate($model);
		
		if ($model->save()){
			echo json_encode([
				'success' => true,
				'message' => 'Datos guardados con exito!',
				'data' => $model
			]);

			Yii::app()->end();
		}

		echo json_encode([
			'success' => false,
			'message' => 'Error en datos del form!',
			'data' => $model->getErrors()
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		header('Content-type: application/json', true, 200);

		$model=$this->loadModel($id);

		$model->attributes=Yii::app()->getRequest()->getRestParams();

		if ($model->save()){
			echo json_encode([
				'success' => true,
				'message' => 'Datos actualizados con exito!',
				'data' => $model
			]);

			Yii::app()->end();
		}

		echo json_encode([
			'success' => false,
			'message' => 'Error al actualizar datos!',
			'data' => $model->getErrors()
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		$model->delete();

		if ($model){
			echo json_encode([
				'success' => true,
				'message' => 'Registro eliminado con exito!',
				'data' => $model
			]);

			Yii::app()->end();
		}

		echo json_encode([
			'success' => false,
			'message' => 'Error al actuaizar datos!',
			'data' => $model->getErrors()
		]);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		header('Content-type: application/json', true, 200);
		
		$dataProvider=new CActiveDataProvider('Product');
		$data = [];
		foreach ($dataProvider->getData() as $record) {
			$data[] = $record->getAttributes();
		}

		echo json_encode($data);
		
		Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
