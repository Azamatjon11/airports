<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The world airports</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>

<?php
$keyword = $_GET['keyword'] ?? null;
$field = $_GET['field'] ?? 'country';
require_once "database.php";
$obj = new \Database\database("karimov");

if ($keyword) {
    if ($field == 'anywhere') {
        $sql = "SELECT * FROM airports WHERE city like '%$keyword%' or country like '%$keyword%' or name like '%$keyword%';";
    } else {
        $sql = "SELECT * FROM airports WHERE $field like '%$keyword%';";
    }
} else {
    $sql = "SELECT * FROM airports order by country_abbr like '%$keyword%';";
}

$airports = $obj->sql($sql);
?>
<div id="airports">
    <div class="airports_title">The World Airports</div>
    <div class="airports_search">
        <form>
            <p>
                <label>Search: </label><input value="<?php echo $keyword; ?>" name="keyword" placeholder="Your keyword"
                                              type="text">
                <select name="field">
                    <?php
                    $columns = ['anywhere', 'city', 'country', 'country_abbr'];
                    foreach ($columns as $column) {
                        if ($field == $column) {
                            echo "<option selected value=\"$column\">$column</option>";
                        } else {
                            echo "<option value=\"$column\">$column</option>";
                        }
                    }
                    ?>
                </select>
                <button class="btn btn-success" type="submit">GO</button>
            </p>
        </form>
    </div>
    <div class="airports_list">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Country ABBR</th>
                <th>City</th>
                <th>Country</th>
                <th>Name</th>
                <th>World area code</th>
            </tr>
            <?php foreach ($airports as $airport): ?>
                <tr>
                    <td><?php echo $airport['id']; ?></td>
                    <td><?php echo $airport['country_abbr']; ?></td>
                    <td><?php echo $airport['city']; ?></td>
                    <td><?php echo $airport['country']; ?></td>
                    <td><?php echo $airport['name']; ?></td>
                    <td><?php echo $airport['world_area_code']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>
