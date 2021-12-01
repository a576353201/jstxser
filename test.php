<html>
<body>

<canvas id="myCanvas"></canvas>


<input type="file" name="" value="" id="musicFile">

<script>


    const myCanvas = document.getElementById('myCanvas');
    const canvasCtx = myCanvas.getContext('2d')
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    const audioContext = new AudioContext();
    const that = this;
    var analyser=null;
    var bufferLength=null;
    var dataArray=null;
    var  width =500;
    var  height = 300;
    const upload = document.querySelector('#musicFile');
    upload.addEventListener('change', function() {
        var file = upload.files[0];//通过input上传的音频文件
        var fileReader = new FileReader();//使用FileReader异步读取文件
        fileReader.readAsArrayBuffer(file);//开始读取音频文件
        fileReader.onload = function (e) { //读取文件完成的回调
            var  audioData = e.target.result // 即为读取的音频文件（此文件为二进制文件arraybuffer）
            //下面就是解码操作 buffer节点
            make(audioData);
        }
    })
       // 二种是获取线上音频xhr请求
        function request(url) { //url 线上音频地址
            const request = new XMLHttpRequest();
            request.open('GET', url, true);
            request.responseType = 'arraybuffer';
            request.onload = function () {
                const audioData = request.response; // 请求回来的arraybuffer的音频文件
                //下面就是解码操作 buffer节点
            }
            request.send();
        }

    function make(audioData) {

        //AudioContext接口的decodeAudioData()方法可用于异步解码音频文件中的 ArrayBuffer
        audioContext.decodeAudioData(audioData, function (buffer) {
            //创建AudioBufferSourceNode 用于播放解码出来的buffer的节点
            var  audioBufferSourceNode = audioContext.createBufferSource(); //  一个 AudioBufferSourceNode 只能被播放一次,可以把这个创建单独拉出去，播放结束之后想要再次播放就再次创建一次
            //连接节点,audioContext.destination是音频要最终输出的目标，
            // 我们可以把它理解为声卡。所以所有节点中的最后一个节点应该再
            // 连接到audioContext.destination才能听到声音。
            audioBufferSourceNode.connect(audioContext.destination)
            audioBufferSourceNode.buffer = buffer // 解码出来的buffer节点 ，回调函数传入的参数
            audioBufferSourceNode.start() //音频播放
            // 如果想要控制音频的暂停与播放 可使用audioContext.resume 和 suspend 方法
            // resume 重新启动一个已被暂停的音频环境
            //suspend 暂停音频内容的进度.暂时停止音频硬件访问和减少在过程中的CPU/电池使用。

            // 下面就是实现音频可视化 音波的展现
            // 从音频源中提取数据,创建AnalyserNode
             analyser = audioContext.createAnalyser()
            //fftSize (Fast Fourier Transform) 是快速傅里叶变换，一般情况下是固定值2048。可以决定音频频谱的密集程度。值大了，频谱就松散，值小就密集。
            analyser.fftSize = 2048

            //连接到音频源
            audioBufferSourceNode.connect(analyser);
            analyser.connect(audioContext.destination);
            //下面就开始绘制音波
            bufferLength = analyser.frequencyBinCount // 返回的是 analyser的fftsize的一半
            dataArray = new Uint8Array(bufferLength);
          console.log(dataArray);
            myCanvas.setAttribute('width', width);
            myCanvas.setAttribute('height', height);
          draw();
        });


    }


    function draw() {
        canvasCtx.clearRect(0, 0, width, height); //清除画布
        analyser.getByteFrequencyData(dataArray); // 将当前频率数据复制到传入其中的Uint8Array
        const requestAnimFrame = window.requestAnimationFrame(draw) || window.webkitRequestAnimationFrame(draw);

        canvasCtx.fillStyle = '#000130';
        canvasCtx.fillRect(0, 0, width, height);
        var  barWidth = (width * 1 / bufferLength) * 2;
        var  barHeight;
        var  x = 0;
        for (var  i = 0; i < bufferLength; i++) {
          barHeight = dataArray[i];
           ////console.log(barHeight);
            canvasCtx.fillStyle = 'rgb(0, 255, 30)';
            canvasCtx.fillRect(x, height / 2 - barHeight / 2, barWidth, barHeight);
            x += barWidth + 1;
        }
    }


</script>
</body>


</html>