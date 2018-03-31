<?php
/**
 *description		 首页入口
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 10:54:29
 */

/**
 * 打印
 * @param $var
 */
function p($var){
	echo '<pre style="width: 100%;padding: 5px;background: #CCCCCC;border-radius: 5px">';
	if(is_bool ($var) || is_null ($var)){
		var_dump ($var);
	}else{
		print_r ($var);
	}
	echo '</pre>';
}


/**
 * 自动加载实例化之后的类文件
 * @param $classname	实例化的类名
 */
function __autoload($classname){
	//测试是否触发了这个函数
	//echo $classname;die();//app\Entry
	//加载实例化的类文件
	$filde=str_replace ('\\','/',$classname).'.php';
	//p($filde);die();//app/Entry.php
	//加载实例化的类模板
	include_once $filde;//加载OK
}


/**
 * 实例化一个未知的类和调用一个未知的方法
 */
(new \app\Entry())->handler ();