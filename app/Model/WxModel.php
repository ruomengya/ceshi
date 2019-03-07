<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class WxModel extends Model
{
    public $table = 'wx_user';
    public $timestamps = false;

    public static $redis_wechat_access_token = 'wechat_access_token';

    //获取access_token
    public static function getAccessToken(){
        $access_token = Redis::get(self::$redis_wechat_access_token);
        if(!$access_token){
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('APP_ID').'&secret='.env('APP_SECRET');
            $date = file_get_contents($url);
            $data = json_decode($date , true);
            $access_token = $data['access_token'];

            //存入REDIS
            Redis::set(self::$redis_wechat_access_token , $access_token);
            //过期时间
            Redis::set(self::$redis_wechat_access_token , 3600);
        }
        return $access_token;
    }
}
