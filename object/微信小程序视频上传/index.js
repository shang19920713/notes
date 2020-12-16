//方式一
Page({
    data: {
        src: ''
    },
    //选择视频
    chooseVideo: function() {
        var that = this
        wx.chooseVideo({
            success: function(res) {
                that.setData({
                    src: res.tempFilePath,
                })
            }
        })
    },
    //上传视频 目前后台限制最大100M，以后如果视频太大可以在选择视频的时候进行压缩
    uploadvideo: function() {
        var src = this.data.src;
        wx.uploadFile({
            url: 'http://172.16.98.36:8080/upanddown/upload2',//服务器接口
            method: 'POST',//这句话好像可以不用
            filePath: src,
            header: {
                'content-type': 'multipart/form-data'
            },
            name: 'files',//服务器定义的Key值
            success: function() {
                console.log('视频上传成功')
            },
            fail: function() {
                console.log('接口调用失败')
            }
        })
    }
})

//方式二

Page({
    /**
     * 页面的初始数据
     */
    data: {
        videoUrl:''
    },
//点击上传视频按钮
    addVideoTap: function () {
        var that = this;
//选择上传视频
        wx.chooseVideo({
            sourceType: ['camera'], //视频选择的来源
            //sizeType: ['compressed'],
            compressed:false,//是否压缩上传视频
            camera: 'back', //默认拉起的是前置或者后置摄像头
            success: function (res) {
                //上传成功，设置选定视频的临时文件路径
                that.setData({
                    videoUrl: res.tempFilePath
                });
                //在上传到服务器前显示加载中
                wx.showLoading({
                    title: '加载中...',
                    icon: 'loading',
                });
                //上传视频
                wx.uploadFile({
                    url: '/upload/service/uploadFiles', //开发者服务器的 url
                    filePath: res.tempFilePath, // 要上传文件资源的路径 String类型！！！
                    name: 'file', // 文件对应的 key ,(后台接口规定的关于图片的请求参数)
                    header: {
                        'content-type': 'multipart/form-data'
                    }, // 设置请求的 header
                    formData: {

                    }, // HTTP 请求中其他额外的参数
                    success: function (res) {
                        //上传成功后隐藏加载框
                        wx.hideLoading();
                        console.log(res);
                    },
                    fail: function (res) {
                        console.log("图片上传失败" + res);
                    }
                })
            }
        })
    }

});