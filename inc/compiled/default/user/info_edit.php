<?php include_once template("header");?>



    <div class="user_info">
      <form action="info_edit.php" method='post'>


        <ul >
          <li><strong class='title'>手机号：</strong><?php echo $users['name']; ?></li>



          <li><strong>用户名：</strong>
            <input id='realname' name='realname' type='text' value="<?php echo $users['realname']; ?>" class='input' onblur="check_name(this.value);">
          </li>

                <li><strong>性别：</strong>
            <input type='radio' name='sex' value='1' <?php echo $sex1; ?> >
            先生
            <input type='radio' name='sex' value='2' <?php echo $sex2; ?> >
            女士</li>





                  <li>

            <input name="button" type="submit" class="btn11" id="button" value="确 定"   />
          </li>
        </ul>

      </form>
    </div>



<script>
var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}
var realname=true;
function check_name(name){


	Sxmlhttprequest();
	xmlHttp.open('GET','../ajax/check_reg.php?type=check_realname&realname='+document.getElementById('realname').value,true);
	xmlHttp.onreadystatechange=function(){



		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;
	    if(msg.indexOf('ok')>-1){
	    	realname=true;

	    }
	    else{
realname=false;
	    	 window.wxc.xcConfirm(msg,window.wxc.xcConfirm.typeEnum.warning);
		     return false;



	    }

		}


	};
	xmlHttp.send(null);


}





</script>









<?php include_once template("footer");?>

