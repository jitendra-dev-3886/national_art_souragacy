<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ChangeAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */
    protected const YES = 'Yes';
    protected const NO  = 'No';

    protected array $validQualifications = ['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'];
    protected array $validDegrees = ['Doctorate', 'Post Graduate', 'Graduate', 'Diploma', 'Under Graduate', 'Any Other'];
    protected array $validPosts = ['Gynecologist','Andrologist','Clinical Embryologist','Counselor','Anesthetist','Any Other'];
    protected array $validBankPosts = ['Registered Medical Practioner', 'Any Other'];

    /*
    |--------------------------------------------------------------------------
    | Prepare Input (IMPORTANT FIX)
    |--------------------------------------------------------------------------
    */
    protected function prepareForValidation()
    {
        // If director is NOT Yes, remove director fields to avoid validation issues
        if ($this->director !== self::YES) {
            $this->merge([
                'name_director'  => null,
                'quali_director' => null,
            ]);
        }

        // If no other procedure
        if ($this->anyotherprocedure !== self::YES) {
            $this->merge([
                'otherprocedure' => null,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */
    public function rules()
    {
        // Draft mode (minimal validation)
        if ($this->input('submit_type') === 'draft') {
            return [
                'clinic_id'   => 'required|integer',
                'clinic_type' => 'required|string',
                'submit_type'  => ['required', Rule::in(['draft','final'])],
            ];
        }

        $validPostOptions = $this->clinic_type === 'ARTBANK' ? $this->validBankPosts : $this->validPosts;

        $rules = [
            'submit_type'   => ['required', Rule::in(['draft','final'])],
            'clinic_id'     => 'required|integer',

            'address'       => 'required|string',
            'pincode'       => 'required',
            'state'         => 'required',
            'district'         => 'required',
            'contactno'     => 'required',

            'personname'    => 'required|string|max:255',
            'mobilecontact' => 'required',
            'emailcontact'  => 'required|email',
            'fax'           => 'nullable|digits:11',
            'email_clinic'  => 'required|email',
            'clinic_type'   => 'required|string',
            'applicationno' => 'required|string|max:50',
            'declaration'                 => ['accepted'],

            'director'      => ['required', Rule::in([self::YES, self::NO])],

            /*
            |--------------------------------------------------------------------------
            | Staff
            |--------------------------------------------------------------------------
            */
            'post'             => 'required|array',
            'post.*'           => ['required', Rule::in($validPostOptions)],

            'name_otherstaff'  => 'required|array',
            'name_otherstaff.*'=> 'required|string|max:255',

            'quali_otherstaff' => 'required|array',
            'quali_otherstaff.*' => ['required', Rule::in($this->validDegrees)],

            'regno'            => 'nullable|array',
            'regno.*'          => 'nullable|string|max:100',

            'anyotherpost'     => 'nullable|array',
            'anyotherpost.*'   => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1] ?? null;
                    if ($index !== null && $this->input("post.$index") === 'Any Other' && trim((string) $value) === '') {
                        $fail('Please specify the other post when Any Other is selected.');
                    }
                },
            ],

            'anyotherdegree'   => 'nullable|array',
            'anyotherdegree.*' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1] ?? null;
                    if ($index !== null && $this->input("quali_otherstaff.$index") === 'Any Other' && trim((string) $value) === '') {
                        $fail('Please specify the other qualification when Any Other is selected.');
                    }
                },
            ],

            /*
            |--------------------------------------------------------------------------
            | Equipment
            |--------------------------------------------------------------------------
            */
            'equipmentname'    => 'required|array|min:1',
            'equipmentname.*'  => 'required|string|max:255',

            /*
            |--------------------------------------------------------------------------
            | Procedures
            |--------------------------------------------------------------------------
            */
        ];

        /*
        |--------------------------------------------------------------------------
        | Clinic Specific Rules
        |--------------------------------------------------------------------------
        */
        if (in_array($this->clinic_type, ['ARTSURROGACY', 'ARTCLINIC'])) {
            $rules += [
                'pcpndtact'      => 'required|string',
                'mtpact'         => 'required|string',

                'iuih'           => ['required', Rule::in([self::YES, self::NO])],
                'iuid'           => ['required', Rule::in([self::YES, self::NO])],
                'ivfet'          => ['required', Rule::in([self::YES, self::NO])],
                'icsi'           => ['required', Rule::in([self::YES, self::NO])],
                'pgt'            => ['required', Rule::in([self::YES, self::NO])],
                'spermandoocyte' => ['required', Rule::in([self::YES, self::NO])],
                'anyotherprocedure' => ['required', Rule::in([self::YES, self::NO])],
            ];
        } elseif ($this->clinic_type === 'ARTBANK') {
            $rules += [
                'ejaculation'                 => ['required', Rule::in([self::YES, self::NO])],
                'electrojaculation'           => ['required', Rule::in([self::YES, self::NO])],
                'sperm_vitrification'         => ['required', Rule::in([self::YES, self::NO])],
                'storage_sperm'               => ['required', Rule::in([self::YES, self::NO])],
                'oocyte_doner'                => ['required', Rule::in([self::YES, self::NO])],
                'processing_sperm'            => ['required', Rule::in([self::YES, self::NO])],
                'cryopreservation_of_sperm'   => ['required', Rule::in([self::YES, self::NO])],
                'methode_of_freezing_of_sperm'=> ['required', Rule::in([self::YES, self::NO])],
                'freezing_of_testicular_tissue'=> ['required', Rule::in([self::YES, self::NO])],
            ];

            $rules['director']         = 'nullable';
            $rules['name_director']    = 'nullable';
            $rules['name_director.*']  = 'nullable';
            $rules['quali_director']   = 'nullable';
            $rules['quali_director.*'] = 'nullable';
        }

        /*
        |--------------------------------------------------------------------------
        | Director Rules (FIXED - NO prohibited)
        |--------------------------------------------------------------------------
        */
        if ($this->input('director') === self::YES) {

            $rules['name_director']    = 'required|array|min:1';
            $rules['name_director.*']  = 'required|string|max:255';

            $rules['quali_director']   = 'required|array|min:1';
            $rules['quali_director.*'] = ['required', Rule::in($this->validQualifications)];

        } else {

            // SAFE: allow null instead of prohibited
            $rules['name_director']   = 'nullable';
            $rules['quali_director']  = 'nullable';
        }

        /*
        |--------------------------------------------------------------------------
        | Other Procedure
        |--------------------------------------------------------------------------
        */
        if ($this->input('anyotherprocedure') === self::YES) {
            $rules['otherprocedure'] = 'required|string|max:255';
        }

        return $rules;
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */
    public function messages()
    {
        return [
            'address.required' => 'Address is required',
            'pincode.required' => 'Pincode is required',

            'personname.required' => 'Contact person name is required',
            'mobilecontact.required' => 'Mobile number is required',
            'emailcontact.required' => 'Email is required',
            'fax.digits' => 'Fax number must be exactly 11 digits.',
            'director.required' => 'Please select director option',
            'director.in' => 'Please select a valid director option',

            'name_director.*.required' => 'Director name is required',
            'quali_director.*.required' => 'Director qualification is required',

            'equipmentname.required' => 'At least one equipment is required',

            'otherprocedure.required' => 'Please specify other procedure',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validation Failure Logging
    |--------------------------------------------------------------------------
    */
    protected function failedValidation(Validator $validator)
    {
        Log::warning('Change Address Validation Failed', [
            'errors' => $validator->errors()->toArray(),
            'ip' => $this->ip(),
        ]);

        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}