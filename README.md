php-class-IniDB
===============

Класс для работы с INI файлами как з мини базой данных.

###При инстализации необходимо определить правила
```
$iniDB = new IniDB( array(
                         'file'=>'__путь_к_файлу__', // относительны или полный путь к фалу ini
                         'autosave'=>'false',        // сохранять файл после каждого изминения
                         'safetags'=>'false',        // переобразование HTML тегов
                         'safemode'=>'true'          // безопасный режим для имен
                     ) );
                     
```



###Заприщенные слова и символы для имен:

null, yes, no, true, false, on, off, none. 

?{}|&~![()^



###Methods
```
add($key, $value) // добавить запись ключ, значение
get($key)         // достать запись по ключу
getAll()          // выбрать все в массив
save()            // созранить изминения
delete($key)      // удалить запись по ключу       
```
