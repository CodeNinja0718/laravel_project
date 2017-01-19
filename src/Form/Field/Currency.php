<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class Currency extends Field
{
    /**
     * digits.
     *
     * @var int
     */
    protected $digits = 2;

    protected $symbol = '$';

    protected static $js = [
        '/packages/admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'radixPoint'            => '.',
        'prefix'                => '',
        'removeMaskOnSubmit'    => true,
    ];

    public function digits($number)
    {
        $this->digits = (int) $number;
        return $this;
    }

    public function symbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function prepare($value)
    {
        return (float) $value;
    }

    public function render()
    {
        $options = json_encode($this->options);

        $this->script = <<<EOT

$('.{$this->getElementClass()}').inputmask("currency", $options);

EOT;

        return parent::render()->with(['symbol' => $this->symbol]);
    }
}
