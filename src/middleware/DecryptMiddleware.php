<?php
/**
 * @desc DecryptMiddleware.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/23 0:19
 */

namespace Cdyun\WebmanResponse\middleware;

use Cdyun\WebmanResponse\EncryptorEnforcer;
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
     * @throws \Exception
     */
    public function process(Request $request, callable $handler): Response
    {
        // 获取配置并做默认值处理
        $enableEncrypt = (bool)EncryptorEnforcer::getConfig('enable', false);

        // 未开启加密
        if (!$enableEncrypt) {
            return $handler($request);
        }

        // 获取加密头
        $encryptedHeader = $request->header('Cdyun-Encrypt');
        if (!$encryptedHeader) {
            $this->throwError('未找到加密头');
        }

        // RSA 解密获取密钥串
        $ks = EncryptorEnforcer::rsaDecrypt($encryptedHeader);
        if (strlen($ks) != 48) {
            $this->throwError('解密获取密钥串失败');
        }

        // 提取 AES 密钥32位和 IV16位
        $aesKey = substr($ks, 0, 32);
        $aesIv = substr($ks, 32, 16);

        $request->aes_key = $aesKey;
        $request->aes_iv = $aesIv;

        // 获取白名单
        $urlWhitelist = (array)EncryptorEnforcer::getConfig('url', []);
        $path = $request->path();

        if (in_array($path, $urlWhitelist, true)) {
            return $handler($request);
        }

        // 处理请求参数
        $processData = function ($method) use ($request, $aesKey, $aesIv) {
            $encryptData = $request->{$method}('encrypt_data');
            if (!$encryptData) {
                $this->throwError('获取加密参数失败');
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

    /**
     * @param $msg
     * @param $code
     * @return mixed
     * @throws \InvalidArgumentException
     * @author cdyun(121625706@qq.com)
     * @desc 抛出错误信息
     */
    public function throwError($msg, $code = null): mixed
    {
        $exception = EncryptorEnforcer::getConfig('exception');
        if (empty($exception)) {
            throw new \InvalidArgumentException('config配置文件中，未找到异常处理驱动');
        }
        throw new $exception($msg, $code);

    }

}