<?php
return [
    'template' => [
        'nav' => TEMPLATE_PATH . 'nav.php',
        'header' => TEMPLATE_PATH . 'header.php',
        'wrapper_start' => TEMPLATE_PATH . 'wrapperstart.php',
        ':view' => ':action_view',
        'wrapper_end' => TEMPLATE_PATH . 'wrapperend.php',
    ],
    'header_resources' => [
        'css' => [
            'bootstrap' => CSS . 'bootstrap.min.css',
            'fawsome' => CSS . 'all.css',
            'owl1' => CSS . 'owl/owl.carousel.min.css',
            'owl2' => CSS . 'owl/owl.theme.default.min.css',
            'default' => CSS . 'style.default.css',
            'main' => CSS . 'style.css',
        ],
        'js' => [
            'jquery' => JS . 'jquery.min.js',
            // 'ckeditor' => JS . 'ckeditor/ckeditor.js', <script src=""></script>
            'bootstrap' => JS . 'bootstrap.min.js',
             'ajaxform' => JS . 'jquery.form.js',
            'owl' => JS . 'owl/owl.carousel.js',
            'owlhight' => JS . 'owl/highlight.js',



        ],
    ],
    'footer_resources' => [
        'helper' => JS . 'helper.js',
        'datatables' => JS . 'datatables' . $_SESSION['lang'] . '.js',
        'main' => JS . 'main.js'

    ]
];

