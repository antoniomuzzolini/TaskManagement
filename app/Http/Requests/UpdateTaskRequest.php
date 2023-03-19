<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = $this->route('task')->project;

        return auth()->user()->hasPermissionTo('update tasks') 
            || auth()->user()->hasPermissionTo('update own project tasks')
                && auth()->user()->id == $project->project_manager_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'priority' => [
                'sometimes',
                Rule::in(['high', 'medium', 'low'])
            ],
            'developer_id' => [
                'nullable',
                Rule::in(Role::where('name', 'developer')->first()->users()->pluck('id')->all())
            ],
        ];
    }
}
