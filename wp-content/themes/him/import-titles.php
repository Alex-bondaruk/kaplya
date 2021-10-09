<?php /* Template Name: Import Titles */ ?>
<?php get_header();
?>
<div id="import_titles">
    <div class="wrapper">
        <div class="title">Импорт titles</div>
        <form method="post" enctype="multipart/form-data">
            <div class="modal_form_field">
                <label for="file_name">Путь расположение файла (файл должен называться - <b>titles.csv</b>):</label>
                <input type="text" class="file_name" name="file_name" value="/wp-content/uploads/csv/titles.csv">
                <label for="userfile"></label>
                <input class="userfile" name="userfile" type="file" />
            </div>
            <div class="modal_form_submit">
                <input class="submit imports_submit" type="submit" value="Импортировать/обновить файл с данными">
            </div>
        </form>
        <div id="import_titles_response"></div>
    </div>
</div>

<?php

    function custom_lcfirst($str, $e='utf-8') {
        $fc = mb_strtolower(mb_substr($str, 0, 1, $e), $e);
        return $fc.mb_substr($str, 1, mb_strlen($str, $e), $e);
    }

    /*if ($_REQUEST['file_name']) {
        class CSV {
            private $_csv_file = null;
            public function __construct($csv_file) {
                if (file_exists($csv_file)) { //Если файл существует
                    $this->_csv_file = $csv_file; //Записываем путь к файлу в переменную
                } else { //Если файл не найден то вызываем исключение
                    throw new Exception("Файл ".$csv_file." не найден");
                }
            }
            public function setCSV(Array $csv) {
                //Открываем csv для до-записи,
                //если указать w, то  ифнормация которая была в csv будет затерта
                $handle = fopen($this->_csv_file, "a");
                foreach ($csv as $value) { //Проходим массив
                    //Записываем, 3-ий параметр - разделитель поля
                    fputcsv($handle, explode(";", $value), ";");
                }
                fclose($handle); //Закрываем
            }
            public function getCSV() {
                $handle = fopen($this->_csv_file, "r"); //Открываем csv для чтения

                $array_line_full = array(); //Массив будет хранить данные из csv
                //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
                while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
                    $array_line_full[] = $line; //Записываем строчки в массив
                }
                fclose($handle); //Закрываем файл
                return $array_line_full; //Возвращаем прочтенные данные
            }
        }

        try {

            $csv = new CSV($_SERVER["DOCUMENT_ROOT"].'/wp-content/uploads/csv/'.$_REQUEST['file_name']); //open csv
            $get_csv = $csv->getCSV();

            $keys = $get_csv[0]; //first element with names of TVs and fields of resource
            unset($get_csv[0]);
            foreach ($get_csv as $key => &$row) {
                foreach ($row as $keysPr => $prop) {
                    if ($prop) {
                        $arImport[$key][$keys[$keysPr]] = iconv("windows-1251","utf-8", $prop);
                    }
                }
            }
            echo '<pre>';print_r($arImport);echo'</pre>';
            foreach ($arImport as $resource) {

            }

        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo "Ошибка: " . $e->getMessage();
        }

    }*/
?>

<?php get_footer(); ?>