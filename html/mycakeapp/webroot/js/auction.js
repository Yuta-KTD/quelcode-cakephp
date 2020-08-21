//時刻表示の仕方の参考：https://qiita.com/piesuke0727/items/91333b9a1ba8fe051be2
//参考2：https://jsstudy.hatenablog.com/entry/javascript-primer-5-1-timer

var timelimit = endDate - nowDate;

function countTime() {
    var day = Math.floor(timelimit / (60 * 60 * 24));
    var hour = Math.floor(timelimit / (60 * 60)) % 24;
    var minutes = Math.floor(timelimit / 60) % 60;
    var second = Math.floor(timelimit % 60);
    //配列にする
    var timer = [day, hour, minutes, second];

    return timer;
}

function countdownTimer() {
    if (timelimit >= 0) {
        timelimit -= 1;
        var timeCount = countTime();

        var insert = "";
        insert += timeCount[0] + '日';
        insert += timeCount[1] + '時間';
        insert += timeCount[2] + '分';
        insert += timeCount[3] + '秒';
        document.getElementById('result').innerHTML = insert;
    }
    else {
        document.getElementById('result').innerHTML = '終了しました。';
    }
}

countdownTimer();
setInterval(countdownTimer, 1000);


