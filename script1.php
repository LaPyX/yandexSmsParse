<?php
// т.к. я не смог выпросить из вашего эмулятора другие варианты шаблонов текста, я в итоге накидал свои для примеров

 $text = '
Пароль подтверждения: 4559
Спишется 2234,18р.
Перевод на счет 4100143322850
';

$text = '
код подтверждения: 4559
сумма: 2234,18р.
Аккаунт 4100143322850
';

$text = '
code 4559
summa: 2234,18r.
Account number: 4100143322850
';

$text = '
kod 4559
spishetsya : 2234.18r.
perevod na schet: 4100143322850
';

$text = "
Parol' podtverzhdeniya: 4559
Spishetsya 2234,18r.
Perevod na schet 4100143322850
";

$text = 'Ваш код 4559 произойдет списание на сумму : 2234.18r. на счет аккаунта: 4100143322850';

$text = 'на счет аккаунта: 4100143322850 произойдет списание на сумму : 2234.18r. Ваш пароль 4559 ';

$text = 'списание переводом со счета 123456 на сумму 123.18r на счет 4100143322850 Ваш код подтверждения 4559 ';

print_r(yandexSmsParse($text));

function yandexSmsParse($text) {
    $ret = ['code' => '', 'summa' => '', 'acc' => ''];
    
    // находим код и вырезаем из текста
    $regexpCode = '/(?:пароль|код|code|kod|parol)(?:\D)+(\d+)/ui';
    if (preg_match($regexpCode, $text, $data)){
        $text = preg_replace($regexpCode, ' ', $text);
        $ret['code'] = $data[1];
    }
    
    // находим сумму и вырезаем из текста
    $regexpSumma = '/(?:спишется|сумм|итог|списание|spishetsya|summ|sum|itog|spisanie|perevod|перевод)(?:\D)+([\d\,\.]+)\s?(?:r|р)/ui';
    if (preg_match($regexpSumma, $text, $data)){
        $text = preg_replace($regexpSumma, ' ', $text);
        $ret['summa'] = $data[1];
    }
    
    // находим счет и вырезаем из текста
    $regexpAcc = '/(?:сч(?:е|ё)т|account|acc|номер|number|аккаунт|perevod|schet|перевод)(?:\D)+(\d+)/ui';
    if (preg_match($regexpAcc, $text, $data)){
        $text = preg_replace($regexpAcc, ' ', $text);
        $ret['acc'] = $data[1];
    }
    
    return $ret;
}




