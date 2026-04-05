<?php

$file = "data.json";

// file create if not exists
if(!file_exists($file)){
    file_put_contents($file, json_encode([]));
}

// read data
$data = json_decode(file_get_contents($file), true);

// BOOK
if(isset($_POST['book'])){
    $name = $_POST['name'];
    $seats = explode(",", $_POST['seats']);

    foreach($seats as $seat){
        if($seat != ""){
            $data[$seat] = $name;
        }
    }

    file_put_contents($file, json_encode($data));
}

// RESET
if(isset($_POST['reset'])){
    file_put_contents($file, json_encode([]));
    $data = [];
}

?>

<!DOCTYPE html>
<html>
<head>
<title>No Database Seat Booking</title>

<style>
body{font-family:Segoe UI;background:#2c003e;color:white;text-align:center;}
.seats{display:grid;grid-template-columns:repeat(8,60px);gap:10px;justify-content:center;}
.seat{background:#9b59b6;padding:15px;border-radius:8px;cursor:pointer;}
.selected{background:#f1c40f;}
.booked{background:red;cursor:not-allowed;}
</style>

</head>

<body>

<h1>Library Seat Booking (No MySQL)</h1>

<form method="POST">

<div class="seats">
<?php
for($i=1;$i<=40;$i++){
    if(isset($data[$i])){
        echo "<div class='seat booked'>X</div>";
    }else{
        echo "<div class='seat' onclick='selectSeat(this,$i)'>$i</div>";
    }
}
?>
</div>

<input type="hidden" name="seats" id="seats">

<br><br>

<input type="text" name="name" placeholder="Enter name">

<br><br>

<button name="book">Book</button>
<button name="reset">Reset</button>

</form>

<script>
let selected=[];

function selectSeat(el,num){

if(el.classList.contains("booked")) return;

if(el.classList.contains("selected")){
    el.classList.remove("selected");
    selected = selected.filter(s=>s!==num);
}else{
    el.classList.add("selected");
    selected.push(num);
}

document.getElementById("seats").value = selected.join(",");
}
</script>

</body>
</html>