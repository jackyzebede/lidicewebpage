<?php

namespace backend\controllers;

use Yii;
use app\models\Mainlist;
use app\models\MainlistSearch;
use app\models\Client;
use app\models\MainlistClient;
use app\models\MainlistClientItem;
use app\models\MainlistLog;
use app\models\Driver;
use app\models\Proveedores;
use app\models\MainlistClientDriverNumber;
use app\models\MainlistNotify;

use common\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

/**
 * MainlistController implements the CRUD actions for Mainlist model.
 */
class MainlistController extends Controller
{

	public function beforeAction($action)
    {
		$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
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
     * Lists all Mainlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MainlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionPrintall()
	{
		if ( ! User::UserCan("Despachado") && ! User::UserCan("Preparado"))
		{
			return Yii::$app->response->redirect(['/']);
			exit();
		}
		$this->layout = "print";
		if ( ! isset($_POST['mlid']))
		{
			return false;
		}

		$Dispatched = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
		if ( ! $Dispatched) return false;

		$Mainlist = Mainlist::find()->where(['id'=>$_POST['mlid']])->one();
		if ( ! $Mainlist) return false;

		if ($Mainlist->status < 2)
		{
			$Mainlist->attributes = ['status'=>2];
			$Mainlist->save();
			$this->MakeLog($Mainlist->id, "Status of Main List is changed to 'Printed'");
		}

		$Authorized = User::find()->where(['id' => $Mainlist->authorized_id])->one();
		if ( ! $Authorized) return false;

		$this->view->params['Authorized'] = $Authorized->username;
		$this->view->params['cdate'] = $Mainlist->cdate;
		$this->view->params['embargue'] = $Mainlist->number;

		/* ***************** */
		$ListSheets = [];
		$MainlistClientData = MainlistClient::find()->where(['mainlist_id' => $Mainlist->id])->all();
		if ( ! $MainlistClientData)
		{
			return false;
		}
		foreach ($MainlistClientData AS $MainlistClient)
		{
			$MainlistClientDrivers = MainlistClientItem::find()
					->select('driver_id')
					->distinct()
					->where(['mainlist_client_id' => $MainlistClient->id])
					->andWhere(['>', 'driver_id', 0])
					->all();
			if ( ! $MainlistClientDrivers)
			{
				continue;
			}
			foreach ($MainlistClientDrivers AS $MainlistClientDriver)
			{
				$Driver = Driver::find()->where(['id' => $MainlistClientDriver->driver_id])->one();
				// MainlistClient -> determined above
				$Client = Client::find()->where(['id'=>$MainlistClient->client_id])->one();
				$MainlistClientItems = MainlistClientItem::find()
							->where(['mainlist_client_id'=>$MainlistClient->id])
							->andWhere(['driver_id'=>$Driver->id])
							->all();
				$TotalBultos = MainlistClientItem::find()
							->where(['mainlist_client_id' => $MainlistClient->id])
							->sum('ctns');

				$Numero = $Mainlist->number."-".MainlistClientDriverNumber::GetNumber($Mainlist->id, $Client->id, $Driver->id);

				if (! $Driver || ! $Client || ! $MainlistClientItems || ! count($MainlistClientItems) )
				{
					continue;
				}

				$this->MakeLog($Mainlist->id, "The actual list (".$Numero.") is printed out");

				$ListSheets[] = [
					'Driver' => $Driver,
					'Client' => $Client,
					'MainlistClientItems' => $MainlistClientItems,
					'MainlistClient' => $MainlistClient,
					'Numero' => $Numero,
					'TotalBultos' => $TotalBultos,
				];
			}
		}

		return $this->render('printall', [
			'Authorized' => $Authorized,
			'Dispatched' => $Dispatched,
			'Mainlist' => $Mainlist,

			'ListSheets' => $ListSheets,
		]);
	}

	public function actionPrint()
	{
		if ( ! User::UserCan("Despachado") && ! User::UserCan("Preparado"))
		{
			return Yii::$app->response->redirect(['/']);
			exit();
		}
		$this->layout = "print";
		if (! isset($_POST['did']) || ! isset($_POST['mlcid']))
		{
			return false;
		}

		$Driver = Driver::find()->where(['id' => $_POST['did']])->one();
		if ( ! $Driver) return false;

		$MainlistClient = MainlistClient::find()->where(['id'=>$_POST['mlcid']])->one();
		if ( ! $MainlistClient) return false;

		$Dispatched = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
		if ( ! $Dispatched) return false;

		$Mainlist = Mainlist::find()->where(['id'=>$MainlistClient->mainlist_id])->one();
		if ( ! $Mainlist) return false;

		if ($Mainlist->status < 2)
		{
			$Mainlist->attributes = ['status'=>2];
			$Mainlist->save();
			$this->MakeLog($Mainlist->id, "Status of Main List is changed to 'Printed'");
		}

		$Authorized = User::find()->where(['id' => $Mainlist->authorized_id])->one();
		if ( ! $Authorized) return false;

		$Client = Client::find()->where(['id'=>$MainlistClient->client_id])->one();
		if ( ! $Client) return false;

		$TotalBultos = MainlistClientItem::find()
				->where(['mainlist_client_id' => $MainlistClient->id])
				->sum('ctns');

		$MainlistClientItems = MainlistClientItem::find()
							->where(['mainlist_client_id'=>$MainlistClient->id])
							->andWhere(['driver_id'=>$Driver->id])
							->all();
		if (! $MainlistClientItems || ! count($MainlistClientItems) ) return false;

		$this->view->params['Authorized'] = $Authorized->username;
		$this->view->params['cdate'] = $Mainlist->cdate;
		$this->view->params['embargue'] = $Mainlist->number;
		$Numero = $Mainlist->number."-".MainlistClientDriverNumber::GetNumber($Mainlist->id, $Client->id, $Driver->id);

		$this->MakeLog($Mainlist->id, "The actual list (".$Numero.") is printed out");

		return $this->render('print', [
			'Driver' => $Driver,
			'Authorized' => $Authorized,
			'Dispatched' => $Dispatched,
			'Mainlist' => $Mainlist,
			'MainlistClient' => $MainlistClient,
			'Client' => $Client,
			'MainlistClientItems' => $MainlistClientItems,
			'Numero' => $Numero,
			'TotalBultos' => $TotalBultos,
		]);
	}

	public function MakeLog($id = 0, $text = '')
	{
		$id = (int)$id;
		$MainlistLog = new MainlistLog();
		$MainlistLog->attributes =
		[
			'mainlist_id' => $id,
			'text' => $text,
			'user_id' => Yii::$app->user->identity->id,
			'cdate' => time()
		];
		if ($MainlistLog->save())
		{
			//echo "log saved<br />";
		}
		else
		{
			//echo "log not saved<br />";
			//print_r($MainlistLog->getErrors());
		}
		return true;
	}
	public function MakeNotify($id = 0, $text = '')
	{
		$MainlistNotify = new MainlistNotify();
		$MainlistNotify->attributes = [
			'mainlist_id' => $id,
			'cdate' => time(),
			'msg' => $text,
		];
		$MainlistNotify->save();
		return true;
	}

    /**
     * Displays a single Mainlist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $act = false, $act_id = false)
    {
		$id = (int)$id;
		if (Yii::$app->request->isAjax && isset($_POST['timefrom']))
		{
			$to_reply = ['newtime' => time()];
			$Notifications = MainlistNotify::find()
					->where(['>','cdate', $_POST['timefrom']])
					->andWhere(['mainlist_id' => $id])
					->all();
			if ( ! $Notifications)
			{
				$to_reply['res'] = 0;
			}
			else
			{
				$res = "";
				foreach ($Notifications AS $Notify)
				{
					$res .= $Notify->msg."<br />";
				}
				$to_reply['res'] = $res;
 			}

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $to_reply;
        }

		if ($act && $act_id)
		{
			if ($act == "remove")
			{
				User::ControlUserCan("Preparado");

				$Item = MainlistClientItem::find()->where(['id'=>$act_id])->one();
				if ($Item)
				{
					$this->MakeLog($id, "DELETED: ".$Item->proveedores.", CTNS:".$Item->ctns);
					$this->MakeNotify($id, "DELETED: ".$Item->proveedores.", CTNS:".$Item->ctns);
					$Item->delete();
				}
			}
			elseif ($act == "unassign")
			{
				User::ControlUserCan("Despachado");

				$Item = MainlistClientItem::find()->where(['id'=>$act_id])->one();
				if ($Item)
				{
					$Item->driver_id = 0;
					$Item->save();
					$this->MakeLog($id, "UNASSIGNED: ".$Item->proveedores.", CTNS:".$Item->ctns);
				}
			}
			elseif ($act == "make_assigned_status")
			{
				User::ControlUserCan("Despachado");

				$Mainlist = Mainlist::find()->where(['id' => $id])->one();
				if ($Mainlist)
				{
					$Mainlist->attributes = ['status' => 1];
					$Mainlist->save();
					$this->MakeLog($id, "STATUS CHANGED TO 'ASSIGN'");
				}
			}
		}

		if (isset($_POST['frm-task']))
		{
			switch($_POST['frm-task'])
			{
				case "ap-drv":
					User::ControlUserCan("Despachado");
					$driver_id = $_POST['driver_select'];
					foreach ($_POST AS $key => $val)
					{
						if ( strpos($key, "itm_") !== false && $val == "on")
						{
							$line_id = substr($key, 4);
							$mci = MainlistClientItem::find()->where(['id'=>$line_id])->one();
							if ($mci)
							{
								$mci->driver_id = $driver_id;
								$mci->save();
								$this->MakeLog($id, "ASSIGNED TO DRIVER #".$driver_id.": ".$mci->proveedores.", CTNS:".$mci->ctns);
							}
						}
					}
					break;
				case "item-ctns":
					User::ControlUserCan("Despachado");
					$dataset = explode("|||", $_POST['item-ctns-data']);
					if (count($dataset))
					{
						foreach ($dataset AS $dataline)
						{
							$dataline = explode(":::", $dataline);
							$MainlistClientItem = MainlistClientItem::find()->where(['id'=>$dataline[0]])->one();
							if ($MainlistClientItem)
							{
								$MainlistClientItem->attributes = [
									'ctns_recibidos' => $dataline[1],
									'ctns_faltantes' => $dataline[2],
									'comments' => $dataline[3],
								];
								$MainlistClientItem->save();
								$this->MakeLog($id, "CTNS RECIBIDOS (".$dataline[1].") AND CTNS FALTANTES (".$dataline[2].") ADDED TO: ".$MainlistClientItem->proveedores.", CTNS:".$MainlistClientItem->ctns);
							}
						}
					}
					break;
				case "make_salio":
					User::ControlUserCan("Despachado");
					$date = strtotime($_POST['salio_date']);
					$Mainlist = Mainlist::find()->where(['id'=>$id])->one();
					if ($Mainlist)
					{
						$Mainlist->attributes = ['status' => $date];
						$Mainlist->save();
						$this->MakeLog($id, 'STATUS changed to SALIO: '.$_POST['salio_date']);
					}
					break;
				case "assign_another_mainlist":
					User::ControlUserCan("Despachado");
					$MainlistId = $_POST['another_mainlist'];
					$AMainlist = Mainlist::find()->where(['id' => $MainlistId])->one();
					if ($AMainlist)
					{
						$AMainlistClients = MainlistClient::find()->where(['mainlist_id' => $MainlistId])->all();
						if ($AMainlistClients && count($AMainlistClients))
						{
							foreach ($AMainlistClients AS $AMainlistClient)
							{
								$AMainlistClient->mainlist_id = $id;
								$AMainlistClient->save();
							}
						}
						$AMainlist->delete();

						$this->MakeLog($id, "Mainlist was merged with another one");
					}
					break;
				case "ctns-split":
					$ItemId = $_POST['item-id'];
					$SplitData = explode("|||", $_POST['item-splitted']);
					$SMainlistClientItem = MainlistClientItem::find()->where(['id' => $ItemId])->one();
					if ($SMainlistClientItem)
					{
						foreach ($SplitData AS $Splitter)
						{
							if ($Splitter && is_numeric($Splitter) && $Splitter > 0)
							{
								$NMainlistClientItem = new MainlistClientItem();
								$NMainlistClientItem->attributes = [
											'mainlist_client_id' => $SMainlistClientItem->mainlist_client_id,
											'driver_id' => 0,
											'embarque' => $SMainlistClientItem->embarque,
											'proveedores' => $SMainlistClientItem->proveedores,
											'ctns' => $Splitter,
											'cbm' => $SMainlistClientItem->cbm,
											'tipo' => $SMainlistClientItem->tipo,
											'ctns_recibidos' => $SMainlistClientItem->ctns_recibidos,
											'ctns_faltantes' => $SMainlistClientItem->ctns_faltantes,
										];
								$NMainlistClientItem->save();
							}
						}
						$SMainlistClientItem->delete();
					}
					break;
				case "change-client-address":
					$ThisMainlistClient = MainlistClient::find()
						->where(['id' => $_POST['mainlist_client_id']])
						->one();
					if ($ThisMainlistClient)
					{
						$ThisMainlistClient->attributes = [
							'address' => $_POST['address'],
							'notas' => $_POST['notas'],
						];
						$ThisMainlistClient->save();
					}
					break;
			}
		}
		if ( ($model = Mainlist::find()->with('authorized')->where(['id'=>$id])->one()) !== null)
		{
			if (isset($_POST['unmerge_mainlist']) && $_POST['unmerge_mainlist'] == "go")
			{
				User::ControlUserCan("Despachado");
				$ThisMainlistClient = MainlistClient::find()
						->where(['id' => $_POST['mainlist_client_id']])
						->one();
				$NewMainlist = new Mainlist();
				$NewMainlist->attributes = [
					'entrada' => $model->entrada,
					'salida' => $model->salida,
					'traspaso' => $model->traspaso,
					'salidaliqui' => $model->salidaliqui,
					'authorized_id' => $model->authorized_id,
					'status' => 0,
				];
				$NewMainlist->save();
				$ThisMainlistClient->attributes = ['mainlist_id' => $NewMainlist->id];
				$ThisMainlistClient->save();

				$this->MakeLog($id, "Mainlist was unmerged");
			}

			if (isset($_POST['add_proveedores_items']) && $_POST['add_proveedores_items'] == "go")
			{
				User::ControlUserCan("Preparado");
				$client_id = $_POST['mainlist_client_id'];
				$data = $_POST['mainlist_proveedors_data'];
				$dataset = explode("|||", $data);
				if (count($dataset))
				{
					foreach ($dataset AS $dataline)
					{
						if ($dataline)
						{
							$dataline = explode(":::", $dataline);
							$mci_model = new MainlistClientItem();

							$mci_model->attributes = [
								'mainlist_client_id' => $client_id,
								'driver_id' => 0,
								'proveedores' => $dataline[0],
								'ctns' => $dataline[1],
								'embarque' => $dataline[2],
								'cbm' => $dataline[3],
								'tipo' => MainlistClientItem::GetTipoId($dataline[4]),
							];
							if ($mci_model->save())
							{
								$this->MakeLog($id, "Proveedores ".$dataline[0]." with CTNS ".$dataline[1]." is added");
								$this->MakeNotify($id, "Proveedores ".$dataline[0]." with CTNS ".$dataline[1]." is added");
							}
						}
					}
				}
			}

			$DriversModel = Driver::find()->all();
			$Drivers = [];
			if (count($DriversModel))
			{
				foreach ($DriversModel AS $Driver)
				{
					$Drivers[$Driver->id] = [
						'conductor' => $Driver->transportista->name." / ".$Driver->conductor,
					];
				}
			}

			$IncludedClientsModel = MainlistClient::find()->where(["mainlist_id"=>$id])->all();
			$IncludedClients = [];
			$IncludedClientsIds = [];
			if (count($IncludedClientsModel))
			{
				$cind = 0;
				foreach ($IncludedClientsModel AS $IncludedClient)
				{
					$ClientModel = Client::find()->where(["id"=>$IncludedClient->client_id])->one();
					$IncludedClients[$cind] = [
															'client_id' => $IncludedClient->client_id,
															'name' => $ClientModel->cliente,
															'mainlist_client_id' => $IncludedClient->id,
															'address' => $IncludedClient->address,
															'notas' => $IncludedClient->notas,
															];
					$Items = MainlistClientItem::find()->where(['mainlist_client_id'=>$IncludedClient->id])->all();
					$IncludedClients[$cind]["items"] = [];
					if (count($Items))
					{
						foreach ($Items AS $Item)
						{
							if ( ! isset($IncludedClients[$cind]["items"][$Item->driver_id]))
							{
								$IncludedClients[$cind]["items"][$Item->driver_id]= [];
							}
							$IncludedClients[$cind]["items"][$Item->driver_id][] = $Item;
						}
					}
					if ( ! in_array($IncludedClient->client_id, $IncludedClientsIds))
					{
						$IncludedClientsIds[] = $IncludedClient->client_id;
					}
					$cind++;
				}
			}

			$Proveedores = Proveedores::find()->all();
			$Proveedores_list = array();
			if ($Proveedores && count($Proveedores))
			{
				foreach ($Proveedores AS $Proveedor)
				{
					$Proveedores_list[$Proveedor->name." (".$Proveedor->phone.")"] = $Proveedor->name;
				}
			}

/*
			$SuitableMainlists = Mainlist::find()
									//->where(['status' => 0])
									->where(['entrada' => $model->entrada])
									->andWhere(['salida' => $model->salida])
									->andWhere(['traspaso' => $model->traspaso])
									->andWhere(['salidaliqui' => $model->salidaliqui])
									->andWhere(['<>', 'id', $model->id])
									->all();
*/	


                        $freeDrivers_subquery = MainlistClient::find()
						->select('mainlist_client.mainlist_id')
						->join('INNER JOIN', 'mainlist_client_item',
						'mainlist_client.id = mainlist_client_item.mainlist_client_id')
						->where(['>', 'mainlist_client_item.driver_id', 0]);
						
						$SuitableMainlists = Mainlist::find()
									
									->where(['mainlist.entrada' => $model->entrada])
									->andWhere(['mainlist.salida' => $model->salida])
									->andWhere(['mainlist.traspaso' => $model->traspaso])
									->andWhere(['mainlist.salidaliqui' => $model->salidaliqui])
									->andWhere(['<>', 'mainlist.id', $model->id]) 
									->andWhere(['not in', 'mainlist.id', $freeDrivers_subquery])
									->all();
								


/*
			foreach ($SuitableMainlists AS $Tkey => $TMainlist)
			{
				$TMainlistClients = MainlistClient::find()
						->where(['mainlist_id' => $TMainlist->id])
						->all();

				if ($TMainlistClients)
				{
					foreach ($TMainlistClients AS $TMainlistClient)
					{
						$TMainlistClientItem = MainlistClientItem::find()
								->where(['>', 'driver_id', 0])
								->andWhere(['mainlist_client_id' => $TMainlistClient->id])
								->all();
						if ($TMainlistClientItem)
						{
							unset($SuitableMainlists[$Tkey]);
							break;
						}
					}
				}
			}
*/




			$LogData = $this->GetLogs($id);

            return $this->render('view', [
				'model' => $model,
				//'mc_model' => $mc_model,
				//'FreeClients' => $FreeClients,
				'SuitableMainlists' => $SuitableMainlists,
				'IncludedClients' => $IncludedClients,
				'Drivers' => $Drivers,
				'Proveedores' => $Proveedores_list,
				'LogData' => $LogData,
			]);
        }
		else
		{
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * Creates a new Mainlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		User::ControlUserCan("Preparado");

        $model = new Mainlist();

		$cl_model = new MainlistClient();

		$FreeClients = Client::find()->all();

        if ($model->load(Yii::$app->request->post()))
		{
			if ( $model->save())
			{
				if ($cl_model->load(Yii::$app->request->post()))
				{
					$Client = Client::find()->where(['id' => $cl_model->client_id])->one();
					$cl_model->mainlist_id = $model->id;
					$cl_model->address = $Client->direccionexacta;
					$cl_model->save();
				}

				$this->MakeLog($model->id, "Main List (".$model->number.") is created");
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
		else
		{
            return $this->render('create', [
                'model' => $model,
				'cl_model' => $cl_model,
				'FreeClients' => $FreeClients,
            ]);
        }
    }

	public function GetLogs($id)
	{
// text, user_id, cdate
		$UsersData = User::find()->all();
		$Users = [];
		foreach ($UsersData AS $UserData)
		{
			$Users[$UserData->id] = $UserData->username;
		}

		$answ = "";
		$MainlistLog = MainlistLog::find()->where(['mainlist_id'=>$id])->orderBy('cdate')->all();
		if ($MainlistLog)
		{
			$answ .= "<table class='logs-info'>";
			$answ .= "<thead><tr>";
			$answ .= "<th>Date</th>";
			$answ .= "<th>Details</th>";
			$answ .= "<th>User</th>";
			$answ .= "</tr></thead><tbody>";
			foreach ($MainlistLog AS $LogItem)
			{
				$answ .= "<tr><td>".strftime("%d %B %Y %H:%M:%S", $LogItem->cdate)."</td>";
				$answ .= "<td>".$LogItem->text."</td>";
				$answ .= "<td>".$Users[$LogItem->user_id]."</td></tr>";
			}
			$answ .= "</tbody></table>";
		}
		return $answ;
	}

    /**
     * Updates an existing Mainlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		User::ControlUserCan("Preparado");

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->MakeLog($id, "Main List information is updated");
            return $this->redirect(['view', 'id' => $model->id]);
        }
		else
		{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mainlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		User::ControlUserCan("Preparado");

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mainlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mainlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mainlist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
