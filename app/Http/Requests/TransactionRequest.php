<?php

namespace App\Http\Requests;

use CodePix\System\Domain\Entities\Enum\PixKey\KindPixKey;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends FormRequest
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
     * @throws Exception
     */
    public function rules(): array
    {
        $rules = [
            'account' => 'required',
            'value' => 'required|numeric|min:0',
            'description' => 'required|min:3',
            'kind' => ['required', new Enum(KindPixKey::class)],
            'key' => ['required'],
        ];

        match($this->get('kind')) {
            'email' => $rules['key'] + ['email', 'required'],
            'phone' => $rules['key'] + ['required', 'size:11'],
            'document' => $rules['key'] + ['required', 'cpf_ou_cnpj'],
            'id' => $rules['key'] + ['required', 'uuid'],
            default => true,
        };

        return $rules;
    }
}
