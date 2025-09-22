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
        'success' => getenv('SUCCESS_CODE') ? getenv('SUCCESS_CODE') : 0,
        //  失败返回码
        'error' => getenv('ERROR_CODE') ? getenv('ERROR_CODE') : -1,
    ],
    //  是否开启加密
    'enable' => !(getenv('APP_DEBUG') == 'true'),
    //  不需要加密的url，上传URL不需要加密
    'url' => ['/web_api/core/ocr/scan', '/web_api/core/upload/direct'],
    //  RSA私钥
    'rsa_private' => '-----BEGIN RSA PRIVATE KEY-----
MIIEoQIBAAKCAQBVtvW3edfdZxiNJ4m+u7LWv8J0npBMh8xw2tXsgcQ9PcwGWpRo
m6GGKznUOCW8Cb8Ct2+zR5ocMtChxZNVwJwYo2Zip29imws++jNIApVB0+pAMJG+
LGYfwqzTylnd3J/otRpl02f6Yqy2/ljFcUDyx3cOK9889QzefynZpZiFoDotmz25
L/1PKocfqjbgZ2eky0dVaTepXaEovAymEXKbUrtObOMMFUfvbdIeQzW0n/yDdgAI
J+Mf0J7Cvnfbo3L1jTQ7EV34bzGc75P5sZH733aHQWcaBEeQdPXT6CsibY9EJYBo
1UKMzetmHvquAAuUQIKZoc8wChzwon3c/5UzAgMBAAECggEATcqiESW040zI/HrQ
ydkiA0LAIgUyozJwOlBx7JcNWiN2wqF8pb/xhYo/jrpyjMkvoTCIYOZwGH2J2fgt
spr/UGEj8A9TyOM7/qkm14j4m2jP5ffunfE/sj2FiyXQD8pHGvUagyWt7ZGWfPIz
8OXLc0vSYnswvOsOBfTVL6HZ3hOzHchIoPdQjpi/ipY1GWfQll+kIPTtduLbyjDG
gU+fNBewF5MKqVnQUWLgae2ekon9bpwtwjIMUSKhVeUQ/YBVA7guuEXfeUsqFZIK
J3CBie7xr4QL30NWZPnrU85WHN2aJr9Nm+Ai2qD/dFPCPmH2qwYuZuJ+kTLb+ykm
qgUn6QKBgQCYQCqTILj/Yv+vPx7lAaEZoa3SqTOre1qNKECvpHShapeEWNAu5lDo
UiXD4wCOTYxijQJ+n9TwnYv5BuSdUxLd12B19VAjAEqWvB0t286QJAq4WZgwmGeH
ejqrNRTbjds0pIEq2MVNpBOk0wGyUnCHmWRmCRO9rscCiNwNjIfFVwKBgQCQH7j0
jQH4rSEK2TLD+e3fLqzeVq7v2WSpJTBI8d4q3/dqHJ+VA8R2BBvDebdVk+5MZaKE
VkLDDCPDM4gducaZq9vO5aOEL0MX2xNQSNr+QGrIil8EqO3GfoNj1sZsxzFXQrlv
drQ66lIeGAFIS/qlrjxSf5E+KSF5k4MiBeoJhQKBgGmOSzY4QKqne3eHvqatS4EW
zAm6z5z7Z9tn5fkgftAOs7/JR4TMn5mCorY94vvGHieRdgJOU/cCc7ISqlu85d6y
XSlLC+VIZW4+O8i4lWzv4BLR4ycF8vlFr/lVUwGpRyonR3pqUdizgf8LYCi+6U/J
9Iadknc2/rjuJAqsvND/AoGAYcKCzK8RFUMqVJd7jd9r8KVScQZPZzYIx4sIM5KM
ZnzA8GM2A/goPP0QcAmRyCSt0XhnQmjYpEEJyRCdVbx78CTY1oCB59m/IuFhOmYQ
1cGQLTNevGRx1OBf80ruET8UQuJpsifMnOHwjaUuyYFwJQ4IsNUDCi0QHc1nd56X
X5kCgYB1/KvCMFF6wWsT/4aktyXwU9Gw15VhVWoZsSQ1z+zNh6Z396xEkt98Ralr
6uqG+TMZPSScl/xwlczB3Bl9Mtoeu7kGoEqYonXgSbRbJy5wiwqZ5WYCyGH249k5
CcT34w8KEJI47QK4oaTFso1TAtB838azcLR3NwhwYkhypZV24g==
-----END RSA PRIVATE KEY-----',
];
