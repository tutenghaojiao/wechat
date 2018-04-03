<?php
/**
 *description
 *FILE_NAME          wechat
 *author             周天君 ztj1030@qq.com
 *date               2018/4/2 18:53:39
 */

namespace app;


class Jssdk extends Common
{

//————————————————————jssdk练习2018年4月2日20:24:37————————————————————————

	/**
	 * 1、加载jssdk模板并进行测试
	 */
	public function index ()
	{
		//echo 'ceshi';die;//首页连接OK
		//1、公众号的唯一标识
		$appId=$this->config['appID'];
		//p ($appId);die;



		//签名参数样本
		//noncestr=Wm3WZYTPz0wzccnW
		//jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VMCPGGVi4C3VM0P37wVUCFvkVAy_90u5h9nbSlYy3-Sl-HhTdfl2fzFy1AOcHKP7qg
		//timestamp=1414587457
		//url=http://mp.weixin.qq.com?params=value


		//2、生成签名的时间戳
		$timestamp = time ();

		//3、生成签名的随机串
		$nonceStr = md5 (microtime (true));

		//4、获取jsapi_ticket
		$ticket = $this->getApiTicket ();
		//p ($ticket);die;//HoagFKDcsGMVCIY2vOjf9nHefNFHqVudXAPV5nmDFSYPEgXQ4tVIhCBQiN2bBQ6NkELStrZ93GNQDvsguvGJXA


		//5、获取url地址（当前页面地址配合 p($_SERVER);die;）
		$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		//var_dump ($url);die();//OK

		//6、签名拼接(样本：
		// jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VMCPGGVi4C3VM0P37wVUCFvkVAy_90u5h9nbSlYy3-Sl-HhTdfl2fzFy1AOcHKP7qg&
		//noncestr=Wm3WZYTPz0wzccnW&
		//timestamp=1414587457&
		//url=http://mp.weixin.qq.com?params=value)
		//(&times会被解析成X，不影响在网页输出，但是本地操作需要改成php识别的编码——》X改成&times)
		$str='jsapi_ticket='.$ticket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
		//p ($str);die;//OK

		//7、签名加密
		$signature =sha1 ($str);
		//p($signature);die;


		//加载jssdk模板文件(上面的变量可以加载到页面中去)
		include "./view/jssdk.php";
	}


	/**
	 * 2、获取jsapi_ticket
	 *
	 * 2018年4月2日22:29:11作业：将jsapi_ticket进行缓存2小时
	 * @return mixed
	 */
	private function getApiTicket(){
		//3.创建缓存目录
		$dir=__DIR__.'/cache';//把文件创建在同级文件目录里面
		//p ($dir);die();////www/wwwroot/wechat.houdunphp.cn/app/cache
		is_dir ($dir)||mkdir ($dir,0777,true);

		//4、创建文件（存储令牌数据）
		$fileName=md5 ($this->config['token'].$this->config['appID']).'.php';
		//p ($fileName);die();//OK

		//5、组合成一个完整文件目录
		$fullPath=$dir.'/'.$fileName;
		//p ($fullPath);die();//OK

		//6、由于jsapi_ticket的有效期7200秒，开发者必须在自己的服务全局缓存jsapi_ticket;
		if (is_file ($fullPath)&& filemtime ($fullPath)+7000>time ()){//如果接口文件存在，且时间没有超过2小时，那么就直接调用
			//echo 1;//能输出说明存在
			$ticket=include $fullPath;
			//p($data);die();
		}else{//如果不存在就执行以下判断，重新调用接口
			//echo 2;//能输出说明不存在
			//通过curl请求该接口（数据是json格式的）

			//1、采用http GET方式请求获得jsapi_ticket
			$url=$this->config['interfacedamin'].'/cgi-bin/ticket/getticket?access_token='.$this->wx->getAccessToken().'&type=jsapi';
			//p ($url);die();//OK

			//2、请求接口，获取jsapi_ticket
			$ticket=json_decode ($this->wx->curl ($url),true);//json数据转换成php数组
			//p($ticket);die();//OK

			//将数据写入已经建立好的缓存目录文件里面(需要合法化缓存的数据，才能正常在文件中读取查看)——》测试用
			file_put_contents ($fullPath,"<?php \n\rreturn ".var_export ($ticket,true).";\r\n?>");//测试OK
		}

		return $ticket['ticket'];//返回jsapi_ticket
	}
}