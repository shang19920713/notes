<?php
    //后端处理图片上传
    $photo_types = array(
        'image/png',
        'image/jpeg',
        'image/jpg'
    );//定义上传格
    $max_size = 9999999999;    //上传照片大小限制
    $photo_folder = "upload/imgs/" . date("Y") . "/" . date("m") . "/" . date("d") . "/"; //上传照片路径
    if (!file_exists($photo_folder)) //检查照片目录是否存在
    {
        mkdir($photo_folder, 0777, true);  //mkdir("temp/sub, 0777, true);
    }
    $upfile = $_FILES['file'];
    $name = $upfile['name'];
    $type = $upfile['type'];
    $size = $upfile['size'];
    $tmp_name = $upfile['tmp_name'];

    $file = $_FILES["file"];
    $photo_name = $file["tmp_name"];
    $photo_size = getimagesize($photo_name);
    $info = array();
    if ($max_size < $file["size"])//检查文件大小
    {
        $info['code'] = '-1';
        $info['msg'] = '文件超过规定大小';
        echo json_encode($info);
        exit;
    }

    if (!in_array($file["type"], $photo_types))//检查文件类型
    {
        $info['code'] = '-1';
        $info['msg'] = '文件类型不符';
        echo json_encode($info);
        exit;
    }

    if (!file_exists($photo_folder))//照片目录
        mkdir($photo_folder);
    $pinfo = pathinfo($file["name"]);
    $photo_type = $pinfo['extension'];//上传文件扩展名
    $photo_server_folder = $photo_folder . time() . "." . $photo_type;//以当前时间和7位随机数作为文件名，这里是上传的完整路径
    if (!move_uploaded_file($photo_name, $photo_server_folder)) {
        $info['code'] = '-3';
        $info['msg'] = '移动文件出错';
        echo json_encode($info);
        exit;
    }
    $pinfo = pathinfo($photo_server_folder);
    $fname = $pinfo['basename'];
    $info['code'] = '1';
    $info['msg'] = "http://".$_SERVER['HTTP_HOST']."/".$photo_server_folder;
    $info['audioname'] = str_replace(strrchr($name, '.'), '', $name);
    echo json_encode($info);
    exit;
?>

<link rel="stylesheet" href="/dms/res/layui/css/layui.css">
<form  class="form-horizontal layui-form"  >
    <div class="form-group">
        <label class="col-sm-2 control-label">背景图片:</label>
        <div class="col-sm-10">
            <div class="layui-upload">
                <input type="hidden" name="backpic" value="">
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo1" src="" style="width: 300px;height: 200px;">
                    <p id="demoText"></p>
                </div>
                <button type="button" style="display: none" class="layui-btn" id="test1">上传图片</button>
            </div>
        </div>
    </div>
</form>
<script src="/dms/res/layui/layui.js" type="text/javascript"></script>
<script>
    layui.use(['form', 'layedit', 'laydate','upload'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate
            ,upload = layui.upload;
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: "/dms/upload/img"
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            },done: function(res){
                $("input[name='backpic']").val(res.msg);
                return layer.msg('上传成功');
            }
            ,error: function(){
            }

        });

    });

</script>