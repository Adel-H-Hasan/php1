<?php
echo "<meta charset='utf-8'><body style='font-family:sans-serif'>";

function ex($title, $fn, $pre = true)
{
    echo "<h3>$title</h3>";
    if ($pre) {
        echo "<pre>";
    }
    $fn();
    if ($pre) {
        echo "</pre>";
    }
}

function section($title)
{
    echo "<hr><h2>$title</h2>";
}


section("Logical Statements and Operators");

function isLeapYear($year)
{
    return ($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0;
}

function sumOrTriple($a, $b)
{
    if ($a == $b) {
        return "( $a + $b ) * 3 = " . (($a + $b) * 3);
    }
    return "$a + $b = " . ($a + $b);
}

function sumIs30($a, $b)
{
    $sum = $a + $b;
    return $sum == 30 ? $sum : false;
}

function isMultipleOf3($n)
{
    return $n > 0 && $n % 3 == 0;
}

function inRange($n)
{
    return $n >= 20 && $n <= 50;
}

function largest($a, $b, $c)
{
    if ($a >= $b && $a >= $c) {
        return $a;
    } elseif ($b >= $a && $b >= $c) {
        return $b;
    }
    return $c;
}

function electricityBill($units)
{
    if ($units <= 50) {
        return $units * 2.50;
    } elseif ($units <= 150) {
        return 50 * 2.50 + ($units - 50) * 5.00;
    } elseif ($units <= 250) {
        return 50 * 2.50 + 100 * 5.00 + ($units - 150) * 6.20;
    }
    return 50 * 2.50 + 100 * 5.00 + 100 * 6.20 + ($units - 250) * 7.50;
}

function calculate($a, $op, $b)
{
    switch ($op) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            return $b == 0 ? "Cannot divide by zero" : $a / $b;
        default:
            return "Unknown operation";
    }
}

function canVote($age)
{
    return $age >= 18 ? "$age is eligible to vote" : "$age is not eligible to vote";
}

function signOf($n)
{
    if ($n > 0) {
        return "Positive";
    } elseif ($n < 0) {
        return "Negative";
    }
    return "Zero";
}

function gradeOf($scores)
{
    $avg = array_sum($scores) / count($scores);
    if ($avg < 60) {
        return "F";
    } elseif ($avg < 70) {
        return "D";
    } elseif ($avg < 80) {
        return "C";
    } elseif ($avg < 90) {
        return "B";
    }
    return "A";
}

ex("1. Leap year", function () {
    $year = 2013;
    echo isLeapYear($year) ? "This year is a leap year" : "This year is not a leap year";
});

ex("2. Season", function () {
    $temp = 27;
    echo $temp < 20 ? "It is wintertime!" : "It is summertime!";
});

ex("3. Sum or triple of the sum", function () {
    echo sumOrTriple(2, 2) . "\n";
    echo sumOrTriple(2, 5);
});

ex("4. Sum equals 30", function () {
    echo var_export(sumIs30(10, 10), true) . "\n";
    echo var_export(sumIs30(10, 20), true);
});

ex("5. Multiple of 3", function () {
    echo var_export(isMultipleOf3(20), true) . "\n";
    echo var_export(isMultipleOf3(21), true);
});

ex("6. Range 20-50 inclusive", function () {
    echo var_export(inRange(50), true) . "\n";
    echo var_export(inRange(51), true);
});

ex("7. Largest of three", function () {
    echo largest(1, 5, 9);
});

ex("8. Electricity bill", function () {
    foreach ([30, 120, 200, 300] as $units) {
        echo "$units units = " . number_format(electricityBill($units), 2) . " JOD\n";
    }
});

ex("9. Calculator", function () {
    echo "12 + 3 = " . calculate(12, '+', 3) . "\n";
    echo "12 - 3 = " . calculate(12, '-', 3) . "\n";
    echo "12 * 3 = " . calculate(12, '*', 3) . "\n";
    echo "12 / 3 = " . calculate(12, '/', 3) . "\n";
    echo "12 / 0 = " . calculate(12, '/', 0);
});

ex("9b. Calculator form", function () {
    $a = $_POST['a'] ?? "";
    $b = $_POST['b'] ?? "";
    $op = $_POST['op'] ?? "+";
    echo "<form method='post' action='#calc' id='calc'>";
    echo "<input type='number' step='any' name='a' placeholder='First number' value='" . htmlspecialchars($a) . "' required> ";
    echo "<select name='op'>";
    foreach (['+' => 'Addition', '-' => 'Subtraction', '*' => 'Multiplication', '/' => 'Division'] as $symbol => $label) {
        $selected = $op == $symbol ? " selected" : "";
        echo "<option value='$symbol'$selected>$label ($symbol)</option>";
    }
    echo "</select> ";
    echo "<input type='number' step='any' name='b' placeholder='Second number' value='" . htmlspecialchars($b) . "' required> ";
    echo "<button type='submit'>Calculate</button>";
    echo "</form>";
    if (is_numeric($a) && is_numeric($b)) {
        echo "<p><b>Result: " . htmlspecialchars(calculate($a, $op, $b)) . "</b></p>";
    }
}, false);

ex("10. Voting eligibility", function () {
    echo canVote(15) . "\n";
    echo canVote(18);
});

ex("11. Positive, negative or zero", function () {
    echo signOf(-60) . "\n";
    echo signOf(0) . "\n";
    echo signOf(8);
});

ex("12. Student grade", function () {
    $scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];
    echo gradeOf($scores);
});

section("Arrays");

function insertAt($array, $location, $item)
{
    array_splice($array, $location - 1, 0, [$item]);
    return $array;
}

function toUpper($array)
{
    return array_map('strtoupper', $array);
}

function toLower($array)
{
    return array_map('strtolower', $array);
}

function uniqueRandom($min, $max, $count = 10)
{
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $count);
}

function lowestNonZero($array)
{
    return min(array_filter($array, function ($n) {
        return $n != 0;
    }));
}

ex("1. Paragraph with colors", function () {
    $colors = array('white', 'green', 'red');
    echo "The memory of that scene for me is like a frame of film forever frozen at that moment: ";
    echo "the $colors[2] carpet, the $colors[1] lawn, the $colors[0] house, the leaden sky. ";
    echo "The new president and his first lady. - Richard M. Nixon";
});

ex("2. Colors as an unordered list", function () {
    $colors = array('white', 'green', 'red');
    sort($colors);
    echo "<ul>";
    foreach ($colors as $color) {
        echo "<li>$color</li>";
    }
    echo "</ul>";
}, false);

ex("3. Capitals sorted by capital", function () {
    $cities = array(
        "Italy" => "Rome", "Luxembourg" => "Luxembourg", "Belgium" => "Brussels",
        "Denmark" => "Copenhagen", "Finland" => "Helsinki", "France" => "Paris",
        "Slovakia" => "Bratislava", "Slovenia" => "Ljubljana", "Germany" => "Berlin",
        "Greece" => "Athens", "Ireland" => "Dublin", "Netherlands" => "Amsterdam",
        "Portugal" => "Lisbon", "Spain" => "Madrid"
    );
    asort($cities);
    foreach ($cities as $country => $capital) {
        echo "The capital of $country is $capital\n";
    }
});

ex("4. First element", function () {
    $color = array(4 => 'white', 6 => 'green', 11 => 'red');
    echo reset($color);
});

ex("5. Insert an item at any position", function () {
    $array = [1, 2, 3, 4, 5];
    echo implode(" ", insertAt($array, 4, '$'));
});

ex("6. Sort the associative array", function () {
    $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
    asort($fruits);
    foreach ($fruits as $key => $value) {
        echo "$key = $value\n";
    }
});

ex("7. Temperatures", function () {
    $temps = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
    $average = array_sum($temps) / count($temps);
    sort($temps);
    $lowest = array_slice($temps, 0, 5);
    $highest = array_slice($temps, -5);
    echo "Average Temperature is: " . round($average, 1) . "\n";
    echo "List of five lowest temperatures: " . implode(", ", $lowest) . "\n";
    echo "List of five highest temperatures: " . implode(", ", $highest);
});

ex("8. Merge two arrays", function () {
    $array1 = array("color" => "red", 2, 4);
    $array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
    print_r(array_merge($array1, $array2));
});

ex("9. Convert to upper case", function () {
    $colors = array("red", "blue", "white", "yellow");
    print_r(toUpper($colors));
});

ex("10. Convert to lower case", function () {
    $colors = array("RED", "BLUE", "WHITE", "YELLOW");
    print_r(toLower($colors));
});

ex("11. Numbers between 200 and 250 divisible by 4", function () {
    $numbers = [];
    for ($i = 200; $i <= 250; $i++) {
        if ($i % 4 == 0) {
            $numbers[] = $i;
        }
    }
    echo implode(",", $numbers);
});

ex("12. Shortest and longest string length", function () {
    $words = array("abcd", "abc", "de", "hjjj", "g", "wer");
    $lengths = array_map('strlen', $words);
    echo "The shortest array length is " . min($lengths) . ". The longest array length is " . max($lengths) . ".";
});

ex("13. Ten unique random numbers in a range", function () {
    echo implode(" ", uniqueRandom(11, 20));
});

ex("14. Lowest integer that is not 0", function () {
    $array1 = array(2, 0, 10, 12, 6);
    echo lowestNonZero($array1);
});

section("Loops");

ex("1. 1-2-3-...-10", function () {
    for ($i = 1; $i <= 10; $i++) {
        echo $i;
        if ($i < 10) {
            echo "-";
        }
    }
});

ex("2. Sum of 0 to 30", function () {
    $total = 0;
    for ($i = 0; $i <= 30; $i++) {
        $total += $i;
    }
    echo $total;
});

ex("3. Letters pattern", function () {
    for ($i = 0; $i < 5; $i++) {
        $row = [];
        for ($j = 0; $j < 5; $j++) {
            $row[] = $j < 4 - $i ? 'A' : chr(65 + $i);
        }
        echo implode(" ", $row) . "\n";
    }
});

ex("4. Numbers pattern", function () {
    for ($i = 0; $i < 5; $i++) {
        $row = [];
        for ($j = 0; $j < 5; $j++) {
            $row[] = $j < 4 - $i ? 1 : $i + 1;
        }
        echo implode(" ", $row) . "\n";
    }
});

ex("5. Diagonal pattern", function () {
    for ($i = 1; $i <= 5; $i++) {
        $row = [];
        for ($j = 1; $j <= 5; $j++) {
            $row[] = $i == $j ? $i : 0;
        }
        echo implode(" ", $row) . "\n";
    }
});

ex("6. Factorial", function () {
    $number = 5;
    $factorial = 1;
    for ($i = 2; $i <= $number; $i++) {
        $factorial *= $i;
    }
    echo $factorial;
});

ex("7. Fibonacci", function () {
    $count = 10;
    $a = 0;
    $b = 1;
    $sequence = [];
    for ($i = 0; $i < $count; $i++) {
        $sequence[] = $a;
        $next = $a + $b;
        $a = $b;
        $b = $next;
    }
    echo implode(", ", $sequence) . ", ...";
});

ex("8. Count the letter c", function () {
    $text = "Orange Coding Academy";
    $count = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        if (strtolower($text[$i]) == 'c') {
            $count++;
        }
    }
    echo $count;
});

ex("9. Multiplication table", function () {
    echo '<table border="1" cellpadding="3px" cellspacing="0px">';
    for ($i = 1; $i <= 6; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= 5; $j++) {
            echo "<td>$i * $j = " . ($i * $j) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}, false);

ex("10. FizzBuzz", function () {
    $items = [];
    for ($i = 1; $i <= 50; $i++) {
        if ($i % 15 == 0) {
            $items[] = "FizzBuzz";
        } elseif ($i % 3 == 0) {
            $items[] = "Fizz";
        } elseif ($i % 5 == 0) {
            $items[] = "Buzz";
        } else {
            $items[] = $i;
        }
    }
    echo implode(" ", $items);
});

ex("11. Floyd triangle", function () {
    $n = 5;
    $number = 1;
    for ($i = 1; $i <= $n; $i++) {
        $row = [];
        for ($j = 1; $j <= $i; $j++) {
            $row[] = $number++;
        }
        echo implode(" ", $row) . "\n";
    }
});

ex("12. Letters triangle", function () {
    for ($i = 1; $i <= 5; $i++) {
        $row = [];
        for ($j = 0; $j < $i; $j++) {
            $row[] = chr(65 + $j);
        }
        echo implode(" ", $row) . "\n";
    }
    for ($i = 4; $i >= 1; $i--) {
        $row = [];
        for ($j = 0; $j < $i; $j++) {
            $row[] = chr(65 + $j);
        }
        echo implode(" ", $row) . "\n";
    }
});

section("Functions");

function isPrime($n)
{
    if ($n < 2) {
        return false;
    }
    for ($i = 2; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}

function reverseString($text)
{
    $reversed = "";
    for ($i = strlen($text) - 1; $i >= 0; $i--) {
        $reversed .= $text[$i];
    }
    return $reversed;
}

function allLowerCase($text)
{
    return $text === strtolower($text);
}

function swap(&$a, &$b)
{
    $temp = $a;
    $a = $b;
    $b = $temp;
}

function isArmstrong($n)
{
    $digits = str_split((string)$n);
    $power = count($digits);
    $sum = 0;
    foreach ($digits as $digit) {
        $sum += pow($digit, $power);
    }
    return $sum == $n;
}

function isPalindrome($text)
{
    $clean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $text));
    return $clean === strrev($clean);
}

function removeDuplicates($array)
{
    return array_values(array_unique($array));
}

ex("1. Prime number", function () {
    $n = 3;
    echo isPrime($n) ? "$n is a prime number" : "$n is not a prime number";
});

ex("2. Reverse a string", function () {
    echo reverseString("remove");
});

ex("3. All characters lower case", function () {
    echo allLowerCase("remove") ? "Your String is Ok" : "Your String has upper case characters";
});

ex("4 and 5. Swap two variables (exercise 5 repeats exercise 4)", function () {
    $x = 12;
    $y = 10;
    swap($x, $y);
    echo "y=$y x=$x";
});

ex("6. Armstrong number", function () {
    $n = 407;
    echo isArmstrong($n) ? "$n is Armstrong Number" : "$n is not Armstrong Number";
});

ex("7. Palindrome", function () {
    $text = "Eva, can I see bees in a cave?";
    echo isPalindrome($text) ? "Yes it is a palindrome" : "No it is not a palindrome";
});

ex("8. Remove duplicates from an array", function () {
    $array1 = array(2, 4, 7, 4, 8, 4);
    print_r(removeDuplicates($array1));
});
