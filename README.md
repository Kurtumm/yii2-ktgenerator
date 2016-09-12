# yii2-ktgenerator

- clone to vendor/yiisoft
- add this to `vendor/yiisoft/extensions.php`

```
...

return array(
...

    'yiisoft/yii2-ktgenerator' =>
        array(
            'name' => 'yiisoft/yii2-ktgenerator',
            'version' => '0.01',
            'alias' =>
                array(
                    '@yii/ktgenerator' => $vendorDir . '/yiisoft/yii2-ktgenerator',
                ),
        ),
);
```

- add this to config

```
'modules' => [
    'ktgenerator' => [
        'class' => 'yii\ktgenerator\KTGenerator',
    ],
],
```
