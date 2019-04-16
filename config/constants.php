<?php
return [

    'route' => [
        'admin/index'                       => '首页',

        'admin/account/index'               => '管理员列表',
        'admin/account/password'            => '修改密码页面',
        'admin/account/create'              => '添加管理员',
        'admin/account/edit'                => '编辑管理员',
        'admin/account/reset'               => '重置管理员密码',
        'admin/account/del'                 => '删除管理员',

        'admin/role/index'                  => '角色列表',
        'admin/role/create'                 => '添加角色',
        'admin/role/edit'                   => '编辑角色',
        'admin/role/set'                    => '设置权限页面',
        'admin/role/del'                    => '删除角色',

        'admin/permission/index'            => '权限列表',
        'admin/permission/clear'            => '清除权限缓存',
        'admin/permission/restore'          => '重置权限表',
        'admin/permission/edit'             => '编辑权限',
        'admin/permission/del'              => '删除权限',

        'admin/menu/index'                  => '菜单列表',
        'admin/menu/create'                 => '添加菜单',
        'admin/menu/edit'                   => '修改菜单',
        'admin/menu/del'                    => '删除菜单',

        'admin/merchant/index'              => '商户列表',
        'admin/merchant/create'             => '添加商户',
        'admin/merchant/rate'               => '设置商户费率',
        'admin/merchant/key'                => '重置商户密钥',
        'admin/merchant/password'           => '重置商户登录密码',
        'admin/merchant/security'           => '重置商户资金密码',
        'admin/merchant/del'                => '删除商户',

        'admin/payType/index'               => '支付通道',
        'admin/payType/create'              => '添加支付通道',
        'admin/payType/edit'                => '编辑支付通道',
        'admin/payType/lock/{id}/{status}'  => '开启/关闭支付通道',
        'admin/payType/del'                 => '删除支付通道',

        'admin/channel/index'               => '支付列表',
        'admin/channel/create'              => '添加支付渠道',
        'admin/channel/edit'                => '编辑支付渠道',
        'admin/channel/lock/{id}/{status}'  => '开启/关闭支付渠道',
        'admin/channel/del'                 => '删除支付渠道',

        'admin/order/index'                 => '订单列表',
        'admin/order/remedy/{id}'           => '补单操作',
        'admin/order/detail/{id}'           => '订单详情',

        'admin/bank/index'                  => '银行类别',
        'admin/bank/create'                 => '添加银行类别',
        'admin/bank/edit'                   => '编辑银行类别',
        'admin/bank/lock/{id}/{status}'     => '启用/停用银行类别',
        'admin/bank/del'                    => '删除银行类别',

        'admin/bankcard/index'              => '银行卡列表',
        'admin/bankcard/create'             => '添加银行卡',
        'admin/bankcard/edit'               => '编辑银行卡',
        'admin/bankcard/lock/{id}/{status}' => '绑定/解绑银行卡',
        'admin/bankcard/del'                => '删除银行卡',

        'admin/withdraw/index'              => '提现记录',
        'admin/withdraw/accept'             => '提现审核通过',
        'admin/withdraw/reject'             => '拒绝提现',
    ]

];