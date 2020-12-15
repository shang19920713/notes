<?php
//根据字段last_name对数组$data进行降序排列
$data = array(
    array(
        'id' => 5698,
        'first_name' => 'Bill',
        'last_name' => 'Gates',
    ),
    array(
        'id' => 4767,
        'first_name' => 'Steve',
        'last_name' => 'Aobs',
    ),
    array(
        'id' => 3809,
        'first_name' => 'Mark',
        'last_name' => 'Zuckerberg',
    )
);
$last_names = array_column($data,'last_name');
array_multisort($last_names,SORT_DESC,$data);

