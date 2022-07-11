<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=lesson_list", "root", "");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1</title>
</head>
<body>
<div style="display: flex">
<form action="" method="post">
    <label for="group">Group: </label>
    <input type="text" name="group" id="group">
    <input type="submit" value="Submit">
</form>
<?php
if (isset($_POST["group"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type
    FROM lesson INNER JOIN lesson_groups 
    ON ID_Lesson = FID_Lesson2
    INNER JOIN groups ON FID_Groups = ID_Groups
    WHERE `title` = :group");
    $statement->execute([":group"=>$_POST["group"]]);
    echo "<hr><div>";
    while ($data = $statement->fetch()) {
        echo "<b> Day: </b> {$data['week_day']}; <b>Lesson: </b> {$data['lesson_number']}; <b> Auditorium: </b> {$data['auditorium']}; <b> Disciple: </b> {$data['disciple']}; <b> Type: </b> {$data['type']}.<br>";
    }
    echo "</div>";
}
?>
</div>
<form action="" method="post">
    <label for="teacher">Teacher: </label>
    <input type="text" name="teacher" id="teacher">
    <input type="submit" placeholder="Submit">
</form>
<?php
if (isset($_POST["teacher"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type
    FROM lesson INNER JOIN lesson_teacher ON ID_Lesson = FID_Lesson1
    INNER JOIN teacher ON FID_Teacher = ID_Teacher
    WHERE name = :teacher");
    $statement->execute([":teacher"=>$_POST["teacher"]]);

    echo "<hr><div>";
    while ($data = $statement->fetch()) {
        echo " <b> Day: </b> {$data['week_day']}; <b>Lesson: </b> {$data['lesson_number']}; <b> Auditorium: </b> {$data['auditorium']}; <b> Disciple: </b> {$data['disciple']}; <b> Type: </b> {$data['type']}.<br>";
    }
    echo "</div>";
}
?>
<br>
<form action="" method="post">
    <label for="auditorium">Auditorium: </label>
    <input type="text" name="auditorium" id="auditorium">
    <input type="submit" placeholder="Submit"><br>
</form>
<?php
if (isset($_POST["auditorium"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type 
    FROM lesson
    WHERE auditorium = :auditorium");
    $statement->execute([":auditorium"=>$_POST["auditorium"]]);

    echo "<hr><div>";
    while ($data = $statement->fetch()) {
       echo " <b> Day: </b> {$data['week_day']}; <b>Lesson: </b> {$data['lesson_number']}; <b> Auditorium: </b> {$data['auditorium']}; <b> Disciple: </b> {$data['disciple']}; <b> Type: </b> {$data['type']}.<br>";
    }
    echo "</div>";
}
?>
<br>
<form action="" method="post">
    <label>
        Day:
        <input type="text" name="week_dayAdd">
    </label>
    <label>
        Lesson:
        <input type="number" name="lesson_numberAdd">
    </label>
    <label>
        Auditorium:
        <input type="text" name="auditoriumAdd">
    </label>
    <label>
        Disciple:
        <input type="text" name="discipleAdd">
    </label>
    <label>
        Type:
        <input type="text" name="typeAdd">
    </label>
    <label>
        Teacher:
        <input type="text" name="teacherAdd">
    </label>
    <label>
        Group:
        <input type="text" name="groupAdd">
    </label>
    <input type="submit" value="Submit">
</form>
<?php
if (isset($_POST["week_dayAdd"])) {
    $statement = $db->prepare("INSERT INTO lesson (week_day, lesson_number, auditorium, disciple, `type`) VALUES (?, ?, ?, ?, ?)");
    $statement->execute([$_POST["week_dayAdd"], $_POST["lesson_numberAdd"], $_POST["auditoriumAdd"], $_POST["discipleAdd"], $_POST["typeAdd"]]);
    $lessonId = $db->lastInsertId();
    $statement = $db->prepare("
        INSERT INTO lesson_teacher (FID_Teacher, FID_Lesson1) VALUES (:teacher, :lesson);
        INSERT INTO lesson_groups (FID_Groups, FID_Lesson2) VALUES (:group, :lesson);
    ");
    $statement->execute([":teacher"=>$_POST["teacherAdd"], ":lesson"=>$lessonId, ":group"=>$_POST["groupAdd"]]);
}
?>
</body>
</html>