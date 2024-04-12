<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сокращатель</title>
    <link href="styles.css" rel="stylesheet">
    <script src="script.js"></script>
  </head>
  <body>
    <main>
      <div class="outer">
          <div class="inner">
            <h1>Сокращатель</h1>
            <form onsubmit="return false">
              <input type="url" id="link" placeholder="Адрес для сокращения">
              <input type="submit" value="ОК" onclick="shortify()">
            </form>
            <div id="shortifiedLink">Тут будет результат...</div>
          </div>
      </div>
    </main>
  </body>
</html>

<?php
require_once('database.php');

// переадресация, если в path есть какие-либо данные
if (array_key_exists('path', $_GET)) {
  $db = new Database();
  $link = $db->getLinkByPath($_GET['path']);
  if (!is_null($link)) {
    header('Location: '.$link, true, 302);
    exit();
  }
}
?>