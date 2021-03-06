<?php
namespace app;
use wechat\build\Button;
use wechat\build\Message;
use wechat\Wx;

/**
 *description		测试微信sdk
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 14:52:14
 */

class Entry extends Common
{
	/**
	 * 功能测试
	 */
	public  function handler(){
		//file_put_contents ('a.php',1);die;
		//echo '我是handler测试连接方法';die();//OK

		////2、测试接收粉丝发送来的消息（需要在Wx.php里面进行创建方法）
		//	file_put_contents ('app.php',12312312);//测试写入正确OK
		//	$content=$this->wx->getMessage();//获得粉丝发来的信息
		//
		//	$content=var_export ($content,true);//数据合法化之后才能通过file_put_contents输出到页面进行显示
		//	//如果消息没有写入，需要检查valid里面的方法是否加了判定;还是不行就是微信缓存的问题，可以用公众平台测试号操作
		//	file_put_contents ('./message.php',$content);//抓取发送的消息对应的所有信息OK
		//
		//	$content=var_export ($content->ToUserName,true);//合法法发送信息的人名称
		//	file_put_contents ('./user.php',$content);//在php输出消息的人名  OK


		//3、测试给粉丝自动回复消息（'FromUserName' => 'onQSk1OjFUcWDJELWOX65JpbOcJI',）
		//	$time=time ();//回复时间当前系统时间
			//回复文本消息;(样式中不能有空格)
//			$str=<<<message
//<xml>
//<ToUserName><![CDATA[{$content->FromUserName}]]></ToUserName>
//<FromUserName><![CDATA[{$content->ToUserName}]]></FromUserName>
//<CreateTime>{$time}</CreateTime>
//<MsgType><![CDATA[text]]></MsgType>
//<Content><![CDATA[你好;我很忙]]></Content>
//</xml>
//message;
 //echo $str;//测试OK


		////4、封装给粉丝的回复信息;
		//	(new Message())->text ('我是测试信息，收到我说明已经通了');//OK
		//	(new Button())->create ();//按钮测试成功了
		//
		//	$this->wx;
		//	//自动实例化信息类，并发送消息（测试成功）
		//	$this->wx->instance ('message')->text('发送成功');

		////5、关键词回复
		//	//1、实例化消息控制器这个类
		//		$messageClass=$this->wx->instance ('message');
		//		//p ($messageClass);//一个对像
		//
		//		//$messageClass->text('成功');//自动回复信息OK
		//
		//	//2、抓取粉丝发来的信息内容用一个变量存起来(即关键字)
		//		$fanContent=$this->wx->getMessage ()->Content;
		//		//file_put_contents ('aa.php',$fanContent);//接收信息内容成功
		//
		//		//1.已经关注和首次关注的判定执行自动回复的信息
		//		if($messageClass->isSubscribe()){
		//			$messageClass->text('欢迎你订阅微信公众号,点击1有惊喜，点击2有福利，点击3有图文');
		//		}


				//2.关键字匹配判定自动回复信息
				//	if ($fanContent==1){//关键字为1的时候回复的内容
				//		$messageClass->text('恭喜发财');
				//	}elseif ($fanContent==2){//关键字为2的时候回复的内容
				//		$messageClass->text('大吉大利');
				//	}
				//	else{//没有在关键字范围内时自动回复信息（默认回复）
				//		$messageClass->text('没有及时回复请拨打电话400820189');
				//	}

		//6、测试消息类型
		//		//1、文本消息判定OK
		//			if ($messageClass->isText()){
		//				$messageClass->text('你发送的是文本');
		//			}
		//
		//		//2、图片判定OK
		//			if ($messageClass->isImage()){
		//				$messageClass->text('你发送的是图片');
		//			}
		//
		//		//3、语音类型判定OK
		//			if ($messageClass->isVoice()){
		//				$messageClass->text('你发送的是语音');
		//			}
		//
		//		//4、连接类型判定OK
		//			if ($messageClass->isLink()){
		//				$messageClass->text('你发送的是连接');
		//			}



		////7、图文消息回复 (把信息用数组储存起来，方便方法里面调用)2018年3月30日14:02:04
		//$data=[
		//	[
		//		'title'=>'世界利好',
		//		'description'=>'我是内容部分',
		//		'picurl'=>'http://wechat.houdunphp.cn/xiang.jpg',
		//		'url'=>'http://www.houdunren.com',
		//
		//	],
		//	[
		//		'title'=>'兄弟你瘦了',
		//		'description'=>'我是内容部分',
		//		'picurl'=>'http://wechat.houdunphp.cn/k.png',
		//		'url'=>'http://www.houdunren.com',
		//	],
		//];
		////$messageClass->news($data);



//—————————————————————2018年3月30日14:57:29————————————————————————
		//1、测试curl(请求接口数据——》可以在浏览器中测试)
				//get方式接口测试
					//$res=$this->wx->curl ('http://www.houdunren.com');
					//file_put_contents ('interface.html',var_export ($res,true));
				//post方式接口测试
				//	echo $this->wx->curl ('http://www.baidu.com',1);//两个参数会报302found 错误
				//	echo $this->wx->curl ('http://www.baidu.com');//正常输出

		//2、测试获取access_token
		//		echo  $this->wx->getAccessToken();//OK

		//3、创建测试菜单
				//1、click和view的请求示例()
					$buttonData=<<<str
{
     "button":[
     {    
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"大唐无双",
           "sub_button":[
           {    
               "type":"view",
               "name":"少林",
               "url":"http://www.shiyongzhiwuyuan.cn/?05bd-slkf-11"
            },
            {
               "type":"click",
               "name":"联系我们",
               "key":"V1001_GOOD"
            }]
       	}
       ]
 }
str;
					//$res=$this->wx->instance ('button')->create($buttonData);//调用菜单方式，传参数（数据）创建相对应的菜单
					//p ($res);//OK

		//4、测试删除菜单
		       		//$res=$this->wx->instance ('button')->delete();
		       		//p ($res);//OK

		//5、获得用户信息
		//			$FromUserName='onQSk1OjFUcWDJELWOX65JpbOcJI';//粉丝id
					//$res=$this->wx->instance ('user')->getUserInfo($FromUserName);
					//p ($res);//OK

		//6、批量获得粉丝信息（需要传输粉丝的id数据）
					$FromUserName1='onQSk1OjFUcWDJELWOX65JpbOcJI';//粉丝ID
					$FromUserName2='onQSk1OjFUcWDJELWOX65JpbOcJI';//粉丝ID
					$FromUserName3='onQSk1LErGuh57FdVEjpmZNEcr0A';//粉丝ID
					//$res=$this->wx->instance ('user')->getFansInfo([$FromUserName1,$FromUserName2,$FromUserName3]);
					//p ($res);//OK

//—————————————————————练习部分2018年3月31日14:18:49————————————————————————
//			$className=$this->wx->instance ('message');//实例化信息类

		/**
		 *1、自定义菜单事件(需要先创建菜单)点击菜单拉取消息时的事件推送
		 */
		//	if ($className->isClick()){
		//	return $className->text('我是自定义菜单事件');
		//}




		 /**
		  * 3、获取微信服务器IP地址
		  */
		 	//p ($className->getIp());//获取OK


		/**
		 * 4、测试设置用户备注名（备注名字汉字不显示）
		 * 备注名如果是汉子会被转成编码
		 */
			//$userName=$this->wx->instance ('user');//实例化信息类
		    //$userName->reMark('onQSk1OjFUcWDJELWOX65JpbOcJI','今天');//OK 可以通过上面的粉丝信息查看remake是否变化

		/**
		 * 5、测试标签创建配合下面的6使用（汉字不显示）
		 */
			 //echo  $userName->createTag('目目');//OK

		/**
		 * 6、获取公众号已创建的标签
		 */
			//p ($userName->getTags());//OK

		/**
		 * 7、删除标签
		 */
			//echo $userName->deleteTags(105);


//—————————————————————练习部分2018年4月2日16:17:59————————————————————————
		/**
		 * 1、测试错误翻译是否执行
		 */
		//$FromUserName='onQSk1OjFUcWDJELWOX65JpbOcJI'; //粉丝id
		//$res=$this->wx->instance ('user')->getUserInfo($FromUserName);
		//p ($res);//OK


		/**
		 *实例化素材这个类，方便后面测试调用
		 */
		//$meterial=$this->wx->instance ('meterial');

		/**
		 * 2、上传素材，素材文件必须保证服务器上有
		 */
		//$res=$meterial->uploadMeterial('dx.jpg',2);
		//p ($res);//OK








//—————————————————————练习部分2018年4月3日16:17:59————————————————————————

	}



}