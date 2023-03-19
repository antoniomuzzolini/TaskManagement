<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task');
        $project = $task->project;

        return auth()->user()->hasPermissionTo('update tasks')
            || auth()->user()->hasPermissionTo('update status own tasks')
                && auth()->user()->id == $task->developer_id
            ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(['backlog', 'to do', 'in progress', 'done'])
            ],
        ];
    }
}
