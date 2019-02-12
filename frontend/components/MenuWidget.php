<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 24.07.2018
 * Time: 14:13
 */
namespace frontend\components;
use Yii;
use common\models\Categories;

class MenuWidget extends \yii\base\Widget
{

    public $tpl;
    public $param;
    public $tree;
    public $menuHtml;
    public $model;

    public function init(){
        parent::init();
        if( $this->tpl === null ){
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run(){
        if($this->tpl == 'menu.php') {
             $menu = Yii::$app->cache->get('menu');
             if($menu) return $menu;
        }
        $this->tree = Categories::find()->asArray()->all();
        $this->menuHtml = $this->catToTemplate($this->tree);
        Yii::$app->cache->set('menu', $this->menuHtml, 60 * 60);
        return $this->menuHtml;
    }

    protected function catToTemplate($model)
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}