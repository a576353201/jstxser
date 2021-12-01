var ws='';
var ws_open=0;
var is_joinroom=0;
var Groupid=0;
var join_times=0;
var join_timer='';
var time11=null;
function ws_join() {
    ws= new WebSocket(websocketUrl);


    ws.onopen=function(e){
        console.log("websocket已连接"+userid);
      if(userid>0)  ws_send(userid,'bind','绑定uid');
       ws_open=1;
        clearInterval(time11);
      time11=setInterval(function () {
          var data={type:'ping'};
          send_data(JSON.stringify(data));
          
       if(Groupid!='admin')   online_time(userid);
      },20000)
        join_times=0; clearInterval(join_timer);


    }


    ws.onmessage=function (e) {
        sockect_message(e.data);

    }
    ws.onclose=function (e) {
        ws_open=0;
        console.log("websock服务器已经断");
        clearInterval(join_timer);
        clearInterval(time11);
        join_timer=  setInterval(function () {
            join_times++;
            if(join_times<20){
                try {
                    join_room(roomid);
                }catch(e) {
                    ws_join();
                }

            }
            else{
                clearInterval(join_timer);
            }
        },3000)

    }
}

function ws_send(uid,type,message) {
    var message='{"type":"'+type+'","uid":"'+uid+'","message":"'+message+'"}';
    ws.send(message);
}


function join_room(roomid) {
    Groupid=roomid;

    if(ws_open==0)ws_join();
    else{

        var message='{"type":"joinGroup","uid":"'+userid+'","GroupId":"'+roomid+'","message":"加入房间+'+roomid+'"}';
      //  console.log(message);
        ws.send(message);
        if(join_times>0)  parent.message_close();
        join_times=0; clearInterval(join_timer);
    }
}

function online_time(uid) {
    console.log(uid);
    $.post("../api/user.php?act=online",{userid:uid}, function(result){

        var res=JSON.parse(result);
        if(res.data=='ok'){

        }else{
           if(res.data=='logout'){
               $.get("/user/quit.php",{}, function(result){

                   userid=0;
                   layer.msg(res.message,{ type: 1, anim: 2 ,time:2000});
                   setTimeout(function () {
                       location.reload();
                   },1800)

               });
           }
        }

    });
}


function send_data(data) {
// console.log(data);
    ws.send(data);
}
