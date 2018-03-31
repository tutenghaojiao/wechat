<?php


namespace wechat\build;


use wechat\Wx;

/**
 *description		 自定义菜单功能
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 17:42:25
 */

class Button extends Wx
{
	/**
	 * 1、自定义菜单创建接口（2018年3月30日19:00:09）
	 */
	public function create($postData){
		//echo '我是按钮';//OK
		//p ($postData);die();//jSON格式数据

		//http请求方式：POST
			$url=self::$config['interfacedamin'].'/cgi-bin/menu/create?access_token='.$this->getAccessToken ();
			//p ($url);die();//ok
			//把json格式的数据转换成php数组
			return json_decode ($this->curl ($url,$postData),true);
	}

	/**
	 * 2、删除自定义菜单
	 */
	public function delete(){
		//http请求方式：GET
		$url=self::$config['interfacedamin'].'/cgi-bin/menu/delete?access_token='.$this->getAccessToken ();
		return json_decode ($this->curl ($url),true);
	}
}