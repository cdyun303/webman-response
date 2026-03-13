# Webman Response插件

> 提供响应处理功能

## 安装

```bash
composer require cdyun/webman-response
```

## 使用示例

### 常规用法
```php
use Cdyun\WebmanResponse\Response;

//获取配置
ResponseEnforcer::getConfig($name = null, $default = null);

//成功
ResponseEnforcer::success($msg = '操作成功', $data = null);

//失败
ResponseEnforcer::error($msg = '操作失败', $data = null);

//异常
ResponseEnforcer::abort($msg = '服务器内部错误', $code = null);

//分页
ResponseEnforcer::paginate( $data = [], $totalCount = 0, $msg = '加载完成');

//结果
ResponseEnforcer::result($result, $is_encrypt = false);
```

### 加密/解密
```php
use Cdyun\WebmanResponse\EncryptorEnforcer;

//获取配置
ResponseEnforcer::getConfig($name = null, $default = null);

//RSA解密
EncryptorEnforcer::rsaDecrypt($data);

//AES解密
EncryptorEnforcer::aesDecrypt($data, $key, $iv);

//AES加密
EncryptorEnforcer::aesEncrypt($data, $key, $iv);
```

### 中间件-加密/解密
```php
use Cdyun\WebmanResponse\middleware\DecryptMiddleware;
```

## 相关链接

- [Packagist 仓库](https://packagist.org/packages/cdyun/webman-response)
- [GitHub 仓库](https://github.com/cdyun303/webman-response)
- [问题反馈](https://github.com/cdyun303/webman-response/issues)

# 版本要求

- php: >=8.1

# 许可证

MIT License