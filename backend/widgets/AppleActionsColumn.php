<?php

declare(strict_types=1);

namespace backend\widgets;

use yii\db\ActiveRecordInterface;
use yii\helpers\Html;

/**
 * Class AppleActionsColumn
 */
class AppleActionsColumn extends \yii\grid\ActionColumn
{
    public $template = '{hit} {bite}';

    /**
     * @return void
     */
    protected function initDefaultButtons()
    {
        $this->buttons['hit']  = $this->initTextButton(
            'Hit(force to fall)',
            ['class' => 'btn-xs btn-success']
        );
        $this->buttons['bite'] = $this->initTextButton(
            'Bite',
            ['class' => 'btn-xs btn-primary bite-apple-button']
        );

        $this->grid->view->registerJs($this->biteScript());
    }

    /**
     * @param string $text
     * @param string $action
     * @param array $additionalOptions
     * @return callable
     */
    protected function initTextButton(string $text, array $additionalOptions = []): callable
    {
        return function ($url, ActiveRecordInterface $model, $key) use ($text, $additionalOptions) {
            $options = array_merge([
                'title'        => $text,
                'aria-label'   => $text,
                'data-pjax'    => '0',
                'data-modelid' => $model->getPrimaryKey(),
            ], $additionalOptions, $this->buttonOptions);

            return Html::a($text, $url, $options);
        };
    }

    /**
     * //todo Better to store in another place or make widget for only "bite" button
     * @return string
     */
    protected function biteScript(): string
    {
        return "$(document).on('click', '.bite-apple-button', function() {
            console.log($(this).data('modelid'));
            let percentage = parseInt(prompt('How much do you wanna bite(1-100)?'), 10);
            
            if (!percentage && percentage < 100) {
                alert('Invalid value');
            } else {
                document.location = `\${\$(this).attr('href')}&percentage=\${percentage}`;     
            }
            return false;
        })";
    }
}