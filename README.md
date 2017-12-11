# yii2-workflow

工作流程

===========
工作流程管理控件扩展

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist jingshou/yii2-workflow "*"
```

or add

```
"jingshou/yii2-workflow": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
    # 工作流程列表
    /Workflow/workflow/index
    
```

配置说明
--------

请在配置文件加入模块，以调用工作流程管理controller
```php
    ...
        'Workflow' => [
            'class' => 'anlewo\workflow\Module',
        ],
    ...
```  
请在配置文件加入组件配置，以调用工作流程管理Component
```php
    ...
     
    ...
...
``` 
请到vendor的yiisoft扩展添加映射关系
```php

'anlewo/yii2-workflow' => 
  array (
    'name' => 'jingshou/yii2-workflow',
    'version' => '1.0.0.0',
    'alias' => 
    array (
      '@anlewo/workflow' => $vendorDir . '/jingshou/yii2-workflow',
    ),
  ),

```