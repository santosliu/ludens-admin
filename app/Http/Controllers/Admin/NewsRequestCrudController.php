<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequestRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NewsRequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsRequestCrudController extends CrudController
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
        CRUD::setModel(\App\Models\NewsRequest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/news-request');
        CRUD::setEntityNameStrings('news request', 'news requests');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->setDefaultPageLength(100);

        CRUD::addColumn([
            'name'    => 'url',
            'label'   => '網址',
            'type'    => 'text',
            'limit'   => 200,
        ]);

        CRUD::addColumn([
            'name'    => 'game',
            'label'   => '遊戲名稱',
            'type'    => 'text',
        ]);
       
        CRUD::addColumn([
            'name'    => 'status',
            'label'   => '狀態',
            'type'    => 'boolean',
            'options' => [0 => '尚未處理', 1 => '已爬取完畢'],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(NewsRequestRequest::class);

        CRUD::field('url')->type('url')->attributes([
            'maxlength' => 250,
        ]);

        // game 欄位：從 proper_nouns 表抓取 distinct(topic) 當作選項
        $topics = \App\Models\ProperNoun::query()
            ->distinct()
            ->pluck('topic')
            ->filter()
            ->values()
            ->all();

        $topicOptions = [];
        foreach ($topics as $t) {
            $topicOptions[$t] = $t;
        }

        CRUD::addField([
            'name'    => 'game',
            'label'   => '遊戲名稱',
            'type'    => 'select2_from_array',
            'options' => $topicOptions,
            'allows_null' => true,
        ]);

        CRUD::field('file_name')
            ->type('upload')
            ->label('上傳文件')
            ->upload(true)
            ->disk('external_scripts');

    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
