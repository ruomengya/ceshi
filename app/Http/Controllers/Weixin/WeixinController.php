<?php

namespace App\Http\Controllers\Weixin;

use GuzzleHttp;
use App\Model\WxModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class WeixinController extends Controller
{
    /**
     * 首次接入
     */
    public function validToken1()
    {
        //$get = json_encode($_GET);
        //$str = '>>>>>' . date('Y-m-d H:i:s') .' '. $get . "<<<<<\n";
        //file_put_contents('logs/weixin.log',$str,FILE_APPEND);
        echo $_GET['echostr'];
    }

    public function wxEvent()
    {
        $data = file_get_contents("php://input");
        //解析XML
        $xml = simplexml_load_string($data);        //将 xml字符串 转换成对象
        //记录日志
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<";
        file_put_contents('logs/wx_event.log',$log_str,FILE_APPEND);

        $event = $xml->Event;
        $openid = $xml->FromUserName;

        if($event == 'subscribe'){
            $sub_time = $xml->CreateTime;
            $user_info = $this -> getUserInfo($openid);
            //var_dump($user_info);exit;
            $u = WxModel::where(['openid' => $openid])->first();
            if($u){
                echo '用户已存在';
            }else{
                $xml_response = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$xml->ToUserName.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['. date('Y-m-d H:i:s') .']]></Content></xml>';
                echo $xml_response;
                $data = [
                    'openid' => $openid,
                    'add_time' => time(),
                    'nickname' => $user_info['nickname'],
                    'sex' => $user_info['sex'],
                    'headimgurl' => $user_info['headimgurl'],
                    'subscribe_time' => $user_info['subscribe_time']
                ];
                $id = WxModel::insertGetId($data);
                //var_dump($id);
            }
        }
    }

    public function delmenu(){
        $access_token = WxModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$access_token;
        echo $url;

    }

    //获取微信用户信息
    public function getUserInfo($openid){
        $access_token = WxModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $data = json_decode(file_get_contents($url) , true);
        return $data;
    }

    public function menu(){

        return view('menu.menu');
    }

    public function wx_menu(Request $request){
        $data = $request->input();
        $info = [
            'button' => $data
        ];
        $access_token = WxModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $client = new GuzzleHttp\Client();
        $a = $client->request('post',$url,[
           'body'=> json_encode($info,JSON_UNESCAPED_UNICODE)
        ]);
        $reponse = json_decode($a->getBody(),true);
        prinr_r($reponse);
    }
}
