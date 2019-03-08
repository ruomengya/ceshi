<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>

        <div class="m1">
            <p>
                <input type="button" value="一级按钮" class="first_menu">
                名字：<input type="text" class="first_name">
                <input type="button" value="克隆" class="a1">
            </p>

            <br><br>
            <div class="m2">
            <input type="button" value="二级按钮" class="second_menu">
            <input type="button" value="克隆" class="a2">
                <div>
                    <br>
                    按钮类型：<select class="second_select">
                        <option value ="click">CLICK</option>
                        <option value ="view">VIEW</option>
                    </select><br>
                    二级按钮名字：<input type="text" class="second_name"><br>
                    二级按钮URL：<input type="text" class="second_url"><br>
                    二级按钮名字key：<input type="text" class="second_key">
                </div>
            </div>
        </div>
        <div>
            <button id="sub_btn">发布菜单</button>
        </div>
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

        $('#sub_btn').click(function(){
            first_info={};
            $('.m1').each(function(i){
                info = {};
                info['name']=$(this).find('p').find('.first_name').val();
                data = {}
                $(this).find('.m2').each(function(g){
                    two_data = {}
                    two_data['type'] = $(this).find('div').find('.second_select').val();
                    two_data['name'] = $(this).find('.second_name').val();
                    if($(this).find('div').find('.second_select').val() == 'view'){
                        two_data['url'] = $(this).find('.second_url').val();
                    }else{
                        two_data['key'] = $(this).find('.second_key').val();
                    }
                    data[g] = two_data;
                });
                info['sub_button']=data;
                first_info[i] = info;
                console.log(info)
            })
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/wx_menu',
                type: 'post',
                data: first_info,
                dataType:"json",
                success:  function(msg){
                    if(msg.error == 0){
                        alert('发布成功')
                    }
                }

            })
        })
    })
</script>