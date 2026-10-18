<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class SurrogacyClinicRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        Log::warning('Validation Failed', [
            'errors' => $validator->errors()->toArray(),
            // 'input' => $this->except(['password']), // avoid sensitive data
            'ip' => $this->ip(),
        ]);
        // throw new HttpResponseException(response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        throw new HttpResponseException(
            redirect()->route('clinic.add_surrogacy_application_form')
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
        return true; // Set this to true if you want to allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $validQualifications = ['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'];
    protected $validPosts = ['Gynecologist','Andrologist','Clinical Embryologist','Counselor','Anesthetist','Any Other'];
    protected $validDegrees = ['Doctorate', 'Post Graduate', 'Graduate', 'Diploma', 'Under Graduate', 'Any Other'];
    

   public function rules()
    {
          
     $submitType = $this->input('submit_type'); // draft or final
     // Initialize rules array
       $rules = [];
       if ($submitType === 'draft') {
       $rules = [];
       } else {
        
         
        $rules = [
            'clinicname' => 'required|string',
            'address' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'nature' => 'required',
            'email_clinic' => 'required',
            'contactno' => 'required',
            'personname' => 'required',
            'mobilecontact' => 'required',
            'emailcontact' => 'required',
            'dateestab' => 'required|date',
            'mtpact' => 'required|string',
            'pcpndtact' => 'required|string',
            // 'director' => 'required|in:Yes,No',  // 'director' must be 'Yes'
            // 'name_director' => [
            //                     Rule::requiredIf($this->input('director') === 'Yes'),
            //                     Rule::prohibitedIf($this->input('director') === 'No'),
            //                     'array'
            //                     ],                              // 'name_director' must be an array if 'director' is 'Yes'
            // 'name_director.*' => [Rule::requiredIf($this->input('director') === 'Yes'),'string'],  // Each element in 'name_director' must be required if 'director' is 'Yes'
            // 'quali_director' => [
            //                     Rule::requiredIf($this->input('director') === 'Yes'),
            //                     Rule::prohibitedIf($this->input('director') === 'No'),
            //                     'array'
            //                 ],
            // 'quali_director.*' => [
            //                     Rule::requiredIf($this->input('director') === 'Yes'),
            //                     Rule::in($this->validQualifications)
            //                     ],  // Each element in 'quali_director' must be required if 'director' is 'Yes'
            // 'post_otherstaff' => 'required',
            // 'post_otherstaff.*' => ['required', Rule::in($this->validPosts)],
            // 'name_otherstaff' => 'required',
            // 'name_otherstaff.*' => ['required', 'string'],
            // 'quali_otherstaff' => 'required',
            // 'quali_otherstaff.*' => ['required', Rule::in($this->validDegrees)],
            // // Optional text fields (conditionally required)
            // 'anyotherpost' => 'array',
            // 'anyotherdegree' => 'array',
            // 'anyotherpost.*' => [
            //             'nullable',
            //             'string',
            //             'max:255',
            //             function ($attribute, $value, $fail) {
            //                 $index = explode('.', $attribute)[1] ?? null;
            //                 $posts = request()->input('post_otherstaff', []);
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

            // 'equipmentname' => 'required|array|min:1|max:255',
            // 'equipmentname.*' => 'required|string|min:1|max:255',
            // 'iuih' => 'required|in:Yes,No',
            // 'iuid' => 'required|in:Yes,No',
            // 'ivfet' => 'required|in:Yes,No',
            // 'icsi' => 'required|in:Yes,No',
            // 'pgt' => 'required|in:Yes,No',
            // 'spermandoocyte' => 'required|in:Yes,No',
            // 'anyotherprocedure' => 'required|in:Yes,No',
            // 'otherprocedure' => 'required_if:anyotherprocedure,Yes',
            // 'otherdetails' => 'required',
            // 'declaration' => 'required',





            // Director logic
            'director'         => 'required|in:Yes,No',
            'name_director'    => 'required_if:director,Yes|array',
            'name_director.*'  => 'required_if:director,Yes|string|max:255',
            'quali_director'   => 'required_if:director,Yes|array',
            'quali_director.*' => 'required_if:director,Yes|string|in:'.implode(',', $this->validQualifications),

            // Other staff
            'post_otherstaff'     => 'required|array|min:1',
            'post_otherstaff.*'   => ['required', Rule::in($this->validPosts)],
            'name_otherstaff'     => 'required|array|min:1',
            'name_otherstaff.*'   => 'required|string|max:255',
            'quali_otherstaff'    => 'required|array|min:1',
            'quali_otherstaff.*'  => ['required', Rule::in($this->validDegrees)],

            // Conditional "Any Other" logic
            'anyotherpost'     => 'array',
            'anyotherpost.*'   => 'nullable|string|max:255',
            'anyotherdegree'   => 'array',
            'anyotherdegree.*' => 'nullable|string|max:255',

            // Equipment
            'equipmentname'    => 'required|array|min:1',
            'equipmentname.*'  => 'required|string|max:200',

            // Procedures
            'iuih'             => 'required|in:Yes,No',
            'iuid'             => 'required|in:Yes,No',
            'ivfet'            => 'required|in:Yes,No',
            'icsi'             => 'required|in:Yes,No',
            'pgt'              => 'required|in:Yes,No',
            'spermandoocyte'   => 'required|in:Yes,No',
            'anyotherprocedure'=> 'required|in:Yes,No',
            'otherprocedure'   => 'nullable|required_if:anyotherprocedure,Yes|string|max:2000',

            // Extra details
            
            'declaration'      => 'required',
        ];
    }
       
    // dd($rules);
     return $rules;
}

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'clinicname' => 'clinic name field is required.',
            'address' => 'clinic address field is required.',
            'pincode' => 'clinic pincode is required.',
            'state' => 'clinic state is required.',
            'nature' => 'clinic nature is required.',
            'email_clinic' => 'email of clinic is required.',
            'contactno' => 'clinic contact number is required.',
            'personname' => 'clinic contact person name is required.',
            'mobilecontact' => 'contact person mobile number is required.',
            'emailcontact' => 'contact person email is required.',
            'dateestab' => 'date of establishment field is required.',
            'dateestab.date' => 'Date established must be a valid date.',
            'mtpact' => 'MTP Act field is required.',
            'pcpndtact' => 'PCPNDT field is required.',
            'director.required' => 'Please select whether the clinic has a director.',
            'director.in' => 'Invalid value for director choose yes or no.',
            'name_director.required_if' => 'Please enter at least one director name.',
            'name_director.*.required_if' => 'Each director name is required.',
            'name_director.*.string' => 'Each director name must be a valid string.',

            'quali_director.required_if' => 'Please provide qualifications for each director.',
            'quali_director.*.in' => 'Please select a valid qualification.',
            'post_otherstaff.required' => 'Please select a post for other staff member.',
            'post_otherstaff.in' => 'Invalid post selected.',
            'post_otherstaff.*.required' => 'Please select a post for each other staff member.',
            'post_otherstaff.*.in' => 'Invalid post selected.',
            'anyotherpost.*.string' => 'Other post must be a string.',
            'anyotherpost.*.max' => 'Other post must not exceed 255 characters.',
            'name_otherstaff.required' => 'Please enter a name for other staff member.',
            'name_otherstaff.*.required' => 'Please enter a name for each other staff member.',
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
            'iuih' => 'iuih field is required',
            'iuih.in' => 'Only Yes or NO allowed',
            'iuid' => 'iuid field is required',
            'iuid.in' => 'Only Yes or NO allowed',
            'ivfet' => 'ivfet field is required',
            'ivfet.in' => 'Only Yes or NO allowed',
            'icsi' => 'icsi field is required',
            'icsi.in' => 'Only Yes or NO allowed',
            'pgt' => 'pgt field is required',
            'pgt.in' => 'Only Yes or NO allowed',
            'spermandoocyte' => 'spermandoocyte field is required',
            'spermandoocyte.in' => 'Only Yes or NO allowed',
            'anyotherprocedure' => 'anyotherprocedure field is required',
            'anyotherprocedure.in' => 'Only Yes or NO allowed',


            'otherprocedure.required_if' => 'otherprocedure is required',
            // 'equipmentname.*.required' => 'The  Equipment Name is required.',
            // Add other custom error messages as needed
        ];
    }
}
