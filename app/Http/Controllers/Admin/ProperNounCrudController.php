<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProperNounRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProperNounCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProperNounCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ProperNoun::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/proper-noun');
        CRUD::setEntityNameStrings('proper noun', 'proper nouns');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.

        CRUD::addColumn([
            'name'  => 'url',
            'label' => '首見網址',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::addColumn([
            'name'  => 'unknown_noun',
            'label' => '需翻譯字彙',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::addColumn([
            'name'  => 'translated_noun',
            'label' => '字彙翻譯',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::addColumn([
            'name'  => 'pass',
            'label' => '跳過不取代',
            'type'  => 'boolean', // 欄位類型
        ]);

        CRUD::setOperationSetting('pageLength', 25);
        CRUD::setOperationSetting('lengthMenu', [[10, 25, 50], [10, 25, 50]]);
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProperNounRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name'  => 'url',
            'label' => '首見網址',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::addField([
            'name'  => 'unknown_noun',
            'label' => '需翻譯字彙',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::addField([
            'name'  => 'translated_noun',
            'label' => '字彙翻譯',
            'type'  => 'text', // 欄位類型
        ]);

        CRUD::field('pass')->type('boolean')->label('跳過不取代')->default(0);
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::addField([
            'name'    => 'url', // 資料庫欄位名稱
            'label'   => '首見網址', // 顯示在表單上的標籤文字
            'type'    => 'text', // 欄位類型 (根據你的資料類型選擇)
            'attributes' => [
                'readonly' => 'readonly', // 將這個欄位設為唯讀
                // 'disabled' => 'disabled', // 如果你希望完全禁用並阻止提交，可以使用這個 (但通常用 readonly 即可)
            ],
            'hint' => '這個欄位不能修改', // 可選：添加提示文字
        ]);
    }
}
