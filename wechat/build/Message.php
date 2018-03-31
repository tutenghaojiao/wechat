<?php

namespace wechat\build;

use wechat\Wx;

/**
 *description         消息管理器类
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 17:28:35
 */
class Message extends Wx
{
	//________________________________________普通消息常量_________________________________
	const MSG_TYPE_TEXT       = 'text';//文本类型
	const MSG_TYPE_IMAGE      = 'image';//图片类型
	const MSG_TYPE_VOICE      = 'voice';//语音类型
	const MSG_TYPE_VIDEO      = 'video';//视频类型
	const MSG_TYPE_SHORTVIDEO = 'shortvideo';//小视频类型
	const MSG_TYPE_LOCATION   = 'location';//地理位置类型
	const MSG_TYPE_LINK       = 'link';//链接类型
	//________________________________________事件消息常量_________________________________
	const MSG_EVENT_SUBSCRIBE   = 'subscribe';//订阅常量
	const MSG_EVENT_UNSUBSCRIBE = 'unsubscribe';//取消订阅常量


	/**
	 * 1、文本消息回复
	 *
	 * @param $message 回复内容
	 */
	public function text ( $message )
	{
		$content = $this->getMessage ();//通过父级Wx获得粉丝发来的信息
		$time    = time ();//回复时间当前系统时间
		//回复文本消息;(样式中不能有空格)
		$str= <<<message
<xml> 
<ToUserName><![CDATA[{$content->FromUserName}]]></ToUserName>
<FromUserName><![CDATA[{$content->ToUserName}]]></FromUserName>
<CreateTime>{$time}</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[{$message}]]></Content>
</xml>
message;
		echo $str;//测试OK
	}


	/**
	 *2、 图文消息自动回复
	 */
	public function news ($data)
	{
		//p ($data);die();
		//$content = $this->getMessage ();//通过父级Wx获得粉丝发来的信息
		$time= time ();//回复时间当前系统时间
		$count=count ($data);//数组元素的数量（下面用到信息条数）
		//p ($count);die();

		$res="<xml>
<ToUserName><![CDATA[{$this->getMessage ()->FromUserName}]]></ToUserName>
<FromUserName><![CDATA[{$this->getMessage ()->ToUserName}]]></FromUserName>
<CreateTime>{$time}</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>{$count}</ArticleCount>
<Articles>";

foreach($data as $v){
	$res.="<item>
	<Title><![CDATA[{$v['title']}]]></Title>
	<Description><![CDATA[{$v['description']}]]></Description>
	<PicUrl><![CDATA[{$v['picurl']}]]></PicUrl>
	<Url><![CDATA[{$v['url']}]]></Url>
	</item>";
	}

		$res.="</Articles></xml>";
		echo $res;
	}
	//________________________________________普通消息判定_________________________________

	/**
	 * 1、文本消息判定
	 *
	 * @return bool
	 */
	public function isText ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_TEXT;
	}

	/**
	 * 2、图片判定
	 *
	 * @return bool
	 */
	public function isImage ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_IMAGE;
	}

	/**
	 * 3、语音消息
	 *
	 * @return bool
	 */
	public function isVoice ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_VOICE;
	}

	/**
	 * 4、视频消息
	 *
	 * @return bool
	 */
	public function isVideo ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_VIDEO;
	}

	/**
	 * 5、短视频消息
	 *
	 * @return bool
	 */
	public function isShortVideo ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_SHORTVIDEO;
	}

	/**
	 * 6、地理位置类型
	 *
	 * @return bool
	 */
	public function isLocation ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_LOCATION;
	}

	/**
	 * 7、链接类型
	 *
	 * @return bool
	 */
	public function isLink ()
	{
		return $this->getMessage ()->MsgType == self::MSG_TYPE_LINK;
	}

	//________________________________________事件消息判定_________________________________

	/**
	 * 1、订阅事件
	 */
	public function isSubscribe ()
	{
		//file_put_contents ('a.php',$this->getMessage ()->MsgType);//event类型
		//file_put_contents ('a.php',$this->getMessage ()->Event);//subscribe订阅事件
		//return $this->getMessage ()->MsgType=='text';
		//判断事件类型和事件值
		return $this->getMessage ()->MsgType == 'event' && $this->getMessage ()->Event == self::MSG_EVENT_SUBSCRIBE;
	}


	/**
	 * 2、取消订阅事件
	 */
	public function isUnSubscribe ()
	{
		return $this->getMessage ()->MsgType == 'event' && $this->getMessage ()->Event == self::MSG_EVENT_UNSUBSCRIBE;


	}


}