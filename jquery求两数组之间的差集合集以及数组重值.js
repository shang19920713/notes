<script>
 ///集合取交集
        Array.intersect = function () {
            var result = new Array();
            var arrCount = arguments.length;/*数组个数,默认2个数组取交集*/
            if (arrCount <= 1) { return; }
            var type = typeof (arguments[0][0]);
            for (var k = 1; k < arrCount; k++) {
                if (arguments[k].length < 1) {
                    return;//每个数组都要有值
                }
                if (type != typeof (arguments[k][0])) {//每个数组元素类型相同
                    return;
                }
            }
            var obj = {};

            for (var i = 0; i < arrCount; i++) {
                var arr = arguments[i];
                for (var j = 0; j < arr.length; j++) {
                    if (!obj[arr[j]]) {
                        obj[arr[j]] = 1;
                    }
                    else {
                        obj[arr[j]]++;
                    }
                }
            }

            for (var num in obj) {
                if (obj[num] == arrCount) {
                    if (type == typeof (0)) {
                        result.push(num - 0);
                    }
                    else {
                        result.push(num);
                    }
                }
            }
            return result;
        }

        Array.prototype.intersect = function (arr) {
            Array.intersect(this, arr);
        }
        //集合去掉重复
        Array.prototype.uniquelize = function () {
            var tmp = {},
                ret = [];
            for (var i = 0, j = this.length; i < j; i++) {
                if (!tmp[this[i]]) {
                    tmp[this[i]] = 1;
                    ret.push(this[i]);
                }
            }

            return ret;
        }
        //并集
        Array.union = function () {
            var arrCount = arguments.length;/*数组个数,默认2个数组取交集*/
            if (arrCount <= 1) { return; }
            var type = typeof (arguments[0][0]);
            for (var k = 1; k < arrCount; k++) {
                if (arguments[k].length < 1) {
                    return;//每个数组都要有值
                }
                if (type != typeof (arguments[k][0])) {//每个数组元素类型相同
                    return;
                }
            }
            var temp = arguments[0];
            var arrCount = temp.length;
            for (var i = 1; i < arguments.length; i++) {
                var arr = arguments[i];
                if (i > 1) {
                    arrCount += arr.length;
                }
                for (var j = 0; j < arr.length; j++) {
                    temp[arrCount + j] = arr[j];
                }
            }
            temp = temp.uniquelize();//去掉重复
            return temp;
        }
        Array.prototype.union = function (ar) {
            Array.union(this, ar);
        }
        //2个集合的差集 在arr不存在
        Array.prototype.minus = function (arr) {
            var result = new Array();
            var obj = {};
            var type = typeof (this[0]);
            for (var i = 0; i < this.length; i++) {
                obj[this[i]] = true;
            }
            for (var i = 0; i < arr.length; i++) {
                if (obj[arr[i]]) {
                    obj[arr[i]] = false;
                }
            }
            for (var num in obj) {
                if (obj[num]) {
                    if (type == typeof (0)) {
                        result.push(num - 0);
                    }
                    else {
                        result.push(num);
                    }
                }
            }
            return result;
        };

        console.log(Array.intersect(["1", "2", "3"], ["2", "3", "4", "5", "6"]));//[2,3]

        console.log([1, 2, 3, 2, 3, 4, 5, 6].uniquelize());//[1,2,3,4,5,6]
        console.log(Array.union(["1", "2", "3"], ["2", "3", "4", "5", "6"], ["5", "6", "7", "8", "9"]))
        console.log(["2", "3", "4", "5", "6"].minus(["1", "2", "3"]));
</script>
