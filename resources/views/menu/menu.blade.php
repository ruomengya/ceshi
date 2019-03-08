<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <form action="/form/test" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="m1">
            <input type="button" value="一级按钮" name="first_menu">
            名字：<input type="text" name="first_name">
            <input type="button" value="克隆" class="a1">
            <br><br>
            <div class="m2">
            <input type="button" value="二级按钮" name="second_menu">
            <input type="button" value="克隆" class="a2">
                <div>
                    <br>
                    按钮类型：<select name="second_select">
                        <option value ="click">click</option>
                        <option value ="view">view</option>
                    </select><br>
                    二级按钮名字：<input type="text" name="second_name"><br>
                    二级按钮URL：<input type="text" name="second_url"><br>
                    二级按钮名字key：<input type="text" name="second_key">
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<script>
    $(function(){

        $(document).on('click','.a2',function(){
            var _this=$(this);
            var div2= _this.parents('.m2');
            var two_length = _this.parents('.m1').find('.m2').length;
            if(two_length<3){
                div2.after(div2.clone());
            }
        })
        $(document).on('click','.a1',function(){
            var _this=$(this);
            var div1= _this.parents('.m1');
            if($('.m1').length<3){
                div1.after(div1.clone());
            }
        })
    })
</script>