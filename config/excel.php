<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Excel Package Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Excel package.
    | You can customize the settings according to your needs.
    |
    */

    'exports' => [

        /*
        |--------------------------------------------------------------------------
        | Chunk size
        |--------------------------------------------------------------------------
        |
        | When using FromQuery, the query is automatically chunked.
        | Here you can specify how big the chunk should be.
        |
        */
        'chunk_size' => 1000,

        /*
        |--------------------------------------------------------------------------
        | Temporary files
        |--------------------------------------------------------------------------
        |
        | When exporting files, we use a temporary file, before storing
        | or downloading. Here you can configure that temporary file path.
        |
        */
        'temp_path' => sys_get_temp_dir(),

        /*
        |--------------------------------------------------------------------------
        | CSV Settings
        |--------------------------------------------------------------------------
        */
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape_character' => '\\',
            'contiguous' => false,
            'input_encoding' => 'UTF-8',
        ],

        /*
        |--------------------------------------------------------------------------
        | Worksheet properties
        |--------------------------------------------------------------------------
        */
        'properties' => [
            'creator' => 'Sistem Sekolah Dasar',
            'lastModifiedBy' => 'Sistem Sekolah Dasar',
            'title' => 'Export Data',
            'description' => 'Data export dari sistem sekolah dasar',
            'subject' => 'Data Export',
            'keywords' => 'export, data, sekolah, dasar',
            'category' => 'Data Export',
            'manager' => 'Sistem Sekolah Dasar',
            'company' => 'Sekolah Dasar',
        ],

    ],

    'imports' => [

        /*
        |--------------------------------------------------------------------------
        | Read Only
        |--------------------------------------------------------------------------
        |
        | When reading files, we can optionally ignore empty rows.
        | If you want to ignore empty rows, set this to true.
        |
        */
        'read_only' => true,

        /*
        |--------------------------------------------------------------------------
        | Heading Row Formatter
        |--------------------------------------------------------------------------
        |
        | Configure the heading row formatter.
        | Available options: none|slug|custom
        |
        */
        'heading_row' => [
            'formatter' => 'slug',
        ],

        /*
        |--------------------------------------------------------------------------
        | CSV Settings
        |--------------------------------------------------------------------------
        */
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape_character' => '\\',
            'contiguous' => false,
            'input_encoding' => 'UTF-8',
        ],

        /*
        |--------------------------------------------------------------------------
        | Calculate formulas
        |--------------------------------------------------------------------------
        |
        | Configure if formulas should be calculated during import.
        | This can be resource intensive, so disable if not needed.
        |
        */
        'calculate_formulas' => false,

        /*
        |--------------------------------------------------------------------------
        | Ignore empty rows
        |--------------------------------------------------------------------------
        |
        | When reading files, we can optionally ignore empty rows.
        | If you want to ignore empty rows, set this to true.
        |
        */
        'ignore_empty' => true,

        /*
        |--------------------------------------------------------------------------
        | Heading row formatter
        |--------------------------------------------------------------------------
        |
        | Configure the heading row formatter.
        | Available options: none|slug|custom
        |
        */
        'heading_row' => [
            'formatter' => 'slug',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Extension detector
    |--------------------------------------------------------------------------
    |
    | Configure here which class/extension should be used to detect the file type.
    | You can use the default PhpSpreadsheet extension detector, or create your
    | own. When using the default, we can configure which extensions are allowed.
    |
    */
    'extension_detector' => [
        'xlsx' => \PhpOffice\PhpSpreadsheet\Reader\Xlsx::class,
        'xls' => \PhpOffice\PhpSpreadsheet\Reader\Xls::class,
        'csv' => \PhpOffice\PhpSpreadsheet\Reader\Csv::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Value Binder
    |--------------------------------------------------------------------------
    |
    | PhpSpreadsheet offers a way to hook into the process of a value being
    | written to a cell. In there some assumptions are made on how the
    | value should be formatted. If you want to change those defaults,
    | you can implement your own default value binder.
    |
    | Possible value binders:
    |
    | [x] Maatwebsite\Excel\DefaultValueBinder::class
    | [x] PhpOffice\PhpSpreadsheet\Cell\StringValueBinder::class
    | [x] PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder::class
    |
    */
    'value_binder' => [
        'default' => Maatwebsite\Excel\DefaultValueBinder::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | By default PhpSpreadsheet keeps all cell values in memory, however when
    | dealing with large files, this can result into memory issues. If you
    | want to mitigate that, you can configure a cache driver here.
    | When using the illuminate driver, it will store each value in the
    | cache store. This can slow down the process, because it needs to
    | store each value. You can use the "batch" store if you want to
    | only persist to the store when the memory limit is reached.
    |
    | Default: illuminate
    | Supported: memory|illuminate|batch
    |
    */
    'cache' => [
        'driver' => 'memory',
        'batch' => [
            'memory_limit' => 60000,
        ],
        'illuminate' => [
            'store' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Transaction handler
    |--------------------------------------------------------------------------
    |
    | By default the import is wrapped in a transaction. This is useful
    | for when an import may fail and you want to retry it. With the
    | transactions, the previous import gets rolled-back automatically.
    |
    | You can disable the transaction handler by setting this to null.
    | Or you can choose a custom made transaction handler here.
    |
    | Supported handlers: null|db
    |
    */
    'transactions' => [
        'handler' => 'db',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tmp path
    |--------------------------------------------------------------------------
    |
    | When uploading files, before storing them, we need to store them
    | temporarily somewhere. Here you can configure that temporary path.
    |
    */
    'tmp_path' => sys_get_temp_dir(),

    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    |
    | By default imports are processed synchronously. This is great for
    | small imports. However, for large imports, this can cause timeouts.
    | You can configure the queue to process imports in the background.
    |
    | When using the queue, you can configure the connection and queue
    | name here. The default connection will be used if not specified.
    |
    */
    'queue' => [
        'connection' => null,
        'queue' => null,
    ],

];
