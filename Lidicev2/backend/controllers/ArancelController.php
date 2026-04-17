<?php

namespace backend\controllers;

use Yii;
use app\models\Arancel;
use app\models\ArancelSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\UploadForm;

/**
 * ArancelController implements the CRUD actions for Arancel model.
 */
class ArancelController extends Controller
{
    /**
     * @inheritdoc
     */

	public function init()
    {
		User::ControlUserCan(["Movir","Preparado"]);
        parent::init();
    }

    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete','import'],
                        'allow' => true,
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
     * Lists all Arancel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArancelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Arancel model.
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
     * Creates a new Arancel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Arancel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Arancel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Arancel model.
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
     * Finds the Arancel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Arancel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Arancel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
	import Arancel from csv
	*/
	public function actionImport()
    {
		ini_set('max_execution_time', -1); //300 seconds = 5 minutes
        //$model = new Import();
		$model = new UploadForm();		

        if ($model->load(Yii::$app->request->post()) ) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ( $model->file )
                {
                    $time = time();
                    //$model->file->saveAs('csv/' .$time. '.' . $model->file->extension);
					$model->file->saveAs($time. '.' . $model->file->extension);
                    $model->file = $time. '.' . $model->file->extension;

					 $row = 1;
                     $handle = fopen($model->file, "r");
                     while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                     {
						if ($row == 1) {
							$row++;
							continue;
						}
                        $codigo = trim($fileop[0]);
                        $descripcion = addslashes(trim($fileop[1]));
                        $dia = $fileop[2];
						$itbm = $fileop[3];
						$isc = $fileop[4];
						$descripcion_simple = $fileop[5];
						
						$arnecel = Arancel::find()->where(['codigo'=>$codigo])->one();
						
						if ($codigo > 0 and strlen($codigo) > 0 and strlen($descripcion) > 0) {
						
							if (isset($arnecel->id)) {
								$codigo_code = $arnecel->codigo;
								$sql = "Update arancel set descripcion = '$descripcion', dia = '$dia', itbm = '$itbm', isc = '$isc', descripcion_simple = '$descripcion_simple' where codigo = '$codigo_code' limit 1";
							} else {
								$sql = "INSERT INTO arancel set codigo = '$codigo', descripcion = '$descripcion', dia = '$dia', itbm = '$itbm', isc = '$isc', descripcion_simple = '$descripcion_simple' ";
							}
							
							$query = Yii::$app->db->createCommand($sql)->execute();
							
						}
						$row++;
                     }

                     if ($row>1) 
                     {
                        //echo "Arancels uploaded successfully";
						Yii::$app->session->setFlash('uploadsuccess', "Arancels uploaded successfully");
						//Yii::app()->user->setFlash('uploadsuccess', "Arancels uploaded successfully");
                     }

                }

			return $this->redirect(['index']);
        } else {
            return $this->render('import', [
                'model' => $model,
            ]);
        }
    }
}
