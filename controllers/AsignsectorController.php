<?php

namespace app\controllers;

use Yii;
use app\models\Asignsector;
use app\models\AsignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\commands\RoleAccessChecker;

/**
 * AsignsectorController implements the CRUD actions for Asignsector model.
 */
class AsignsectorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Asignsector models.
     * @return mixed
     */
    public function actionIndex(){
		//$ctrl = new RoleAccessChecker();
		if (RoleAccessChecker::actionIsAsignSector('asignsector/index')) {
			$searchModel = new AsignSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);		
        }else{
			return $this->redirect(['error/error']);
		}
    }

    /**
     * Displays a single Asignsector model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
		//$ctrl = new RoleAccessChecker();
		if (RoleAccessChecker::actionIsAsignSector('asignsector/view')) {
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
        }else{
			return $this->render('error/error');
		}
    }

    /**
     * Creates a new Asignsector model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
		//~ $ctrl = new RoleAccessChecker();
		if (RoleAccessChecker::actionIsAsignSector('asignsector/create')) {
			$model = new Asignsector();

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->asignsector_id]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
        }else{
			return $this->render('error/error');
		}
    }

    /**
     * Updates an existing Asignsector model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
		//~ $ctrl = new RoleAccessChecker();
		if (RoleAccessChecker::actionIsAsignSector('asignsector/update')) {
			$model = $this->findModel($id);

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->asignsector_id]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
        }else{
			return $this->render('error/error');
		}
    }

    /**
     * Deletes an existing Asignsector model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){
		//~ $ctrl = new RoleAccessChecker();
		if (RoleAccessChecker::actionIsAsignSector('asignsector/delete')) {
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
        }else{
			return $this->render('error/error');
		}
    }

    /**
     * Finds the Asignsector model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asignsector the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asignsector::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}