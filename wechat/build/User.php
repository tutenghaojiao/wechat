<?php


namespace wechat\build;


use wechat\Wx;

/**
 *description		 用户管理
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/30 20:04:03
 */
class User extends Wx
{
	/**1、
	 *获得单一粉丝信息
	 * @param        $openid  粉丝的id
	 * @param string $lang    语言
	 *
	 * @return mixed		  返回值是多种不同的数据类型（伪类型）
	 */
	public function getUserInfo($openid,$lang='zh_CN '){
			//p ($openid);//粉丝的openid相当于是｛FromUserName｝
			//p($lang);die();//开发者传的字体
		//http请求方式: GET
		$url=self::$config['interfacedamin'].'/cgi-bin/user/info?access_token='.$this->getAccessToken ().'&openid='.$openid.'&lang='.$lang;
		return json_decode ($this->curl ($url),true);

	}


	/**
	 *2、 批量获得分析信息
	 * @param        $data		粉丝的id信息（数组承接）
	 * @param string $lang		语言
	 *
	 * @return mixed
	 */
	public function getFansInfo($data,$lang='zh_CN'){
		     //p ($data);
			//http请求方式: POST
			$url=self::$config['interfacedamin'].'/cgi-bin/user/info/batchget?access_token='.$this->getAccessToken ();
			//p ($url);die();
			$postData=[];
			foreach ($data as $k=>$v){
				$postData['user_list'][]=[
					"openid"=>$v,
					"lang"=> $lang,
				];
			}

			//p ($postData);die();//成功转换成PHP数组
			echo  json_encode ($postData,true);//数组转成json格式
			return json_decode ($this->curl ($url,json_encode ($postData,true),true));





	}
}