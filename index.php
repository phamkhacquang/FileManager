<html>
    <head>
        <title>File Manager</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="lib/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="lib/bootstrap.min.js" type="text/javascript"></script>
        <script src="lib/jquery.min.js" type="text/javascript"></script>
        <script src="script.js" type="text/javascript"></script>
        <link href="style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="file_drop_target">
                        Thả file và đây để upload
                        <b>Hoặc</b>
                        <input type="file" multiple />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div id="breadcrumb"></div>
                </div>
                <div class="col-sm-6">
                    <form action="?" method="post" id="mkdir" />
                    <div class="input-group">                   
                        <input type=text name=name value="" class="form-control" placeholder="Tên tệp mới"/>                        
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span>Tạo</span>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>                
            </div>
            <div id="upload_progress"></div>
            <table id="table" class="table-fill" >
                <thead>
                    <tr>
                        <th class="text-left">Tên</th>
                        <th class="text-left">Kích cỡ</th>
                        <th class="text-left">Lần thay đổi cuối</th>
                        <th class="text-left">Quyền</th>
                        <th class="text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody id="list" class="table-hover"></tbody>
            </table>
        </div>
    </body>
</html>