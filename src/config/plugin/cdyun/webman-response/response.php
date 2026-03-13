<?php
/**
 * @desc response.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/22 22:38
 */

return [
    //  返回码
    'code' => [
        //  成功返回码
        'success' => 0,
        //  失败返回码
        'error' => -1,
    ],
    //  异常处理驱动
    'exception'=>'',
    //  是否开启加密
    'enable' => false,
    //  不需要加密的url，上传URL不需要加密
    'url' => ['/web_api/core/ocr/scan', '/web_api/core/upload/direct'],
    //  RSA私钥,推荐 2048 位
    'rsa_private' => '',
    //  RSA公钥
    'rsa_public' => '',
];
