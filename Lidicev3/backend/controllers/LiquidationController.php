<?php

namespace backend\controllers;

use Yii;
use app\models\Liquidation;
use app\models\LiquidationItem;
use app\models\LiquidationSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Arancel;

/**
 * LiquidationController implements the CRUD actions for Liquidation model.
 */
class LiquidationController extends Controller
{
    public function init()
    {
		User::ControlUserCan(["Movir","Preparado"]);
        parent::init();
    }

	public function beforeAction($action)
    {
		$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

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
     * Lists all Liquidation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LiquidationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionPrint()
	{
		$this->layout = "print";
		if (! isset($_POST['lid']))
		{
			return false;
		}

		$Liquidation = Liquidation::find()->where(['id'=>$_POST['lid']])->one();
		$LiquidationItems = LiquidationItem::find()->where(['liquidation_id'=>$_POST['lid']])->orderBy('proveedores_id')->all();


		return $this->render('print', [
			'Liquidation' => $Liquidation,
			'LiquidationItems' => $LiquidationItems,
		]);
	}

    /**
     * Displays a single Liquidation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if (isset($_POST) and count($_POST) > 0) {
            //mail("qualityclix01@gmail.com","post data live",print_r($_REQUEST,true));
        }
		
		if (isset($_POST['act']) && $_POST['act'])
		{
			switch ($_POST['act'])
			{
				case "add-records":
					$data = json_decode($_POST['data_to_process']);

                     // if (count($data) < 1)
                     // {
                     //     LiquidationItem::deleteAll(['liquidation_id' => $id]);
                     // }

					if (is_array($data) && count($data))
					{
						LiquidationItem::deleteAll(['liquidation_id' => $id]);

						foreach ($data AS $row)
						{
                            // resolve duplication issue
                            $LiquidationItem = LiquidationItem::find()->where(['liquidation_id' => $id,'arancel_id'=>$row->arancel_id,'desc' => $row->descripciyon])->one();
                            if (!isset($LiquidationItem)) {
                                $LiquidationItem = new LiquidationItem();
                            }
							//$LiquidationItem = new LiquidationItem();
                            $LiquidationItem->liquidation_id = $id;
                            $LiquidationItem->arancel_id = $row->arancel_id;
                            $LiquidationItem->tipo_id = $row->tipocodigo_id;
                            if (isset($row->canreal) and !empty($row->canreal)) {
                                $LiquidationItem->canreal = $row->canreal;
                            }
                            if (isset($row->crf) and !empty($row->crf)) {
                                $LiquidationItem->crf = $row->crf;
                            }
                            if (isset($row->fob) and !empty($row->fob)) {
                                $LiquidationItem->fob = $row->fob;
                            }
                            if (isset($row->cif) and !empty($row->cif)) {
                                $LiquidationItem->cif = $row->cif;
                            }
                            // if (isset($row->bultos) and !empty($row->bultos)) {
                            //     $LiquidationItem->bultos = $row->bultos;
                            // }

                            if (isset($row->descripciyon) and !empty($row->descripciyon)) {
                                $LiquidationItem->desc = $row->descripciyon;
                            }

                            if (isset($row->item_peso) and !empty($row->item_peso)) {
                                $LiquidationItem->item_peso = $row->item_peso;
                            }

                            $LiquidationItem->save(false);

                            // update discription of arnacel

                            // if (isset($row->descripciyon)) {
                            // $arancel = Arancel::find()->where(['id'=>$row->arancel_id])->one();
                            //     $arancel->descripcion = trim($row->descripciyon);
                            //     $arancel->save(false);
                            // }

       //                      if (isset($_POST['tipocodigo_id'])) {
       //                          $model->tipo_id = $row->tipocodigo_id;
       //                      }
       //                      if (isset($_POST['canreal'])) {
       //                          $model->canreal = $row->canreal;
       //                      }
       //                      if (isset($_POST['flete'])) {
       //                          $model->flete = $_POST['flete'];
       //                      }
       //                      if (isset($_POST['flete'])) {
       //                          $model->flete = $_POST['flete'];
       //                      }

							// $LiquidationItem->attributes = array(
							// 	'liquidation_id' => $id,
							// 	//'proveedores_id' => $row->proveedores_id,
							// 	'arancel_id' => $row->arancel_id,
							// 	'tipo_id' => $row->tipocodigo_id,
       //                          'canreal' => $row->canreal,
       //                          'crf' => $row->crf,
       //                          'fob' => $row->fob,
       //                          'cif' => $row->cif,
							// 	//'cantbulto' => $row->cantbulto,
							// 	//'entero' => $row->entero,
							// 	//'valor' => $row->valor,
							// );
							// $LiquidationItem->save();

						}
					}
                    // update liqidation
                    $model = $this->findModel($id);

                    if (isset($_POST['flete'])) {
                        $model->flete = $_POST['flete'];
                    }
                    
                    if (isset($_POST['seg'])) {
                        $model->seg = $_POST['seg'];
                    }

                    if (isset($_POST['peso-total'])) {
                        $model->peso = $_POST['peso-total'];
                    }

                    if (isset($_POST['gasto1'])) {
                        $model->gasto1 = $_POST['gasto1'];
                    }

                    if (isset($_POST['gasto2'])) {
                        $model->gasto2 = $_POST['gasto2'];
                    }

                    if (isset($_POST['bultos'])) {
                        $model->bultos = $_POST['bultos'];
                    }

                    if (!isset($_POST['customPeso'])) {
                        $model->customPeso = 0;
                    }

                    if (isset($_POST['customPeso'])) {
                        $model->customPeso = $_POST['customPeso'];
                    }

                    $model->save(false);

					break;
			}
		}

		$CurrentItems = LiquidationItem::find()->where(['liquidation_id'=>$id])->orderBy('liquidation_id')->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
			'CurrentItems' => $CurrentItems,
        ]);
    }

    /**
     * Creates a new Liquidation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Liquidation();

        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
            return $this->redirect(['view', 'id' => $model->id]);
        }
		else
		{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Liquidation model.
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
     * Deletes an existing Liquidation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        LiquidationItem::deleteAll(['liquidation_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Liquidation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Liquidation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Liquidation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
