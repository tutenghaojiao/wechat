<?php
/**
 *description         微信基础类
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 14:26:03
 */

namespace wechat;



class Wx
{
	protected static $config;//配置常用配置项成员属性

	/**
	 * 自动加载配置项
	 * Wx constructor.
	 *
	 * @param string $config
	 */
	 public function __construct ($config='')
	 {
	 	//p ($config);die();//
	 	if (!self::$config){//如果条为false
	 		//p (self::$config);die();
	 		self::$config=$config;
			//p (self::$config);die();

		}
	 }


	/**
	 * 1、微信通信验证
	 */
	public function valid ()
	{
		//判断为了，只有在通信验证的时候再执行，粉丝之间消息往来的时候不要执行
		if ( isset( $_GET[ "signature" ] ) && isset( $_GET[ "timestamp" ] ) && isset( $_GET[ "nonce" ] ) && isset( $_GET[ "echostr" ] )) {

			//微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
			$signature = $_GET[ "signature" ];
			//	时间戳
			$timestamp = $_GET[ "timestamp" ];
			//随机数
			$nonce = $_GET[ "nonce" ];
			//这里token需要跟微信服务器配置保持一致，自行设置
			$token = self::$config['token'];
			//三个参数放到数组里面
			$tmpArr = [ $token , $timestamp , $nonce ];
			//数组排序
			sort ( $tmpArr , SORT_STRING );
			//数组转成字符串
			$tmpStr = implode ( $tmpArr );
			//字符串加密
			$tmpStr = sha1 ( $tmpStr );

			//加密字符串$tmpStr与$signature进行比对
			if ( $tmpStr == $signature ) {//比对成功原样返回echostr(随机字符串)参数内容
				echo $_GET[ 'echostr' ];
				exit;
			} else {
				return false;
			}
		}
	}


	/**
	 *2、接收粉丝发来的消息
	 */
	public function getMessage ()
	{
		//LIBXML_NOCDATA：把 CDATA 设置为文本节点。
		//php://input 是个可以访问请求的原始数据的只读流
		//返回粉丝发来的信息
		return simplexml_load_string ( file_get_contents ( 'php://input' ) , 'simpleXmlElement' , LIBXML_NOCDATA );
	}


	/**
	 * 3、实例化功能类
	 * @param $class  需要连接的类名
	 */
	public function instance($class){
		$className='\wechat\build\\'.ucfirst($class);
		//p ($className);die();
		return (new $className());

	}


	//——————————————————2018年3月30日15:51:21————————————————————————

	/**
	 * 1、curl请求接口的get和post方法
	 * post方式接口，传来的数据必须是json格式的
	 *
	 * @param        $url            请求地址
	 * @param string $postData       post请求数据
	 *
	 * @return string                curl请求结果
	 */
	public function curl ( $url , $postData = '' )
	{
		$ch = curl_init ();//初始化
		//get请求方法
		curl_setopt ( $ch , CURLOPT_URL , $url );//执行curl请求地址
		curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );////0是默认值，默认把数据展示   1 不展示数据，可以接收   RETURN返回   TRANSFER转义、运输
		curl_setopt ( $ch , CURLOPT_SSL_VERIFYPEER , false );//校验对等
		curl_setopt ( $ch , CURLOPT_SSL_VERIFYHOST , false );
		if ( $postData ) {//POST请求方法
			curl_setopt ( $ch , CURLOPT_TIMEOUT , 60 );
			curl_setopt ( $ch , CURLOPT_POST , 1 );
			curl_setopt ( $ch , CURLOPT_POSTFIELDS , $postData );
		}
		if ( curl_exec ( $ch ) === false ) {//执行--发送请求
			$data = "";
		} else {
			$data = curl_multi_getcontent ( $ch );
		}
		curl_close ( $ch );////关闭curl资源

		return $data;
	}

	/**
	 * 2、获取access_token
	 */
	public function getAccessToken()
	{
		//1.创建缓存目录
			$dir=__DIR__.'/cache';
			//p ($dir);die();///www/wwwroot/wechat.houdunphp.cn/wechat/cache
			is_dir ($dir)||mkdir ($dir,0777,true);

		//2、创建文件（存储令牌数据）
			$fileName=md5 (self::$config['appID'].self::$config['appsecret']).'.php';
			//p ($fileName);die();//OK
		//3、组合成一个完整文件目录
			$fullPath=$dir.'/'.$fileName;
			//p ($fullPath);die();//OK



		//5、由于access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效。（每天调用上限2000次）;需要判定

			if (is_file ($fullPath)&& filemtime ($fullPath)+7200>time ()){//如果接口文件存在，且时间没有超过2小时，那么就直接调用
					//echo 1;//能输出说明存在
					$data=include_once $fullPath;
					//p($data);die();
			}else{//如果不存在就执行以下判断，重新调用接口
				//echo 2;//能输出说明不存在
				//4、https请求方式: GET(注意在手册中复制，需要查看前后是否有空白)
					$url=self::$config['interfacedamin'].'/cgi-bin/token?grant_type=client_credential&appid='.self::$config['appID'].'&secret='.self::$config['appsecret'];
					//通过curl请求该接口（数据是json格式的）
					$data=json_decode ($this->curl ($url),true);//json数据转换成php数组
					//p($data);die();//OK

					//将数据写入已经建立好的缓存目录文件里面(需要合法化缓存的数据，才能正常在文件中读取查看)——》测试用
					file_put_contents ($fullPath,"<?php \n\rreturn ".var_export ($data,true).";\r\n?>");//测试OK
			}
			return $data['access_token'];//返回通行令牌的值
	}


}