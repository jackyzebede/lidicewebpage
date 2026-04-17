<?php

namespace common\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use app\helpers\Lhelper;

class MainUrlRule extends Object implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function parseRequest($manager, $request)
    {
		$url = $request->getUrl();
		//$url = str_replace("/Lidice/", "", $url);
                $url = str_replace("/Liqui/", "", $url);

		$url = str_replace("?", "/", $url);
		$url = str_replace("=", "/", $url);
		if ($url)
		{
			$url = explode("/", $url);
			$path = "";
			$params = [];
			if (isset($url[1]))
			{
				$path = $url[0]."/".$url[1];
			}
			if (isset($url[3]))
			{
				$params = [$url[2] => $url[3]];
			}
			return [$path, $params];
		}
		else
		{
			return ['site/index', []];
		}




        return false;
    }
}