#数组转字符串 
`[1,2,3].tostring();输出 1,2,3`
#字符串转数组 
`"a,b,c".split(',');输出 ["a","b","c"]`
#长时间存储值 刷新页面不会失效
`localStorage.setItem("key",'value')存值`  
`localStorage.getItem("key")取值`  
`localStorage.clear()初始化删除所有值`
#设置表单属性 
`$("input[name='ids']").prop('checked',true)`
#js使用php变量
###字符串
`var text = '<?php echo $text ?>';`
###数组
`var articlesJson = '<?php echo json_encode($articles); ?>';`  
`var articles = JSON.parse(articlesJson);`
#layui 提示弹出层 
`if(res.code != 0){
    layer.msg(res.msg, {icon: 2, time: 1000}, function () {
    location.reload();});
}else{
    layer.msg(res.msg, {icon:1,time:1000},function(){
    location.reload();});
}`
#blob处理图片
`https://blog.csdn.net/qq_35393869/article/details/80924677`
#图片压缩
`https://www.jianshu.com/p/2da2b4db49db`
#layui上传并压缩图片
`https://blog.csdn.net/Jasons_xie/article/details/89204379`
#另一种blob压缩图片
`https://www.cnblogs.com/zhaoyingjie/p/8456731.html`
#jquery跳转
###第一种：(跳转到b.html)
`window.location.href="b.html";`
###第二种：（返回上一页面）
`window.history.back(-1);`
###第三种：
`window.navigate("b.html");`
###第四种：
`self.location='b.html';`
###第五种
`top.location='b.html';`
###第六种刷新当前页面
`location.reload();`









