<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use app\models\RegisterForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
	public function init()
    {
		User::ControlUserCan();
        parent::init();
    }
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegisterForm();
		$model->isNewRecord = true;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
		{
			$User = new User();
			$User->attributes = [
				'username' => $model->username,
				'email' => $model->email,
				'status' => $model->status,
				'created_at' => time(),
				'updated_at' => time(),
				'password_hash' => Yii::$app->security->generatePasswordHash($model->password),
			];
			if ($User->save())
			{
				return $this->redirect(['view', 'id' => $User->id]);
			}
			else
			{
				return $this->render('create', ['model' => $model]);
			}
        }
		else
		{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $User = $this->findModel($id);

        $model = new RegisterForm();
		$model->isNewRecord = false;

		$model->username = $User->username;
		$model->email = $User->email;
		$model->status = $User->status;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
		{
			$User->attributes = [
				'username' => $model->username,
				'email' => $model->email,
				'status' => $model->status,
				'updated_at' => time()
			];
			if (strlen($model->password))
			{
				$User->password_hash = Yii::$app->security->generatePasswordHash($model->password);
			}
			if ($User->save())
			{
				return $this->redirect(['view', 'id' => $User->id]);
			}
			else
			{
				return $this->render('update', ['model' => $model]);
			}
        }
		else
		{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
