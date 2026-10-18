<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
class BankApplicationFormRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        Log::warning('art bank Validation Failed', [
            'errors' => $validator->errors()->toArray(),
            // 'input' => $this->except(['password']), // avoid sensitive data
            'ip' => $this->ip(),
        ]);
        // throw new HttpResponseException(response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        throw new HttpResponseException(
            redirect()->route('clinic.add_bank_application_form')
                ->withErrors($validator)
                ->withInput()
        );
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
    protected $validDesignations = ['Registered Medical Practioner', 'Any Other'];
    protected $validDegrees = ['Doctorate', 'Post Graduate', 'Graduate', 'Diploma', 'Under Graduate', 'Any Other'];
    public function rules()
    {
        //dd("check1");
       $rules = ['clinicname' => 'required|string',
            'address' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'nature' => 'required',
            'email_bank' => 'required',
            'contactno' => 'required',
            'personname' => 'required',
            'mobilecontact' => 'required',
            'emailcontact' => 'required',
            'dateestab' => 'required|date',
            'name_otherstaff' => 'required|array',
            'name_otherstaff.*' => ['required', 'string'],
            'designation_otherstaff' => 'required|array',
            'designation_otherstaff.*' => ['required', Rule::in($this->validDesignations)],
            'quali_otherstaff' => 'required|array',
            'quali_otherstaff.*' => ['required', Rule::in($this->validDegrees)],
            'anyotherpost' => 'array',
            'anyotherdegree' => 'array',
            // 'anyotherpost.*' => [
            //             'nullable',
            //             'string',
            //             'max:255',
            //             function ($attribute, $value, $fail) {
            //                 $index = explode('.', $attribute)[1] ?? null;
            //                 $posts = request()->input('designationotherstaff', []);
            //                 if (isset($posts[$index]) && $posts[$index] === 'Any Other' && empty($value)) {
            //                     $fail('Please specify the other post when "Any Other" is selected.');
            //                 }
            //                 if (isset($posts[$index]) && $posts[$index] !== 'Any Other' && !empty($value)) {
            //                     $fail('Other post should only be filled if "Any Other" is selected.');
            //                 }
            //             }
            //         ],

            // 'anyotherdegree.*' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            //     function ($attribute, $value, $fail) {
            //         $index = explode('.', $attribute)[1] ?? null;
            //         $quals = request()->input('quali_otherstaff', []);
            //         if (isset($quals[$index]) && $quals[$index] === 'Any Other' && empty($value)) {
            //             $fail('Please specify the other qualification when "Any Other" is selected.');
            //         }
            //         if (isset($quals[$index]) && $quals[$index] !== 'Any Other' && !empty($value)) {
            //             $fail('Other qualification should only be filled if "Any Other" is selected.');
            //         }
            //     }
            // ],
            // Equipment data
            'equipmentname' => 'required|array|min:1|max:255',
            'equipmentname.*' => 'required|string|min:1|max:255',
            'ejaculation' => 'required|in:Yes,No',
            'electroejaculation' => 'required|in:Yes,No',
            'processingsperm' => 'required|in:Yes,No',
            'storagesperm' => 'required|in:Yes,No',
            'oocytedonor' => 'required|in:Yes,No',
            'cryopreservation' => 'required|in:Yes,No',
            'spermslow' => 'required|in:Yes,No',
            'spermvitrification' => 'required|in:Yes,No',
            'tisticulartissue' => 'required|in:Yes,No',
            'otherdetails' => 'nullable|string|max:1000',
            //
        ];
        if($this->input('common') == 'draft'){
            // dd("wwwwwwwwwwwwwwwwwwwwww");
            $rules = [];
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'clinicname' => 'clinic name field is required.',
            'address' => 'clinic address field is required.',
            'pincode' => 'clinic pincode is required.',
            'state' => 'clinic state is required.',
            'nature' => 'clinic nature is required.',
            'email_bank' => 'email of clinic is required.',
            'contactno' => 'clinic contact number is required.',
            'personname' => 'clinic contact person name is required.',
            'mobilecontact' => 'contact person mobile number is required.',
            'emailcontact' => 'contact person email is required.',
            'dateestab' => 'date of establishment field is required.',
            'dateestab.date' => 'Date established must be a valid date.',
            'name_otherstaff' => 'Please enter a name for other staff member.',
            'name_otherstaff.*' => 'Please enter a name for each other staff member.',
            'designation_otherstaff.required' => 'Please select a designation for other staff member.',
            'designation_otherstaff.in' => 'Invalid designation selected.',
            'designation_otherstaff.*.required' => 'Please select a designation for each other staff member.',
            'designation_otherstaff.*.in' => 'Invalid designation selected.',
            'anyotherpost.*.string' => 'Other designation must be a string.',
            'anyotherpost.*.max' => 'Other designation must not exceed 255 characters.',
            'quali_otherstaff.required' => 'Please select a qualification for other staff member.',
            'quali_otherstaff.in' => 'Invalid qualification selected.',
            'quali_otherstaff.*.required' => 'Please select a qualification for each other staff member.',
            'quali_otherstaff.*.in' => 'Invalid qualification selected.',
            'anyotherdegree.*.string' => 'Other qualification must be a string.',
            'anyotherdegree.*.max' => 'Other qualification must not exceed 255 characters.',
            'equipmentname.required' => 'Equipment name is required',
            'equipmentname.min' => 'Equipment name is required',
            'equipmentname.max' => 'character limit of equipment name exceeds',
            'equipmentname.*' => 'Please enter name for each equipment',
            'equipmentname.*.string' => 'Each equipment name must be a valid string.',
            'equipmentname.*.min' => 'Please enter name for each equipment',
            'equipmentname.*.max' => 'character limit of this equipment name exceeds',
            
            'ejaculation' => 'ejaculation field is required.',
            'ejaculation.in' => 'Only Yes or NO allowed',
            'electroejaculation' => 'electroejaculation field is required.',
            'electroejaculation.in' => 'Only Yes or NO allowed',
            'processingsperm' => 'processingsperm field is required.',
            'processingsperm.in' => 'Only Yes or NO allowed',
            'storagesperm' => 'storagesperm field is required.',
            'storagesperm.in' => 'Only Yes or NO allowed',
            'oocytedonor' => 'oocytedonor field is required.',
            'oocytedonor.in' => 'Only Yes or NO allowed',
            'cryopreservation' => 'cryopreservation field is required.',
            'cryopreservation.in' => 'Only Yes or NO allowed',
            'spermslow' => 'spermslow field is required.',
            'spermslow.in' => 'Only Yes or NO allowed',
            'spermvitrification' => 'spermvitrification field is required.',
            'spermvitrification.in' => 'Only Yes or NO allowed',
            'tisticulartissue' => 'tisticulartissue field is required.',
            'tisticulartissue.in' => 'Only Yes or NO allowed',
            'otherdetails.string' => 'otherdetails only contains string.',
            
            // 'director.required' => 'Please select whether the clinic has a director.',
            // 'director.in' => 'Invalid value for director choose yes or no.',
            // 'name_director.required_if' => 'Please enter at least one director name.',
            // 'name_director.*.required_if' => 'Each director name is required.',
            // 'name_director.*.string' => 'Each director name must be a valid string.',

            // 'quali_director.required_if' => 'Please provide qualifications for each director.',
            // 'quali_director.*.in' => 'Please select a valid qualification.',
            

            'otherprocedure.required_if' => 'otherprocedure is required',
        ];
    }
}
