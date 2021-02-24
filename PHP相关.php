<?php
//根据字段last_name对数组$data进行降序排列
$data = array(
    array(
        'id' => 5698,
        'first_name' => 'Bill',
        'last_name' => 'Gates',
    ),
    array(
        'id' => 4767,
        'first_name' => 'Steve',
        'last_name' => 'Aobs',
    ),
    array(
        'id' => 3809,
        'first_name' => 'Mark',
        'last_name' => 'Zuckerberg',
    )
);
$last_names = array_column($data,'last_name');
array_multisort($last_names,SORT_DESC,$data);
//多维数组去重
function assoc_unique($arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    sort($arr); //sort函数对数组进行排序
    return $arr;
}

//php下载
function download($file_sub_path, $file_name)
{
    //用以解决中文不能显示出来的问题
    //$file_name=iconv("utf-8","gb2312",$file_name);
    $file_sub_path = $file_sub_path;
    $file_path = $file_sub_path . $file_name;
    $file_path = str_replace("'", "", $file_path);
    //首先要判断给定的文件存在与否
    if (!file_exists($file_path)) {
        echo "没有该文件";
        return;
    }
    $fp = fopen($file_path, "r");
    $file_size = filesize($file_path);
    //下载文件需要用到的头
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Accept-Length:" . $file_size);
    Header("Content-Disposition: attachment; filename=" . $file_name);
    $buffer = 1024;
    $file_count = 0;

    //一下两行防止（格式未知 数据已被损坏）
    ob_clean();
    flush();
    //向浏览器返回数据
    while (!feof($fp) && $file_count < $file_size) {
        $file_con = fread($fp, $buffer);
        $file_count += $buffer;
        echo $file_con;
    }
    fclose($fp);
}
download('http://120.53.223.29:8200/upload/2021/01/07/','1609986107.mp3');
//爬虫GET方式
/**
 * curl_get
 * @param $url
 * @param null $param
 * @param null $options
 * @return array
 */
function curl_get($url,$param = null,$options = null){
    if(empty($options)){
        $options = array(
            'timeout' 		=> 30,// 请求超时
            'header' 		=> array(),
            'cookie' 		=> '',// cookie字符串，浏览器直接复制即可
            'cookie_file'   => '',// 文件路径,并要有读写权限的
            'ssl' 			=> 0,// 是否检查https协议
            'referer' 		=> null
        );
    }else{
        empty($options['timeout']) && $options['timeout'] = 30;
        empty($options['ssl']) && $options['ssl']	= 0;
    }
    $result = array(
        'code'      => 0,
        'msg'       => 'success',
        'body'      => ''
    );
    if(is_array($param)){
        $param = http_build_query($param);
    }
    $url = strstr($url,'?')?trim($url,'&').'&'.$param:$url.'?'.$param;
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);// 设置url
    !empty($options['header']) && curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']); // 设置请求头
    if(!empty($options['cookie_file']) && file_exists($options['cookie_file'])){
        curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie_file']);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie_file']);
    }else if(!empty($options['cookie'])){
        curl_setopt($ch, CURLOPT_COOKIE, $options['cookie']);
    }
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //curl解压gzip页面内容
    curl_setopt($ch, CURLOPT_HEADER, 0);// 不获取请求头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 输出转移，不输出页面
    !$options['ssl'] && curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['ssl']); // 禁止服务器端的验证ssl
    !empty($options['referer']) && curl_setopt($ch, CURLOPT_REFERER, $options['referer']);//伪装请求来源，绕过防盗
    curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
    //执行并获取内容
    $output = curl_exec($ch);
    //对获取到的内容进行操作
    if($output === FALSE ){
        $result['code'] = 1; // 错误
        $result['msg'] = "CURL Error:".curl_error($ch);
    }
    $result['body'] = $output;
    //释放curl句柄
    curl_close($ch);
    return $result;
}
//POST
/**
 * curl_post
 * @param $url              请求地址
 * @param null $param       get参数
 * @param array $options    配置参数
 * @return array
 */
function curl_post($url,$param = null,$options = array()){
    if(empty($options)){
        $options = array(
            'timeout' 		=> 30,
            'header' 		=> array(),
            'cookie' 		=> '',
            'cookie_file'   => '',
            'ssl' 			=> 0,
            'referer' 		=> null
        );
    }else{
        empty($options['timeout']) && $options['timeout'] = 30;
        empty($options['ssl']) && $options['ssl']	= 0;
    }

    $result = array(
        'code'      => 0,
        'msg'       => 'success',
        'body'      => ''
    );
    if(is_array($param)){
        $param = http_build_query($param);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);// 设置url
    !empty($options['header']) && curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']); // 设置请求头
    if(!empty($options['cookie_file']) && file_exists($options['cookie_file'])){
        curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie_file']);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie_file']);
    }else if(!empty($options['cookie'])){
        curl_setopt($ch, CURLOPT_COOKIE, $options['cookie']);
    }


    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //curl解压gzip页面内容
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    curl_setopt($ch, CURLOPT_HEADER, 0);// 不获取请求头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 输出转移，不输出页面
    !$options['ssl'] && curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['ssl']); // 禁止服务器端的验证ssl
    !empty($options['referer']) && curl_setopt($ch, CURLOPT_REFERER, $options['referer']);//伪装请求来源，绕过防盗
    curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
    //执行并获取内容
    $output = curl_exec($ch);
    //对获取到的内容进行操作
    if($output === FALSE ){
        $result['code'] = 1; // 错误
        $result['msg'] = "CURL Error:".curl_error($ch);
    }
    $result['body'] = $output;
    //释放curl句柄
    curl_close($ch);
    return $result;
}
//PHP随机不重复的数（自定义，以随机大乐透举例）
function getRandNumber($start = 1, $end = 35, $length = 5){
    //初始化变量为0
    $count = 0;
    //建一个新数组
    $temp = array();
    while ($count < $length) {
        //在一定范围内随机生成一个数放入数组中
        $temp[] = mt_rand($start, $end);
        //$data = array_unique($temp);
        //去除数组中的重复值用了“翻翻法”，就是用array_flip()把数组的key和value交换两次。这种做法比用 array_unique() 快得多。
        $data = array_flip(array_flip($temp));
        //将数组的数量存入变量count中
        $count = count($data);
    }
    //为数组赋予新的键名
    shuffle($data);
    //数组转字符串
    $str = implode(",", $data);
    //替换掉逗号
    $number = str_replace(',',' ', $str);
    return $number;
}
function in_total(){
    $front_area = getRandNumber(1,35,5);
    $back_area = getRandNumber(1,12,2);
    $in_total = $front_area . ' + '.$back_area;
    echo $in_total;
}
//php随机生成验证码，php随机生成数字，php随机生成数字加字母！

/*
 * 方法类
 * */

class functions
{
    /**
     * PHP随机生成验证码函数
     *
     * @param array
     * @return  mixed
     */
    function randCode($params = [])
    {
        $num = $params['num'] ?? 4; //验证码个数
        $isLetter = $params['isLetter'] ? $params['isLetter'] : 1; //1是纯数字 2是字母和数字的组合

        if ($isLetter == 1) {
            for ($i = 1; $i <= $num; $i++) {
                $codeMin .= 0;
                $codeMax .= 9;
            }
            return rand($codeMin, $codeMax);
        }

        if ($isLetter == 2) {
            //如果想调整权重，自己可以根据需求修改$codeArr这个一位数组
            $codeArr = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'e', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
            $codeKeys = array_rand($codeArr, $num);
            shuffle($codeKeys);
            foreach ($codeKeys as $codeValue) {
                $codeStr .= $codeArr[$codeValue];
            }
            return $codeStr;
        }
    }
}

//测试生成验证码方法
$re = (new functions())->randCode([
    'num' => 6, //需要的个数
    'isLetter' => 2, //1是纯数字 2是数字加字符串
]);
print_r($re);

