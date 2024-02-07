<?php



$con = new mysqli('localhost', 'root', '', 'employees');


if($_SERVER['REQUEST_METHOD'] == "POST"){
$var = $_POST['fname'];
$var1 = "S";

}else{

$var = "";
$var1 = "N";
}




print(
"
<form action \"?\" method=\"post\">
<label for=\"fname\">Nombre</label>
<input type=text name = \"fname\" >
<label for=\"flastname\">Apellido</label>
<input type=text name = \"flastname\" >
<input type=\"submit\">
</form>
"
);

$query = "SELECT first_name, last_name FROM employees WHERE first_name LIKE '%$var%'";


if($var1 == 'S'){

$res1 = mysqli_query($con, $query);
if(mysqli_num_rows($res1) == 0){

echo "No hay resultados";}else{
print("<table border=1>
<tr><td>Nombre</td><td>Apellido</td></tr>

");}


mysqli_free_result($res1);



$res = mysqli_query($con, $query, MYSQLI_USE_RESULT);

//echo mysqli_num_rows($res1);
  
 if ($res) {
      while ($row = mysqli_fetch_row($res)) {
         print("<tr>");
	 print("<td>".$row[0]."</td>");
         print("<td>".$row[1]."</td>");
	 print("</tr>");
      }
   }


print("</table>");
}

?>