<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2017/6/24
 * Time: 下午6:19
 */
return array(
    'app_begin'=>array('Home\\Behaviors\\UserBehavior'),
    'view_filter' => array('Behavior\TokenBuildBehavior'),
);