<?php

namespace app\controllers;

use Yii;
use app\models\Materia;
use app\models\MateriaSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\commands\RoleAccessChecker;
use app\controllers\ErrorController;

/**
 * MateriaController implements the CRUD actions for Materia model.
 */
class MateriaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()	{
        return [
              'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['index', 'view', 'update', 'create', 'delete',],
                 'rules' => [
                     [
                         'allow' => true,
                         'actions' => ['',],
                         'roles' => ['?'],
                     ],
                     [
                         'allow' => true,
                         'actions' => ['index', 'view', 'update', 'create', 'delete',],
                         'roles' => ['@'],
                     ],
                     [
                         'allow' => false,
                         'actions' => ['',],
                         'roles' => ['@'],
                     ],
                 ],
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Materia models.
     * @return mixed
     */
    public function actionIndex(){
		$msg='';
		if (RoleAccessChecker::actionIsAsignSector('materia/index')) {
			try{
				$searchModel = new MateriaSearch();
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

				return $this->render('index', [
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider,
				]);
 			} catch (\yii\db\Exception $e) {return $this->redirect(['error/db-grant-error',]);}
        }else return $this->redirect(['error/level-access-error',]);
	}

    /**
     * Displays a single Materia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
		$msg='';
		if (RoleAccessChecker::actionIsAsignSector('materia/view')) {
			try{
				return $this->render('view', [
					'model' => $this->findModel($id),
				]);
 			} catch (\yii\db\Exception $e) {return $this->redirect(['error/db-grant-error',]);}
        }else return $this->redirect(['error/level-access-error',]);
    }

    /**
     * Creates a new Materia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
		$msg='';
		if (RoleAccessChecker::actionIsAsignSector('materia/create')) {
			try{
				$model = new Materia();

				if ($model->load(Yii::$app->request->post()) && $model->save()) {
					return $this->redirect(['index', 'id' => $model->materia_id]);
				} else {
					return $this->render('create', [
						'model' => $model,
					]);
				}
 			} catch (\yii\db\Exception $e) {return $this->redirect(['error/db-grant-error',]);}
        }else return $this->redirect(['error/level-access-error',]);
    }

    /**
     * Updates an existing Materia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
		$msg='';
		if (RoleAccessChecker::actionIsAsignSector('materia/update')) {
			try{
				$model = $this->findModel($id);

				if ($model->load(Yii::$app->request->post()) && $model->save()) {
					return $this->redirect(['index', 'id' => $model->materia_id]);
				} else {
					return $this->render('update', [
						'model' => $model,
					]);
				}
 			} catch (\yii\db\Exception $e) {return $this->redirect(['error/db-grant-error',]);}
        }else return $this->redirect(['error/level-access-error',]);
    }

    /**
     * Deletes an existing Materia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){
		$msg='';
		if (RoleAccessChecker::actionIsAsignSector('materia/delete')) {
			try{
				$this->findModel($id)->delete();
				return $this->redirect(['index']);
 			} catch (\yii\db\Exception $e) {return $this->redirect(['error/db-grant-error',]);}
        }else return $this->redirect(['error/level-access-error',]);
    }

    /**
     * Finds the Materia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Materia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Materia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
