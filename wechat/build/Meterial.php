<?php


namespace wechat\build;

use wechat\Wx;

/**
 *description		 素材管理
 *FILE_NAME          wechat
 *author             周天君 ztj1030@qq.com
 *date               2018/4/2 17:02:33
 */

class Meterial extends Wx
{

	/**
	 * 上传素材永久和临时
	 * @param        $file     		素材文件
	 * @param int    $allowTime		素材保留的时间默认1为临时，除了1之外就是永久保留
	 * @param string $type			类型(image、video、voice、thumb)
	 *
	 * @return array
	 */
	public function uploadMeterial($file,$allowTime=1,$type='image'){



		if ($allowTime==1){
			//上传临时素材
			//http请求方式：POST/FORM，使用https
			$url=self::$config['interfacedamin'].'/cgi-bin/media/upload?access_token='.$this->getAccessToken ().'&type='.$type;
		}else{
			//上传永久素材
			//http请求方式: POST，需使用https
			$url=self::$config['interfacedamin'].'/cgi-bin/material/add_material?access_token='.$this->getAccessToken ().'&type='.$type;
		}
		//p ($file);die();//dx.jpg;
		//将文件变变成绝对路径
		$path=realpath ($file);
		//p ($path);die;///www/wwwroot/wechat.houdunphp.cn/dx.jpg

		//\CURLFile::
		//检测CURLFile类是否已定义
		//false不让走autoload
		//php版本>=5.5
		//p (class_exists ('CURLFile',false));die;//bool(true)
		if (class_exists ('CURLFile',false))
				{
					//echo 1;
					$data = [
						'media'=> new \CURLFile($path),
					];
				}else{
					$data = [
						'media'=> '@' . $path,
					];
				}
				//p ($data);die;//是一个对象

		//请求接口
		return $this->translateError (json_decode ($this->curl ($url,$data),true));
	}

}