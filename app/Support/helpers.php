<?php
if (! function_exists('multisort')) {
    /**
     * SORT_REGULAR - 默认。将每一项按常规顺序排列。
     * SORT_NUMERIC - 将每一项按数字顺序排列。
     * SORT_STRING - 将每一项按字母顺序排列。
     *
     */
    function multisort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }
}

if (! function_exists('admin_group_tag')) {
    /**
     * SORT_REGULAR - 默认。将每一项按常规顺序排列。
     * SORT_NUMERIC - 将每一项按数字顺序排列。
     * SORT_STRING - 将每一项按字母顺序排列。
     *
     */
    function admin_group_tag($key){
        $groups = ['admin'=>'管理员管理','role'=>'权限管理','menu'=>'菜单管理','user'=>'用户管理','order'=>'订单管理','video'=>'视频管理','picture'=>'图片管理','vip'=>'VIP管理','channel'=>'渠道管理','version'=>'更新管理','news'=>'新闻管理','config'=>'配置管理','pay'=>'支付管理','bank'=>'银行卡管理','advert'=>'广告管理','perm'=>'权限管理','promotion'=>'推广管理','log'=>'日志管理'];
        if(in_array($key,array_keys($groups))){
            return $groups[$key];
        }
        return null;
    }
}

if (! function_exists('Sec2Time')) {
    function Sec2Time($time){
        if(is_numeric($time)){
            $value = ["years" => 0, "days" => 0, "hours" => 0,"minutes" => 0, "seconds" => 0];

            $timeStr = '';

            if($time >= 31556926){
                $timeStr .= floor($time/31556926) . "年";
                $time = ($time%31556926);
            }

            if($time >= 86400){
                $timeStr .= floor($time/86400) . "天";
                $time = ($time%86400);
            }

            if($time >= 3600){
                $timeStr .= floor($time/3600) . "小时";
                $time = ($time%3600);
            }
            if($time >= 60){
                $timeStr .= floor($time/60) . "分";
                $time = ($time%60);
            }

            $timeStr .= floor($time) . "秒";
            return  $timeStr;
        }else{
            return "0秒";
        }
     }
}
