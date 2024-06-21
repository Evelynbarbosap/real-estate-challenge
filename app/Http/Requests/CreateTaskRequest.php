<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Carbon\Carbon;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => [
                'required',
                'integer',
                Rule::exists(User::class, 'id'),
            ],
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date_format:d/m/Y'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('due_date')) {
            $this->merge([
                'due_date' => $this->formatDate($this->due_date),
            ]);
        }
    }

    /**
     * Format the due_date attribute.
     *
     * @param string|null $date
     * @return string|null
     */
    protected function formatDate($date)
    {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

}
