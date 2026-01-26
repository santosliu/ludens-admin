<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => [
                'required',
                'url',
                'max:200',
                'unique:news_request,url,'.$this->id,
                function ($attribute, $value, $fail) {
                    $allowedPrefixes = [
                        'https://www.inven.co.kr/board/',
                        'https://www.inven.co.kr/webzine/',
                        'https://www.gamespot.com/articles/',
                        'https://www.gamespot.com/gallery/',
                        'https://mp.weixin.qq.com/',
                    ];

                    foreach ($allowedPrefixes as $prefix) {
                        if (str_starts_with($value, $prefix)) {
                            return;
                        }
                    }

                    $fail($this->getUrlPrefixErrorMessage());
                },
            ],
            'status' => 'required|integer',
        ];
    }

    /**
     * Get custom error message for URL prefix validation.
     */
    protected function getUrlPrefixErrorMessage(): string
    {
        return '網址格式不符，僅接受以下來源：'.PHP_EOL.
            '• https://www.inven.co.kr/board/'.PHP_EOL.
            '• https://www.inven.co.kr/webzine/'.PHP_EOL.
            '• https://www.gamespot.com/articles/'.PHP_EOL.
            '• https://www.gamespot.com/gallery/'.PHP_EOL.
            '• https://mp.weixin.qq.com/';
    }
}
