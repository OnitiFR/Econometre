<?php

return [
    'occupancy' => [
        'rules' => 'is_array_walk:is_int_between!0@1|required',
        'output_name' => 'Occupation'
    ],
    'culture' => [
        'rules' => 'is_string|required',
        'output_name' => 'Culture'
    ],
    'nbPersons' => [
        'rules' => 'is_int_between:1,7|required',
        'output_name' => 'Nb_occupants'
    ],
    'department' => [
        'rules' => 'is_int_between:1,96|required',
        'output_name' => 'Departement'
    ],
    'city' => [
        'rules' => 'is_string|required',
        'output_name' => 'Ville'
    ],
    'constYear' => [
        'rules' => 'is_int_between:1,5|required',
        'output_name' => 'Annee_const'
    ],
    'glazing' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Vitrage'
    ],
    'works' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'Travaux'
    ],
    'tempCons' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'T_cons'
    ],
    'actualSys' => [
        'rules' => 'is_int_between:1,6|required',
        'output_name' => 'Syst_actuel'
    ],
    'transmitter' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Emetteurs'
    ],
    'dHWActualSystem' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'Syst_ECS_actuel|required'
    ],
    'dHWChangement' => [
        'rules' => 'is_bool|required',
        'output_name' => 'Chgmt_ECS'
    ],
    'systemAge' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Age_syst'
    ],
    'area' => [
        'rules' => 'is_int|required',
        'output_name' => 'Surface'
    ]
];