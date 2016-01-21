<?php

namespace Encore\Admin;

use Closure;
use Encore\Admin\Facades\Auth;
use InvalidArgumentException;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Admin
{
    public static $css = [];

    public static $js = [];

    public static $script = [];

    /**
     * @param $model
     * @param callable $callable
     * @return Grid
     */
    public function grid($model, Closure $callable)
    {
        return new Grid($this->getModel($model), $callable);
    }

    /**
     * @param $model
     * @param callable $callable
     * @return Form
     */
    public function form($model, Closure $callable)
    {
        return new Form($this->getModel($model), $callable);
    }

    /**
     * @param $model
     * @param callable $callable
     * @return Chart
     */
    public function chart(Closure $callable)
    {
        return new Chart($callable);
    }

    /**
     * @param $model
     * @return mixed
     */
    public function getModel($model)
    {
        if($model instanceof EloquentModel) {
            return $model;
        }

        if(is_string($model) && class_exists($model)) {
            return $this->getModel(new $model);
        }

        throw new InvalidArgumentException("$model is not a valid model");
    }

    /**
     * Get namespace of controllers.
     *
     * @return string
     */
    public function controllerNamespace()
    {
        $directory = config('admin.directory');

        return 'App\\' . ucfirst(basename($directory)) . '\\Controllers';
    }

    /**
     * @param string $css
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function css($css = '')
    {
        if(! empty($css)) {
            self::$css = array_merge(self::$css, (array) $css);

            return ;
        }

        return view('admin::partials.css', ['css' => array_unique(self::$css)]);
    }

    /**
     * @param string $js
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function js($js = '')
    {
        if( ! empty($js)) {
            self::$js = array_merge(self::$js, (array) $js);

            return;
        }

        return view('admin::partials.js', ['js' => array_unique(self::$js)]);
    }

    /**
     * @param string $script
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function script($script = '')
    {
        if( ! empty($script)) {
            self::$script = array_merge(self::$script, (array) $script);

            return;
        }

        return view('admin::partials.script', ['script' => array_unique(self::$script)]);
    }

    public static function url($url)
    {
        $prefix = app('router')->current()->getPrefix();

        return "/$prefix/" . trim($url, '/');
    }

    public function menu()
    {
        if(Config::has('admin.menu')) {
            return Config::get('admin.menu');
        }
    }

    /**
     * Get admin title.
     *
     * @return Config
     */
    public function title()
    {
        return config('admin.title');
    }

    public function user()
    {
        return Auth::user();
    }
}