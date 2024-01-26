<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Transaction;


class PaymentRequest extends FormRequest
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
            'transaction_id' => [
                'required',
                'exists:transactions,transaction_id',
                Rule::exists('transactions', 'transaction_id')
            ],
            'amount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $transactionId = $this->input('transaction_id');

                    if (!$transactionId) {
                        $fail("The transaction_id field is required.");
                        return;
                    }

                    $transaction = Transaction::where('transaction_id',$transactionId)->first();

                    if (!$transaction) {
                        $fail("Transaction not found.");
                        return;
                    }

                    if ($transaction->status == 'Paid') {
                        $fail("Transaction is Already Paid");
                    } else {
                        if ($value > $transaction->amount) {
                            $fail("The amount cannot be larger than the transaction amount ($transaction->amount).");
                        }
                        if ($transaction->balance != 0 && $value > $transaction->balance) {
                            $fail("The amount cannot be larger than the transaction balance amount ($transaction->balance).");
                        }
                    }
                },
            ],
            'paid_on' => 'required|date',
            'details' => 'nullable|string',
        ];
    }

}
