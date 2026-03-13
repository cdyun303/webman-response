<?php
/**
 * @desc EncryptorEnforcer.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/22 22:31
 */

declare(strict_types=1);

namespace Cdyun\WebmanResponse;

use support\Log;

class EncryptorEnforcer
{
    /**
     * @param string|null $data
     * @return string
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     * @desc RSA解密
     */
    public static function rsaDecrypt(?string $data): string
    {
        try {
            if (!$data) {
                throw new \Exception('解密数据不能为空');
            }

            $privateKeyContent = self::getConfig('rsa_private');
            if (!$privateKeyContent) {
                throw new \Exception('未设置解密私钥');
            }

            $privateKey = openssl_pkey_get_private($privateKeyContent);
            if (!$privateKey) {
                throw new \Exception('密钥错误~');
            }

            // 启用 strict 模式防止非法 base64 输入
            $decodedData = base64_decode($data, true);
            if ($decodedData === false) {
                throw new \Exception('无效的 base64 数据');
            }

            $returnDecrypted = openssl_private_decrypt($decodedData, $decrypted, $privateKey);

            if (!$returnDecrypted || !is_string($decrypted)) {
                throw new \Exception('RSA解密失败，请检查密钥~');
            }

            return $decrypted;
        } catch (\Exception $e) {
            Log::error("RSA解密失败:", [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // 避免暴露具体错误信息
            throw new \Exception('RSA解密失败');
        }
    }

    /**
     * @param string|null $name - 名称
     * @param $default - 默认值
     * @return mixed
     * @author cdyun(121625706@qq.com)
     * @desc 获取配置config
     */
    public static function getConfig(?string $name = null, $default = null): mixed
    {
        if (!is_null($name)) {
            return config('plugin.cdyun.webman-response.response.' . $name, $default);
        }
        return config('plugin.cdyun.webman-response.response');
    }

    /**
     * @param string|null $data
     * @param string $key - AES密钥
     * @param string $iv - AES IV
     * @return array
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     * @desc AES解密
     */
    public static function aesDecrypt(?string $data, string $key, string $iv): array
    {
        try {
            if (!$data) {
                throw new \Exception('解密的数据不能为空');
            }

            // 校验 key 和 iv 长度
            if (strlen($key) !== 32) {
                throw new \Exception('AES密钥长度必须为32字节');
            }
            if (strlen($iv) !== 16) {
                throw new \Exception('AES IV长度必须为16字节');
            }

            $decodedData = base64_decode($data);
            if ($decodedData === false) {
                throw new \Exception('Base64解码失败');
            }

            $decrypted = openssl_decrypt($decodedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            if ($decrypted === false) {
                throw new \Exception('AES解密失败');
            }

            $result = json_decode($decrypted, true);
            if (!is_array($result)) {
                throw new \Exception('解密后的数据不是合法的JSON对象');
            }

            return $result;
        } catch (\Exception $e) {
            Log::error("AES解密失败:", [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // 避免暴露具体错误信息
            throw new \Exception('AES解密失败');
        }
    }

    /**
     * @param $data
     * @param string $key - AES密钥
     * @param string $iv - AES IV
     * @return string
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     * @desc AES加密
     */
    public static function aesEncrypt($data, string $key, string $iv): string
    {
        try {
            // 校验密钥长度
            if (strlen($key) !== 32) {
                throw new \Exception('密钥长度必须为32字节');
            }
            // 校验IV长度
            if (strlen($iv) !== 16) {
                throw new \Exception('IV长度必须为16字节');
            }
            // JSON序列化
            $jsonData = json_encode($data);
            if ($jsonData === false) {
                throw new \Exception('json_encode失败');
            }
            // 加密
            $encrypted = openssl_encrypt($jsonData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            if ($encrypted === false) {
                throw new \Exception('openssl_encrypt失败');
            }

            return base64_encode($encrypted);
        } catch (\Exception $e) {
            Log::error("AES加密失败:", [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // 避免暴露具体错误信息
            throw new \Exception('AES加密失败');
        }
    }

}