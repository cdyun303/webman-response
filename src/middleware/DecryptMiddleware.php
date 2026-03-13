<?php
/**
 * @desc DecryptMiddleware.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/23 0:19
 */

namespace Cdyun\WebmanResponse\middleware;

use Cdyun\WebmanResponse\EncryptorEnforcer;
use Cdyun\WebmanResponse\ResponseEnforcer;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class DecryptMiddleware implements MiddlewareInterface
{

    /**
     * 中间件处理数据加密
     * @param Request $request
     * @param callable $handler
     * @return Response
     */
    public function process(Request $request, callable $handler): Response
    {
        // 获取配置并做默认值处理
        $enableEncrypt = (bool)ResponseEnforcer::getConfig('enable', false);

        // 未开启加密
        if (!$enableEncrypt) {
            return $handler($request);
        }

        // 获取加密头
        $encryptedHeader = $request->header('Cdyun-Encrypt');
        if (!$encryptedHeader) {
            ResponseEnforcer::throwError('未找到加密头');
        }

        // RSA 解密获取密钥串
        $ks = EncryptorEnforcer::rsaDecrypt($encryptedHeader);
        if (strlen($ks) != 48) {
            ResponseEnforcer::throwError('解密获取密钥串失败');
        }

        // 提取 AES 密钥32位和 IV16位
        $aesKey = substr($ks, 0, 32);
        $aesIv = substr($ks, 32, 16);

        $request->aes_key = $aesKey;
        $request->aes_iv = $aesIv;

        // 获取白名单
        $urlWhitelist = (array)ResponseEnforcer::getConfig('url', []);
        $path = $request->path();

        if (in_array($path, $urlWhitelist, true)) {
            return $handler($request);
        }

        // 处理请求参数
        $processData = function ($method) use ($request, $aesKey, $aesIv) {
            $encryptData = $request->{$method}('encrypt_data');
            if (!$encryptData) {
                ResponseEnforcer::throwError('获取加密参数失败');
            }
            $decrypted = EncryptorEnforcer::aesDecrypt($encryptData, $aesKey, $aesIv);
            $request->{"set" . ucfirst($method)}($decrypted);
        };

        if ($request->get()) {
            $processData('get');
        }

        if ($request->post()) {
            $processData('post');
        }

        return $handler($request);
    }

}