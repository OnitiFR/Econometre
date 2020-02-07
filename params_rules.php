<?php

return [
    'occupancy' => [
        'rules' => 'is_array_walk:is_int_between!0@1|required',
        'output_name' => 'Occupation'
    ],
    'culture' => [
        'rules' => 'is_string',
        'output_name' => 'Culture'
    ],
    'nbPersons' => [
        'rules' => 'is_int_between:1,7|required',
        'output_name' => 'Nb_occupants',
        'transform' => 'intval'
    ],
    'department' => [
        'rules' => 'is_int_between:1,96|required',
        'output_name' => 'Departement',
        'transform' => 'addquotes'
    ],
    'city' => [
        'rules' => 'is_string|required',
        'output_name' => 'Ville',
        'transform' => 'addquotes'
    ],
    'constYear' => [
        'rules' => 'is_int_between:1,5|required',
        'output_name' => 'Annee_const',
        'transform' => 'intval'
    ],
    'glazing' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Vitrage',
        'transform' => 'intval'
    ],
    'works' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'Travaux',
        'transform' => 'intval'
    ],
    'tempCons' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'T_cons',
        'transform' => 'intval'
    ],
    'actualSys' => [
        'rules' => 'is_int_between:1,6|required',
        'output_name' => 'Syst_actuel',
        'transform' => 'intval'
    ],
    'transmitter' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Emetteurs',
        'transform' => 'intval'
    ],
    'dHWActualSystem' => [
        'rules' => 'is_int_between:1,3|required',
        'output_name' => 'Syst_ECS_actuel',
        'transform' => 'intval'
    ],
    'dHWChangement' => [
        'rules' => 'required',
        'output_name' => 'Chgmt_ECS',
        'transform' => 'boolval'
    ],
    'systemAge' => [
        'rules' => 'is_int_between:1,2|required',
        'output_name' => 'Age_syst',
        'transform' => 'intval'
    ],
    'area' => [
        'rules' => 'is_int|required',
        'output_name' => 'Surface',
        'transform' => 'intval'
    ]
];