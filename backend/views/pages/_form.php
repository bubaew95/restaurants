<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="pages-form">

            <?php $form = ActiveForm::begin(); ?>

                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'text')->widget(CKEditor::className(),[
                            'editorOptions' => [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                            ],
                        ])->textarea(['class' => 'page-text']); ?>

                        <a id="open-page" data-id="<?= !$model->isNewRecord ? $model->id : 0?>" class="btn btn-default btn-sm"><i class="fa fa-clipboard"></i> Страницы</a>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'tr_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'created_at')->textInput() ?>

                        <?= $form->field($model, 'updated_at')->textInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success pull-right']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php

$url = \yii\helpers\Url::to(['pages/json-index']);

$js = <<<JS
 
    var Properties = {
        Btn: {
            OpenPageBtn: $('#open-page'),
        },
        Modal: {
            ModalAction:   $('#modalwindow'),
            ModalHeader:   $('.modal-header > h2'),
            ModalDialog:   $('.modal-dialog '),
            ModalBody:     $('.modal-body')
        },
        Textarea: {
            TxtContainer: $('#pages-text')
        }
    };
    
    var Action = {
        OpenWindowBtnAction: function () {
            Properties.Btn.OpenPageBtn.on('click', function () {
                Properties.Modal.ModalHeader.text('Страницы');
                Properties.Modal.ModalAction.modal('show');
                var id = $(this).data('id');
                Action.LoadPage(id);
            });
        },
        LoadPage: function (id) {
            $.get({
                url: '$url',
                data: {id: id},
                success: function(data) {
                    if(data.length > 0) WorkDom.AppendText(data);
                }
            });
        },
        ItemPageAction: function () {
            $(document).on('click', '.item-page', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var text = $(this).data('name');
                var link = '<a href="'+url+'">'+text+'</a>';
                var oEditor = CKEDITOR.instances['pages-text'];
                var newElement = CKEDITOR.dom.element.createFromHtml( link, oEditor.document );
                oEditor.insertElement( newElement );
                Properties.Modal.ModalAction.modal('hide');
            });
        },
        Init: function () {
            this.OpenWindowBtnAction();
            this.ItemPageAction();
        }
    };
    
    var WorkDom = {
        AppendText: function (data) {
            Properties.Modal.ModalBody.empty().append(data);
        },
    };
    Action.Init();

JS;

$this->registerJs($js);
?>