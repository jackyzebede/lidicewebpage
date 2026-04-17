<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\Package;
use app\models\PackageSearch;
use yii\helpers\Url;
use app\models\Client;
/**
 * Miami controller
 */
class MiamiController extends Controller
{
	private $pdf_file_path = __DIR__ .'/../web/miamipdf/';
	private $pdf_file_name = NULL;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'client', 'warehouse', 'transit', 'transit','panama','dispatch','upload','markintransit','update','delete','sendpanama','senddispatch','pdf','mail'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionClient()
    {
        return $this->render('create');
    }
	
	public function actionWarehouse()
    {
		//print_r($_POST);
		if (isset($_POST['package_id']) and $_POST['package_id']>0) {
			//echo "send email";
			//$request = Yii::$app->request;
			//$package_id = \Yii::$app->db->quoteValue($request->post('package_id'));
			$this->send_warehouse_email($_POST['package_id']);
		}
		
		$searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->query->where('package.status = 0');
		$dataProvider->query->andWhere('package.status = 0')->orderBy(['id' => SORT_DESC]);
		

        return $this->render('warehouse', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionTransit()
    {
		$searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->query->where('package.status = 1');
		$dataProvider->query->andWhere('package.status = 1')->orderBy(['hbl_number' => SORT_DESC]);

        return $this->render('transit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
        //return $this->render('transit');
    }
	
	public function actionPanama()
    {
		$searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->query->where('package.status = 1');
		$dataProvider->query->andWhere('package.status = 2')->orderBy(['hbl_number' => SORT_DESC]);

        return $this->render('panama', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        //return $this->render('ammivedot');
    }
	
	public function actionDispatch()
    {
		$searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->query->where('package.status = 1');
		$dataProvider->query->andWhere('package.status = 3')->orderBy(['hbl_number' => SORT_DESC]);

        return $this->render('dispatch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        //return $this->render('dispatch');
    }
	
	public function actionUpload()
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
						
                        $number = trim($fileop[0]);
                        $csv_date = $fileop[1];
                        $consignee = addslashes(trim($fileop[2]));
						$weight = round($fileop[3]);
						$supplier = addslashes(trim($fileop[4]));
						$carrier = $fileop[5];
						
						$tracking_number = $fileop[6];
						$pieces = $fileop[7];
						$volume = round($fileop[8]);
						
						//if number already exist
						$package = Package::find()->where(['number'=>$number])->one();
						
						if (!isset($package->id) and $number > 0 and strlen($number) > 0 and strlen($consignee) > 0) {
						
							//check if new consignee already exist
							$new_consignee_rs = Package::find()->where(['consignee'=>$consignee])->andWhere(['>','new_consignee', 0])->one();
							
							$new_consignee = '';
							if (isset($new_consignee_rs) and $new_consignee_rs->new_consignee > 0) {
								$new_consignee = $new_consignee_rs->new_consignee;
							}
						
							$sql = "INSERT INTO package set number = '$number', csv_date = '$csv_date', consignee = '$consignee', new_consignee = '$new_consignee', weight = '$weight', supplier = '$supplier', carrier = '$carrier', tracking_number = '$tracking_number', pieces = '$pieces', volume = '$volume' ";
							
							$query = Yii::$app->db->createCommand($sql)->execute();
							
						}
						$row++;
                     }

                     if ($row>1) 
                     {
						Yii::$app->session->setFlash('uploadsuccess', "Packages uploaded successfully");
                     }

                }

			return $this->redirect(['warehouse']);
        } else {
            return $this->render('upload', [
                'model' => $model,
            ]);
        }
        //return $this->render('upload');
    }
	
	public function actionMarkintransit(){
		$action = Yii::$app->request->post('action'); // dropDown (array)
		$select = Yii::$app->request->post('selection'); //checkbox (array)
		
		if (is_array($select) and count($select)> 0) {
			foreach($select as $id){
				//$model= Package::findOne((int)$id);
				if (($model = Package::findOne((int)$id)) !== null) {
					$model->status = 1;
					$model->save();
					//set hbl number
					$this->set_hbl_number($model);
				}
			}
			Yii::$app->session->setFlash('uploadsuccess', "Selected items are updated to In Transit");			
		}
		return $this->redirect(['warehouse']);
	}
 
	protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function set_hbl_number($model)
    {
		//get last hbl
		$hbl_max = Package::find()->max('hbl_number');
		
		if (isset($model->new_consignee)) {
			
			//check if hbl exist for new record according new_consignee
			$hbl = Package::find()->where(['new_consignee'=>$model->new_consignee])->andWhere(['>','hbl_number', 0])->one();
			
			if (isset($hbl) and $hbl->hbl_number > 0) {
				$model->hbl_number = $hbl->hbl_number; // old hbl is assigned to new record
				$model->save(); 
			} else if (!isset($hbl)) {
				Package::updateAll(['hbl_number' => $hbl_max+1], ['new_consignee' => $model->new_consignee]); # condition
				//$model->hbl_number = $hbl_max+1; // new hbl is assigned
				//$model->save(); 
			} 
			
			// then check if this uploaded package dont have hbl already in db then assign new hbl to all records with same old consignee

			//if (($new_consignee = Package::findOne($id)) !== null) {
		// now check if new consignee is empty and old consignee has already hbl number in package then assigne that hbl to this uploaded package
		} 
		if (isset($model->consignee) and !isset($model->new_consignee)) {
			//check if hbl exist for new record against old consignee
			//$hbl = Package::find()->where(["consignee = $model->consignee and hbl_number > 0"])->one();
			$hbl = Package::find()->where(['consignee'=>$model->consignee])->andWhere(['>','hbl_number', 0])->one();
			
			if (isset($hbl) and $hbl->hbl_number > 0) {
				$model->hbl_number = $hbl->hbl_number; // old hbl is assigned to new record
				$model->save(); 
			} else if (!isset($hbl)) {
				Package::updateAll(['hbl_number' => $hbl_max+1], ['consignee' => $model->consignee]); # condition
				//$model->hbl_number = $hbl_max+1; // new hbl is assigned
				//$model->save(); 
			}
			
			//Package::updateAll(['hbl_number' => $hbl_max+1], ['consignee' => $model->consignee]); # condition
		}
		/*
		
        if (($model = Package::findOne($id)) !== null) {
			
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
		*/
    }
	
	public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			$model->new_consignee = $_POST['Package']['new_consignee'];
			//$model->save();
			
			//update all old consignee
			Package::updateAll(['new_consignee' => $model->new_consignee], ['consignee' => $model->consignee]); # condition
			
            return $this->redirect(['warehouse']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['warehouse']);
    }
	
	public function actionSendpanama(){
		$action = Yii::$app->request->post('action'); // dropDown (array)
		$select = Yii::$app->request->post('selection'); //checkbox (array)
		
		if (is_array($select) and count($select)> 0) {
			foreach($select as $id){
				//$model= Package::findOne((int)$id);
				if (($model = Package::findOne((int)$id)) !== null) {
					$model->status = 2;
					$model->save();
					//set hbl number
					$this->set_hbl_number($model);
				}
			}
			Yii::$app->session->setFlash('uploadsuccess', "Selected items are Sent to Panama");			
		}
		return $this->redirect(['transit']);
	}
	
	public function actionSenddispatch(){
		$action = Yii::$app->request->post('action'); // dropDown (array)
		$select = Yii::$app->request->post('selection'); //checkbox (array)
		
		if (is_array($select) and count($select)> 0) {
			foreach($select as $id){
				//$model= Package::findOne((int)$id);
				if (($model = Package::findOne((int)$id)) !== null) {
					$model->truck_co = (int) $_POST['truck_co'];
					$model->driver_id = (int) $_POST['driver_id'];
					$model->pack_comments = addslashes($_POST['pak_comments']);
					$model->status = 3;
					$model->save();
					//set hbl number
					$this->set_hbl_number($model);
				}
			}
			Yii::$app->session->setFlash('uploadsuccess', "Selected items are Sent to Dispatch");			
		}
		return $this->redirect(['panama']);
	}
	
	
	
	
	public function actionPdf(){
		//echo __DIR__;
		//die();
		require_once("../../tcpdf/tcpdf.php");
		//echo "pdf";

$width = 500;
$height = 400;
$pageLayout = array($width, $height); //  or array($height, $width) 
//$pdf = new \TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);

// create new PDF document
//$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(400, 200), true, 'UTF-8', false);
//210 x 297
////$pdf = new \TCPDF('L', 'mm', array('210','297'), true, 'UTF-8', false);
$pdf = new \TCPDF('P', 'mm', array('210','200'), true, 'UTF-8', false);

$pdf->AddPage();
//$pdf->AddPage('P', 'A6');
//$pdf->AddPage('L', 'A6');
//$pdf->AddPage('L', 'A4');
//$pdf->AddPage('P', 'A4');
//$pdf->AddPage('P', 'A5');

		// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
////$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aamir');
$pdf->SetTitle('Lidice');
$pdf->SetSubject('Licide Recept');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


/*
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 065', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
*/

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(5, 10, 5);
$pdf->SetMargins(0, 0, 5);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-30, PDF_MARGIN_RIGHT);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetHeaderMargin(0);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetFooterMargin(0);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 0);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->setCellPaddings(0,0,0,0);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
////$pdf->AddPage();

// Set some content to print
/*
$html = <<<EOD
<style>
.blue_class{color:#0000FF;}
</style>
<table>
	<tr>
		<td class="blue_class"><b>Warehouse recipt</b> </td>
		<td class="blue_class"><b>1234456</b></td>
		<td><b>Transmar Inc</b></td>
		
	</tr>
	<tr>
		<td>Received On</td>
		<td>Jan 20,2021 10:29 PM</td>
		<td>Hugo Valitinal</td>
	</tr>
	<tr>
		<td>Tracking Number</td>
		<td>1122334456</td>
		<td>6123 Nw 75th Ava</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Miami FL 55685 USA </td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Email:asdfasdf@asdf.com</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Fax:786-987-564</td>
	</tr>
</table>
<p></p>
<table>
	<tr>
		<td>
			<span class="blue_class">Shipper Information</span> <br>
			ELEVER SPORTS MFG CORP <br>
			1900 SPORTS MFG CORP <br>
			Mobetly mp MFG CORP <br>
			United state <br>
		</td>
		<td>
			<span class="blue_class">Consignee Information</span> <br>
			Deportiva Internationl <br>
			S.A
			Zona Libre.
			Panama
		</td>
		
	</tr>
	
</table>

<p class="blue_class">Tracking Details</p>

<table>
	<tr class="blue_class">
		<td>Date/Time</td>
		<td>Event</td>
		<td>Operation</td>
		<td>Location</td>
		<td>Details</td>
	</tr>
	<tr>
		<td>Jan/20/2021 10:29 AM</td>
		<td>Arrived at Warehouse</td>
		<td>
			Warehouse <br>
			Recept: 223654
		</td>
		<td></td>
		<td></td>
		
	</tr>
	
</table>
<div></div>
<table>
	<tr class="blue_class">
		<td>Pcs</td>
		<td>Package</td>
		<td>Dimensions</td>
		<td>Description</td>
		<td>Weight</td>
		<td>Volume</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>Pallet</td>
		<td>48x44c56</td>
		<td></td>
		<td>221.00 lb</td>
		<td>66.44 ft3</td>		
	</tr>
	
</table>


EOD;
*/






$html = <<<EOD
<style>

table{font-size: 16px; color: #1b1b1b;}
.blue_class{color:#075ea6;}
.inc_color{font-size: 20px; color:#47526e;}
tr.border_bottom td {
  border-bottom: 2px solid #04bcf6;
  height:2px;
}
p.border_bottom {
  border-bottom: 8px solid #04bcf6;
  height:10px;
}
.recipt_no {
	color:"#4d88ae";
}
.bg_image{ /*background: url("../web/images/pdf_bg.png");*/ }

</style>
<div class="bg_image">
<table class="bg_image">
	<tr>
		<td><img src="../web/images/pdf1_logo.png" width="250" height="150"> </td>
		<td></td>
		<td colspan="2" align="right"><b class="inc_color">TRANSMAR, INC </b><br>
			   6132 NW 74TH. AVE.<br>
			   MIAMI, FL 33166 <br>
			   UNITEDSTATES
		</td>
		
	</tr>
	<tr class="border_bottom">
		<td colspan="4"></td>		
	</tr>
	<tr>
		<td colspan="4"></td>		
	</tr>
	<tr>
		<td width="20%"></td>
		<td width="40%" class="blue_class">
				<b>Warehouse recipt</b>  <br>
				Received On  <br>
				Tracking Number  <br>
		</td>
		<td width="40%" colspan="2">
				 <span class="recipt_no"><b>1234456</b></span> <br>
				 May/26/2021 10:48 <br>
				 019822176 <br>
		</td>	
	</tr>
</table>
<p></p>

<table>
	<tr>
		<td width="40%">
			<span class="blue_class" style="color:#3ac4ed;">Shipper Information</span> <br>
			<span style="color:	#A8A8A8;">ELEVER SPORTS MFG CORP <br>
			1900 SPORTS MFG CORP <br>
			Mobetly mp MFG CORP <br>
			United state <br>
			</span>
		</td>
		<td width="40%">
			<span class="blue_class">Consignee Information</span> <br>
			Deportiva Internationl <br>
			S.A
			Zona Libre.
			Panama
		</td>
		<td width="20%">
			<span class="blue_class">Carrier</span> <br>
			UPS
		</td>
		
	</tr>
	
</table>

<p class="border_bottom"></p>
<p></p>
<p></p>

<table>
	<tr class="blue_class">
		<td style="color:#3ac4ed;">Qty</td>
		<td style="color:#3ac4ed;">Pieces</td>
		<td>Weight</td>
		<td>Volume</td>
	</tr>
	<tr>
		<td style="color:	#A8A8A8;">1</td>
		<td>Pallet</td>
		<td>
			385.00 lb
		</td>
		<td>43.33 ft3</td>		
	</tr>
	
</table>
</div>

EOD;

// set background image
/*
        $img_file = '../web/images/new_bg3.jpg';
        $pdf->Image($img_file, 0, 10, 225, 150, '', '', '', false, 300, '', false, false, 0);
		*/
		
		$img_file = "../web/images/new_bg3.jpg";
		//$pdf->Image($img_file, 0, 50, 225, 160, '', '', '', false, 300, '', false, false, 0);
		////$pdf->Image($img_file, 0, 75, 300, 110, '', '', '', false, 300, '', false, false, 0);
		//$pdf->Image($img_file, 0, 50, 200, 120, '', '', '', false, 300, '', false, false, 0);
		$pdf->Image($img_file, 0, 60, 200, 120, '', '', '', true, 300, '', false, false, 0);



// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_065.pdf', 'I');
////$pdf->Output(__DIR__ .'/../web/miamipdf/example_0655.pdf', 'F');

		
		//return $this->redirect(['transit']);
	}
	
	public function actionMail(){
		
		date_default_timezone_set('Etc/UTC');

require '../../phpmailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new \PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;

// But you can comment from here
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->CharSet = "UTF-8";
// To here. 'cause default secure is TLS.

$mail->setFrom("123456@gmail.com", "Ololoev");
$mail->Username = "satwahh@gmail.com";
$mail->Password = "Quality@123456";

$mail->Subject = "Тест";
$mail->msgHTML("Test");
$mail->addAddress("phpamir@gmail.com", "Alex");

if (!$mail->send()) {
$mail->ErrorInfo;
} else {
echo 123;
}

	}
	
	function send_warehouse_email($pid){
		
		$pdf_url = "";
		
		require '../../phpmailer/PHPMailerAutoload.php';

		//Create a new PHPMailer instance
		$mail = new \PHPMailer;
		
		$package = $this->findModel($pid);
		
		if ($package->new_consignee > 0) {
			$client_id = $package->new_consignee;
		} else {
			$consignee = strtolower(trim($package->consignee));
			$Client = Client::find()->where(['LOWER(marka)' => $consignee])->one();
			
			if (isset($Client->id)) {
				$client_id = $Client->id;
			}
			
		}
		
		
		
		if ($client_id > 0) {
			$Client = Client::find()->where(['id' => $client_id])->one();
			if (filter_var(trim($Client->email1), FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress(trim($Client->email1), $Client->cliente);
			}
			if (filter_var(trim($Client->email2), FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress(trim($Client->email2), $Client->cliente);
			}
			if (filter_var(trim($Client->email3), FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress(trim($Client->email3), $Client->cliente);
			}
			if (filter_var(trim($Client->email4), FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress(trim($Client->email4), $Client->cliente);
			}
			if (filter_var(trim($Client->email5), FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress(trim($Client->email5), $Client->cliente);
			}
		}
		
		
		//$date = "Mar 03, 2011";
		$es_date = strtotime($_POST['estimate_date']);
		$es_date = strtotime("-7 day", $es_date);
		$es_date = date('M d, Y', $es_date);
		
		if ( $this->createPdf($package) ) {
			$mail->addAttachment($this->pdf_file_path.$this->pdf_file_name);
			$pdf_url = Url::base(true)."/miamipdf/".$this->pdf_file_name;
		}
		
		//echo $pdf_url;
		//die();
		
		$email_text = "
		
			Por medio de la presente le notificamos que la carga detallada a continuación, está siendo procesada en nuestro sistema, favor tomar nota: 
			<br><br>
			<span style='color: red;'>*Le ofrecemos asegurar su carga por el 1% del valor de su factura*</span>
			<br><br>
			<b>Recibimos/Received:  ".$package->pieces." PALLET // ".$package->weight." LB //  ".$package->volume." FT3 </b>
			<br><br>
			<b>Proveedor/Shipper:</b>  ".$package->supplier." // ".$package->new_consignee."
			<br><br>
			<b>Tracking and carrier:  ".$package->tracking_number." ".$package->carrier." </b>
            <br><br>   
			<b>Fecha de Recibido: ".$package->csv_date." </b>
			<br><br>
			<b>Estimado de Arribo Panamá: ".$_POST['estimate_date'].". </b>
			<br><br>
			<b>Cut off (documentos) ".$es_date." - 12:00 m.d.(ESTA FECHA DEBE SER BIEN RESALTANTE, SERIA CADA VIERNES) </b>
			<br><br>
			<b>CLIENTES CIUDAD DE PANAMA:</b>  enviar factura comercial y descripcion de la carga.
			<br><br>
			<b>CLIENTES ZONA LIBRE COLON:</b>  enviar DMC de entrada y factura (el dia viernes le enviaremos el BL para su emision)
			<br><br>
			<b>IMPORTANTE:</b> confirmar si su mercancía requiere algún tipo de permiso especial ( CUARENTENA o AUPSA)
			<br><br>
			You can see pdf here <br>
			".$pdf_url."
		";
		
		
		
		// $mail->isSMTP();
		// //$mail->SMTPDebug = 2;
		// $mail->Host = "smtp.gmail.com";
		// $mail->SMTPAuth = true;

		// // But you can comment from here
		// $mail->SMTPSecure = "tls";
		// $mail->Port = 587;
		// $mail->CharSet = "UTF-8";
		// // To here. 'cause default secure is TLS.

		 
		// $mail->Username = "satwahh@gmail.com";
		// $mail->Password = "********";
		
		$mail->setFrom("logistica1@lidice.net", "Lidice");
		
		$mail->Subject = "AVISO DE LLEGADA SEMANA 20 WR ".$package->number." // ".$package->supplier." // ".$package->consignee."";
		$mail->msgHTML($email_text);
		
		//$mail->addAddress("phpamir@gmail.com", "Aamir");
		
		
		//$mail->addAddress("hammadashfaq817@gmail.com", "Hammad");
		
		
		$mail->AddCC("rosaandrades@lidice.net");
		$mail->AddCC("beder@lidice.net");
		$mail->AddCC("jacky@lidice.net");
		$mail->AddCC("hugovillanueva@transmarinc.com");
		
		
		if (!$mail->send()) {
			$mail->ErrorInfo;
		} else {
			$this->redirect(['warehouse']);
		//echo 123;
		}
		
	}
	
	private function createPDF($package) {
		require_once("../../tcpdf/tcpdf.php");
		//echo "pdf";
		// create new PDF document
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Aamir');
		$pdf->SetTitle('Lidice');
		$pdf->SetSubject('Licide Recept');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


		/*
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 065', PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		*/

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(5, 10, 5);

		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		$pdf->SetFont('helvetica', '', 10, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
/*
// Set some content to print
$html = <<<EOD
<style>
.blue_class{color:#0000FF;}
.blue_class2{color:#000FFF;}
</style>
<table>
	<tr>
		<td class="blue_class"><b>Warehouse recipt</b> </td>
		<td class="blue_class"><b>$package->number</b></td>
		<td><b>Transmar Inc</b></td>
		
	</tr>
	<tr>
		<td>Received On</td>
		<td>$package->csv_date <!--(Jan 20,2021 10:29 PM)--></td>
		<td>Hugo Valitinal</td>
	</tr>
	<tr>
		<td>Tracking Number</td>
		<td>$package->tracking_number</td>
		<td>6123 Nw 75th Ava</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Miami FL 55685 USA </td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Email:asdfasdf@asdf.com</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Fax:786-987-564</td>
	</tr>
</table>
<p></p>
<table>
	<tr>
		<td>
			<span class="blue_class-- blue_class2">Shipper Information</span> <br>
			$package->carrier
			<!--
			ELEVER SPORTS MFG CORP <br>
			1900 SPORTS MFG CORP <br>
			Mobetly mp MFG CORP <br>
			United state <br>
			-->
		</td>
		<td>
			<span class="blue_class">Consignee Information</span> <br>
			$package->consignee
			<!--
			Deportiva Internationl <br>
			S.A
			Zona Libre.
			Panama
			-->
		</td>
		
	</tr>
	
</table>

<p class="blue_class">Tracking Details</p>

<table>
	<tr class="blue_class">
		<td>Date/Time</td>
		<td>Event</td>
		<td>Operation</td>
		<td>Location</td>
		<td>Details</td>
	</tr>
	<tr>
		<td>$package->csv_date</td>
		<td>Arrived at Warehouse</td>
		<td>
			Warehouse <br>
			Recept: $package->number
		</td>
		<td></td>
		<td></td>
		
	</tr>
	
</table>
<div></div>
<table>
	<tr class="blue_class">
		<td>Pcs</td>
		<td>Package</td>
		<td>Dimensions</td>
		<td>Description</td>
		<td>Weight</td>
		<td>Volume</td>		
	</tr>
	<tr>
		<td>$package->pieces</td>
		<td>Pallet</td>
		<td>48x44c56</td>
		<td></td>
		<td>$package->weight.00 lb</td>
		<td>$package->volume.00 ft3</td>		
	</tr>
	
</table>


EOD;
*/

//-------new html format copy from pdf function above---------

$html = <<<EOD
<style>

table{font-size: 16px; color: #1b1b1b;}
.blue_class{color:#075ea6;}
.inc_color{font-size: 20px; color:#47526e;}
tr.border_bottom td {
  border-bottom: 2px solid #04bcf6;
  height:2px;
}
p.border_bottom {
  border-bottom: 8px solid #04bcf6;
  height:10px;
}
.recipt_no {
	color:"#4d88ae";
}
.bg_image{ /*background: url("../web/images/pdf_bg.png");*/ }

</style>
<div class="bg_image">
<table class="bg_image">
	<tr>
		<td><img src="../web/images/pdf1_logo.png" width="250" height="150"> </td>
		<td></td>
		<td colspan="2" align="right"><b class="inc_color">TRANSMAR, INC </b><br>
			   6132 NW 74TH. AVE.<br>
			   MIAMI, FL 33166 <br>
			   UNITEDSTATES
		</td>
		
	</tr>
	<tr class="border_bottom">
		<td colspan="4"></td>		
	</tr>
	<tr>
		<td colspan="4"></td>		
	</tr>
	<tr>
		<td width="20%"></td>
		<td width="40%" class="blue_class">
				<b>Warehouse recipt</b>  <br>
				Received On  <br>
				Tracking Number  <br>
		</td>
		<td width="40%" colspan="2">
				 <span class="recipt_no"><b>$package->number</b></span> <br>
				 $package->csv_date <br>
				 $package->tracking_number <br>
		</td>	
	</tr>
</table>
<p></p>

<table>
	<tr>
		<td width="40%">
			<span class="blue_class" style="color:#3ac4ed;">Shipper Information</span> <br>
			<span style="color:	#A8A8A8;">
			$package->carrier
			<!--
			ELEVER SPORTS MFG CORP <br>
			1900 SPORTS MFG CORP <br>
			Mobetly mp MFG CORP <br>
			United state <br>
			-->
			</span>
		</td>
		<td width="40%">
			<span class="blue_class">Consignee Information</span> <br>
			$package->consignee
			<!--
			Deportiva Internationl <br>
			S.A
			Zona Libre.
			Panama
			-->
		</td>
		<td width="20%">
			<span class="blue_class">Carrier</span> <br>
			$package->carrier
			<!--UPS-->
		</td>
		
	</tr>
	
</table>

<p class="border_bottom"></p>
<p></p>
<p></p>

<table>
	<tr class="blue_class">
		<td style="color:#3ac4ed;">Qty</td>
		<td style="color:#3ac4ed;">Pieces</td>
		<td>Weight</td>
		<td>Volume</td>
	</tr>
	<tr>
		<td style="color:	#A8A8A8;">$package->pieces</td>
		<td>Pallet</td>
		<td>
			$package->weight.00 lb
		</td>
		<td>$package->volume.00 ft3</td>		
	</tr>
	
</table>
</div>

EOD;

		$img_file = "../web/images/new_bg3.jpg";
		//$pdf->Image($img_file, 0, 50, 225, 160, '', '', '', false, 300, '', false, false, 0);
		////$pdf->Image($img_file, 0, 75, 300, 110, '', '', '', false, 300, '', false, false, 0);
		//$pdf->Image($img_file, 0, 50, 200, 120, '', '', '', false, 300, '', false, false, 0);
		$pdf->Image($img_file, 0, 60, 200, 120, '', '', '', true, 300, '', false, false, 0);
		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// ---------------------------------------------------------

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		//$pdf->Output('example_065.pdf', 'I');
		$this->pdf_file_name = 'invoice_'.$package->number.'_'.base64_encode($package->id).'.pdf';
		$full_pdf_file_name = $this->pdf_file_path.$this->pdf_file_name;
		$pdf->Output($full_pdf_file_name, 'F');
		
		if (is_file($full_pdf_file_name)) {
			return true;
		} else {
			return false;
		}
		//return $pdf_file_name;
	} // end of function

} // end of class
