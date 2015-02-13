<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Mage Import</title>
        <style type="text/css">
            body{background-color:#2B2B2B; }
            .container{height:500px;width:600px;margin:10% auto;color:#314E58;font-size:25px;font-weight:bold;background-color:#EFF5EA;font-family:微软雅黑,Verdana,Arial;}
            .header{width:100%;height:20%;background-color:#314E58;}
            .header span{color:white;margin-left:10px;font-size: 55px; }
            .form1{width:100%;margin:10px auto;border-bottom: 1px solid #CCCCCC;}
            .form2{margin-top:25px;}
            #saveConfig>div{margin:10px;}
            #file>div{margin:10px;}
            .input{border:1px solid #314E58;height: 25px;margin-left: 10px;}
            .submit{margin-left:65%;font-weight: bold;color: white;background-color:#314E58;font-size:25px; }
            .notice,.csv_notice{font-weight:normal;font-family: arial,Verdana;font-size: 20px;}
            .file{font-size: 20px;margin-left: 5px;}
        </style>
        <script type="text/javascript" src="jquery-2.1.3.min.js"></script>
        <script type="text/javascript">
          $(function(){
            $("#saveConfig").submit(function(){return false;});//禁用form提交
            $("#saveConfig input[type='submit']").click(function(){
              var url=$('#saveConfig').attr('action');//获取表单中action
              var param={};//组装发送参数
              param['baseurl']=$("#saveConfig input[name='baseurl']").val();
              param['username']=$("#saveConfig input[name='username']").val();
              param['key']=$("#saveConfig input[name='key']").val();
                $.post(url,param,function(msg){//用post方式提交
                  if(msg=="Save Success."){$(".notice").css({color:"green"});} else {$(".notice").css({color:"red"});}
                  $(".notice").html(msg);//显示提示语
                });
            });
          });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="header"><span>Mage Import</span></div>
            <div class="form1">
                <form action="save_config.php" method="post" id="saveConfig">
                  <div><label>BaseUrl</label>&nbsp;<input type="text" name="baseurl" size="50" class="input"/></div>
                  <div><label>ApiUser</label>&nbsp;<input type="text" name="username" size="30" class="input"/></div>
                  <div><label>Api Key</label>&nbsp;<input type="password" name="key" size="30" class="input"/></div>
                  <div><input type="submit" value="Save Config" class="submit"/><div class="notice"></div></div>
                </form>
            </div>
            <div class="form2">
                <form action="import.php" method="post" id="file" enctype="multipart/form-data">
                  <div><label>File Upload</label>&nbsp;<input type="file" name="csv_products" class="file" /></div>
                  <div><input type="submit" value="Run Import" class="submit"/><div class="csv_notice"></div></div>
                </form>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $("#file").submit(function(){
        var msg = $(".notice").text();
        if(msg!="Save Success."){
            $(".csv_notice").css("color","red");
            $(".csv_notice").html("Config information cannot be empty.");
            return false;
        }
    });
</script>