<?php
// получаю все данные с POST массива
$name = $_POST['name'];
$email = $_POST['email'];
//валидирую ИМЯ и ЭМАИЛ
if (!preg_match("/^[A-Za-z]{1,20}$/i", $name)) {
     echo "Введите корректное имя (Должно состоять только из букв, без специальных символов и цифр)";
$name = NULL;
}
if (!preg_match("/^[a-zA-Z0-9]+@[a-z]+[.](ru|com)/i", $email)) {
     echo  "Введите корректный email (пример - example@mail.ru)";
     $email = NULL;
}
//если данные прошли валидацию, выполняем этот код, если нет - вывод формы, без выполнения кода.
if (!$email==NULL && !$name==NULL){
// при успешной валидации - записываем в куки имя и эмаил
    setcookie('name', $name);
    setcookie('email', $email);
    // получаю остальные данные
    $date = $_POST['date'];
    $contact = $_POST['contact'];
    setcookie('date', $date);
    setcookie('contact', $contact);
    $topic = $_POST['topic'];
    $information = $_POST['information'];
    $rule = $_POST['rules'];
// подключаюсь к БД
    $host = 'localhost';
    $user = 'root';
    $pass = '1111';
    $db_name = 'form';
    $link = mysqli_connect($host, $user, $pass, $db_name);

    if (!$link) {
        echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    // еще раз проверяю переменные на существования, хотя у нас они все required, но мало ли, что случится в коде

  if (isset($date) && isset($contact) && isset($topic) && isset($information) && isset($rule)) {
      $mysqli = "INSERT INTO users (`name`, `email`, `date`, `gender`, `topic`, `information`, `rule`) VALUES ('{$name}', '{$email}', '{$date}', '{$contact}', '{$topic}', '{$information}', '{$rule}')";
      if (mysqli_query($link, $mysqli)) {
          echo "Запись добавлена!";
      }
  }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Форма регистрации</title>
</head>
<body class='white-block'>
<main class='form-block'>
    <header>
        <h1>Форма обратной связи</h1>
    </header>
    <article>
        <form method='POST' accept-charset="UTF-8" action="index.php" autocomplete="on" class='form'>
            <section class='first-field'><label>Имя
                    <br>
                    <input type='text' name="name" required autocomplete="name" placeholder="Гость"
                           value="<?php if (isset($_COOKIE['name'])) {
                               echo $_COOKIE['name'];
                           }  ?>">
                </label>
            </section>
            <section class='first-field'><label>Email
                    <br>
                    <input type='text' name="email" required autocomplete="email" value="<?php if (isset($_COOKIE['email'])) {
                        echo $_COOKIE['email'];
                    }  ?>"
                           placeholder="example@mail.ru">
                </label>
            </section>
            <section class='first-field'><label>Дата рождения
                    <br>
                    <input type='date' name="date" required autocomplete="date" value="<?php if (isset($_COOKIE['date'])) {
                        echo $_COOKIE['date'];
                    }  ?>">
                </label>
            </section>
            <section class="radio">
                <input type="radio" id="contactChoice1"
                       name="contact" value="man" required>
                <label for="contactChoice1">M</label>

                <input type="radio" id="contactChoice2"
                       name="contact" value="woman" required>
                <label for="contactChoice2">Ж</label>

            </section>
            <section class='first-field'><label>Тема обращения
                    <br>
                    <input type='text' name="topic" required autocomplete="topic">
                </label>
            </section>
            <section class="first-field"><label>Суть вопроса: <br></label>
                <label>
                    <textarea rows="10" cols="40" name="information" placeholder='Напишите здесь' required></textarea>
                </label></section>
            <section class="first-field">
                <input type="checkbox" id="checkbox1"
                       name="rules" value="rules" required>
                <label for="checkbox1">С правилами ознакомился и согласен</label>
            </section>
            <section>
                <button class="button" type="submit"><b>Отправить</b></button>
            </section>


        </form>
    </article>
</main>
</body>