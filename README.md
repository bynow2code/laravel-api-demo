## Introduction
laravel 10.x API demo

## Behavior
- [x] 封装 Api json 返回格式
- [x] 异常统一处理
- [x] 加入全局 trace id
- [x] 调试模式，返回更多有用的信息
- [x] 请求过程数据记录并分表储存示例：http path,http method,request body,response data.

## Start
````
git clone ...
cd ./laravel-test
./vendor/bin/sail up
````
## Thank you
如果有更优雅的实现，可以给我指条路吗？

### Yii 框架内的一种实现
````
config/web.php
'components' => [
    'response' => [
        'class' => 'yii\web\Response',
        'format' => yii\web\Response::FORMAT_JSON,
        'on beforeSend' => function ($event) {
            /**
             * @var $response \yii\web\Response
             */
            $response = $event->sender;
            if ($response->data !== null) {
                $response->data = [
                    'errorCode' => (string)$response->exitStatus,
                    'errorInfo' => $response->statusText,
                    'data' => $response->data,
                ];
                $response->statusCode = 200;
            }
        },
    ],
  ],


modules/api/controllers/TestController.php
public function actionTest()
{
    return ['token' => '1234567'];
}

````
