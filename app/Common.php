<?php


namespace app;

use wechat\Wx;

/**
 *description		 公用类加载配置项和微信通信
 *FILE_NAME          wechat
 *author             周天君 ztj1030@qq.com
 *date               2018/4/2 17:55:10
 */

class Common
{
	protected $wx;//粉丝发来的微信信息
	protected $config;//加载配置项


	/**
	 * 自动连接微信通信
	 * Entry constructor.
	 */
	public function __construct ()
	{
		//设置常用配置项,用一个数组来储存起来
		$this->config=$config=[
			'token'=>'ztj1010',//开发者令牌
			'appID'=>'wxbdd94055d9c7cb12',//开发者ID
			'appsecret'=>'bde2e648174f18b0168e850abccb2462',//开发者秘钥
			'interfacedamin'=>'https://api.weixin.qq.com',//接口域名地址apiurl
			'ToUserName'=>'gh_1bbfc33ada53',//信息接收人（公众测试号）
			'FromUserName'=>'onQSk1OjFUcWDJELWOX65JpbOcJI',//消息发送人（粉丝）

		];
		//p ($config);die();//OK
		//1、跟微信服务器通信（需要一直开着直到测试结束）

		$this->wx=new Wx($config);//实例化调用Wx这个类
		$this->wx->valid ();//验证连接微信通信配置是否成功OK


	}
}