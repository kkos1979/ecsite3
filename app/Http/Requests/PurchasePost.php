<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasePost extends FormRequest
{
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
            //
            'start_date' => ['required', 'date', 'before_or_equal:last_date'],
        ];
    }

    protected function getValidatorInstance()
    {
      $data = $this->all();

      // 取得した月が1~9月の場合は先頭に0を付ける
      if (strlen($this->input('start_month')) === 1) {
        $start_month = '0' . $this->input('start_month');
      } else {
        $start_month = $this->input('start_month');
      }
      if (strlen($this->input('last_month')) === 1) {
        $last_month = '0' . $this->input('last_month');
      } else {
        $last_month = $this->input('last_month');
      }

      // 月初日
      $data['start_date'] = $this->input('start_year') . '-' . $start_month . '-' . '01';
      // 月末日
      $target_month = $this->input('last_year') . '-' . $last_month;
      $data['last_date'] = date('Y-m-d', strtotime('last day of' . $target_month));

      $this->getInputSource()->replace($data);

      return parent::getValidatorInstance();
    }
}
