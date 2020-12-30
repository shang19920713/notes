function minDay(day){
    var today = new Date();
    var targetday_milliseconds=today.getTime() + 1000*60*60*24*day;
    today.setTime(targetday_milliseconds); //ע�⣬�����ǹؼ�����
    var tYear = today.getFullYear();
    var tMonth = today.getMonth();
    var tDate = today.getDate();
    tMonth = doHandleMonth(tMonth + 1);
    tDate = doHandleMonth(tDate);
    return tYear+"-"+tMonth+"-"+tDate;
}
function doHandleMonth(month){
    var m = month;
    if(month.toString().length == 1){
        m = "0" + month;
    }
    return m;
}
//��ȡ���7������
console.log(getDay(0));//��������
console.log(getDay(-7));//7��ǰ����
//��ȡ���3������
console.log(getDay(0));//��������
console.log(getDay(-3));//3��ǰ����