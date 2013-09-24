/**
 * @author      OLWerdffelynir <werdffelynir@gmail.com>
 * @copyright   Copyright (C), 2013
 * @license     GNU General Public License 3 (http://www.gnu.org/licenses/)
 *              Refer to the LICENSE file distributed within the package.
 *
 * @link        
 *
 * @internal    Inspired by OLWerdffelynir @ https://github.com/Werdffelynir/php-class-IniDB.git
 */

/**
 * Класс для работы INI файлами как з мини базой данных.
 * При инстализации необходимо определить правила
 * $iniDB = new IniDB( array(
 *                          'file'=>'__путь_к_файлу__', // относительны или полный путь к фалу ini
 *                          'autosave'=>'false',        // сохранять файл после каждого изминения
 *                          'safetags'=>'false',        // переобразование HTML тегов
 *                          'safemode'=>'true'          // безопасный режим для имен
 *                      ) );
 * Заприщенные слова и символы для имен:
 * null, yes, no, true, false, on, off, none. 
 * ?{}|&~![()^
 * 
 * 
 * Methods
 * 
 * add($key, $value) // добавить запись ключ, значение
 * get($key)         // достать запись по ключу
 * getAll()          // выбрать все в массив
 * save()            // созранить изминения
 * delete($key)      // удалить запись по ключу 
 * 
 */
 

class IniDB
{
    public $items = array();
    private $count = 0;
    public $ini_file;
    private $autosave = false;
    private $safetags = false;
    private $safemode = true;

    public function __construct(array $params = null) {
        
        if($params != null){
        $this->ini_file = (isset($params['file']))      ? $params['file'] : 'iniDB.ini';
        $this->autosave = (isset($params['autosave']))  ? $params['autosave'] : false;
        $this->safetags = (isset($params['safetags']))  ? $params['safetags'] : false;
        $this->safemode = (isset($params['safemode']))  ? $params['safemode'] : true;
        
        $this->parse();
        }
        
    }
    
    public function path($pathFile) {
        if(!file_exists($pathFile)){
            file_put_contents($pathFile, '');
        }
        $this->ini_file = $pathFile;
        $this->parse();
    }
    
    public function parse() {
        $ini_array = parse_ini_file($this->ini_file);
        $this->items = $ini_array;
        $this->count = count($ini_array);
    }

    public function add($key, $value) {
        
        $reserved_words = true;
        $reserved_charset = true;
        
        if($this->safemode === true){
            $reserved_words = preg_match("/^(null|yes|no|true|false|on|off|none)$/", $key);
            $reserved_charset = preg_match("/(\?|\{|\}|\\|\||\&|\~|!|\[\]|\(|\)|\^|\")/", $key);
        }else{
            $reserved_words = null;
            $reserved_charset = null;
        }
        
        if($reserved_words != null AND $reserved_charset != null) {
            echo '<h3>ERROR value: "'.$key.'". There are reserved words. Dotn use words: null, yes, no, true, false, on, off, none. And charset: ?{}|&~![()^"</h3>';
            return false;
        }else{
            $this->items[$key] = $value;
            
            if($this->autosave === true){
                $this->save();
            }
        }
    }
    
    public function save() {
        $strToSave = '';
        foreach($this->items as $k => $v){
            
            if($this->safetags === true){
                $v = htmlspecialchars($v);
            }
            
            $strToSave .= trim($k)."='".trim($v)."'".PHP_EOL;
        }
        
        file_put_contents($this->ini_file, $strToSave);
        return "database is saved!";
    }
    
    public function get($key) {
        return $this->items[$key];
    }
    
    public function getAll() {
        return $this->items;
    }
    
    public function delete($key) {
        unset($this->items[$key]);
        $this->save();
    }
}



