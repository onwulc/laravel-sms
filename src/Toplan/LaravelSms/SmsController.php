<?php

namespace Toplan\Sms;

use Illuminate\Routing\Controller;
use SmsManager as Manager;

class SmsController extends Controller
{
    public function postVoiceVerify()
    {
        $res = Manager::validateSendable();
        if (!$res['success']) {
            return response()->json($res);
        }

        $res = Manager::validateFields();
        if (!$res['success']) {
            return response()->json($res);
        }

        $res = Manager::requestVoiceVerify();

        return response()->json($res);
    }

    public function postSendCode()
    {
        $res = Manager::validateSendable();
        if (!$res['success']) {
            return response()->json($res);
        }

        $res = Manager::validateFields();
        if (!$res['success']) {
            return response()->json($res);
        }

        $res = Manager::requestVerifySms();

        return response()->json($res);
    }

    public function getInfo()
    {
        $html = '<meta charset="UTF-8"/><h2 align="center" style="margin-top: 30px;margin-bottom: 0;">发送信息</h2>';
        $html .= '<p>你可以在调试模式(设置config/app.php中的debug为true)下查看到存储在存储器中的验证码短信/语音相关数据:</p>';
        echo $html;
        if (config('app.debug')) {
            dump(Manager::retrieveAllData());
        } else {
            echo '<p align="center" style="color: red;">现在是非调试模式，无法查看调试数据</p>';
        }
    }
}
