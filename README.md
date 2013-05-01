fuel-g2verify
=============

Google Two-step verification Package for Fuel.

## About

Version: 1.0.0  
License: MIT License  
Author: [Yusuke NAKA](http://www.think-sv.net/blog/)  
Original URL: [https://github.com/Y-NAKA/fuel-g2verify](https://github.com/Y-NAKA/fuel-g2verify)  

## Installation

### Add repository url to package.php for oil command.

COREPATH/config/package.php
```php
return array(
    'sources' => array(
        'github.com/fuel-g2verify',
    ),
);
```

### Using Oil command.

	$ oil package install g2verify

## Configuration

### The easiest way to change configuration.

config/g2verify.php
```php
return array(

    'initial_key' => '',
    'product_name' => 'You will make service name',

);
```
NOTE: if you will be add initial_key, you will be overwrite $secret param on each methods.

## Usage

### G2verify::getSecret()

Get the Secret key at Base32 string.  
This key will be used other methods.  
Save secret key the database for each user.  

```php
$secret = G2verify::getSecret();
```

### G2verify::getQRcodeurl($username,$secret = null)

Generate QR code for [Google Authenticator](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2).  
$username will be used in [Google Authenticator](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2) for identify.  
Use the Google Chart API to generate a QR Code.  

```php
$secret = 'ABCDEFGHIJKLNMOP'; //each user different.
$qrcodeurl = G2verify::getQRcodeurl('username',$secret);

//View QR code
echo("<iframe src=$qrcodeurl height=200 width=200></iframe>");
```

### G2verify::verify($key,$secret = null)

Check the validity of one-time password after user authentication is successful.

```php
$inputkey = '123456'; //user input data.
$secret = 'ABCDEFGHIJKLNMOP'; //each user different.
$result = G2verify::verify($inputkey,$secret);

if($result){
  echo('OK');
}else{
  echo('NG');
}
```

### G2verify::getOTP($key,$secret = null)

Get a one-time password.

```php
$secret = 'ABCDEFGHIJKLNMOP';
$otp = G2verify::getOTP($secret);
```

## Licence

The MIT License

Copyright (c) 2013 Yusuke NAKA

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

以下に定める条件に従い、本ソフトウェアおよび関連文書のファイル（以下「ソフトウェア」）の複製を取得するすべての人に対し、ソフトウェアを無制限に扱うことを無償で許可します。これには、ソフトウェアの複製を使用、複写、変更、結合、掲載、頒布、サブライセンス、および/または販売する権利、およびソフトウェアを提供する相手に同じことを許可する権利も無制限に含まれます。

上記の著作権表示および本許諾表示を、ソフトウェアのすべての複製または重要な部分に記載するものとします。

ソフトウェアは「現状のまま」で、明示であるか暗黙であるかを問わず、何らの保証もなく提供されます。ここでいう保証とは、商品性、特定の目的への適合性、および権利非侵害についての保証も含みますが、それに限定されるものではありません。 作者または著作権者は、契約行為、不法行為、またはそれ以外であろうと、ソフトウェアに起因または関連し、あるいはソフトウェアの使用またはその他の扱いによって生じる一切の請求、損害、その他の義務について何らの責任も負わないものとします。


## Special Thanks

I use PHP-Base32 library for base32 decode.

### PHP-Base32
https://github.com/NTICompass/PHP-Base32
* Author : Christian Riesen <chris.riesen@gmail.com>
* Link : http://christianriesen.com
* License : MIT License see LICENSE file
