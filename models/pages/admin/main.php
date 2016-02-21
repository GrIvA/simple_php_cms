<?php
$source_folders = [
    ROOTDIR . 'models' . DS . 'pages',
    ROOTDIR . 'templates',
];

/*
                files: [{name: 'test1.php'}, {name: 'test2.razr'}],
                folders: [{
                    name: 'Folder 1',
                    files: [{ name: 'File 1.jpg' }, { name: 'File 2.png' }],
                    folders: [
                        { name: 'Subfolder 1', files: [{ name: 'Subfile 1' }] },
                        { name: 'Subfolder 2' },
                        { name: 'Subfolder 3' }
                    ]},
                    { name: 'Folder 2' }
                ]
function getFileList($path)
{
    dbg(scandir($path));
    $files = $dirs = [];
    array_walk(scandir($path), function ($file) use ($path, &$files, &$dirs) {
        if (is_dir($path . DS . $file)) {
            if (!in_array($file, ['.', '..'])) {
                $dirs[] = $file;
            }
        } else {
            $files[] = $file;
        }
    });
    dbg(['directories' => $dirs, 'files' => $files]);
}

for ($i = 0; $i < count($source_folders); $i++) {
    getFileList($source_folders[$i]);

}
*/
 
$result = [
    'page' => [
        'title'       => 'admin page',
        'name'        => 'pages/' . $file_name . '.razr',
        'header_menu' => 'elements/admin/header_menu.razr',
    ],
    'parameters' => [
        'header' => 'Hi! It is my admin interface!'
    ],
];

if (DEVELOP) {
    $result['debug'] = [
        'session' => $_SESSION,
    ];

}
return $result;


$arr = array("folder_1","folder_2");
$format  = ".csv";
