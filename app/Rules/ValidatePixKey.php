<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ValidatePixKey implements ValidationRule
{
    public function __construct(protected string $account, protected $kind)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $account = $this->account;
        $kind = $this->kind;

        $pix = DB::table('pix_keys')->select(['account_id'])
            ->where('pix_keys.kind', $kind)
            ->where('pix_keys.key', $value)
            ->first()?->account_id;

        if ($pix && $pix == $account) {
            $fail('The source and destination account cannot be the same.');
        }
    }
}
