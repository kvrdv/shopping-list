<?php

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
  OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
  OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
  OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
  OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = ['хлеб', 'соль', 'вода'];

// Показать список покупок:
function showBasket($items)
{
  echo 'Ваш список покупок: ' . PHP_EOL;
  echo implode(PHP_EOL, $items) . PHP_EOL;
}

// Отображение меню:
function showMenu($items, $operations)
{
  if (count($items)) {
    showBasket($items);
  } else {
    unset($operations[2]);
    echo 'Ваш список покупок пуст.' . PHP_EOL;
  }

  do {
    echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
    $operationNumber = trim(fgets(STDIN));

    if (!array_key_exists($operationNumber, $operations)) {
      system('clear');
      echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
    } else {
      return $operationNumber;
    }
  } while (!array_key_exists($operationNumber, $operations));
}

// Добавление элемента в список:
function operationAdd(&$items)
{
  echo "Введение название товара для добавления в список: \n> ";
  $itemName = trim(fgets(STDIN));
  $items[] = $itemName;
}

// Удаление элемента из списка:
function operationDelete(&$items)
{
  echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
  $itemName = trim(fgets(STDIN));


  if (in_array($itemName, $items, true) !== true) {
    system('clear');
    echo '!!! Такого товара нет в списке, повторите попытку.' . PHP_EOL;
    fgets(STDIN);
  } else {
    while (($key = array_search($itemName, $items, true)) !== false) {
      unset($items[$key]);
    }
    return $items;
  }
}

// Отображения списка покупок и их общее количество:
function operationPrint($items)
{
  showBasket($items);
  echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
  echo 'Нажмите enter для продолжения';
  fgets(STDIN);
}

do {
  system('clear');
  $operationNumber = showMenu($items, $operations);
  echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

  switch ($operationNumber) {
    case OPERATION_ADD:
      operationAdd($items);
      break;

    case OPERATION_DELETE:
      operationDelete($items);
      break;

    case OPERATION_PRINT:
      operationPrint($items);
      break;
  }

  echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;