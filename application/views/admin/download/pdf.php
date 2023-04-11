<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style> 
            <?=file_get_contents(FCPATH.'assets\\css\\sb-admin-2.min.css')?>
        </style>
        <style>
            table { page-break-inside:auto }
            tr    { page-break-inside:avoid; page-break-after:auto }

            .table th {
                white-space: nowrap;
            }
            
        </style>
    </head>
    <body class="vh-100 vw-100">
        <div class="w-100 mb-2">
            <h3 class="w-100 text-center font-weight-bold"><?=$title?></h3>
        </div>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <?php foreach($header as $h): ?>
                    <th class="align-middle"><?=trim($h)?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0; 
                    foreach($body as $key => $val):
                        if(!isset($val)) continue; 
                        $i++;
                ?>
                <tr>
                    <td><?=$i?></td>
                    <?php foreach($val as $k => $v): ?>
                        <?php 
                            if(!empty($image[$k])): 
                                $pic = basename($v, '.jpg');
                                $img = html_escape($image[$k].$pic.'_thumb.jpg');
                        ?>
                            <td><img src="<?=file_exists($img) ? $img : FCPATH.'assets/img/book_placeholder.png'?>"></td>
                        <?php 
                            else:
                                $v = str_replace('days', 'hari', $v);
                                $v = str_replace('day', 'hari', $v);
                                $v = str_replace('mons', 'bulan', $v);
                                $v = str_replace('mon', 'bulan', $v);
                        ?>
                            <td><?=$v?></td>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                </tr>
                <?php unset($body[$key]); endforeach; ?>
            </tbody>
        </table>
        
    </body>
</html>