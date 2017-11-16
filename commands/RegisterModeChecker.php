<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use app\models\Usuario;
use app\models\DocumentUpload;

/**
 * Clase usada en cada uno de los controladores de los registros de a
 * en Archivoprograma. Esta clase provee de la información habilitación o no
 * según lo que el autor haya registrado en la columna mode. Cada acción 
 * debe tener implementado previamente el if de control qe referencia a
 * ésta clase.
 */
class RegisterModeChecker extends Controller{
	
	/**
	 * Esta función estática consutla al modelo ModeRegister y deacuerdo
	 * a lo devuelto por identityInterface retorna true si es permitido la 
	 * lectura del registro deacuerdo a la referencia del parámetro:
	 * @param $currentModeRegister: valor mode de la columna de la tabla 
	 * archivoprograma, ejemplo:"OTROS|LECTOESCR_SECTOR|LECTOESCR_USUARIO|LECTOESCR"
	 **/
	public static function registerIsReadable($idRegister){
		/**
		 * DocumentUpload class for table "archivoprograma".
		 * @property integer $archivoprograma_id
		 * @property integer $programa_id
		 * @property integer $usuario_id
		 * @property integer $estado_id
		 * @property string $archivo
		 * @property string $fecha
		 * @property string $mode_reg
		 */
		$currentRegister=DocumentUpload::find()
			-> where('archivoprograma_id=:archivoprograma_id',[':archivoprograma_id'=> $idRegister ])
			-> one();
		$modeUsr=substr($currentRegister->mode_reg,strpos("_USUARIO|")-strlen($currentRegister->mode_reg));
		$modeSec=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg)+strpos("_USUARIO|"),strpos("_SECTOR|"));
		$modeOtr=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg),strpos("OTROS|"));
		if(Yii::$app->user->isGuest)return false;
		else {
			if($modeUsr == "USUARIO|LECTOESCRITURA" && 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeUsr == "USUARIO|LECTURA" && 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeSec == "SECTOR|LECTOESCRITURA"&& 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeSec == "SECTOR|LECTURA"&& 
				Yii::$app->user->identity->getSector()->one()->sector_id == 
					Usuario::findIdentity($currentRegister->usuario_id)->sector_id
				)return true;
			else return false;
		}
	}
	
	/**
	 * Esta función estática consutla al modelo ModeRegister y deacuerdo
	 * a lo devuelto por identityInterface retorna true si es permitido la 
	 * escritura del registro deacuerdo a la referencia del parámetro:
	 * @param $currentModeRegister: valor mode de la columna de la tabla 
	 * archivoprograma.
	 **/
	public static function registerIsWritable($currentModeRegister){
		/**
		 * DocumentUpload class for table "archivoprograma".
		 * @property integer $archivoprograma_id
		 * @property integer $programa_id
		 * @property integer $usuario_id
		 * @property integer $estado_id
		 * @property string $archivo
		 * @property string $fecha
		 * @property string $mode_reg
		 */
		$currentRegister=DocumentUpload::find()
			-> where('archivoprograma_id=:archivoprograma_id',[':archivoprograma_id'=> $idRegister ])
			-> one();
		$modeUsr=substr($currentRegister->mode_reg,strpos("_USUARIO|")-strlen($currentRegister->mode_reg));
		$modeSec=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg)+strpos("_USUARIO|"),strpos("_SECTOR|"));
		$modeOtr=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg),strpos("OTROS|"));
		if(Yii::$app->user->isGuest)return false;
		else {
			if($modeUsr == "USUARIO|LECTOESCRITURA" && 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeUsr == "USUARIO|ESCRITURA" && 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeSec == "SECTOR|LECTOESCRITURA"&& 
				Yii::$app->user->identity->usuario_id==$currentRegister->usuario_id)return true;
			else if($modeSec == "SECTOR|ESCRITURA"&& 
				Yii::$app->user->identity->getSector()->one()->sector_id == 
					Usuario::findIdentity($currentRegister->usuario_id)->sector_id
				)return true;
			else return false;
		}
	}
	public static function test($currentModeRegister,$msg){
		/**
		 * DocumentUpload class for table "archivoprograma".
		 * @property integer $archivoprograma_id
		 * @property integer $programa_id
		 * @property integer $usuario_id
		 * @property integer $estado_id
		 * @property string $archivo
		 * @property string $fecha
		 * @property string $mode
		 */
		 if($currentModeRegister!=-1){
			$currentRegister=DocumentUpload::find()
				-> where('archivoprograma_id=:archivoprograma_id',[':archivoprograma_id'=> $idRegister ])
				-> one();
			$modeUsr=substr($currentRegister->mode_reg,strpos($currentRegister->mode_reg,"_USUARIO|")-strlen($currentRegister->mode_reg));
			$modeSec=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg)+strpos($currentRegister->mode_reg,"_USUARIO|"),strpos($currentRegister->mode_reg,"_SECTOR|"));
			$modeOtr=substr($currentRegister->mode_reg,-strlen($currentRegister->mode_reg),strpos($currentRegister->mode_reg,"OTROS|"));
			return $modeUsr."##".$modeSec."##".modeOtr;
		}else{
			//~ se prueba con "OTROS|LECTOESCR_SECTOR|LECTOESCR_USUARIO|LECTOESCR"			
			$modeUsr=substr($msg,strpos($msg,"_USUARIO|")-strlen($msg));
			$modeSec=substr($msg,-strlen($msg)+strpos($msg,"_USUARIO|"),strpos($msg,"_SECTOR|"));
			$modeOtr=substr($msg,-strlen($msg),strpos($msg,"OTROS|"));
			return "1)strlen=".strlen($msg)."  2)Strpos(_USUARIO)=".strpos($msg,"_USUARIO|")."  3)Strpos(_SECTOR|)=".strpos($msg,"_SECTOR|")."  4)Strpos(OTROS)=".strpos($msg,"OTROS|")." </p><p>-<>-".$modeUsr."-<>-".$modeSec."-<>-".$modeOtr."-<>-";
		}
	}
}
