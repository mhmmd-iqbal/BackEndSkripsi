<?php 

return [
    'role' => [
        'admin'     => 'admin',
        'manager'   => 'manager',
        'auditor'   => 'auditor',
        'auditee'   => 'auditee'
    ],
    'audit_status'  => [
        'open'      => 0,
        'assign'    => 1,
        'finish'    => 2,
        'reject'    => 3
    ],
    'approval'      => [
        'approved'  => 1,
        'rejected'  => 2  
    ],
];