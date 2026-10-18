<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManpowerRequest extends FormRequest
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
        $request_rule = [];

        if ($this->submit_type == 'final') {

            $request_rule = array_merge($request_rule, [

                'clinic_id' => 'required',
                'registration_no' => 'required',
                'clinicname' => 'required',
                'clinic_type' => 'required|string',
                'current_registration_date' => 'required|date',
                'address' => 'required|string|max:255',
                'pincode' => 'required|integer',
                'state' => 'required|string|max:255',
                'district' => 'required|string|max:255',

                // Declaration
                'declaration' => 'required|accepted',
                'name_signatory' => 'required|string|max:255',
                'declaration_designation' => 'required|string|max:255',
                'declaration_contact' => 'required|numeric|digits:11',
                'declaration_date' => 'required|date',

                // // Staff (Add More Supported)
                // 'post' => 'required|array|min:1',
                // 'post.*' => 'required|string',

                // 'name_otherstaff' => 'required|array|min:1',
                // 'name_otherstaff.*' => 'required|string|max:255',

                // 'qualification' => 'required|array|min:1',
                // 'qualification.*' => 'required|string|max:255',

                // 'regno' => 'required|array|min:1',
                // 'regno.*' => 'required|string|max:255',
                'post' => 'nullable|array',
                'post.*' => 'nullable|string',

                'name_otherstaff' => 'nullable|array',
                'name_otherstaff.*' => 'nullable|string|max:255',

                'qualification' => 'nullable|array',
                'qualification.*' => 'nullable|string|max:255',

                // 'regno' => 'nullable|array',
                // 'regno.*' => 'nullable|string|max:255',
            ]);


            // Director Section
            if ($this->clinic_type != 'ARTBANK') {

                $request_rule = array_merge($request_rule, [

                    'director' => 'required|in:Yes,No',

                    // 'name_director' => 'required_if:director,Yes|array|min:1',
                    // 'name_director.*' => 'required|string|max:255',

                    // 'quali_director' => 'required_if:director,Yes|array|min:1',
                    // 'quali_director.*' => 'required|string|max:255',

                    // 'reg_director' => 'required_if:director,Yes|array|min:1',
                    // 'reg_director.*' => 'required|string|max:255',

                    'name_director' => 'nullable|array',
                    'name_director.*' => 'nullable|string|max:255',

                    'quali_director' => 'nullable|array',
                    'quali_director.*' => 'nullable|string|max:255',

                    // 'reg_director' => 'nullable|array',
                    // 'reg_director.*' => 'nullable|string|max:255',
                ]);
            }
        }

        return $request_rule;
    }
    public function withValidator($validator)
    {
        if ($this->submit_type == 'final') {
            $validator->after(function ($validator) {

                $names = $this->input('name_director', []);
                $qualis = $this->input('quali_director', []);
                $regs = $this->input('reg_director', []);

                $totalRows = max(
                    count($names),
                    count($qualis),
                    count($regs)
                );

                for ($i = 0; $i < $totalRows; $i++) {

                    $name = trim($names[$i] ?? '');
                    $quali = trim($qualis[$i] ?? '');
                    $reg = trim($regs[$i] ?? '');

                    // Agar poori row blank hai to ignore
                    if (
                        $name === '' &&
                        $quali === '' &&
                        $reg === ''
                    ) {
                        continue;
                    }

                    // Agar ek bhi field bhari hai to sab mandatory
                    if ($name === '') {
                        $validator->errors()->add(
                            "name_director.$i",
                            "Director Name cannot be blank."
                        );
                    }

                    if ($quali === '') {
                        $validator->errors()->add(
                            "quali_director.$i",
                            "Director Qualification cannot be blank."
                        );
                    }

                    // if ($reg === '') {
                    //     $validator->errors()->add(
                    //         "reg_director.$i",
                    //         "Director Registration No. cannot be blank."
                    //     );
                    // }
                }


                // ====================Staff manpower=================

                $posts = $this->input('post', []);
                $names = $this->input('name_otherstaff', []);
                $qualifications = $this->input('qualification', []);
                // $regnos = $this->input('regno', []);

                $totalRows = max(
                    count($posts),
                    count($names),
                    count($qualifications),
                    // count($regnos)
                );

                for ($i = 0; $i < $totalRows; $i++) {

                    $post = trim($posts[$i] ?? '');
                    $name = trim($names[$i] ?? '');
                    $qualification = trim($qualifications[$i] ?? '');
                    $regno = trim($regnos[$i] ?? '');

                    // Agar poori row blank hai to ignore karo
                    if (
                        $post === '' &&
                        $name === '' &&
                        $qualification === '' &&
                        $regno === ''
                    ) {
                        continue;
                    }

                    // Agar kisi ek field me value hai to sab required honge
                    if ($post === '') {
                        $validator->errors()->add("post.$i", "Post of staff cannot be blank.");
                    }

                    if ($name === '') {
                        $validator->errors()->add("name_otherstaff.$i", "Name of staff cannot be blank.");
                    }

                    if ($qualification === '') {
                        $validator->errors()->add("qualification.$i", "Qualification of staff cannot be blank.");
                    }

                    // if ($regno === '') {
                    //     $validator->errors()->add("regno.$i", "Registration No. cannot be blank.");
                    // }
                }
            });
        }
    }
}
