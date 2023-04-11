<?php
ini_set('memory_limit', '4000M');

/**
 * ***********************************************************************
 *         Custom data export  library for hit perpus application 
 * **********************************************************************
 * 
 * requirement:
 *  - PHP 7.4
 *  - php_xlswriter -> excel
 *  - michaelheart wkhtmltopdf php wrapper -> pdf
 * 
 * @author Naquib Alatas
 * @create_date 2023-03-20
 */


class Export {

    private $ci;
    private $options;
    private $filename;

    public function __construct(array $options) {
        $error = NULL;
        if(!$this->validate_options($options, $error))
        {
            throw new Exception($error);
            exit(0);
        }
        $this->options = $options;
        $this->ci = &get_instance();
    }

    /**
     *  Validation Konfig
     *
     * @param array $options
     * @param string $error
     * @return boolean
     */
    private function validate_options(array $options, ?string &$error): bool {
        
        if(!is_array($options))
        {
            $error = 'Konfigurasi harus berupa array';
            return false;
        }

        if(!file_exists($options['filepath']))
            @mkdir(FCPATH.$options['filepath'], 0777);
        
        return true;
    }


    /**
     * Convert data to excel
     *
     * @return self
     */
    public function toExcel(): self {
        require_once APPPATH.'third_party/xlsx/xlsxwriter.class.php';
        //$config = ['path' => $this->options['filepath'].'\\'];
        // user php extendsion php_xlswriter
        $xlsx = new XLSXWriter();
        $data = $this->options['data'];
        $image = $this->options['image'] ?? [];
        $title = $this->options['title'];
        // style
        $header_style = ['font-style' => 'bold', 'color' => '#FFFFFF', 'fill' => '#34c38f', 'height' => 20, 'halign' => 'center'];
        // header
        function setHeader($sum, $index)
        {
            $sum[$index] = 'string';
            return $sum;
        }
        $headers = array_reduce($this->options['header'], 'setHeader', []);
        // write sheet header
        $sheetTitle = strpos($title, '<br') ? (explode('<br/>', $title))[0] : $title;
        $xlsx->writeSheetHeader(trim($sheetTitle), $headers, $header_style);
        // write data
        foreach($data as $d)
            $xlsx->writeSheetRow(trim($sheetTitle), $d);
        // set filename for download
        $this->filename = $this->options['filepath'].DIRECTORY_SEPARATOR.$this->options['filename'].'.xlsx';
        // wite data to file
        $xlsx->writeToFile($this->filename);

        return $this;
    }

    /**
     * Create PDF
     *
     * @return self
     */
    public function toPDF(): self {
        // Config
        $config = [
            'binary' => FCPATH.'vendor\\wemersonjanuario\\wkhtmltopdf-windows\\bin\\64bit\\wkhtmltopdf'
        ];
        if(!empty($this->options['pdf']))
        {
            foreach($this->options['pdf'] as $k => $v)
            {   
                $config[$k] = $v;
            }
        }
        // Instance
        $pdf  = new \mikehaertl\wkhtmlto\Pdf($config);
        $file = $this->options['filepath'].DIRECTORY_SEPARATOR.$this->options['filename'];
        // set template
        $data['header'] = $this->options['header'];
        $data['body']   = $this->options['data'];
        $data['title']  = $this->options['title'];
        $data['image']  = $this->options['image'] ?? [];
        file_put_contents($file.'.html', $this->ci->load->view('download/pdf', $data, TRUE));
        // Save as pdf
        $pdf->addPage(FCPATH.$file.'.html');
        if(!$pdf->saveAs(FCPATH.$file.'.pdf'))
        {
            throw new Exception($pdf->getError());
            exit(0);
        }
        $this->filename = $file.'.pdf';
        @unlink($file.'.html');

        return $this;
    }

    /**
     * Download Created File
     *
     * @return self
     */
    public function download(): self {
        $ext = pathinfo($this->filename, PATHINFO_EXTENSION);

        switch($ext) {
            case 'xlsx':
                header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Disposition: attachment;filename="' . basename($this->filename) . '"');
                header('Content-Length: '.filesize($this->filename));
                header('Cache-Control: max-age=0');
                ob_clean();
                flush();
                readfile($this->filename);                
                break;
            case 'pdf':
                header("Content-Type: application/pdf");
                header('Content-Disposition: attachment;filename="' . basename($this->filename) . '"');
                header('Content-Length: '.filesize($this->filename));
                header('Cache-Control: max-age=0');
                ob_clean();
                flush();
                readfile($this->filename);        
                break;
        }

       @unlink($this->filename);

        return $this;
    }
}