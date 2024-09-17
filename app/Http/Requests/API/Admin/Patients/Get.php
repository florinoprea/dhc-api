<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;
use Illuminate\Validation\Rule;

class Get extends DefaultFormRequest
{
    public function __construct()
    {
        $this->message = 'Patients could not be listed. Please review your input.';
        parent::__construct();
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'options.order_type' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],
            'options.order_by' => [
                'nullable',
                Rule::in(['order','first_name', 'active']),
            ],
            'options.per_page' => [
                'nullable',
                Rule::in([2, 5, 10, 20, 50, 100]),
            ],
            'filters.search' => [
                'nullable'
            ],
            'filters.status' => [
                'nullable',
                'boolean'
            ],
            'page' => [
                'nullable',
                'integer',
                'min:1'
            ]
        ];
    }
}
