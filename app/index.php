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
                    <label>Base Url</label>
                    <input type="text" name="baseurl" class="text"/>
                </div>
                <div class="entry">
                    <label>Api User</label>
                    <input type="text" name="username" class="text"/>
                </div>
                <div class="entry">
                    <label>Api Key</label>
                    <input type="password" name="key" class="text"/>
                </div>
                <div class="clear"></div>
                <div class="btn-set">
                    <div class="notice"></div>
                    <a href="#" class="btn btn-dark btn-submit ">Submit</a>
                    <div class="clear"></div>
                </div>
            </div>
            </form>
            
            <form action="./import.php" method="post" id="form-csv" enctype="multipart/form-data">
            <div class="form-holder no-border">
                <div class="entry">
                    <label>File Upload</label>
                    <input type="file" name="csv_products" class="file" />
                </div>
                <div class="clear"></div>
                <div class="btn-set">
                    <div class="notice"></div>
                    <a href="#" class="btn btn-dark btn-submit">Import</a>
                    <div class="clear"></div>
                </div>
            </div>
            </form>
        </div>
    </body>
</html>
