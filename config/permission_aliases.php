<?php

// Map of alias => canonical permission/action name
return [
    // Documents/upload
    'subir_documentos' => 'upload_documents',
    'subir_soportes' => 'upload_documents',
    'upload_documents' => 'upload_documents',

    // View accounts
    'view_cuenta_cobro' => 'view_cuenta_cobro',
    'ver_cuenta_cobro' => 'view_cuenta_cobro',

    // Approvals
    'aprobar' => 'approve_cuenta_cobro',
    'approve_cuenta_cobro' => 'approve_cuenta_cobro',
    'rechazar' => 'reject_cuenta_cobro',
    'reject_cuenta_cobro' => 'reject_cuenta_cobro',

    // Payments
    'procesar_pago' => 'process_payment',
    'process_payment' => 'process_payment',
    'payment_confirmation' => 'payment_confirmation',

    // Contracts
    'manage_contracts' => 'manage_contracts',
    'gestionar_contratos' => 'manage_contracts',

    // Reports
    'view_reports' => 'view_reports',
    'ver_reportes' => 'view_reports',

    // Soportes
    'eliminar_soportes' => 'delete_supports',
    'subir_soportes' => 'upload_documents',
];
