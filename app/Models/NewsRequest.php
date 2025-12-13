<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Storage;

class NewsRequest extends Model
{
    use CrudTrait;

    protected $table = 'news_request';
    protected $fillable = ['url', 'status', 'game', 'file_name'];

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setFileNameAttribute($value)
    {
        $attribute_name = "file_name";
        
        // 1. 指定我們剛剛在 config 定義的 disk 名稱
        $disk = "external_scripts"; 
        
        // 2. 指定相對路徑 (相對於 disk root)
        // 因為 disk root 已經是 /var/www/html/script
        // 如果設為 '' (空字串)，檔案就會直接存在該目錄下
        // 如果設為 'v1'，檔案會存在 /var/www/html/script/v1
        $destination_path = ""; 

        // 移除舊檔案邏輯
        if ($value == null) {
            if (isset($this->attributes[$attribute_name])) {
                Storage::disk($disk)->delete($this->attributes[$attribute_name]);
            }
            $this->attributes[$attribute_name] = null;
        }

        // 新檔案上傳邏輯
        if (request()->hasFile($attribute_name)) {
            $file = request()->file($attribute_name);
            
            if ($this->attributes[$attribute_name] ?? false) {
                Storage::disk($disk)->delete($this->attributes[$attribute_name]);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 3. 儲存檔案
            // 實際路徑會是：/var/www/html/script/檔名
            $path = $file->storeAs($destination_path, $filename, $disk);

            // 4. 存入資料庫
            // 注意：這裡存入的僅是檔名或相對路徑，不是絕對路徑
            $this->attributes[$attribute_name] = $path;
        }
    }
}