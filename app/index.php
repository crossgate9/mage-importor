<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Mage Import</title>
        <link href="./css/reset.css" media="all" rel="stylesheet">
        <link href="./css/main.css" media="all" rel="stylesheet">
        <link href="./css/jquery.fancybox.css" media="all" rel="stylesheet">
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="./js/main.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="header up"><h1>Mage Import</h1></div>

            <form id="form-config" action="./save_config.php" method="post">
            <div class="form-holder">
                <div class="entry">
                    <label>BaseUrl</label>
                    <input type="text" name="baseurl" class="text"/>
                </div>
                <div class="entry">
                    <label>ApiUser</label>
                    <input type="text" name="username" class="text"/>
                </div>
                <div class="entry">
                    <label>Api Key</label>
                    <input type="password" name="key" class="text"/>
                </div>
                <div class="clear"></div>
                <div class="btn-set">
                    <a href="#" class="btn btn-dark btn-submit up">Submit</a>
                    <div class="notice"></div>
                </div>
            </div>
            </form>
            
            <form action="import.php" method="post" id="file" enctype="multipart/form-data">
            <div class="form-holder no-border">
                <div class="entry">
                    <label>File Upload</label>
                    <input type="file" name="csv_products" class="file" />
                </div>
                <div class="clear"></div>
                <div class="btn-set">
                    <a href="#" class="btn btn-dark btn-submit up">Import</a>
                    <div class="notice"></div>
                </div>
            </div>
            </form>
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