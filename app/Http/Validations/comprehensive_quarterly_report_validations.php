<?php

$serverSideRules = [

    [
        'first'   => 'art_clinic_qtr_end_q2',
        'second'  => 'art_clinic_qtr_end_q1',
        'errorId' => 'art_clinic_qtr_1_error_msg',
        'message' => 'Q1 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q2',
        'second'  => 'art_clinic_q2',
        'errorId' => 'art_clinic_qtr_2_error_msg',
        'message' => 'ART Clinic value cannot be Less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q2',
        'second'  => 'art_clinic_qtr_end_q2',
        'errorId' => 'art_clinic_left_2_error_msg',
        'message' => 'ART Clinic cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q2',
        'second'  => 'art_banks_qtr_end_q1',
        'errorId' => 'art_banks_qtr_1_error_msg',
        'message' => 'Q1 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q2',
        'second'  => 'art_banks_q2',
        'errorId' => 'art_banks_qtr_2_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q2',
        'second'  => 'art_banks_qtr_end_q2',
        'errorId' => 'art_bank_left_2_error_msg',
        'message' => 'ART Bank cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q2',
        'second'  => 'surrogacy_clinic_qtr_end_q1',
        'errorId' => 'surrogacy_clinic_qtr_1_error_msg',
        'message' => 'Q1 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q2',
        'second'  => 'surrogacy_clinic_q2',
        'errorId' => 'surrogacy_clinic_qtr_2_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q2',
        'second'  => 'surrogacy_clinic_qtr_end_q2',
        'errorId' => 'surrogacy_clinic_left_2_error_msg',
        'message' => 'Surrogacy Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q3',
        'second'  => 'art_clinic_qtr_end_q2',
        'errorId' => 'art_clinic_qtr_3_error_msg',
        'message' => 'Q2 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q3',
        'second'  => 'art_clinic_q3',
        'errorId' => 'art_clinic_qtr_3_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q3',
        'second'  => 'art_clinic_qtr_end_q3',
        'errorId' => 'art_clinic_left_3_error_msg',
        'message' => 'ART Clinic value cannot be Greater than the value on the right',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q2',
        'second'  => 'art_clinic_qtr_end_q3',
        'errorId' => 'art_clinic_qtr_2_error_msg',
        'message' => 'Q3 Art Clinic connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q3',
        'second'  => 'art_banks_qtr_end_q2',
        'errorId' => 'art_banks_qtr_3_error_msg',
        'message' => 'Q2 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q3',
        'second'  => 'art_banks_q3',
        'errorId' => 'art_banks_qtr_3_error_msg',
        'message' => 'ART Banks value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q3',
        'second'  => 'art_banks_qtr_end_q3',
        'errorId' => 'art_banks_left_3_error_msg',
        'message' => 'ART Bank cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q2',
        'second'  => 'art_banks_qtr_end_q3',
        'errorId' => 'art_banks_qtr_2_error_msg',
        'message' => 'Q3 Art Bank connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q3',
        'second'  => 'surrogacy_clinic_qtr_end_q2',
        'errorId' => 'surrogacy_clinic_qtr_3_error_msg',
        'message' => 'Q2 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q3',
        'second'  => 'surrogacy_clinic_q3',
        'errorId' => 'surrogacy_clinic_qtr_3_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q3',
        'second'  => 'surrogacy_clinic_qtr_end_q3',
        'errorId' => 'surrogacy_clinic_left_2_error_msg',
        'message' => 'Surrogacy Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q2',
        'second'  => 'surrogacy_clinic_qtr_end_q3',
        'errorId' => 'surrogacy_clinic_qtr_2_error_msg',
        'message' => 'Q3 Surrogacy Clinic connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q4',
        'second'  => 'art_clinic_qtr_end_q3',
        'errorId' => 'art_clinic_qtr_4_error_msg',
        'message' => 'Q3 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q4',
        'second'  => 'art_clinic_q4',
        'errorId' => 'art_clinic_qtr_4_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q4',
        'second'  => 'art_clinic_qtr_end_q4',
        'errorId' => 'art_clinic_left_4_error_msg',
        'message' => 'ART Clinic value cannot be Greater than the value on the Right',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q3',
        'second'  => 'art_clinic_qtr_end_q4',
        'errorId' => 'art_clinic_qtr_3_error_msg',
        'message' => 'Q4 Art Clinic connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q4',
        'second'  => 'art_banks_qtr_end_q3',
        'errorId' => 'art_banks_qtr_4_error_msg',
        'message' => 'Q3 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q4',
        'second'  => 'art_banks_q4',
        'errorId' => 'art_banks_qtr_4_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q4',
        'second'  => 'art_banks_qtr_end_q4',
        'errorId' => 'art_banks_left_4_error_msg',
        'message' => 'ART Bank cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q3',
        'second'  => 'art_banks_qtr_end_q4',
        'errorId' => 'art_banks_qtr_3_error_msg',
        'message' => 'Q4 Art Bank connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q4',
        'second'  => 'surrogacy_clinic_qtr_end_q3',
        'errorId' => 'surrogacy_clinic_left_4_error_msg',
        'message' => 'Q3 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q4',
        'second'  => 'surrogacy_clinic_q4',
        'errorId' => 'surrogacy_clinic_left_4_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q4',
        'second'  => 'surrogacy_clinic_qtr_end_q4',
        'errorId' => 'surrogacy_clinic_left_4_error_msg',
        'message' => 'Surrogacy Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q3',
        'second'  => 'surrogacy_clinic_qtr_end_q4',
        'errorId' => 'surrogacy_clinic_qtr_3_error_msg',
        'message' => 'Q4 Surrogacy Clinic value connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q6',
        'second'  => 'art_clinic_qtr_end_q1',
        'errorId' => 'art_clinic_qtr_6_error_msg1',
        'message' => 'Q1 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q6',
        'second'  => 'art_clinic_q6',
        'errorId' => 'art_clinic_qtr_6_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q6',
        'second'  => 'art_clinic_qtr_end_q6',
        'errorId' => 'art_clinic_left_6_error_msg',
        'message' => 'ART Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q6',
        'second'  => 'art_banks_qtr_end_q1',
        'errorId' => 'art_banks_qtr_6_error_msg1',
        'message' => 'Q1 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q6',
        'second'  => 'art_banks_q6',
        'errorId' => 'art_banks_qtr_6_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q6',
        'second'  => 'art_banks_qtr_end_q6',
        'errorId' => 'art_banks_left_6_error_msg',
        'message' => 'ART Bank cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q6',
        'second'  => 'surrogacy_clinic_qtr_end_q1',
        'errorId' => 'surrogacy_clinic_qtr_6_error_msg1',
        'message' => 'Q1 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q6',
        'second'  => 'surrogacy_clinic_q6',
        'errorId' => 'surrogacy_clinic_qtr_6_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q6',
        'second'  => 'surrogacy_clinic_qtr_end_q6',
        'errorId' => 'surrogacy_clinic_left_6_error_msg',
        'message' => 'Surrogacy Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q7',
        'second'  => 'art_clinic_qtr_end_q1',
        'errorId' => 'art_clinic_qtr_7_error_msg1',
        'message' => 'Q1 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q7',
        'second'  => 'art_clinic_q7',
        'errorId' => 'art_clinic_qtr_7_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q7',
        'second'  => 'art_clinic_qtr_end_q7',
        'errorId' => 'art_clinic_left_7_error_msg',
        'message' => 'ART Clinic value cannot be Greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q7',
        'second'  => 'art_banks_qtr_end_q1',
        'errorId' => 'art_banks_qtr_7_error_msg1',
        'message' => 'Q1 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q7',
        'second'  => 'art_banks_q7',
        'errorId' => 'art_banks_qtr_7_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q7',
        'second'  => 'art_banks_qtr_end_q7',
        'errorId' => 'art_banks_left_7_error_msg',
        'message' => 'ART Bank cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q7',
        'second'  => 'surrogacy_clinic_qtr_end_q1',
        'errorId' => 'surrogacy_clinic_qtr_7_error_msg1',
        'message' => 'Q1 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q7',
        'second'  => 'surrogacy_clinic_q7',
        'errorId' => 'surrogacy_clinic_qtr_7_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q7',
        'second'  => 'surrogacy_clinic_qtr_end_q7',
        'errorId' => 'surrogacy_clinic_left_7_error_msg',
        'message' => 'Surrogacy Clinic value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q8',
        'second'  => 'art_clinic_qtr_end_q2',
        'errorId' => 'art_clinic_qtr_8_error_msg',
        'message' => 'Q2 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q2',
        'second'  => 'art_clinic_qtr_end_q8',
        'errorId' => 'art_clinic_qtr_2_error_msg',
        'message' => 'Q8 Art Clinic connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q8',
        'second'  => 'art_clinic_qtr_end_q8',
        'errorId' => 'art_clinic_left_8_error_msg',
        'message' => 'ART Clinic Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q8',
        'second'  => 'art_clinic_q8',
        'errorId' => 'art_clinic_qtr_8_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q8',
        'second'  => 'art_banks_qtr_end_q2',
        'errorId' => 'art_banks_qtr_8_error_msg',
        'message' => 'Q2 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q2',
        'second'  => 'art_banks_qtr_end_q8',
        'errorId' => 'art_banks_qtr_2_error_msg',
        'message' => 'Q8 ART Bank value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q8',
        'second'  => 'art_banks_qtr_end_q8',
        'errorId' => 'art_banks_left_8_error_msg',
        'message' => 'ART Bank Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q8',
        'second'  => 'art_banks_q8',
        'errorId' => 'art_banks_qtr_8_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q8',
        'second'  => 'surrogacy_clinic_qtr_end_q2',
        'errorId' => 'surrogacy_clinic_qtr_8_error_msg',
        'message' => 'Q2 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q2',
        'second'  => 'surrogacy_clinic_qtr_end_q8',
        'errorId' => 'surrogacy_clinic_qtr_2_error_msg',
        'message' => 'Q8 Surrogacy Clinic value cannot be Greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q8',
        'second'  => 'surrogacy_clinic_qtr_end_q8',
        'errorId' => 'surrogacy_clinic_left_8_error_msg',
        'message' => 'Surrogacy Clinic Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q8',
        'second'  => 'surrogacy_clinic_q8',
        'errorId' => 'surrogacy_clinic_qtr_8_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q9',
        'second'  => 'art_clinic_qtr_end_q9',
        'errorId' => 'art_clinic_left_9_error_msg',
        'message' => 'ART Clinic Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q9',
        'second'  => 'art_clinic_q9',
        'errorId' => 'art_clinic_qtr_9_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q9',
        'second'  => 'art_banks_qtr_end_q9',
        'errorId' => 'art_banks_left_9_error_msg',
        'message' => 'ART Banks Value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q9',
        'second'  => 'art_banks_q9',
        'errorId' => 'art_banks_qtr_9_error_msg',
        'message' => 'ART Banks value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q9',
        'second'  => 'surrogacy_clinic_qtr_end_q9',
        'errorId' => 'surrogacy_clinic_left_9_error_msg',
        'message' => 'Surrogacy Clinic Value cannot be greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q9',
        'second'  => 'surrogacy_clinic_q9',
        'errorId' => 'surrogacy_clinic_qtr_9_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q10',
        'second'  => 'art_clinic_qtr_end_q10',
        'errorId' => 'art_clinic_left_10_error_msg',
        'message' => 'ART Clinic Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q10',
        'second'  => 'art_clinic_q10',
        'errorId' => 'art_clinic_qtr_10_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q10',
        'second'  => 'art_banks_qtr_end_q10',
        'errorId' => 'art_banks_left_10_error_msg',
        'message' => 'ART Banks Value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q10',
        'second'  => 'art_banks_q10',
        'errorId' => 'art_banks_qtr_10_error_msg',
        'message' => 'ART Banks value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q10',
        'second'  => 'surrogacy_clinic_qtr_end_q10',
        'errorId' => 'surrogacy_clinic_left_10_error_msg',
        'message' => 'Surrogacy Clinic Value cannot be greater than the value on the left.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q10',
        'second'  => 'surrogacy_clinic_q10',
        'errorId' => 'surrogacy_clinic_qtr_10_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q11',
        'second'  => 'art_clinic_qtr_end_q10',
        'errorId' => 'art_clinic_qtr_11_error_msg',
        'message' => 'Q10 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q11',
        'second'  => 'art_clinic_q11',
        'errorId' => 'art_clinic_qtr_11_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q11',
        'second'  => 'art_clinic_qtr_end_q11',
        'errorId' => 'art_clinic_left_11_error_msg',
        'message' => 'ART Clinic value cannot be Greater than the value on the Right',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q10',
        'second'  => 'art_clinic_qtr_end_q11',
        'errorId' => 'art_clinic_qtr_10_error_msg',
        'message' => 'Q11 Art Clinic connot be Greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q11',
        'second'  => 'art_banks_qtr_end_q10',
        'errorId' => 'art_banks_qtr_11_error_msg',
        'message' => 'Q10 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q11',
        'second'  => 'art_banks_q11',
        'errorId' => 'art_banks_qtr_11_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q11',
        'second'  => 'art_banks_qtr_end_q11',
        'errorId' => 'art_banks_left_11_error_msg',
        'message' => 'ART Bank cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q10',
        'second'  => 'art_banks_qtr_end_q11',
        'errorId' => 'art_banks_qtr_10_error_msg',
        'message' => 'Q11 ART Bank value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q11',
        'second'  => 'surrogacy_clinic_qtr_end_q10',
        'errorId' => 'surrogacy_clinic_qtr_11_error_msg',
        'message' => 'Q10 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q11',
        'second'  => 'surrogacy_clinic_q11',
        'errorId' => 'surrogacy_clinic_qtr_11_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q11',
        'second'  => 'surrogacy_clinic_qtr_end_q11',
        'errorId' => 'surrogacy_clinic_left_11_error_msg',
        'message' => 'Surrogacy Clinic value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q10',
        'second'  => 'surrogacy_clinic_qtr_end_q11',
        'errorId' => 'surrogacy_clinic_qtr_10_error_msg',
        'message' => 'Q11 Surrogacy Clinic value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q12',
        'second'  => 'art_clinic_qtr_end_q10',
        'errorId' => 'art_clinic_qtr_12_error_msg',
        'message' => 'Q10 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q12',
        'second'  => 'art_clinic_q12',
        'errorId' => 'art_clinic_qtr_12_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q12',
        'second'  => 'art_clinic_qtr_end_q12',
        'errorId' => 'art_clinic_left_12_error_msg',
        'message' => 'ART Clinic value cannot be greater than the value on the right',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q10',
        'second'  => 'art_clinic_qtr_end_q12',
        'errorId' => 'art_clinic_qtr_10_error_msg',
        'message' => 'Q12 Art Clinic connot be greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q12',
        'second'  => 'art_banks_qtr_end_q10',
        'errorId' => 'art_banks_qtr_12_error_msg',
        'message' => 'Q10 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q12',
        'second'  => 'art_banks_q12',
        'errorId' => 'art_banks_qtr_12_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q12',
        'second'  => 'art_banks_qtr_end_q12',
        'errorId' => 'art_banks_left_12_error_msg',
        'message' => 'ART Bank cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q10',
        'second'  => 'art_banks_qtr_end_q12',
        'errorId' => 'art_banks_qtr_10_error_msg',
        'message' => 'Q12 ART Bank value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q12',
        'second'  => 'surrogacy_clinic_qtr_end_q10',
        'errorId' => 'surrogacy_clinic_qtr_12_error_msg',
        'message' => 'Q10 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q12',
        'second'  => 'surrogacy_clinic_q12',
        'errorId' => 'surrogacy_clinic_qtr_12_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q12',
        'second'  => 'surrogacy_clinic_qtr_end_q12',
        'errorId' => 'surrogacy_clinic_left_12_error_msg',
        'message' => 'Surrogacy Clinic value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q10',
        'second'  => 'surrogacy_clinic_qtr_end_q12',
        'errorId' => 'surrogacy_clinic_qtr_10_error_msg',
        'message' => 'Q12 Surrogacy Clinic value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q13',
        'second'  => 'art_clinic_qtr_end_q10',
        'errorId' => 'art_clinic_qtr_13_error_msg',
        'message' => 'Q10 Art Clinic connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q13',
        'second'  => 'art_clinic_q13',
        'errorId' => 'art_clinic_qtr_13_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinic_q13',
        'second'  => 'art_clinic_qtr_end_q13',
        'errorId' => 'art_clinic_left_13_error_msg',
        'message' => 'ART Clinic value cannot be greater than the value on the Right',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinic_qtr_end_q10',
        'second'  => 'art_clinic_qtr_end_q13',
        'errorId' => 'art_clinic_qtr_10_error_msg',
        'message' => 'Q13 Art Clinic connot be greater than this value',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q13',
        'second'  => 'art_banks_qtr_end_q10',
        'errorId' => 'art_banks_qtr_13_error_msg',
        'message' => 'Q10 Art Bank connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q13',
        'second'  => 'art_banks_q13',
        'errorId' => 'art_banks_qtr_13_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_q13',
        'second'  => 'art_banks_qtr_end_q13',
        'errorId' => 'art_banks_left_13_error_msg',
        'message' => 'ART Bank cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_q10',
        'second'  => 'art_banks_qtr_end_q13',
        'errorId' => 'art_banks_qtr_10_error_msg',
        'message' => 'Q13 ART Bank value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q13',
        'second'  => 'surrogacy_clinic_qtr_end_q10',
        'errorId' => 'surrogacy_clinic_qtr_13_error_msg',
        'message' => 'Q10 Surrogacy Clinic value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q13',
        'second'  => 'surrogacy_clinic_q13',
        'errorId' => 'surrogacy_clinic_qtr_13_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_q13',
        'second'  => 'surrogacy_clinic_qtr_end_q13',
        'errorId' => 'surrogacy_clinic_left_13_error_msg',
        'message' => 'Surrogacy Clinic value cannot be greater than the value on the left.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinic_qtr_end_q10',
        'second'  => 'surrogacy_clinic_qtr_end_q13',
        'errorId' => 'surrogacy_clinic_qtr_10_error_msg',
        'message' => 'Q13 Surrogacy Clinic value cannot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeal_rej_app_a_q14',
        'second'  => 'appeal_rej_app_qtr_end_a_q14',
        'errorId' => 'renewal_left_14a_error_msg',
        'message' => 'cannot be greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeal_rej_app_qtr_end_a_q14',
        'second'  => 'appeal_rej_app_a_q14',
        'errorId' => 'renewal_qtr_14a_error_msg',
        'message' => 'cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_b_q14',
        'second'  => 'appeals_disposed_qtr_end_b_q14',
        'errorId' => 'renewal_left_14b_error_msg',
        'message' => ' cannot be greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q14',
        'second'  => 'appeals_disposed_b_q14',
        'errorId' => 'renewal_qtr_14b_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q14',
        'second'  => 'appeal_rej_app_qtr_end_a_q14',
        'errorId' => 'renewal_qtr_14b_error_msg',
        'message' => 'Q14A value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeal_rej_app_qtr_end_a_q14',
        'second'  => 'appeals_disposed_qtr_end_b_q14',
        'errorId' => 'renewal_qtr_14a_error_msg',
        'message' => 'Q14 B value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'forwarded_dhr_i_q15',
        'second'  => 'forwarded_dhr_qtr_end_i_q15',
        'errorId' => 'art_clinic_left_15_error_msg',
        'message' => 'Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'forwarded_dhr_qtr_end_i_q15',
        'second'  => 'forwarded_dhr_i_q15',
        'errorId' => 'art_clinic_qtr_15_error_msg',
        'message' => 'value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'received_stakeholders_ii_q15',
        'second'  => 'received_stakeholders_qtr_end_ii_q15',
        'errorId' => 'art_banks_left_15_error_msg',
        'message' => 'Value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'received_stakeholders_qtr_end_ii_q15',
        'second'  => 'received_stakeholders_ii_q15',
        'errorId' => 'art_banks_qtr_15_error_msg',
        'message' => 'value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'suo_moto_cognizancеr_iii_q15',
        'second'  => 'suo_moto_cognizancеr_qtr_end_iii_q15',
        'errorId' => 'surrogacy_clinic_left_15_error_msg',
        'message' => 'Value cannot be greater than the value on the left.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'suo_moto_cognizancеr_qtr_end_iii_q15',
        'second'  => 'suo_moto_cognizancеr_iii_q15',
        'errorId' => 'surrogacy_clinic_qtr_15_error_msg',
        'message' => 'value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'action_taken_a_q16',
        'second'  => 'action_taken_qtr_end_a_q16',
        'errorId' => 'surrogacy_clinic_left_16a_error_msg',
        'message' => ' cannot be greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'action_taken_qtr_end_a_q16',
        'second'  => 'action_taken_a_q16',
        'errorId' => 'surrogacy_clinic_qtr_16a_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_clinics_b_q16',
        'second'  => 'art_clinics_qtr_end_b_q16',
        'errorId' => 'art_clinic_left_b_16_error_msg',
        'message' => 'ART Clinic Value cannot be Greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_clinics_qtr_end_b_q16',
        'second'  => 'art_clinics_b_q16',
        'errorId' => 'art_clinic_qtr_b_16_error_msg',
        'message' => 'ART Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'art_banks_b_q16',
        'second'  => 'art_banks_qtr_end_b_q16',
        'errorId' => 'art_banks_left_b_16_error_msg',
        'message' => 'ART Bank Value cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'art_banks_qtr_end_b_q16',
        'second'  => 'art_banks_b_q16',
        'errorId' => 'art_banks_qtr_b_16_error_msg',
        'message' => 'ART Bank value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinics_b_q16',
        'second'  => 'surrogacy_clinics_qtr_end_b_q16',
        'errorId' => 'surrogacy_clinics_left_b_16_error_msg',
        'message' => 'Surrogacy Clinic Value cannot be greater than the value on the left.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_clinics_qtr_end_b_q16',
        'second'  => 'surrogacy_clinics_b_q16',
        'errorId' => 'surrogacy_clinics_qtr_b_16_error_msg',
        'message' => 'Surrogacy Clinic value cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeal_received_a_q17',
        'second'  => 'appeal_received_qtr_end_a_q17',
        'errorId' => 'appeal_received_left_17a_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeal_received_qtr_end_a_q17',
        'second'  => 'appeal_received_a_q17',
        'errorId' => 'appeal_received_qtr_17a_error_msg',
        'message' => 'cannot be ess than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q17',
        'second'  => 'appeals_disposed_b_q17',
        'errorId' => 'appeal_received_qtr_17b_error_msg',
        'message' => 'Q17 B value connot be less than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_b_q17',
        'second'  => 'appeals_disposed_qtr_end_b_q17',
        'errorId' => 'appeal_received_left_17b_error_msg',
        'message' => ' Q17 B value connot be greater than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q17',
        'second'  => 'appeal_received_qtr_end_a_q17',
        'errorId' => 'appeal_received_qtr_17b_error_msg',
        'message' => 'Q17 A value connot be less than this value',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeal_received_qtr_end_a_q17',
        'second'  => 'appeals_disposed_qtr_end_b_q17',
        'errorId' => 'appeal_received_qtr_17a_error_msg',
        'message' => 'Q17 B value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'complaints_filed_q18',
        'second'  => 'complaints_filed_qtr_end_q18',
        'errorId' => 'complaints_filed_left_18_error_msg',
        'message' => ' cannot be greater than the value on the right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'complaints_filed_qtr_end_q18',
        'second'  => 'complaints_filed_q18',
        'errorId' => 'complaints_filed_qtr_18_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_i_a_q19',
        'second'  => 'applications_received_qtr_end_i_a_q19',
        'errorId' => 'appeal_received_left_19ai_error_msg',
        'message' => ' cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_ii_a_q19',
        'second'  => 'applications_received_qtr_end_ii_a_q19',
        'errorId' => 'appeal_received_left_19aii_error_msg',
        'message' => ' cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_iii_a_q19',
        'second'  => 'applications_received_qtr_end_iii_a_q19',
        'errorId' => 'appeal_received_left_19aiii_error_msg',
        'message' => ' cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_iv_a_q19',
        'second'  => 'applications_received_qtr_end_iv_a_q19',
        'errorId' => 'appeal_received_left_19aiv_error_msg',
        'message' => ' cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_i_a_q19',
        'second'  => 'applications_received_i_a_q19',
        'errorId' => 'appeal_received_qtr_19ai_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_ii_a_q19',
        'second'  => 'applications_received_ii_a_q19',
        'errorId' => 'appeal_received_qtr_19aii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iii_a_q19',
        'second'  => 'applications_received_iii_a_q19',
        'errorId' => 'appeal_received_qtr_19aiii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iv_a_q19',
        'second'  => 'applications_received_iv_a_q19',
        'errorId' => 'appeal_received_qtr_19aiv_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_granted_i_b_q19',
        'second'  => 'applications_granted_qtr_end_i_b_q19',
        'errorId' => 'applications_granted_left_19bi_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_ii_b_q19',
        'second'  => 'applications_granted_qtr_end_ii_b_q19',
        'errorId' => 'applications_granted_left_19bii_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_iii_b_q19',
        'second'  => 'applications_granted_qtr_end_iii_b_q19',
        'errorId' => 'applications_granted_left_19biii_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_iv_b_q19',
        'second'  => 'applications_granted_qtr_end_iv_b_q19',
        'errorId' => 'applications_granted_left_19biv_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_i_b_q19',
        'second'  => 'applications_granted_i_b_q19',
        'errorId' => 'applications_granted_qtr_19bi_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_ii_b_q19',
        'second'  => 'applications_granted_ii_b_q19',
        'errorId' => 'applications_granted_qtr_19bii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_iii_b_q19',
        'second'  => 'applications_granted_iii_b_q19',
        'errorId' => 'applications_granted_qtr_19biii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_iv_b_q19',
        'second'  => 'applications_granted_iv_b_q19',
        'errorId' => 'applications_granted_qtr_19biv_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_i_b_q19',
        'second'  => 'applications_received_qtr_end_i_a_q19',
        'errorId' => 'applications_granted_qtr_19bi_error_msg',
        'message' => 'Q19 A.i value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_ii_b_q19',
        'second'  => 'applications_received_qtr_end_ii_a_q19',
        'errorId' => 'applications_granted_qtr_19bii_error_msg',
        'message' => 'Q19 A.ii value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_iii_b_q19',
        'second'  => 'applications_received_qtr_end_iii_a_q19',
        'errorId' => 'applications_granted_qtr_19biii_error_msg',
        'message' => 'Q19 A.iii value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_granted_qtr_end_iv_b_q19',
        'second'  => 'applications_received_qtr_end_iv_a_q19',
        'errorId' => 'applications_granted_qtr_19biv_error_msg',
        'message' => 'Q19 A.iv value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_i_a_q19',
        'second'  => 'applications_granted_qtr_end_i_b_q19',
        'errorId' => 'appeal_received_qtr_19ai_error_msg',
        'message' => 'Q19 B.i value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_ii_a_q19',
        'second'  => 'applications_granted_qtr_end_ii_b_q19',
        'errorId' => 'appeal_received_qtr_19aii_error_msg',
        'message' => ' Q19 B.ii value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iii_a_q19',
        'second'  => 'applications_granted_qtr_end_iii_b_q19',
        'errorId' => 'appeal_received_qtr_19aiii_error_msg',
        'message' => 'Q19 B.iii value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iv_a_q19',
        'second'  => 'applications_granted_qtr_end_iv_b_q19',
        'errorId' => 'appeal_received_qtr_19aiv_error_msg',
        'message' => 'Q19 B.iv value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_rejected_i_c_q19',
        'second'  => 'applications_rejected_qtr_end_i_c_q19',
        'errorId' => 'applications_rejected_left_19ci_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_ii_c_q19',
        'second'  => 'applications_rejected_qtr_end_ii_c_q19',
        'errorId' => 'applications_rejected_left_19cii_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_iii_c_q19',
        'second'  => 'applications_rejected_qtr_end_iii_c_q19',
        'errorId' => 'applications_rejected_left_19ciii_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_iv_c_q19',
        'second'  => 'applications_rejected_qtr_end_iv_c_q19',
        'errorId' => 'applications_rejected_left_19civ_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_i_c_q19',
        'second'  => 'applications_rejected_i_c_q19',
        'errorId' => 'applications_rejected_qtr_19ci_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_ii_c_q19',
        'second'  => 'applications_rejected_ii_c_q19',
        'errorId' => 'applications_rejected_qtr_19cii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_iii_c_q19',
        'second'  => 'applications_rejected_iii_c_q19',
        'errorId' => 'applications_rejected_qtr_19ciii_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_iv_c_q19',
        'second'  => 'applications_rejected_iv_c_q19',
        'errorId' => 'applications_rejected_qtr_19civ_error_msg',
        'message' => ' cannot be less than the value on the left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_i_c_q19',
        'second'  => 'applications_received_qtr_end_i_a_q19',
        'errorId' => 'applications_rejected_qtr_19ci_error_msg',
        'message' => 'Q19 A.i value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_ii_c_q19',
        'second'  => 'applications_received_qtr_end_ii_a_q19',
        'errorId' => 'applications_rejected_qtr_19cii_error_msg',
        'message' => 'Q19 A.ii value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_iii_c_q19',
        'second'  => 'applications_received_qtr_end_iii_a_q19',
        'errorId' => 'applications_rejected_qtr_19ciii_error_msg',
        'message' => 'Q19 A.iii value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_rejected_qtr_end_iv_c_q19',
        'second'  => 'applications_received_qtr_end_iv_a_q19',
        'errorId' => 'applications_rejected_qtr_19civ_error_msg',
        'message' => 'Q19 A.iv value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_i_a_q19',
        'second'  => 'applications_rejected_qtr_end_i_c_q19',
        'errorId' => 'appeal_received_qtr_19ai_error_msg',
        'message' => 'Q19 C.i value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_ii_a_q19',
        'second'  => 'applications_rejected_qtr_end_ii_c_q19',
        'errorId' => 'appeal_received_qtr_19aii_error_msg',
        'message' => 'Q19 C.ii value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iii_a_q19',
        'second'  => 'applications_rejected_qtr_end_iii_c_q19',
        'errorId' => 'appeal_received_qtr_19aiii_error_msg',
        'message' => 'Q19 C.iii value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'applications_received_qtr_end_iv_a_q19',
        'second'  => 'applications_rejected_qtr_end_iv_c_q19',
        'errorId' => 'appeal_received_qtr_19aiv_error_msg',
        'message' => 'Q19 C.iv value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_against_rejection_a_q20',
        'second'  => 'appeals_against_rejection_qtr_end_a_q20',
        'errorId' => 'appeals_against_rejection_left_20a_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeals_against_rejection_qtr_end_a_q20',
        'second'  => 'appeals_against_rejection_a_q20',
        'errorId' => 'appeals_against_rejection_qtr_20a_error_msg',
        'message' => 'connot be less than the value on the Left',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_b_q20',
        'second'  => 'appeals_disposed_qtr_end_b_q20',
        'errorId' => 'appeals_disposed_left_20b_error_msg',
        'message' => 'connot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q20',
        'second'  => 'appeals_disposed_b_q20',
        'errorId' => 'appeals_disposed_qtr_20b_error_msg',
        'message' => 'connot be less than the value on the Left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'appeals_disposed_qtr_end_b_q20',
        'second'  => 'appeals_against_rejection_qtr_end_a_q20',
        'errorId' => 'appeals_disposed_qtr_20b_error_msg',
        'message' => 'Q20 A value connot be less than this value.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'appeals_against_rejection_qtr_end_a_q20',
        'second'  => 'appeals_disposed_qtr_end_b_q20',
        'errorId' => 'appeals_against_rejection_qtr_20a_error_msg',
        'message' => 'Q20 B value connot be greater than this value.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'chapter_v_art_q22',
        'second'  => 'chapter_v_art_qtr_end_q22',
        'errorId' => 'chapter_v_art_left_22_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'chapter_v_art_qtr_end_q22',
        'second'  => 'chapter_v_art_q22',
        'errorId' => 'chapter_v_art_qtr_22_error_msg',
        'message' => 'cannot be less than the value on the Left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

    [
        'first'   => 'surrogacy_chapter_vii_q22',
        'second'  => 'surrogacy_chapter_qtr_end_vii_q22',
        'errorId' => 'surrogacy_chapter_vii_left_22_error_msg',
        'message' => 'cannot be greater than the value on the Right.',
        'rule'    => 'secondLessThanFirst',
    ],

    [
        'first'   => 'surrogacy_chapter_qtr_end_vii_q22',
        'second'  => 'surrogacy_chapter_vii_q22',
        'errorId' => 'surrogacy_chapter_vii_qtr_22_error_msg',
        'message' => 'cannot be less than the value on the Left.',
        'rule'    => 'secondGreaterThanFirst',
    ],

];

return $serverSideRules;