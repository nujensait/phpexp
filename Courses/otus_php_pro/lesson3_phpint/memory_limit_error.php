<?php

/**
 Задача:
- Доработать скрипт, который должен обработать 100.000 строчек чего-либо,
  но из-за ограничения памяти падает на 1000 строчек
 (подсказка: использовать memory_limit для ограничения потребления памяти скриптом)
- в качестве пимера: будем обрабатывать большой CSV-файл,
  в котором нам нужно прочитаьть даные из одного столбца и записать их в новый файл
  Решение будет неоптимальным в том, что считываемые даные мы будем намеренно сохранять в памяти (расходуя ее),
  а уже потом писаь в файл.
 */

class BadCsvImport
{
    private $data = [];

    /**
     * Read file
     * @param string $filename file to parse
     * @return int readed lines count
     */
    public function readData(string $filename, int $rownum = 0, string $sep = ';') : int
    {
        try {
            $handle     = fopen($filename, "rb");
            $contents   = fread($handle, filesize($filename));
            fclose($handle);
        } catch(Exception $e) {
            return 0;
        }

        $lines = explode("\n", $contents);

        foreach($lines as $line) {
            $row = explode($sep, $line);
            if(isset($row[$rownum])) {
                $this->data[] = $row[$rownum];
            }
        }

        return count($this->data);
    }

    /**
     * Save parsed data into file
     * @param string $filename
     * @return int num of written lines
     */
    public function saveData(string $filename) : int
    {
        @unlink($filename);
        $cnt = count($this->data);
        if($cnt) {
            foreach($this->data as $cell) {
                try {
                    $handle     = fopen($filename, "a");
                    fwrite($handle, $cell . "\n");
                    fclose($handle);
                } catch(Exception $e) {
                    return 0;
                }
            }
            return $cnt;
        }

        return 0;
    }
}

echo "[ Current memory limit: " . ini_get("memory_limit") . " ] \n";
echo "[ Set new memory limit ... ]\n";
ini_set("memory_limit", 1);
echo "[ New memory limit: " . ini_get("memory_limit") . " ] \n";

echo "[ START IMPORT ... ]\n";
$csv = new BadCsvImport();
$cnt = $csv->readData(__DIR__ . '/import.csv', 1, ';');
echo "[ Lines readed: $cnt ]\n";
$cnt = $csv->saveData(__DIR__ . '/result.csv');
echo "[ Lines written: $cnt ]\n";
echo "[ DONE ]\n";