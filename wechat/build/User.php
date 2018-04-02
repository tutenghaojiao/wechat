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
	/**
	 * 1、获得单一粉丝信息
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
	 *2、 批量获得粉丝信息，并且把信息存储起来
	 * @param        $data		粉丝的id信息（数组承接）
	 * @param string $lang		语言
	 *
	 * @return mixed
	 */
	public function getFansInfo($data,$lang='zh_CN'){

			//1.创建用户信息缓存目录
			$dir=__DIR__.'/infoCache';//把文件创建在同级文件目录里面
			//p ($dir);die();///www/wwwroot/wechat.houdunphp.cn/wechat/build/infoCache
			is_dir ($dir)||mkdir ($dir,0777,true);

			//2、创建文件（粉丝信息文件）
			//$fileName=md5 (time ().mt_rand(0,99999)).'.php';//变动文件名称
			$fileName=md5(fansInfo).'.php';
			//p ($fileName);die();//OK
			//3、组合成一个完整文件目录
			$fullPath=$dir.'/'.$fileName;
			//p ($fullPath);die();//OK


		     //p ($data);
			//4、http请求方式: POST
			$url=self::$config['interfacedamin'].'/cgi-bin/user/info/batchget?access_token='.$this->getAccessToken ();
			//p ($url);die();
			$postData=[];
			foreach ($data as $k=>$v){//5、按照开发者文档把数据组合成规定样式（POST数据示例）;并且把重新组合的数据给用一个数组承接起来
				$postData['user_list'][]=[
					"openid"=>$v,
					"lang"=> $lang,
				];
			}

			//p ($postData);die();//成功转换成PHP数组
			//echo  json_encode ($postData,true);//重组的数据转成json格式，是为了POst方式请求接口用
			$data=json_decode ($this->curl ($url,json_encode ($postData,true),true));//把最终请求的数据转为PHP格式，是为了方便数据调用
			//p ($data);
			//把获取的数据全部写入粉丝信息缓存文件（方便查看）
			file_put_contents ($fullPath,"<?php \n\rreturn ".var_export ($data,true).";\r\n?>");

			return $data;//返回所有粉丝的信息





	}

	//———————————————————————2018年3月31日17:39:13——————————————————

	/**
	 *3、设置用户备注名
	 * @param $openid    粉丝id
	 * @param $remark	  将要给粉丝修改的备注名称
	 *
	 * @return mixed	  伪类型数据
	 */
	public function reMark($openid,$remark=''){

		//http请求方式: POST（请使用https协议）
		$url=self::$config['interfacedamin'].'/cgi-bin/user/info/updateremark?access_token='.$this->getAccessToken ();
		//p ($url);//OK

		$markData=[
			"openid"=>$openid,
   			 "remark"=>$remark,
		];
		$markData=json_encode ($markData,true);//组成json格式数据
		//p ($markData);die();
		$markData=json_decode ($this->curl ($url,$markData),true);//数据转换成PHP格式的
		//p ($markData);die();

		if($markData['errcode']==0 || $markData['errmsg']=='ok' ){
			echo '修改备注成功';
		}else{
			echo '修改失败';
		}
	}

	/**
	 * 4、创建标签;一次只能创建一个标签
	 * @param string $tagName	要创建的标签名
	 *
	 * @return string			提示信息
	 */
	public function createTag($tagName=''){
		//http请求方式：POST（请使用https协议）
		$url=self::$config['interfacedamin'].'/cgi-bin/tags/create?access_token='.$this->getAccessToken ();

		//$tagName=explode ('.',$tagName);
		//p($tagName);die();
		//$tagData=[];
		$tagData['tag']=[
			"name"=>$tagName,
		];

		//p ($tagData);die();
		$tagData=json_encode ($tagData,true);//把数据转为json格式
		$tagData=$this->curl ($url,$tagData);//post方式请求接口;这一步实际上是已经完成了标签的创建
		//p ($tagData);die();

		//这一步主要是在浏览器看创建标签后返回的相关数据（成功或失败的数据）
		$tagData=json_decode ($tagData,true);
		//$tagData=json_encode ($tagData,true);
		//p ($tagData);die();

		//标签是否创建成功的提示语句
		if (isset($tagData['tag']['id']) && isset($tagData['tag']['name'])){
			return '创建标签成功';
		}elseif($tagData['errcode']==45157){
		     return '标签名非法，请注意不能和其他标签重名';
		}elseif($tagData['errcode']==45158){
			return '标签名长度超过30个字节';
		}elseif($tagData['errcode']==-1){
			return '系统繁忙';
		}else{
			return '创建的标签数过多，请注意不能超过100个';
		}

	}


	/**
	 *  5、获取公众号已创建的标签
	 * (得到所有的标签里面三个参数 "id":1, "name":"每天一罐可乐星人","count":0 //此标签下粉丝数)
	 *
	 * @return mixed
	 */
	public function getTags(){
		//http请求方式：GET（请使用https协议）
		$url=self::$config['interfacedamin'].'/cgi-bin/tags/get?access_token='.$this->getAccessToken ();
		return json_decode ($this->curl ($url),true);
	}

	/**
	 * 6、删除标签
	 */
	public function deleteTags($id){
		//http请求方式：POST（请使用https协议）
		$url=self::$config['interfacedamin'].'/cgi-bin/tags/delete?access_token='.$this->getAccessToken ();
		$postData["tag"]=[
			"id" => $id,
		];
		//p ($postData);die();
		$postData=json_encode ($postData,true);
		//p ($postData);die();
		$postData=$this->curl ($url,$postData);//这一步已经执行了删除
		//p ($postData);die();//json格式的数据

		$postData=json_decode ($postData,true);//把json格式的数据转成php数据，方便以下作判断
		//p ($postData);die();
		//以下对删除作出错误或成功提示
		if ($postData['errcode']==0 && $postData['errmsg']=='ok'){
			return '删除成功';
		}elseif ($postData['errcode']==45058){
			return '不能修改0/1/2这三个系统默认保留的标签';
		}elseif ($postData['errcode']==45057){
			return '该标签下粉丝数超过10w，不允许直接删除';
		}else{
			return '系统繁忙';
		}


	}

}