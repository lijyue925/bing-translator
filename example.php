<?php
/**
 * Created by PhpStorm.
 * User: LiStan
 * Date: 2015/4/19
 * Time: 下午 05:41
 */
include_once('class/BingTranslator.php');

/*可自由更換成常數宣告*/
$ID = 'ProjectName';
$KEY = 'ProjectKey';
$translator = new BingTranslator($ID, $KEY);

/*語系可以自行參考官方說明文件*/
$FROM = 'zh-CHT';
$TO = 'en';
$Raw_text = '你好';
$result = $translator->getTranslation($FROM, $TO, $Raw_text);

/*輸出=> Hello*/
echo $Raw_text;