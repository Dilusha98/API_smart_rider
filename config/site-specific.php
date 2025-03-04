<?php

if($_ENV['APP_ENV'] == 'live') {
    $BaseUrl     = '';
}
else if($_ENV['APP_ENV'] == 'dev'){
    $BaseUrl     = '';
}
else{
    $BaseUrl     = 'http://127.0.0.1:8000/';
}

$version = 1;
return [
    /*
    |--------------------------------------------------------------------------
    | System configurations
    |--------------------------------------------------------------------------
    */

    // 'attempt-limit'=> 5,
    // 's3-bucket-notification-image-path' => 'ceylonex/notification-images/',
    // 'defult-image'                      => '/custom_assets/img/dummy-profile.png',
    'Base-url'            => $BaseUrl,

    /*
    |--------------------------------------------------------------------------
    | Site Default styles
    |--------------------------------------------------------------------------
    */
    'datatable-css'                 => "https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css",
    'datatable-btn-css'             => "https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css",
    'datatable-bootstrap-css'       => "https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css",
    'dropify-css'                   => "https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css",
    'sweetAlert-css'                => "https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.css",
    'toastr-css'                    => "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css",
    'switchery-css'                 => "https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css",

    // custom css


    /*
    |--------------------------------------------------------------------------
    | Site Default script
    |--------------------------------------------------------------------------
    */
    'jquery-min-js'                 => "plugins/jquery/jquery.min.js",
    'jquery-ui-min-js'              => "plugins/jquery-ui/jquery-ui.min.js",
    'datatable-js'                  => "https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js",
    'datatable-button-js'           => "https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js",
    'datatable-html5-js'            => "https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js",
    'datatable-print-js'            => "https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js",
    'datatable-jszip-js'            => "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js",
    'datatable-pdfmake-js'          => "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js",
    'datatable-pdffont-js'          => "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js",
    'datatable-colVis-js'           => "https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js",
    'datatable-btn-bootstrap-js'    => "https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js",
    'jquery-validation-js'          => "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js",
    'dropify-js'                    => "https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js",
    'sweetAlert-js'                 => "https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js",
    'toastr-js'                     => "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js",
    'switchery-js'                  => "https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js",

    // Custom js example
    'create-user-role-js'          =>"/customjs/user_role_create.js?v=".$version,
    'brand-js'                     =>"/customjs/brand.js?v=".$version,
    'create-user-js'               =>"/customjs/create_user.js?v=".$version,
    'user-list-js'                 =>"/customjs/user_list.js?v=".$version,
    'user-edit-js'                 =>"/customjs/edit_user.js?v=".$version,
    'user-role-list-js'            =>"/customjs/user_role_list.js?v=".$version,
    'user-role-edit-js'            =>"/customjs/edit_user_role.js?v=".$version,
    'category-js'                  =>"/customjs/category.js?v=".$version,
    'product-attributes-js'        =>"/customjs/product_attributes.js?v=".$version,






    'districts'                     => ['Colombo','Gampaha','Kalutara','Ratnapura','Galle','Kegalla','Kurunegala','Puttalam','Matara','Kandy','Nuwara Eliya','Matale','Anuradhapura','Moneragala','Ampara','Trincomalee','Mullaittivu','Badulla','Batticalao','Hambanthota','Mannar','Jaffna','Polonnaruwa','Vavuniya'],
    'provinces'                     => ['Western Province','Sabaragamuwa Province','Southern Province','North Western Province','Central Province','North Central Province','Uva Province','Eastern Province','Nothern Province'],

];






