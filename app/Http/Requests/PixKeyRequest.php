<?php

namespace App\Http\Requests;

use CodePix\System\Domain\Entities\Enum\PixKey\KindPixKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PixKeyRequest extends FormRequest
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
        $rules = [
            'kind' => ['required', new Enum(KindPixKey::class)],
        ];

        match($this->get('kind')) {
            'email' => $rules['key'] = ['email', 'required'],
            'phone' => $rules['key'] = ['required', 'size:11'],
            'document' => $rules['key'] = ['required', 'cpf_ou_cnpj'],
            default => null,
        };

        return $rules;
    }
}
